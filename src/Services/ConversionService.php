<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Services;

use SerenityTechnologies\NowPayments\Client\NowPaymentsClient;
use SerenityTechnologies\NowPayments\DTOs\Request\ConversionRequest;
use SerenityTechnologies\NowPayments\DTOs\Response\ConversionResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\ConversionListResponse;
use SerenityTechnologies\NowPayments\Exceptions\NowPaymentsException;

/**
 * Endpoint for conversion-related operations.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class ConversionService
{
    public function __construct(
        protected NowPaymentsClient $client
    ) {
    }

    /**
     * Create a new conversion.
     *
     * @param ConversionRequest $request
     * @return ConversionResponse
     *
     * @throws NowPaymentsException
     * @see https://api.nowpayments.io/v1/conversion
     */
    public function createConversion(ConversionRequest $request): ConversionResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/conversion', $request->toArray(), requiresAuth: true);

        return ConversionResponse::fromArray($response);
    }

    /**
     * List conversions with optional filters.
     *
     * @param array<string, mixed> $filters
     * @return ConversionListResponse
     *
     * @throws NowPaymentsException
     * @see https://api.nowpayments.io/v1/conversion
     */
    public function listConversions(array $filters = []): ConversionListResponse
    {
        $response = $this->client->get('/v1/conversion', $filters, requiresAuth: true);

        return ConversionListResponse::fromArray($response);
    }

    /**
     * Get conversion status by ID.
     *
     * @param string $conversionId The conversion ID
     * @return ConversionResponse
     *
     * @throws NowPaymentsException
     * @see https://api.nowpayments.io/v1/conversion/{id}
     */
    public function getConversionStatus(string $conversionId): ConversionResponse
    {
        $response = $this->client->get('/v1/conversion/' . $conversionId, query: [], requiresAuth: true);

        return ConversionResponse::fromArray($response);
    }
}
