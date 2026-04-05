<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Endpoints;

use SerenityTechnologies\NowPayments\Client\NowPaymentsClient;
use SerenityTechnologies\NowPayments\DTOs\Request\EstimateRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\MinAmountRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\PaymentListQuery;
use SerenityTechnologies\NowPayments\DTOs\Request\PaymentRequest;
use SerenityTechnologies\NowPayments\DTOs\Response\EstimateResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\MinAmountResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\PaymentListResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\PaymentResponse;
use SerenityTechnologies\NowPayments\Exceptions\NowPaymentsException;

/**
 * Endpoint for payment-related operations.
 *
 * @see https://documenter.getpostman.com/view/7549238/SVfJ6R1w
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class PaymentEndpoint
{
    public function __construct(
        protected NowPaymentsClient $client
    ) {
    }

    /**
     * Create a new payment.
     *
     * @param PaymentRequest $request
     * @return PaymentResponse
     *
     * @see https://api.nowpayments.io/v1/payment
     */
    public function createPayment(PaymentRequest $request): PaymentResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/payment', $request->toArray(), requiresAuth: false);

        return PaymentResponse::fromArray($response);
    }

    /**
     * Get payment status by payment ID.
     *
     * @param string $paymentId The payment ID
     * @return PaymentResponse
     *
     * @see https://api.nowpayments.io/v1/payment/{id}
     */
    public function getPaymentStatus(string $paymentId): PaymentResponse
    {
        $response = $this->client->get('/v1/payment/' . $paymentId, query: [], requiresAuth: false);

        return PaymentResponse::fromArray($response);
    }

    /**
     * Get a list of payments with pagination and filtering.
     *
     * @param PaymentListQuery $query
     * @return PaymentListResponse
     *
     * @see https://api.nowpayments.io/v1/payment/
     */
    public function getListPayments(PaymentListQuery $query): PaymentListResponse
    {
        $query->validate();
        $response = $this->client->get('/v1/payment/', $query->toArray(), requiresAuth: false);

        return PaymentListResponse::fromArray($response);
    }

    /**
     * Get estimated amount for a currency conversion.
     *
     * @param EstimateRequest $request
     * @return EstimateResponse
     *
     * @see https://api.nowpayments.io/v1/estimate
     */
    public function getEstimate(EstimateRequest $request): EstimateResponse
    {
        $request->validate();
        $response = $this->client->get('/v1/estimate', $request->toArray(), requiresAuth: false);

        return EstimateResponse::fromArray($response);
    }

    /**
     * Get minimum payment amount for a currency pair.
     *
     * @param MinAmountRequest $request
     * @return MinAmountResponse
     *
     * @throws NowPaymentsException
     * @see https://api.nowpayments.io/v1/min-amount
     */
    public function getMinAmount(MinAmountRequest $request): MinAmountResponse
    {
        $request->validate();
        $response = $this->client->get('/v1/min-amount', $request->toArray(), requiresAuth: false);

        return MinAmountResponse::fromArray($response);
    }

    /**
     * Update merchant estimate for a payment.
     *
     * @param string $paymentId The payment ID
     * @param array<string, mixed> $data The estimate data
     * @return array<string, mixed>
     *
     * @throws NowPaymentsException
     * @see https://api.nowpayments.io/v1/payment/{id}/update-merchant-estimate
     */
    public function updateMerchantEstimate(string $paymentId, array $data): array
    {
        return $this->client->post('/v1/payment/' . $paymentId . '/update-merchant-estimate', $data, requiresAuth: false);
    }
}
