<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use SerenityTechnologies\NowPayments\NowPaymentsServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            NowPaymentsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('nowpayments.api_key', 'test-api-key');
        $app['config']->set('nowpayments.ipn_secret', 'test-ipn-secret');
        $app['config']->set('nowpayments.dashboard_email', 'test@example.com');
        $app['config']->set('nowpayments.dashboard_password', 'test-password');
        $app['config']->set('nowpayments.base_url', 'https://api.nowpayments.io');
        $app['config']->set('nowpayments.timeout', 30);
    }

    protected function setUp(): void
    {
        parent::setUp();
    }
}
