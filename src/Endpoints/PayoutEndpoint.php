<?php declare(strict_types=1);

/**
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
namespace SerenityTechnologies\NowPayments\Endpoints;

use SerenityTechnologies\NowPayments\Client\NowPaymentsClient;
use SerenityTechnologies\NowPayments\DTOs\Request\PayoutRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\PayoutAddressRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\PayoutVerificationRequest;
use SerenityTechnologies\NowPayments\DTOs\Response\BalanceResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\PayoutResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\PayoutStatusResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\PayoutListResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\FeeEstimateResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\MinWithdrawalAmountResponse;
use SerenityTechnologies\NowPayments\Exceptions\NowPaymentsException;

class PayoutEndpoint
{
    public function __construct(
        protected NowPaymentsClient $client
    ) {
    }

    /**
     * Get account balance.
     *
     * @return BalanceResponse
     */
    public function getBalance(): BalanceResponse
    {
        $response = $this->client->get('/v1/balance');
        return BalanceResponse::fromArray($response);
    }

    /**
     * Validate a payout address.
     *
     * @param PayoutAddressRequest $request
     * @return bool
     */
    public function validateAddress(PayoutAddressRequest $request): bool
    {
        $request->validate();
        try {
            $this->client->post('/v1/payout/validate-address', $request->toArray());
            return true;
        } catch (NowPaymentsException $e) {
            // Only catch validation errors (400, 422), re-throw others
            if (in_array($e->getCode(), [400, 422], true)) {
                return false;
            }
            throw $e;
        }
    }

    /**
     * Create a payout (requires authentication).
     *
     * @param PayoutRequest $request
     * @return PayoutResponse
     */
    public function createPayout(PayoutRequest $request): PayoutResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/payout', $request->toArray(), requiresAuth: true);
        return PayoutResponse::fromArray($response);
    }

    /**
     * List payouts with pagination.
     *
     * @param array $filters
     * @return PayoutListResponse
     */
    public function listPayouts(array $filters = []): PayoutListResponse
    {
        $response = $this->client->get('/v1/payout', $filters);
        return PayoutListResponse::fromArray($response);
    }

    /**
     * Get payout status.
     *
     * @param string $payoutId
     * @return PayoutStatusResponse
     */
    public function getPayoutStatus(string $payoutId): PayoutStatusResponse
    {
        $response = $this->client->get('/v1/payout/' . $payoutId);
        return PayoutStatusResponse::fromArray($response);
    }

    /**
     * Verify a payout with 2FA code.
     *
     * @param string $batchWithdrawalId
     * @param PayoutVerificationRequest $request
     * @return bool
     */
    public function verifyPayout(string $batchWithdrawalId, PayoutVerificationRequest $request): bool
    {
        $request->validate();
        $this->client->post(
            '/v1/payout/' . $batchWithdrawalId . '/verify',
            $request->toArray(),
            requiresAuth: true
        );
        return true;
    }

    /**
     * Cancel a scheduled payout.
     *
     * @param string $withdrawalId
     * @return PayoutStatusResponse
     */
    public function cancelPayout(string $withdrawalId): PayoutStatusResponse
    {
        $response = $this->client->post(
            '/v1/payout/' . $withdrawalId . '/cancel',
            [],
            requiresAuth: true
        );
        return PayoutStatusResponse::fromArray($response);
    }

    /**
     * Get minimum withdrawal amount for a coin.
     *
     * @param string $coin
     * @return MinWithdrawalAmountResponse
     */
    public function getMinWithdrawalAmount(string $coin): MinWithdrawalAmountResponse
    {
        $response = $this->client->get('/v1/payout-withdrawal/min-amount/' . $coin);
        return MinWithdrawalAmountResponse::fromArray($response);
    }

    /**
     * Get payout fee estimate.
     *
     * @return FeeEstimateResponse
     */
    public function getPayoutFeeEstimate(): FeeEstimateResponse
    {
        $response = $this->client->get('/v1/payout/fee');
        return FeeEstimateResponse::fromArray($response);
    }
}
