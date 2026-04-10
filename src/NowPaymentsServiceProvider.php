<?php

/**
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
namespace SerenityTechnologies\NowPayments;

use Illuminate\Support\ServiceProvider;
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

class NowPaymentsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/Config/nowpayments.php' => config_path('nowpayments.php'),
        ], 'nowpayments-config');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/Config/nowpayments.php',
            'nowpayments'
        );

        // Register NOWPayments Client
        $this->app->singleton(NowPaymentsClient::class, function ($app) {
            return new NowPaymentsClient(
                config('nowpayments.api_key', ''),
                config('nowpayments.ipn_secret', ''),
                config('nowpayments.dashboard_email', ''),
                config('nowpayments.dashboard_password', ''),
                config('nowpayments.base_url', 'https://api.nowpayments.io')
            );
        });

        // Register Auth Endpoint
        $this->app->singleton(AuthService::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new AuthService($client);
        });

        // Register Currency Endpoint
        $this->app->singleton(CurrencyService::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new CurrencyService($client);
        });

        // Register Payment Endpoint
        $this->app->singleton(PaymentService::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new PaymentService($client);
        });

        // Register Invoice Endpoint
        $this->app->singleton(InvoiceService::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new InvoiceService($client);
        });

        // Register Payout Endpoint
        $this->app->singleton(PayoutService::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new PayoutService($client);
        });

        // Register Conversion Endpoint
        $this->app->singleton(ConversionService::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new ConversionService($client);
        });

        // Register SubPartner Endpoint
        $this->app->singleton(SubPartnerService::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new SubPartnerService($client);
        });

        // Register Subscription Endpoint
        $this->app->singleton(SubscriptionService::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new SubscriptionService($client);
        });

        // Register FiatPayout Endpoint
        $this->app->singleton(FiatPayoutService::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new FiatPayoutService($client);
        });

        // Register IpnHandler
        $this->app->singleton(IpnHandler::class, function ($app) {
            return new IpnHandler(config('nowpayments.ipn_secret', ''));
        });

        // Register Manager (high-level facade proxy)
        $this->app->singleton(NowPaymentsManager::class, function ($app) {
            return new NowPaymentsManager(
                $app->make(AuthService::class),
                $app->make(CurrencyService::class),
                $app->make(PaymentService::class),
                $app->make(InvoiceService::class),
                $app->make(PayoutService::class),
                $app->make(ConversionService::class),
                $app->make(SubPartnerService::class),
                $app->make(SubscriptionService::class),
                $app->make(FiatPayoutService::class),
                $app->make(IpnHandler::class),
                $app->make(NowPaymentsClient::class)
            );
        });

        // Register main facade binder
        $this->app->singleton('nowpayments', function ($app) {
            return $app->make(NowPaymentsManager::class);
        });
    }
}
