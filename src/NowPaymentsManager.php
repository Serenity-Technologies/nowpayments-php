<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments;

use SerenityTechnologies\NowPayments\Client\NowPaymentsClient;
use SerenityTechnologies\NowPayments\Services\{
    AuthService,
    CurrencyService,
    PaymentService,
    InvoiceService,
    PayoutService,
    ConversionService,
    SubPartnerService,
    SubscriptionService,
    FiatPayoutService
};
use SerenityTechnologies\NowPayments\Exceptions\NowPaymentsException;
use SerenityTechnologies\NowPayments\Handlers\IpnHandler;
use SerenityTechnologies\NowPayments\DTOs\Request\{
    AuthRequest,
    PaymentRequest,
    InvoiceRequest,
    InvoicePaymentRequest,
    PayoutRequest,
    PayoutAddressRequest,
    PayoutVerificationRequest,
    ConversionRequest,
    SubPartnerRequest,
    SubPartnerPaymentRequest,
    SubPartnerDepositRequest,
    TransferRequest,
    PlanRequest,
    SubscriptionRequest,
    FiatAccountRequest,
    FiatPayoutRequest,
    EstimateRequest,
    MinAmountRequest,
    PaymentListQuery
};
use SerenityTechnologies\NowPayments\DTOs\Response\{
    ApiStatusResponse,
    AuthResponse,
    CurrencyResponse,
    FullCurrencyResponse,
    PaymentResponse,
    PaymentListResponse,
    InvoiceResponse,
    PayoutResponse,
    PayoutStatusResponse,
    PayoutListResponse,
    BalanceResponse,
    ConversionResponse,
    ConversionListResponse,
    SubPartnerResponse,
    SubPartnerListResponse,
    TransferResponse,
    TransferListResponse,
    PlanResponse,
    PlanListResponse,
    SubscriptionResponse,
    SubscriptionListResponse,
    FiatProvidersResponse,
    FiatCurrenciesResponse,
    FiatCryptoCurrenciesResponse,
    FiatPaymentMethodsResponse,
    FiatAccountResponse,
    FiatAccountListResponse,
    FiatPayoutResponse,
    FiatPayoutListResponse,
    EstimateResponse,
    MinAmountResponse,
    FeeEstimateResponse,
    MinWithdrawalAmountResponse
};

