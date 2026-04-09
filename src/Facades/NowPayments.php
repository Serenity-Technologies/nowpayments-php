<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Facades;

use Illuminate\Support\Facades\Facade;
use SerenityTechnologies\NowPayments\NowPaymentsManager;

/**
 * NOWPayments Facade - provides static access to all API endpoints.
 *
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\ApiStatusResponse getStatus()
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\AuthResponse authenticate(\SerenityTechnologies\NowPayments\DTOs\Request\AuthRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\CurrencyResponse getAvailableCurrencies(bool $fixedRate = false)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\FullCurrencyResponse getFullCurrencies()
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\CurrencyResponse getMerchantCoins()
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PaymentResponse createPayment(\SerenityTechnologies\NowPayments\DTOs\Request\PaymentRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PaymentResponse getPaymentStatus(string $paymentId)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PaymentListResponse getListPayments(\SerenityTechnologies\NowPayments\DTOs\Request\PaymentListQuery $query)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\EstimateResponse getEstimate(\SerenityTechnologies\NowPayments\DTOs\Request\EstimateRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\MinAmountResponse getMinAmount(\SerenityTechnologies\NowPayments\DTOs\Request\MinAmountRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\InvoiceResponse createInvoice(\SerenityTechnologies\NowPayments\DTOs\Request\InvoiceRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PaymentResponse createInvoicePayment(\SerenityTechnologies\NowPayments\DTOs\Request\InvoicePaymentRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\BalanceResponse getBalance()
 * @method static bool validateAddress(\SerenityTechnologies\NowPayments\DTOs\Request\PayoutAddressRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PayoutResponse createPayout(\SerenityTechnologies\NowPayments\DTOs\Request\PayoutRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PayoutListResponse listPayouts(array $filters = [])
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PayoutStatusResponse getPayoutStatus(string $payoutId)
 * @method static bool verifyPayout(string $batchWithdrawalId, \SerenityTechnologies\NowPayments\DTOs\Request\PayoutVerificationRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PayoutStatusResponse cancelPayout(string $withdrawalId)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\MinWithdrawalAmountResponse getMinWithdrawalAmount(string $coin)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\FeeEstimateResponse getPayoutFeeEstimate()
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\ConversionResponse createConversion(\SerenityTechnologies\NowPayments\DTOs\Request\ConversionRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\ConversionListResponse listConversions(array $filters = [])
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\ConversionResponse getConversionStatus(string $conversionId)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\SubPartnerResponse createSubPartner(\SerenityTechnologies\NowPayments\DTOs\Request\SubPartnerRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\BalanceResponse getSubPartnerBalance(string $id)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\SubPartnerListResponse listSubPartners(array $filters = [])
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\TransferResponse transferFunds(\SerenityTechnologies\NowPayments\DTOs\Request\TransferRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\TransferResponse getTransfer(string $id)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\TransferListResponse listTransfers(array $filters = [])
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\TransferResponse depositToSubPartner(\SerenityTechnologies\NowPayments\DTOs\Request\SubPartnerDepositRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\TransferResponse writeOffFromSubPartner(\SerenityTechnologies\NowPayments\DTOs\Request\SubPartnerDepositRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PaymentResponse createSubPartnerPayment(\SerenityTechnologies\NowPayments\DTOs\Request\SubPartnerPaymentRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PaymentListResponse getSubPartnerPayments(array $filters = [])
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PlanResponse createPlan(\SerenityTechnologies\NowPayments\DTOs\Request\PlanRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PlanListResponse listPlans(array $filters = [])
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PlanResponse getPlan(string $planId)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\PlanResponse updatePlan(string $planId, array $data)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\SubscriptionResponse createSubscription(\SerenityTechnologies\NowPayments\DTOs\Request\SubscriptionRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\SubscriptionListResponse listSubscriptions(array $filters = [])
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\SubscriptionResponse getSubscription(string $subId)
 * @method static bool deleteSubscription(string $subId)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\FiatProvidersResponse getProviders()
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\FiatCurrenciesResponse getFiatCurrencies()
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\FiatCryptoCurrenciesResponse getCryptoCurrencies(string $provider, string $currency)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\FiatPaymentMethodsResponse getPaymentMethods(string $provider, string $currency)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\FiatAccountResponse createFiatAccount(\SerenityTechnologies\NowPayments\DTOs\Request\FiatAccountRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\FiatAccountListResponse listFiatAccounts(array $filters = [])
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\FiatPayoutResponse requestFiatPayout(\SerenityTechnologies\NowPayments\DTOs\Request\FiatPayoutRequest $request)
 * @method static \SerenityTechnologies\NowPayments\DTOs\Response\FiatPayoutListResponse listFiatPayouts(array $filters = [])
 * @method static bool verifyIpnSignature(array $data, string $signature)
 * @method static array processIpn(array $data, string $signature)
 * @method static bool isIpnRetry(array $data)
 * @method static \SerenityTechnologies\NowPayments\Client\NowPaymentsClient client()
 * @method static \SerenityTechnologies\NowPayments\Services\AuthService authService()
 * @method static \SerenityTechnologies\NowPayments\Services\PaymentService paymentService()
 * @method static \SerenityTechnologies\NowPayments\Services\PayoutService payoutService()
 * @method static \SerenityTechnologies\NowPayments\Services\ConversionService conversionService()
 * @method static \SerenityTechnologies\NowPayments\Services\CurrencyService currencyService()
 * @method static \SerenityTechnologies\NowPayments\Services\InvoiceService invoiceService()
 * @method static \SerenityTechnologies\NowPayments\Services\SubPartnerService subPartnerService()
 * @method static \SerenityTechnologies\NowPayments\Services\FiatPayoutService fiatPayoutService()
 * @method static \SerenityTechnologies\NowPayments\Services\SubscriptionService subscriptionService()
 *
 * @see \SerenityTechnologies\NowPayments\NowPaymentsManager
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class NowPayments extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'nowpayments';
    }
}
