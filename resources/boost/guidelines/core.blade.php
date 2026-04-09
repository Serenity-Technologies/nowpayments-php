## NOWPayments Laravel Package

This package provides a comprehensive Laravel integration for the NOWPayments cryptocurrency payment processing API, supporting all 52 endpoints with type-safe DTOs, status enums, webhook handling, Laravel events, and a unified facade.

### Features

- **52 API Services**: Complete coverage of Auth, Currencies, Payments, Invoices, Payouts, Conversions, Sub-Partners, Subscriptions, and Fiat Payouts.
- **Type-Safe DTOs**: Request DTOs with validation (URL format, positive amounts), Response DTOs with explicit numeric casting and `fromArray()` factories.
- **Status Enums**: `PaymentStatus`, `PayoutStatus`, `ConversionStatus`, `SubscriptionStatus` with helper methods (`isFinal()`, `isSuccessful()`, `isPending()`).
- **Webhook System**: IPN handler with HMAC-SHA512 verification, `HandlesIpnWebhooks` controller trait, auto-fired Laravel events, idempotency detection (`isRetry()`).
- **Unified Facade**: `NowPayments` facade proxies to all 52 methods via `NowPaymentsManager` — no DI required for simple use cases.
- **Query Builders**: Fluent pagination/filtering for list endpoints.
- **Laravel Events**: `PaymentStatusChanged`, `PayoutCompleted`, `ConversionFinished` auto-fired from webhook trait.

### Package Structure

```
src/
├── Client/NowPaymentsClient.php          # HTTP client (JWT expiry handling, SSL verification, error handling)
├── Config/nowpayments.php                 # Publishable config
├── DTOs/Request/                          # 20 request DTOs with validation
├── DTOs/Response/                         # 40 response DTOs with numeric casting + FeeResponse
├── Services/                             # 9 endpoint classes (auto-resolved via DI)
├── Events/                                # Laravel events (PaymentStatusChanged, PayoutCompleted, ConversionFinished)
├── Support/                               # 4 enums + HandlesIpnWebhooks trait
├── Handlers/IpnHandler.php                # Webhook signature verification + isRetry()
├── QueryBuilders/                         # PaymentListQueryBuilder, PayoutListQueryBuilder
├── NowPaymentsManager.php                 # Unified facade proxy to all 9 endpoints
└── NowPaymentsServiceProvider.php         # Registers all services + Manager + IpnHandler
```

### Using the Facade (Recommended for Simple Cases)

@verbatim
<code-snippet name="Create a Payment via Facade" lang="php">
use SerenityTechnologies\NowPayments\Facades\NowPayments;
use SerenityTechnologies\NowPayments\DTOs\Request\PaymentRequest;

$request = new PaymentRequest(
    priceAmount: 100.00,
    priceCurrency: 'usd',
    payCurrency: 'btc',
    orderId: 'ORDER-123',
    ipnCallbackUrl: 'https://example.com/webhook'
);

$payment = NowPayments::createPayment($request);

return [
    'address' => $payment->pay_address,
    'amount' => $payment->pay_amount,
];
</code-snippet>
@endverbatim

### Using Endpoint Classes (Recommended for Complex Cases)

@verbatim
<code-snippet name="Create a Payment via DI" lang="php">
use SerenityTechnologies\NowPayments\Services\PaymentEndpoint;
use SerenityTechnologies\NowPayments\DTOs\Request\PaymentRequest;

public function __construct(private PaymentEndpoint $payments) {}

public function create()
{
    $request = new PaymentRequest(
        priceAmount: 100.00,
        priceCurrency: 'usd',
        payCurrency: 'btc',
        orderId: 'ORDER-123',
    );

    return $this->payments->createPayment($request);
}
</code-snippet>
@endverbatim

### Handling Webhooks

@verbatim
<code-snippet name="Webhook Controller with Events" lang="php">
use SerenityTechnologies\NowPayments\Support\HandlesIpnWebhooks;
use Illuminate\Routing\Controller;

class NowPaymentsWebhookController extends Controller
{
    use HandlesIpnWebhooks;
}

// routes/api.php
Route::post('nowpayments/webhook', NowPaymentsWebhookController::class);

