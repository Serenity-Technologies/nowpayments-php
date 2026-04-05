<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Endpoints;

use SerenityTechnologies\NowPayments\Client\NowPaymentsClient;
use SerenityTechnologies\NowPayments\DTOs\Request\InvoicePaymentRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\InvoiceRequest;
use SerenityTechnologies\NowPayments\DTOs\Response\InvoiceResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\PaymentResponse;

/**
 * Endpoint for invoice-related operations.
 *
 * @see https://documenter.getpostman.com/view/7549238/SVfJ6R1w
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class InvoiceEndpoint
{
    public function __construct(
        protected NowPaymentsClient $client
    ) {
    }

    /**
     * Create a new invoice.
     *
     * @param InvoiceRequest $request
     * @return InvoiceResponse
     *
     * @see https://api.nowpayments.io/v1/invoice
     */
    public function createInvoice(InvoiceRequest $request): InvoiceResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/invoice', $request->toArray(), requiresAuth: false);

        return InvoiceResponse::fromArray($response);
    }

    /**
     * Create a payment for an existing invoice.
     *
     * @param InvoicePaymentRequest $request
     * @return PaymentResponse
     *
     * @see https://api.nowpayments.io/v1/invoice-payment
     */
    public function createInvoicePayment(InvoicePaymentRequest $request): PaymentResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/invoice-payment', $request->toArray(), requiresAuth: false);

        return PaymentResponse::fromArray($response);
    }
}
