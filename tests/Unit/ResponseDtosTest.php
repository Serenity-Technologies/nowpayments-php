<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Tests\Unit;

use SerenityTechnologies\NowPayments\DTOs\Response\PaymentResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\ApiStatusResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\AuthResponse;
use SerenityTechnologies\NowPayments\DTOs\Response\InvoiceResponse;
use SerenityTechnologies\NowPayments\Tests\TestCase;

class ResponseDtosTest extends TestCase
{
    /** @test */
    public function api_status_response_creates_from_array(): void
    {
        $data = ['message' => 'OK'];
        $response = ApiStatusResponse::fromArray($data);

        $this->assertEquals('OK', $response->message);
    }

    /** @test */
    public function auth_response_creates_from_array(): void
    {
        $data = ['token' => 'test-jwt-token'];
        $response = AuthResponse::fromArray($data);

        $this->assertEquals('test-jwt-token', $response->token);
    }

    /** @test */
    public function payment_response_handles_nullable_fields(): void
    {
        $data = [
            'payment_id' => 123456789,
            'invoice_id' => null,
            'payment_status' => 'waiting',
            'pay_address' => 'test-btc-address',
            'payin_extra_id' => null,
            'price_amount' => 100.00,
            'price_currency' => 'usd',
            'pay_amount' => 0.001,
            'actually_paid' => 0.001,
            'pay_currency' => 'btc',
            'order_id' => 'ORDER-123',
            'order_description' => 'Test order',
            'purchase_id' => 987654321,
            'outcome_amount' => 0.0009,
            'outcome_currency' => 'btc',
            'payout_hash' => null,
            'payin_hash' => null,
            'created_at' => '2024-01-01T00:00:00.000Z',
            'updated_at' => '2024-01-01T00:00:00.000Z',
            'burning_percent' => null,
            'type' => 'crypto2crypto',
            'payment_extra_ids' => null,
            'parent_payment_id' => null,
            'origin_type' => null,
            'fee' => null,
            'smart_contract' => null,
            'network' => null,
            'network_precision' => null,
            'time_limit' => null,
            'valid_until' => null,
            'is_fixed_rate' => false,
            'is_fee_paid_by_user' => false,
            'expiration_estimate_date' => null,
            'amount_received' => null,
            'redirect_url' => null,
        ];

        $response = PaymentResponse::fromArray($data);

        $this->assertEquals(123456789, $response->payment_id);
        $this->assertNull($response->invoice_id);
        $this->assertEquals('waiting', $response->payment_status);
        $this->assertEquals('test-btc-address', $response->pay_address);
        $this->assertEquals('crypto2crypto', $response->type);
    }

    /** @test */
    public function invoice_response_creates_from_array(): void
    {
        $data = [
            'id' => '12345',
            'order_id' => 'ORDER-123',
            'order_description' => 'Test invoice',
            'price_amount' => '100.00',
            'price_currency' => 'usd',
            'pay_currency' => null,
            'ipn_callback_url' => null,
            'invoice_url' => 'https://nowpayments.io/invoice/12345',
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',
            'created_at' => '2024-01-01T00:00:00.000Z',
            'updated_at' => '2024-01-01T00:00:00.000Z',
        ];

        $response = InvoiceResponse::fromArray($data);

        $this->assertEquals('12345', $response->id);
        $this->assertEquals('https://nowpayments.io/invoice/12345', $response->invoice_url);
        $this->assertNull($response->pay_currency);
    }

    /** @test */
    public function response_dto_to_array_returns_all_properties(): void
    {
        $data = ['message' => 'OK'];
        $response = ApiStatusResponse::fromArray($data);

        $array = $response->toArray();

        $this->assertArrayHasKey('message', $array);
        $this->assertEquals('OK', $array['message']);
    }

    /** @test */
    public function response_dto_to_json_works_correctly(): void
    {
        $data = ['token' => 'jwt-token-123'];
        $response = AuthResponse::fromArray($data);

        $json = $response->toJson();
        $decoded = json_decode($json, true);

        $this->assertEquals('jwt-token-123', $decoded['token']);
    }
}
