<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Endpoints;

use SerenityTechnologies\NowPayments\Client\NowPaymentsClient;
use SerenityTechnologies\NowPayments\DTOs\Request\FiatAccountRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\FiatPayoutRequest;
use SerenityTechnologies\NowPayments\DTOs\Response\FiatProvidersResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\FiatCurrenciesResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\FiatCryptoCurrenciesResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\FiatPaymentMethodsResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\FiatAccountResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\FiatAccountListResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\FiatPayoutResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\FiatPayoutListResponse;

/**
 * Endpoint for fiat payout-related operations.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class FiatPayoutEndpoint
{
    public function __construct(
        protected NowPaymentsClient $client
    ) {
    }

    /**
     * Get available fiat providers.
     *
     * @return FiatProvidersResponse
     *
     * @see https://api.nowpayments.io/v1/fiat-payouts/providers
     */
    public function getProviders(): FiatProvidersResponse
    {
        $response = $this->client->get('/v1/fiat-payouts/providers', query: [], requiresAuth: true);

        return FiatProvidersResponse::fromArray($response);
    }

    /**
     * Get supported fiat currencies.
     *
     * @return FiatCurrenciesResponse
     *
     * @see https://api.nowpayments.io/v1/fiat-payouts/fiat-currencies
     */
    public function getFiatCurrencies(): FiatCurrenciesResponse
    {
        $response = $this->client->get('/v1/fiat-payouts/fiat-currencies', query: [], requiresAuth: true);

        return FiatCurrenciesResponse::fromArray($response);
    }

    /**
     * Get supported crypto currencies for fiat payouts.
     *
     * @param string $provider The provider code
     * @param string $currency The fiat currency
     * @return FiatCryptoCurrenciesResponse
     *
     * @see https://api.nowpayments.io/v1/fiat-payouts/crypto-currencies
     */
    public function getCryptoCurrencies(string $provider, string $currency): FiatCryptoCurrenciesResponse
    {
        $response = $this->client->get(
            '/v1/fiat-payouts/crypto-currencies',
            ['provider' => $provider, 'currency' => $currency],
            requiresAuth: true
        );

        return FiatCryptoCurrenciesResponse::fromArray($response);
    }

    /**
     * Get available payment methods for a provider and currency.
     *
     * @param string $provider The provider code
     * @param string $currency The fiat currency
     * @return FiatPaymentMethodsResponse
     *
     * @see https://api.nowpayments.io/v1/fiat-payouts/payment-methods
     */
    public function getPaymentMethods(string $provider, string $currency): FiatPaymentMethodsResponse
    {
        $response = $this->client->get(
            '/v1/fiat-payouts/payment-methods',
            ['provider' => $provider, 'currency' => $currency],
            requiresAuth: true
        );

        return FiatPaymentMethodsResponse::fromArray($response);
    }

    /**
     * Create a fiat account.
     *
     * @param FiatAccountRequest $request
     * @return FiatAccountResponse
     *
     * @see https://api.nowpayments.io/v1/fiat-payouts/account
     */
    public function createAccount(FiatAccountRequest $request): FiatAccountResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/fiat-payouts/account', $request->toArray(), requiresAuth: true);

        return FiatAccountResponse::fromArray($response);
    }

    /**
     * List fiat accounts with optional filters.
     *
     * @param array<string, mixed> $filters
     * @return FiatAccountListResponse
     *
     * @see https://api.nowpayments.io/v1/fiat-payouts/accounts
     */
    public function listAccounts(array $filters = []): FiatAccountListResponse
    {
        $response = $this->client->get('/v1/fiat-payouts/accounts', $filters, requiresAuth: true);

        return FiatAccountListResponse::fromArray($response);
    }

    /**
     * Request a fiat payout.
     *
     * @param FiatPayoutRequest $request
     * @return FiatPayoutResponse
     *
     * @see https://api.nowpayments.io/v1/fiat-payouts
     */
    public function requestFiatPayout(FiatPayoutRequest $request): FiatPayoutResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/fiat-payouts', $request->toArray(), requiresAuth: true);

        return FiatPayoutResponse::fromArray($response);
    }

    /**
     * List fiat payouts with optional filters.
     *
     * @param array<string, mixed> $filters
     * @return FiatPayoutListResponse
     *
     * @see https://api.nowpayments.io/v1/fiat-payouts
     */
    public function listFiatPayouts(array $filters = []): FiatPayoutListResponse
    {
        $response = $this->client->get('/v1/fiat-payouts', $filters, requiresAuth: true);

        return FiatPayoutListResponse::fromArray($response);
    }
}