// EventServiceProvider:
protected $listen = [
    \SerenityTechnologies\NowPayments\Events\PaymentStatusChanged::class => [
        PaymentStatusListener::class,
    ],
    \SerenityTechnologies\NowPayments\Events\PayoutCompleted::class => [
        PayoutListener::class,
    ],
    \SerenityTechnologies\NowPayments\Events\ConversionFinished::class => [
        ConversionListener::class,
    ],
];
</code-snippet>
@endverbatim

### Idempotency / Retry Detection

@verbatim
<code-snippet name="Detect Retry IPNs" lang="php">
use SerenityTechnologies\NowPayments\Facades\NowPayments;

$data = NowPayments::processIpn($payload, $signature);

if (NowPayments::isIpnRetry($data)) {
    // This is a retry notification — handle accordingly
    Log::warning('Retry IPN received for payment: ' . ($data['payment_id'] ?? 'unknown'));
}
</code-snippet>
@endverbatim

### Using Status Enums

@verbatim
<code-snippet name="Check Payment Status" lang="php">
use SerenityTechnologies\NowPayments\Support\PaymentStatus;

$status = PaymentStatus::from($payment->payment_status);

if ($status->isSuccessful()) {
    // Grant access to purchased content
}

if ($status->isPending()) {
    // Show "processing" UI
}

if ($status->isFinal()) {
    // finished, failed, refunded, or expired
}
</code-snippet>
@endverbatim

### Facade Method Reference

The `NowPayments` facade exposes 50+ methods:

| Category | Methods |
|----------|---------|
| **Auth** | `getStatus()`, `authenticate()` |
| **Currencies** | `getAvailableCurrencies()`, `getFullCurrencies()`, `getMerchantCoins()` |
| **Payments** | `createPayment()`, `getPaymentStatus()`, `getListPayments()`, `getEstimate()`, `getMinAmount()` |
| **Invoices** | `createInvoice()`, `createInvoicePayment()` |
| **Payouts** | `getBalance()`, `validateAddress()`, `createPayout()`, `listPayouts()`, `getPayoutStatus()`, `verifyPayout()`, `cancelPayout()`, `getMinWithdrawalAmount()`, `getPayoutFeeEstimate()` |
| **Conversions** | `createConversion()`, `listConversions()`, `getConversionStatus()` |
| **Sub-Partners** | `createSubPartner()`, `getSubPartnerBalance()`, `listSubPartners()`, `transferFunds()`, `getTransfer()`, `listTransfers()`, `depositToSubPartner()`, `writeOffFromSubPartner()`, `createSubPartnerPayment()`, `getSubPartnerPayments()` |
| **Subscriptions** | `createPlan()`, `listPlans()`, `getPlan()`, `updatePlan()`, `createSubscription()`, `listSubscriptions()`, `getSubscription()`, `deleteSubscription()` |
| **Fiat Payouts** | `getProviders()`, `getFiatCurrencies()`, `getCryptoCurrencies()`, `getPaymentMethods()`, `createFiatAccount()`, `listFiatAccounts()`, `requestFiatPayout()`, `listFiatPayouts()` |
| **IPN** | `verifyIpnSignature()`, `processIpn()`, `isIpnRetry()` |

### Conventions

- **Request DTOs**: Use camelCase constructor params, `toArray()` outputs snake_case for API.
- **Response DTOs**: Use snake_case readonly properties, `fromArray()` casts numerics explicitly: `(int)`, `(float)`.
- **Endpoint Methods**: Accept Request DTOs, return Response DTOs. Never return raw arrays.
- **Authentication**: Services needing dashboard auth pass `requiresAuth: true` to client (auto-manages JWT with 4-min TTL).
- **Validation**: All Request DTOs validate in endpoint methods (`createPayment()`, etc.) before API call. URL fields validated with `filter_var(FILTER_VALIDATE_URL)`.

### Environment Variables

```env
NOWPAYMENTS_API_KEY=
NOWPAYMENTS_IPN_SECRET=
NOWPAYMENTS_DASHBOARD_EMAIL=
NOWPAYMENTS_DASHBOARD_PASSWORD=
NOWPAYMENTS_BASE_URL=https://api.nowpayments.io
NOWPAYMENTS_TIMEOUT=30
```
