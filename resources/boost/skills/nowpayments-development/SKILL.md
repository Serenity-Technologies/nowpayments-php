---
name: nowpayments-development
description: Build and work with NOWPayments features including payments, payouts, invoices, webhooks, events, idempotency, and the unified facade.
---

# NOWPayments Development

## When to use this skill

Use this skill when:
- Creating payments, invoices, or payouts via NOWPayments API
- Setting up webhook endpoints for IPN callbacks
- Working with payment statuses or building payment flows
- Implementing cryptocurrency payment processing
- Listening to payment lifecycle events
- Detecting retry/duplicate IPN notifications

## Core Concepts

### Architecture Overview

The package has 4 layers:

1. **Client** (`NowPaymentsClient`) - HTTP client handling auth, JWT expiry (4-min TTL), SSL verification, JSON error handling
2. **Services** - 9 classes wrapping API groups, accepting Request DTOs, returning Response DTOs
3. **Manager** (`NowPaymentsManager`) - Unified proxy to all 9 endpoints + IpnHandler, exposed via `NowPayments` facade
4. **Support** - 4 status enums, 3 Laravel events, webhook trait, query builders

### Two Usage Patterns

**Pattern A: Facade (simple, static access)**
```php
use SerenityTechnologies\NowPayments\Facades\NowPayments;

$payment = NowPayments::createPayment($request);
$status = NowPayments::getPaymentStatus($paymentId);
```

**Pattern B: Dependency Injection (testable, explicit)**
```php
public function __construct(
    public PaymentEndpoint $payments,
    public PayoutEndpoint $payouts,
    public IpnHandler $ipnHandler,
) {}

$payment = $this->payments->createPayment($request);
```

### Request DTOs

- Constructor uses camelCase: `new PaymentRequest(priceAmount: 100, priceCurrency: 'usd', payCurrency: 'btc')`
- `toArray()` outputs snake_case for API: `['price_amount' => 100, 'price_currency' => 'usd']`
- `validate()` checks: positive amounts, required fields, URL format (`filter_var(FILTER_VALIDATE_URL)`)
- Null values omitted from `toArray()` output (clean payloads)

### Response DTOs

- Snake_case readonly properties: `$payment->payment_id`, `$payment->pay_address`
- `fromArray()` explicitly casts numerics: `(int) $data['payment_id']`, `(float) $data['price_amount']`
- Nullable fields use `?? null` fallback — never throws on missing optional fields
- All numeric fields cast even when API returns strings (`"amount": "50"`)

## Common Workflows

### 1. Create Payment Flow

```php
use SerenityTechnologies\NowPayments\Facades\NowPayments;
use SerenityTechnologies\NowPayments\DTOs\Request\PaymentRequest;
use SerenityTechnologies\NowPayments\Support\PaymentStatus;

// 1. Get estimate
$estimate = NowPayments::getEstimate($estimateRequest);

// 2. Check minimum
$minAmount = NowPayments::getMinAmount($minAmountRequest);

// 3. Create payment
$request = new PaymentRequest(
    priceAmount: 100.00,
    priceCurrency: 'usd',
    payCurrency: 'btc',
    orderId: 'ORDER-123',
    ipnCallbackUrl: route('webhook.nowpayments')
);

$payment = NowPayments::createPayment($request);

// 4. Return deposit address to user
return [
    'address' => $payment->pay_address,
    'amount' => $payment->pay_amount,
    'currency' => $payment->pay_currency,
];

// 5. Later: check status
$updated = NowPayments::getPaymentStatus($payment->payment_id);
$status = PaymentStatus::from($updated->payment_status);
```

### 2. Setup Webhook Endpoint with Events

```php
// routes/api.php
Route::post('nowpayments/webhook', \App\Http\Controllers\NowPaymentsWebhookController::class);

// app/Http/Controllers/NowPaymentsWebhookController.php
use SerenityTechnologies\NowPayments\Support\HandlesIpnWebhooks;
use Illuminate\Routing\Controller;

class NowPaymentsWebhookController extends Controller
{
    use HandlesIpnWebhooks;
}
```

The trait automatically:
- Verifies HMAC-SHA512 signature
- Fires `PaymentStatusChanged`, `PayoutCompleted`, or `ConversionFinished` events
- Returns success/error JSON response

