<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Endpoints;

use SerenityTechnologies\NowPayments\Client\NowPaymentsClient;
use SerenityTechnologies\NowPayments\DTOs\Request\SubPartnerRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\TransferRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\SubPartnerDepositRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\SubPartnerPaymentRequest;
use SerenityTechnologies\NowPayments\DTOs\Response\BalanceResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\SubPartnerResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\SubPartnerListResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\TransferResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\TransferListResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\PaymentResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\PaymentListResponse;

/**
 * Endpoint for sub-partner-related operations.
 */
class SubPartnerEndpoint
{
    public function __construct(
        protected NowPaymentsClient $client
    ) {
    }

    /**
     * Create a new sub-partner.
     *
     * @param SubPartnerRequest $request
     * @return SubPartnerResponse
     *
     * @see https://api.nowpayments.io/v1/sub-partner/balance
     */
    public function createSubPartner(SubPartnerRequest $request): SubPartnerResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/sub-partner/balance', $request->toArray(), requiresAuth: true);

        return SubPartnerResponse::fromArray($response);
    }

    /**
     * Get sub-partner balance by ID.
     *
     * @param string $id The sub-partner ID
     * @return BalanceResponse
     *
     * @see https://api.nowpayments.io/v1/sub-partner/balance/{id}
     */
    public function getSubPartnerBalance(string $id): BalanceResponse
    {
        $response = $this->client->get('/v1/sub-partner/balance/' . $id, query: [], requiresAuth: false);

        return BalanceResponse::fromArray($response);
    }

    /**
     * List sub-partners with optional filters.
     *
     * @param array<string, mixed> $filters
     * @return SubPartnerListResponse
     *
     * @see https://api.nowpayments.io/v1/sub-partner
     */
    public function listSubPartners(array $filters = []): SubPartnerListResponse
    {
        $response = $this->client->get('/v1/sub-partner', $filters, requiresAuth: true);

        return SubPartnerListResponse::fromArray($response);
    }

    /**
     * Transfer funds to a sub-partner.
     *
     * @param TransferRequest $request
     * @return TransferResponse
     *
     * @see https://api.nowpayments.io/v1/sub-partner/transfer
     */
    public function transferFunds(TransferRequest $request): TransferResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/sub-partner/transfer', $request->toArray(), requiresAuth: true);

        return TransferResponse::fromArray($response);
    }

    /**
     * Get transfer details by ID.
     *
     * @param string $id The transfer ID
     * @return TransferResponse
     *
     * @see https://api.nowpayments.io/v1/sub-partner/transfer/{id}
     */
    public function getTransfer(string $id): TransferResponse
    {
        $response = $this->client->get('/v1/sub-partner/transfer/' . $id, query: [], requiresAuth: true);

        return TransferResponse::fromArray($response);
    }

    /**
     * List transfers with optional filters.
     *
     * @param array<string, mixed> $filters
     * @return TransferListResponse
     *
     * @see https://api.nowpayments.io/v1/sub-partner/transfers
     */
    public function listTransfers(array $filters = []): TransferListResponse
    {
        $response = $this->client->get('/v1/sub-partner/transfers', $filters, requiresAuth: true);

        return TransferListResponse::fromArray($response);
    }

    /**
     * Deposit funds to a sub-partner.
     *
     * @param SubPartnerDepositRequest $request
     * @return TransferResponse
     *
     * @see https://api.nowpayments.io/v1/sub-partner/deposit
     */
    public function depositToSubPartner(SubPartnerDepositRequest $request): TransferResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/sub-partner/deposit', $request->toArray(), requiresAuth: true);

        return TransferResponse::fromArray($response);
    }

    /**
     * Write off funds from a sub-partner.
     *
     * @param SubPartnerDepositRequest $request
     * @return TransferResponse
     *
     * @see https://api.nowpayments.io/v1/sub-partner/write-off
     */
    public function writeOffFromSubPartner(SubPartnerDepositRequest $request): TransferResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/sub-partner/write-off', $request->toArray(), requiresAuth: true);

        return TransferResponse::fromArray($response);
    }

    /**
     * Create a payment for a sub-partner.
     *
     * @param SubPartnerPaymentRequest $request
     * @return PaymentResponse
     *
     * @see https://api.nowpayments.io/v1/sub-partner/payment
     */
    public function createSubPartnerPayment(SubPartnerPaymentRequest $request): PaymentResponse
    {
        $request->validate();
        $response = $this->client->post('/v1/sub-partner/payment', $request->toArray(), requiresAuth: true);

        return PaymentResponse::fromArray($response);
    }

    /**
     * Get sub-partner payments with optional filters.
     *
     * @param array<string, mixed> $filters
     * @return PaymentListResponse
     *
     * @see https://api.nowpayments.io/v1/sub-partner/payments
     */
    public function getSubPartnerPayments(array $filters = []): PaymentListResponse
    {
        $response = $this->client->get('/v1/sub-partner/payments', $filters, requiresAuth: true);

        return PaymentListResponse::fromArray($response);
    }
}
