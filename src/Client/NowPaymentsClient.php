<?php

/**
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
namespace SerenityTechnologies\NowPayments\Client;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use SerenityTechnologies\NowPayments\Exceptions\NowPaymentsException;

class NowPaymentsClient
{
    /**
     * @var string
     */
    protected string $baseUrl;

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
     * @param string $apiKey
     * @param string $ipnSecret
     * @param string $dashboardEmail
     * @param string $dashboardPassword
     * @param string $baseUrl
     */
    public function __construct(
        string $apiKey,
        string $ipnSecret = '',
        string $dashboardEmail = '',
        string $dashboardPassword = '',
        string $baseUrl = 'https://api.nowpayments.io'
    ) {
        $this->apiKey = $apiKey;
        $this->ipnSecret = $ipnSecret;
        $this->dashboardEmail = $dashboardEmail;
        $this->dashboardPassword = $dashboardPassword;
        $this->baseUrl = rtrim($baseUrl, '/');
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
        try {
            $response = $this->buildRequest($requiresAuth)->get($uri, $query);
            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            throw $this->handleConnectionException($e);
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
        try {
            $response = $this->buildRequest($requiresAuth)->post($uri, $data);
            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            throw $this->handleConnectionException($e);
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
        try {
            $response = $this->buildRequest($requiresAuth)->patch($uri, $data);
            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            throw $this->handleConnectionException($e);
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
        try {
            $response = $this->buildRequest($requiresAuth)->delete($uri);
            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            throw $this->handleConnectionException($e);
        }
    }

    /**
     * Build the HTTP request with common headers.
     *
     * @param bool $requiresAuth
     * @return PendingRequest
     * @throws NowPaymentsException
     */
    protected function buildRequest(bool $requiresAuth = false): PendingRequest
    {
        $request = Http::baseUrl($this->baseUrl)
            ->withUserAgent('SerenityTechnologies/NowPaymentsClient')
            ->withHeaders([
                'x-api-key' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);

        // Add Bearer token if authentication is required
        if ($requiresAuth) {
            $token = $this->getJwtToken();
            $request->withToken($token);
        }

        return $request->throw(function (Response $response) {
            if ($response->failed()) {
                $this->handleFailedResponse($response);
            }
        });
    }

    /**
     * Handle API response.
     *
     * @param Response $response
     * @return array
     * @throws NowPaymentsException
     */
    protected function handleResponse(Response $response): array
    {
        $body = $response->json();

        if ($body === null || $body === false) {
            throw new NowPaymentsException(
                'Invalid JSON response',
                $response->status()
            );
        }

        return is_array($body) ? $body : [];
    }

    /**
     * Handle failed API response.
     *
     * @param Response $response
     * @throws NowPaymentsException
     */
    protected function handleFailedResponse(Response $response): void
    {
        $body = $response->json();
        $message = $body['message'] ?? $body['error'] ?? 'Unknown error occurred';
        throw new NowPaymentsException($message, $response->status());
    }

    /**
     * Handle connection exception.
     *
     * @param ConnectionException $e
     * @return NowPaymentsException
     */
    protected function handleConnectionException(ConnectionException $e): NowPaymentsException
    {
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
            $response = Http::baseUrl($this->baseUrl)
                ->withUserAgent('SerenityTechnologies/NowPaymentsClient')
                ->withHeaders([
                    'x-api-key' => $this->apiKey,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post('/v1/auth', [
                    'email' => $this->dashboardEmail,
                    'password' => $this->dashboardPassword,
                ]);

            if ($response->failed()) {
                $this->handleFailedResponse($response);
            }

            $body = $response->json();

            if (!isset($body['token'])) {
                throw NowPaymentsException::authenticationFailed('Token not returned');
            }

            $this->jwtToken = $body['token'];
            $this->jwtTokenAcquiredAt = time();

            return $this->jwtToken;
        } catch (NowPaymentsException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new NowPaymentsException($e->getMessage(), $e->getCode());
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
