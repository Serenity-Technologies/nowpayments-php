<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Handlers;

use SerenityTechnologies\NowPayments\Exceptions\NowPaymentsException;

class IpnHandler
{
    /**
     * @var string
     */
    protected string $ipnSecret;

    /**
     * IpnHandler constructor.
     *
     * @param string $ipnSecret
     */
    public function __construct(string $ipnSecret = '')
    {
        $this->ipnSecret = $ipnSecret;
    }

    /**
     * Verify IPN signature from webhook request.
     *
     * @param array $data
     * @param string $signature
     * @return bool
     * @throws NowPaymentsException
     */
    public function verifySignature(array $data, string $signature): bool
    {
        if (empty($this->ipnSecret)) {
            throw NowPaymentsException::invalidSignature('IPN secret not configured');
        }

        // Sort the data by keys recursively
        $sortedData = $this->sortArrayRecursive($data);

        // Convert to JSON string
        $jsonString = json_encode($sortedData, JSON_UNESCAPED_SLASHES);

        // Create HMAC signature
        $computedSignature = hash_hmac('sha512', $jsonString, trim($this->ipnSecret));

        // Compare signatures using timing-safe comparison
        return hash_equals($computedSignature, $signature);
    }

    /**
     * Process and verify incoming IPN request.
     *
     * @param array $postData
     * @param string $signature
     * @return array
     * @throws NowPaymentsException
     */
    public function processIpn(array $postData, string $signature): array
    {
        if (!$this->verifySignature($postData, $signature)) {
            throw NowPaymentsException::invalidSignature('HMAC signature does not match');
        }

        return $postData;
    }

    /**
     * Handle IPN callback from Laravel request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws NowPaymentsException
     */
    public function handleRequest(\Illuminate\Http\Request $request): array
    {
        $signature = $request->header('X-NOWPAYMENTS-SIG', '');
        $postData = $request->all();

        return $this->processIpn($postData, $signature);
    }

    /**
     * Sort array recursively by keys (like ksort in PHP).
     *
     * @param array $array
     * @return array
     */
    protected function sortArrayRecursive(array $array): array
    {
        ksort($array);
        foreach (array_keys($array) as $key) {
            if (is_array($array[$key])) {
                $array[$key] = $this->sortArrayRecursive($array[$key]);
            }
        }

        return $array;
    }

    /**
     * Set IPN secret.
     *
     * @param string $secret
     * @return $this
     */
    public function setIpnSecret(string $secret): self
    {
        $this->ipnSecret = $secret;
        return $this;
    }

    /**
     * Get IPN secret.
     *
     * @return string
     */
    public function getIpnSecret(): string
    {
        return $this->ipnSecret;
    }

    /**
     * Check if this is a recurring/retry notification.
     *
     * The spec describes "Recurrent payment notifications" - retries on error.
     * This helper detects if an IPN is a retry based on the payment status
     * being in a failed/error state.
     *
     * @param array $data
     * @return bool
     */
    public function isRetry(array $data): bool
    {
        $retryStatuses = ['failed', 'refunded', 'expired'];

        $status = $data['payment_status'] ?? $data['status'] ?? '';

        return in_array(strtolower($status), $retryStatuses, true);
    }
}
