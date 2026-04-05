<?php

/**
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
namespace SerenityTechnologies\NowPayments\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use SerenityTechnologies\NowPayments\Exceptions\NowPaymentsException;

class NowPaymentsClient
{
    /**
     * @var GuzzleClient
     */
    protected GuzzleClient $client;

    /**
     * @var string
     */
    protected string $apiKey;

    /**
     * @var string
     */
    protected string $ipnSecret;

    /**
     * @var string
     */
    protected string $dashboardEmail;

    /**
     * @var string
     */
    protected string $dashboardPassword;

    /**
     * @var string|null
     */
    protected ?string $jwtToken = null;

    /**
     * @var int|null
     */
    protected ?int $jwtTokenAcquiredAt = null;

    /**
     * Token TTL in seconds (4 minutes, safe margin on 5-min expiry).
     */
    protected const TOKEN_TTL_SECONDS = 240;

    /**
     * NOWPaymentsClient constructor.
     *
     * @param GuzzleClient $client
     * @param string $apiKey
     * @param string $ipnSecret
     * @param string $dashboardEmail
     * @param string $dashboardPassword
     */
    public function __construct(
        GuzzleClient $client,
        string $apiKey,
        string $ipnSecret = '',
        string $dashboardEmail = '',
        string $dashboardPassword = ''
    ) {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->ipnSecret = $ipnSecret;
        $this->dashboardEmail = $dashboardEmail;
        $this->dashboardPassword = $dashboardPassword;
    }

    /**
     * Send a GET request.
     *
     * @param string $uri
     * @param array $query
     * @param bool $requiresAuth
     * @return array
     * @throws NowPaymentsException
     */
    public function get(string $uri, array $query = [], bool $requiresAuth = false): array
    {
        $options = [
            'query' => $query,
        ];

        $this->addHeaders($options, $requiresAuth);

        try {
            $response = $this->client->get($uri, $options);
            return $this->handleResponse($response);
        } catch (GuzzleException $e) {
            throw $this->handleGuzzleException($e);
        }
    }

    /**
     * Send a POST request.
     *
     * @param string $uri
     * @param array $data
     * @param bool $requiresAuth
     * @return array
     * @throws NowPaymentsException
     */
    public function post(string $uri, array $data = [], bool $requiresAuth = false): array
    {
        $options = [
            'json' => $data,
        ];

        $this->addHeaders($options, $requiresAuth);

        try {
            $response = $this->client->post($uri, $options);
            return $this->handleResponse($response);
        } catch (GuzzleException $e) {
            throw $this->handleGuzzleException($e);
        }
    }

    /**
     * Send a PATCH request.
     *
     * @param string $uri
     * @param array $data
     * @param bool $requiresAuth
     * @return array
     * @throws NowPaymentsException
     */
    public function patch(string $uri, array $data = [], bool $requiresAuth = false): array
    {
        $options = [
            'json' => $data,
        ];

        $this->addHeaders($options, $requiresAuth);

        try {
            $response = $this->client->patch($uri, $options);
            return $this->handleResponse($response);
        } catch (GuzzleException $e) {
            throw $this->handleGuzzleException($e);
        }
    }

    /**
     * Send a DELETE request.
     *
     * @param string $uri
     * @param bool $requiresAuth
     * @return array
     * @throws NowPaymentsException
     */
    public function delete(string $uri, bool $requiresAuth = false): array
    {
        $options = [];

        $this->addHeaders($options, $requiresAuth);

        try {
            $response = $this->client->delete($uri, $options);
            return $this->handleResponse($response);
        } catch (GuzzleException $e) {
            throw $this->handleGuzzleException($e);
        }
    }

    /**
     * Add required headers to request options.
     *
     * @param array $options
     * @param bool $requiresAuth
     * @return void
     * @throws NowPaymentsException
     */
    protected function addHeaders(array &$options, bool $requiresAuth = false): void
    {
        // Always add API key header
        $options['headers']['x-api-key'] = $this->apiKey;

        // Add Bearer token if authentication is required
        if ($requiresAuth) {
            $token = $this->getJwtToken();
            $options['headers']['Authorization'] = 'Bearer ' . $token;
        }
    }

    /**
     * Handle API response.
     *
     * @param ResponseInterface $response
     * @return array
     * @throws NowPaymentsException
     */
    protected function handleResponse(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();
        $contents = $response->getBody()->getContents();
        $body = json_decode($contents, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new NowPaymentsException(
                'Invalid JSON response: ' . json_last_error_msg(),
                $statusCode
            );
        }

        if ($statusCode >= 400) {
            $message = $body['message'] ?? $body['error'] ?? 'Unknown error occurred';
            throw new NowPaymentsException($message, $statusCode);
        }

        return is_array($body) ? $body : [];
    }

    /**
     * Handle Guzzle exception.
     *
     * @param GuzzleException $e
     * @return NowPaymentsException
     */
    protected function handleGuzzleException(GuzzleException $e): NowPaymentsException
    {
        if ($e->hasResponse()) {
            $response = $e->getResponse();
            $contents = $response->getBody()->getContents();
            $body = json_decode($contents, true);

            if (is_array($body)) {
                $message = $body['message'] ?? $body['error'] ?? $e->getMessage();
            } else {
                $message = $e->getMessage();
            }

            return new NowPaymentsException($message, $response->getStatusCode());
        }

        return new NowPaymentsException($e->getMessage(), $e->getCode());
    }

    /**
     * Get JWT token, authenticating if necessary.
     *
     * @return string
     * @throws NowPaymentsException
     */
    public function getJwtToken(): string
    {
        // Check if token exists and hasn't expired
        if ($this->jwtToken !== null && $this->jwtTokenAcquiredAt !== null) {
            if (time() - $this->jwtTokenAcquiredAt < self::TOKEN_TTL_SECONDS) {
                return $this->jwtToken;
            }
            // Token expired, reset and re-authenticate
            $this->jwtToken = null;
            $this->jwtTokenAcquiredAt = null;
        }

        if (empty($this->dashboardEmail) || empty($this->dashboardPassword)) {
            throw NowPaymentsException::authenticationFailed(
                'Dashboard credentials not configured'
            );
        }

        try {
            $response = $this->client->post('/v1/auth', [
                'json' => [
                    'email' => $this->dashboardEmail,
                    'password' => $this->dashboardPassword,
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            if (!isset($body['token'])) {
                throw NowPaymentsException::authenticationFailed('Token not returned');
            }

            $this->jwtToken = $body['token'];
            $this->jwtTokenAcquiredAt = time();

            return $this->jwtToken;
        } catch (GuzzleException $e) {
            throw $this->handleGuzzleException($e);
        }
    }

    /**
     * Set JWT token manually.
     *
     * @param string $token
     * @return $this
     */
    public function setJwtToken(string $token): self
    {
        $this->jwtToken = $token;
        return $this;
    }

    /**
     * Get the API key.
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Get the IPN secret.
     *
     * @return string
     */
    public function getIpnSecret(): string
    {
        return $this->ipnSecret;
    }
}
