<?php declare(strict_types=1);

/**
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
namespace SerenityTechnologies\NowPayments\Tests\Unit;

use SerenityTechnologies\NowPayments\DTOs\Request\PaymentRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\InvoiceRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\AuthRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\PayoutRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\ConversionRequest;
use SerenityTechnologies\NowPayments\DTOs\Request\MinAmountRequest;
use InvalidArgumentException;
use SerenityTechnologies\NowPayments\Tests\TestCase;

class RequestDtosTest extends TestCase
{
    /** @test */
    public function payment_request_converts_to_array_correctly(): void
    {
        $request = new PaymentRequest(
            priceAmount: 100.50,
            priceCurrency: 'usd',
            payCurrency: 'btc',
            orderId: 'ORDER-123',
            orderDescription: 'Test order'
        );

        $array = $request->toArray();

        $this->assertEquals(100.50, $array['price_amount']);
        $this->assertEquals('usd', $array['price_currency']);
        $this->assertEquals('btc', $array['pay_currency']);
        $this->assertEquals('ORDER-123', $array['order_id']);
        $this->assertEquals('Test order', $array['order_description']);
    }

    /** @test */
    public function payment_request_omits_null_values_in_array(): void
    {
        $request = new PaymentRequest(
            priceAmount: 100.00,
            priceCurrency: 'usd',
            payCurrency: 'btc'
        );

        $array = $request->toArray();

        $this->assertArrayNotHasKey('ipn_callback_url', $array);
        $this->assertArrayNotHasKey('order_id', $array);
        $this->assertArrayNotHasKey('order_description', $array);
    }

    /** @test */
    public function payment_request_validation_passes_with_required_fields(): void
    {
        $request = new PaymentRequest(
            priceAmount: 100.00,
            priceCurrency: 'usd',
            payCurrency: 'btc'
        );

        // Should not throw
        $request->validate();
        $this->assertTrue(true);
    }

    /** @test */
    public function payment_request_validation_fails_with_negative_amount(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $request = new PaymentRequest(
            priceAmount: -100.00,
            priceCurrency: 'usd',
            payCurrency: 'btc'
        );

        $request->validate();
    }

    /** @test */
    public function invoice_request_includes_optional_urls(): void
    {
        $request = new InvoiceRequest(
            priceAmount: 50.00,
            priceCurrency: 'usd',
            successUrl: 'https://example.com/success',
            cancelUrl: 'https://example.com/cancel'
        );

        $array = $request->toArray();

        $this->assertEquals('https://example.com/success', $array['success_url']);
        $this->assertEquals('https://example.com/cancel', $array['cancel_url']);
    }

    /** @test */
    public function auth_request_validates_email_format(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $request = new AuthRequest(
            email: 'invalid-email',
            password: 'password123'
        );

        $request->validate();
    }

    /** @test */
    public function conversion_request_validates_different_currencies(): void
    {
        $request = new ConversionRequest(
            amount: 100.00,
            fromCurrency: 'btc',
            toCurrency: 'eth'
        );

        // Should not throw
        $request->validate();
        $this->assertTrue(true);
    }

    /** @test */
    public function conversion_request_fails_with_same_currencies(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $request = new ConversionRequest(
            amount: 100.00,
            fromCurrency: 'btc',
            toCurrency: 'btc'
        );

        $request->validate();
    }

    /** @test */
    public function payout_request_with_withdrawals_validates(): void
    {
        // Ensure PayoutWithdrawalItem class is loaded
        require_once __DIR__ . '/../../src/DTOs/Request/PayoutRequest.php';
        
        $withdrawal = new \SerenityTechnologies\NowPayments\DTOs\Request\PayoutWithdrawalItem(
            address: '0x1234567890abcdef',
            currency: 'usdttrc20',
            amount: 50.00
        );

        $request = new PayoutRequest(
            withdrawals: [$withdrawal]
        );

        // Should not throw
        $request->validate();
        $this->assertTrue(true);
    }

    /** @test */
    public function request_dto_implements_json_serializable(): void
    {
        $request = new PaymentRequest(
            priceAmount: 100.00,
            priceCurrency: 'usd',
            payCurrency: 'btc',
            orderId: 'ORDER-123'
        );

        $json = json_encode($request);
        $decoded = json_decode($json, true);

        $this->assertEquals(100.00, $decoded['price_amount']);
        $this->assertEquals('ORDER-123', $decoded['order_id']);
    }

    /** @test */
    public function min_amount_request_includes_optional_parameters(): void
    {
        $request = new MinAmountRequest(
            currencyFrom: 'eth',
            currencyTo: 'trx',
            fiatEquivalent: 'usd',
            isFixedRate: true,
            isFeePaidByUser: false
        );

        $array = $request->toArray();

        $this->assertEquals('eth', $array['currency_from']);
        $this->assertEquals('trx', $array['currency_to']);
        $this->assertEquals('usd', $array['fiat_equivalent']);
        $this->assertTrue($array['is_fixed_rate']);
        $this->assertFalse($array['is_fee_paid_by_user']);
    }

    /** @test */
    public function min_amount_request_omits_null_values(): void
    {
        $request = new MinAmountRequest(
            currencyFrom: 'btc',
            currencyTo: 'usdt'
        );

        $array = $request->toArray();

        $this->assertArrayNotHasKey('fiat_equivalent', $array);
        $this->assertArrayNotHasKey('is_fixed_rate', $array);
        $this->assertArrayNotHasKey('is_fee_paid_by_user', $array);
    }
}