Listen in `EventServiceProvider`:

```php
protected $listen = [
    \SerenityTechnologies\NowPayments\Events\PaymentStatusChanged::class => [
        App\Listeners\HandlePaymentStatus::class,
    ],
    \SerenityTechnologies\NowPayments\Events\PayoutCompleted::class => [
        App\Listeners\HandlePayout::class,
    ],
    \SerenityTechnologies\NowPayments\Events\ConversionFinished::class => [
        App\Listeners\HandleConversion::class,
    ],
];
```

### 3. Idempotency / Retry Detection

```php
use SerenityTechnologies\NowPayments\Facades\NowPayments;

// Manual processing
$data = NowPayments::processIpn($payload, $signature);

if (NowPayments::isIpnRetry($data)) {
    Log::warning('Retry IPN for payment: ' . ($data['payment_id'] ?? 'unknown'));
    // Handle accordingly — don't double-fulfill orders
}
```

### 4. Check Payment Status with Enums

```php
use SerenityTechnologies\NowPayments\Support\PaymentStatus;

$payment = NowPayments::getPaymentStatus($paymentId);
$status = PaymentStatus::from($payment->payment_status);

if ($status->isSuccessful()) {
    // Payment finished - fulfill order
} elseif ($status->isPending()) {
    // Still processing (waiting, confirming, confirmed, sending)
} elseif ($status === PaymentStatus::Failed) {
    // Handle failure
} elseif ($status->isFinal()) {
    // finished, failed, refunded, or expired
}
```

### 5. Create Payout (Requires Auth)

```php
use SerenityTechnologies\NowPayments\DTOs\Request\PayoutRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\PayoutWithdrawalItem;

$withdrawal = new PayoutWithdrawalItem(
    address: '0x1234567890abcdef',
    currency: 'usdttrc20',
    amount: 50.00,
    payoutDescription: 'Refund for order 123'
);

$request = new PayoutRequest(
    withdrawals: [$withdrawal],
    payoutDescription: 'Batch payout 2024-01-01'
);

$payout = NowPayments::createPayout($request);
```

### 6. Query Payments with Builder

```php
use SerenityTechnologies\NowPayments\QueryBuilders\PaymentListQueryBuilder;

$query = (new PaymentListQueryBuilder())
    ->setLimit(50)
    ->setPage(0)
    ->setSortBy('created_at')
    ->setOrderBy('desc')
    ->setDateFrom('2024-01-01')
    ->setDateTo('2024-12-31');

$payments = NowPayments::getListPayments($query);
```

## Key Files Reference

| Task | File to Use |
|------|-------------|
| Create payment | `NowPayments::createPayment()` or `PaymentEndpoint` |
| Create invoice | `NowPayments::createInvoice()` or `InvoiceEndpoint` |
| Create payout | `NowPayments::createPayout()` or `PayoutEndpoint` |
| Handle webhook | `HandlesIpnWebhooks` trait |
| Check status | `PaymentStatus::from()` enum |
| Listen to events | `Events/PaymentStatusChanged.php` |
| Detect retries | `NowPayments::isIpnRetry()` |
| Query payments | `PaymentListQueryBuilder` |
| Fee info | `FeeResponse` DTO |

## Important Notes

1. **JWT Expiry**: Dashboard tokens expire in 5 minutes. Client auto-refreshes at 4 minutes (240s TTL).
2. **SSL Verification**: Explicitly enabled (`verify => true`) in Guzzle config.
3. **Numeric Casting**: All Response DTOs cast API string numerics: `(int)`, `(float)`, `(bool)`.
4. **URL Validation**: Request DTOs validate URLs with `filter_var(FILTER_VALIDATE_URL)`.
5. **IpnHandler**: Registered in container as singleton, inject via DI or use facade.
6. **Facade Access**: `NowPayments::` proxies to `NowPaymentsManager` — all 52 methods available statically.
7. **Idempotency**: Use `isIpnRetry()` to detect retry notifications and avoid double-processing.
8. **Fee DTO**: Payment responses include typed `FeeResponse` (`currency`, `depositFee`, `withdrawalFee`, `serviceFee`).
