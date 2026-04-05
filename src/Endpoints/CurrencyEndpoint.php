<?php declare(strict_types=1);

/**
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
namespace SerenityTechnologies\NowPayments\Endpoints;

use SerenityTechnologies\NowPayments\Client\NowPaymentsClient;
use SerenityTechnologies\NowPayments\DTOs\Response\CurrencyResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\FullCurrencyResponse;

class CurrencyEndpoint
{
    public function __construct(
        protected NowPaymentsClient $client
    ) {
    }

    /**
     * Get available currencies.
     *
     * @param bool $fixedRate
     * @return CurrencyResponse
     */
    public function getAvailableCurrencies(bool $fixedRate = false): CurrencyResponse
    {
        $response = $this->client->get('/v1/currencies', ['fixed_rate' => $fixedRate]);
        return CurrencyResponse::fromArray($response);
    }

    /**
     * Get full currencies list with details.
     *
     * @return FullCurrencyResponse
     */
    public function getFullCurrencies(): FullCurrencyResponse
    {
        $response = $this->client->get('/v1/full-currencies');
        return FullCurrencyResponse::fromArray($response);
    }

    /**
     * Get available checked currencies (from coins settings).
     *
     * @return CurrencyResponse
     */
    public function getMerchantCoins(): CurrencyResponse
    {
        $response = $this->client->get('/v1/merchant/coins');
        return CurrencyResponse::fromArray($response);
    }
}
