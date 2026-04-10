<?php declare(strict_types=1);

/**
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
namespace SerenityTechnologies\NowPayments\Services;

use SerenityTechnologies\NowPayments\DTOs\Request\AuthRequest;
use SerenityTechnologies\NowPayments\Client\NowPaymentsClient;
use SerenityTechnologies\NowPayments\DTOs\Response\ApiStatusResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\AuthResponse;
use SerenityTechnologies\NowPayments\Exceptions\NowPaymentsException;

class AuthService
{
    public function __construct(
        protected NowPaymentsClient $client
    ) {
    }

    /**
     * Get API status.
     *
     * @return ApiStatusResponse
     * @throws NowPaymentsException
     */
    public function getStatus(): ApiStatusResponse
    {
        $response = $this->client->get('/v1/status');
        return ApiStatusResponse::fromArray($response);
    }

    /**
     * Authenticate with dashboard credentials.
     *
     * @param AuthRequest $request
     * @return AuthResponse
     * @throws NowPaymentsException
     */
    public function authenticate(AuthRequest $request): AuthResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/auth', $request->toArray());
        
        $authResponse = AuthResponse::fromArray($response);
        $this->client->setJwtToken($authResponse->token);
        
        return $authResponse;
    }

    /**
     * Get JWT token.
     *
     * @return string
     * @throws NowPaymentsException
     */
    public function getToken(): string
    {
        return $this->client->getJwtToken();
    }
}
