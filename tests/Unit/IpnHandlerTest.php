<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Tests\Unit;

use SerenityTechnologies\NowPayments\Handlers\IpnHandler;
use SerenityTechnologies\NowPayments\Exceptions\NowPaymentsException;
use SerenityTechnologies\NowPayments\Tests\TestCase;

class IpnHandlerTest extends TestCase
{
    /** @test */
    public function it_verifies_valid_ipn_signature(): void
    {
        $ipnSecret = 'my-secret-key';
        $handler = new IpnHandler($ipnSecret);

        $data = [
            'payment_id' => 123456789,
            'payment_status' => 'finished',
            'pay_address' => 'test-address',
            'price_amount' => 100,
            'price_currency' => 'usd',
            'pay_amount' => 0.001,
            'pay_currency' => 'btc',
            'order_id' => 'ORDER-123',
        ];

        // Generate valid signature
        $sortedData = $data;
        ksort($sortedData);
        $jsonString = json_encode($sortedData, JSON_UNESCAPED_SLASHES);
        $validSignature = hash_hmac('sha512', $jsonString, $ipnSecret);

        // Should not throw exception
        $result = $handler->verifySignature($data, $validSignature);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_rejects_invalid_ipn_signature(): void
    {
        $handler = new IpnHandler('my-secret-key');

        $data = [
            'payment_id' => 123456789,
            'payment_status' => 'finished',
        ];

        $result = $handler->verifySignature($data, 'invalid-signature');
        $this->assertFalse($result);
    }

    /** @test */
    public function it_throws_exception_when_ipn_secret_not_configured(): void
    {
        $this->expectException(NowPaymentsException::class);
        $this->expectExceptionMessage('IPN secret not configured');

        $handler = new IpnHandler('');
        $handler->verifySignature(['payment_id' => 123], 'some-signature');
    }

    /** @test */
    public function it_processes_valid_ipn_and_returns_data(): void
    {
        $ipnSecret = 'secret';
        $handler = new IpnHandler($ipnSecret);

        $data = [
            'payment_id' => 123456789,
            'payment_status' => 'finished',
            'pay_amount' => 0.001,
        ];

        $sortedData = $data;
        ksort($sortedData);
        $jsonString = json_encode($sortedData, JSON_UNESCAPED_SLASHES);
        $validSignature = hash_hmac('sha512', $jsonString, $ipnSecret);

        $result = $handler->processIpn($data, $validSignature);

        $this->assertEquals(123456789, $result['payment_id']);
        $this->assertEquals('finished', $result['payment_status']);
    }

    /** @test */
    public function it_throws_exception_for_invalid_signature_in_process_ipn(): void
    {
        $this->expectException(NowPaymentsException::class);
        $this->expectExceptionMessage('HMAC signature does not match');

        $handler = new IpnHandler('secret');
        $handler->processIpn(['payment_id' => 123], 'invalid-signature');
    }

    /** @test */
    public function it_handles_nested_arrays_in_signature_verification(): void
    {
        $ipnSecret = 'secret';
        $handler = new IpnHandler($ipnSecret);

        $data = [
            'payment_id' => 123,
            'fee' => [
                'currency' => 'btc',
                'depositFee' => 0.1,
                'withdrawalFee' => 0.05,
            ],
        ];

        $sortedData = $data;
        ksort($sortedData);
        ksort($sortedData['fee']);
        $jsonString = json_encode($sortedData, JSON_UNESCAPED_SLASHES);
        $validSignature = hash_hmac('sha512', $jsonString, $ipnSecret);

        $result = $handler->verifySignature($data, $validSignature);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_uses_timing_safe_comparison(): void
    {
        // This test verifies that hash_equals is used (timing-safe)
        // We can't directly test the implementation, but we verify behavior
        $ipnSecret = 'secret';
        $handler = new IpnHandler($ipnSecret);

        $data = ['payment_id' => 123];
        $sortedData = $data;
        ksort($sortedData);
        $jsonString = json_encode($sortedData, JSON_UNESCAPED_SLASHES);
        $validSignature = hash_hmac('sha512', $jsonString, $ipnSecret);

        // Modify one character to ensure timing-safe comparison still works
        $invalidSignature = $validSignature;
        $invalidSignature[0] = ($invalidSignature[0] === 'a') ? 'b' : 'a';

        $this->assertFalse($handler->verifySignature($data, $invalidSignature));
    }
}