/**
 * High-level manager that proxies to all NOWPayments endpoints.
 *
 * This class provides a convenient facade-friendly interface to all 9 endpoint
 * classes, allowing static access like NowPayments::createPayment().
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class NowPaymentsManager
{
    public function __construct(
        protected AuthService         $auth,
        protected CurrencyService     $currency,
        protected PaymentService      $payment,
        protected InvoiceService      $invoice,
        protected PayoutService       $payout,
        protected ConversionService   $conversion,
        protected SubPartnerService   $subPartner,
        protected SubscriptionService $subscription,
        protected FiatPayoutService   $fiatPayout,
        protected IpnHandler          $ipnHandler,
        protected NowPaymentsClient   $client
    ) {
    }

    /* ==================== Auth & Status ==================== */

    public function getStatus(): ApiStatusResponse
    {
        return $this->auth->getStatus();
    }

    /**
     * @throws NowPaymentsException
     */
    public function authenticate(AuthRequest $request): AuthResponse
    {
        return $this->auth->authenticate($request);
    }

    /* ==================== Currencies ==================== */

    public function getAvailableCurrencies(bool $fixedRate = false): CurrencyResponse
    {
        return $this->currency->getAvailableCurrencies($fixedRate);
    }

    public function getFullCurrencies(): FullCurrencyResponse
    {
        return $this->currency->getFullCurrencies();
    }

    public function getMerchantCoins(): CurrencyResponse
    {
        return $this->currency->getMerchantCoins();
    }

    /* ==================== Payments ==================== */

    public function createPayment(PaymentRequest $request): PaymentResponse
    {
        return $this->payment->createPayment($request);
    }

    public function getPaymentStatus(string $paymentId): PaymentResponse
    {
        return $this->payment->getPaymentStatus($paymentId);
    }

    public function getListPayments(PaymentListQuery $query): PaymentListResponse
    {
        return $this->payment->getListPayments($query);
    }

    public function getEstimate(EstimateRequest $request): EstimateResponse
    {
        return $this->payment->getEstimate($request);
    }

    /**
     * @throws NowPaymentsException
     */
    public function getMinAmount(MinAmountRequest $request): MinAmountResponse
    {
        return $this->payment->getMinAmount($request);
    }

    /* ==================== Invoices ==================== */

    public function createInvoice(InvoiceRequest $request): InvoiceResponse
    {
        return $this->invoice->createInvoice($request);
    }

    public function createInvoicePayment(InvoicePaymentRequest $request): PaymentResponse
    {
        return $this->invoice->createInvoicePayment($request);
    }

    /* ==================== Payouts ==================== */

    public function getBalance(): BalanceResponse
    {
        return $this->payout->getBalance();
    }

    /**
     * @throws NowPaymentsException
     */
    public function validateAddress(PayoutAddressRequest $request): bool
    {
        return $this->payout->validateAddress($request);
    }

    public function createPayout(PayoutRequest $request): PayoutResponse
    {
        return $this->payout->createPayout($request);
    }

    public function listPayouts(array $filters = []): PayoutListResponse
    {
        return $this->payout->listPayouts($filters);
    }

    public function getPayoutStatus(string $payoutId): PayoutStatusResponse
    {
        return $this->payout->getPayoutStatus($payoutId);
    }

    public function verifyPayout(string $batchWithdrawalId, PayoutVerificationRequest $request): bool
    {
        return $this->payout->verifyPayout($batchWithdrawalId, $request);
    }

    public function cancelPayout(string $withdrawalId): PayoutStatusResponse
    {
        return $this->payout->cancelPayout($withdrawalId);
    }

    public function getMinWithdrawalAmount(string $coin): MinWithdrawalAmountResponse
    {
        return $this->payout->getMinWithdrawalAmount($coin);
    }

    public function getPayoutFeeEstimate(): FeeEstimateResponse
    {
        return $this->payout->getPayoutFeeEstimate();
    }

    /* ==================== Conversions ==================== */

    public function createConversion(ConversionRequest $request): ConversionResponse
    {
        return $this->conversion->createConversion($request);
    }

    public function listConversions(array $filters = []): ConversionListResponse
    {
        return $this->conversion->listConversions($filters);
    }

    public function getConversionStatus(string $conversionId): ConversionResponse
    {
        return $this->conversion->getConversionStatus($conversionId);
    }

    /* ==================== Sub-Partners ==================== */

    public function createSubPartner(SubPartnerRequest $request): SubPartnerResponse
    {
        return $this->subPartner->createSubPartner($request);
    }

    public function getSubPartnerBalance(string $id): BalanceResponse
    {
        return $this->subPartner->getSubPartnerBalance($id);
    }

    public function listSubPartners(array $filters = []): SubPartnerListResponse
    {
        return $this->subPartner->listSubPartners($filters);
    }

    public function transferFunds(TransferRequest $request): TransferResponse
    {
        return $this->subPartner->transferFunds($request);
    }

    public function getTransfer(string $id): TransferResponse
    {
        return $this->subPartner->getTransfer($id);
    }

    public function listTransfers(array $filters = []): TransferListResponse
    {
        return $this->subPartner->listTransfers($filters);
    }

    public function depositToSubPartner(SubPartnerDepositRequest $request): TransferResponse
    {
        return $this->subPartner->depositToSubPartner($request);
    }

    public function writeOffFromSubPartner(SubPartnerDepositRequest $request): TransferResponse
    {
        return $this->subPartner->writeOffFromSubPartner($request);
    }

    public function createSubPartnerPayment(SubPartnerPaymentRequest $request): PaymentResponse
    {
        return $this->subPartner->createSubPartnerPayment($request);
    }

    public function getSubPartnerPayments(array $filters = []): PaymentListResponse
    {
        return $this->subPartner->getSubPartnerPayments($filters);
    }

    /* ==================== Subscriptions ==================== */

    public function createPlan(PlanRequest $request): PlanResponse
    {
        return $this->subscription->createPlan($request);
    }

    public function listPlans(array $filters = []): PlanListResponse
    {
        return $this->subscription->listPlans($filters);
    }

    public function getPlan(string $planId): PlanResponse
    {
        return $this->subscription->getPlan($planId);
    }

    public function updatePlan(string $planId, array $data): PlanResponse
    {
        return $this->subscription->updatePlan($planId, $data);
    }

    public function createSubscription(SubscriptionRequest $request): SubscriptionResponse
    {
        return $this->subscription->createSubscription($request);
    }

    public function listSubscriptions(array $filters = []): SubscriptionListResponse
    {
        return $this->subscription->listSubscriptions($filters);
    }

    public function getSubscription(string $subId): SubscriptionResponse
    {
        return $this->subscription->getSubscription($subId);
    }

    public function deleteSubscription(string $subId): bool
    {
        return $this->subscription->deleteSubscription($subId);
    }

    /* ==================== Fiat Payouts ==================== */

    public function getProviders(): FiatProvidersResponse
    {
        return $this->fiatPayout->getProviders();
    }

    public function getFiatCurrencies(): FiatCurrenciesResponse
    {
        return $this->fiatPayout->getFiatCurrencies();
    }

    public function getCryptoCurrencies(string $provider, string $currency): FiatCryptoCurrenciesResponse
    {
        return $this->fiatPayout->getCryptoCurrencies($provider, $currency);
    }

    public function getPaymentMethods(string $provider, string $currency): FiatPaymentMethodsResponse
    {
        return $this->fiatPayout->getPaymentMethods($provider, $currency);
    }

    public function createFiatAccount(FiatAccountRequest $request): FiatAccountResponse
    {
        return $this->fiatPayout->createAccount($request);
    }

    public function listFiatAccounts(array $filters = []): FiatAccountListResponse
    {
        return $this->fiatPayout->listAccounts($filters);
    }

    public function requestFiatPayout(FiatPayoutRequest $request): FiatPayoutResponse
    {
        return $this->fiatPayout->requestFiatPayout($request);
    }

    public function listFiatPayouts(array $filters = []): FiatPayoutListResponse
    {
        return $this->fiatPayout->listFiatPayouts($filters);
    }

    /* ==================== IPN / Webhooks ==================== */

    /**
     * @throws NowPaymentsException
     */
    public function verifyIpnSignature(array $data, string $signature): bool
    {
        return $this->ipnHandler->verifySignature($data, $signature);
    }

    /**
     * @throws NowPaymentsException
     */
    public function processIpn(array $data, string $signature): array
    {
        return $this->ipnHandler->processIpn($data, $signature);
    }

    public function isIpnRetry(array $data): bool
    {
        return $this->ipnHandler->isRetry($data);
    }

    /* ==================== Client Access ==================== */

    public function client(): NowPaymentsClient
    {
        return $this->client;
    }
}
