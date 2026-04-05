<?php

namespace SerenityTechnologies\NowPayments;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\ServiceProvider;
use SerenityTechnologies\NowPayments\Client\NowPaymentsClient;
use SerenityTechnologies\NowPayments\Endpoints\{
    AuthEndpoint,
    CurrencyEndpoint,
    PaymentEndpoint,
    InvoiceEndpoint,
    PayoutEndpoint,
    ConversionEndpoint,
    SubPartnerEndpoint,
    SubscriptionEndpoint,
    FiatPayoutEndpoint
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

        // Register HTTP Client
        $this->app->singleton(GuzzleClient::class, function ($app) {
            return new GuzzleClient([
                'base_uri' => config('nowpayments.base_url', 'https://api.nowpayments.io'),
                'timeout' => config('nowpayments.timeout', 30),
                'verify' => true, // Explicitly enforce SSL certificate verification
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ]);
        });

        // Register NOWPayments Client
        $this->app->singleton(NowPaymentsClient::class, function ($app) {
            /** @var GuzzleClient $client */
            $client = $app->make(GuzzleClient::class);

            return new NowPaymentsClient(
                $client,
                config('nowpayments.api_key', ''),
                config('nowpayments.ipn_secret', ''),
                config('nowpayments.dashboard_email', ''),
                config('nowpayments.dashboard_password', '')
            );
        });

        // Register Auth Endpoint
        $this->app->singleton(AuthEndpoint::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new AuthEndpoint($client);
        });

        // Register Currency Endpoint
        $this->app->singleton(CurrencyEndpoint::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new CurrencyEndpoint($client);
        });

        // Register Payment Endpoint
        $this->app->singleton(PaymentEndpoint::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new PaymentEndpoint($client);
        });

        // Register Invoice Endpoint
        $this->app->singleton(InvoiceEndpoint::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new InvoiceEndpoint($client);
        });

        // Register Payout Endpoint
        $this->app->singleton(PayoutEndpoint::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new PayoutEndpoint($client);
        });

        // Register Conversion Endpoint
        $this->app->singleton(ConversionEndpoint::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new ConversionEndpoint($client);
        });

        // Register SubPartner Endpoint
        $this->app->singleton(SubPartnerEndpoint::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new SubPartnerEndpoint($client);
        });

        // Register Subscription Endpoint
        $this->app->singleton(SubscriptionEndpoint::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new SubscriptionEndpoint($client);
        });

        // Register FiatPayout Endpoint
        $this->app->singleton(FiatPayoutEndpoint::class, function ($app) {
            /** @var NowPaymentsClient $client */
            $client = $app->make(NowPaymentsClient::class);
            return new FiatPayoutEndpoint($client);
        });

        // Register IpnHandler
        $this->app->singleton(IpnHandler::class, function ($app) {
            return new IpnHandler(config('nowpayments.ipn_secret', ''));
        });

        // Register Manager (high-level facade proxy)
        $this->app->singleton(NowPaymentsManager::class, function ($app) {
            return new NowPaymentsManager(
                $app->make(AuthEndpoint::class),
                $app->make(CurrencyEndpoint::class),
                $app->make(PaymentEndpoint::class),
                $app->make(InvoiceEndpoint::class),
                $app->make(PayoutEndpoint::class),
                $app->make(ConversionEndpoint::class),
                $app->make(SubPartnerEndpoint::class),
                $app->make(SubscriptionEndpoint::class),
                $app->make(FiatPayoutEndpoint::class),
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
