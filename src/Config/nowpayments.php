<?php

/**
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
return [
    /*
    |--------------------------------------------------------------------------
    | NOWPayments API Key
    |--------------------------------------------------------------------------
    |
    | Your NOWPayments API key generated from the dashboard.
    | This is required for most API endpoints.
    |
    */

    'api_key' => env('NOWPAYMENTS_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | IPN Secret Key
    |--------------------------------------------------------------------------
    |
    | Your IPN (Instant Payment Notification) secret key used to verify
    | webhook signatures. Generate this in Payment Settings tab.
    |
    */

    'ipn_secret' => env('NOWPAYMENTS_IPN_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Dashboard Credentials (Optional)
    |--------------------------------------------------------------------------
    |
    | Email and password for dashboard authentication.
    | Required for certain endpoints like payouts and conversions.
    | JWT tokens obtained with these credentials expire in 5 minutes.
    |
    */

    'dashboard_email' => env('NOWPAYMENTS_DASHBOARD_EMAIL', ''),
    'dashboard_password' => env('NOWPAYMENTS_DASHBOARD_PASSWORD', ''),

    /*
    |--------------------------------------------------------------------------
    | API Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the NOWPayments API. You typically don't need
    | to change this unless using a proxy or test environment.
    |
    */

    'base_url' => env('NOWPAYMENTS_BASE_URL', 'https://api.nowpayments.io'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Timeout
    |--------------------------------------------------------------------------
    |
    | Timeout in seconds for API requests.
    |
    */

    'timeout' => env('NOWPAYMENTS_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Enable Fixed Rate
    |--------------------------------------------------------------------------
    |
    | Default setting for fixed rate exchanges. When enabled, the exchange
    | rate is frozen for 20 minutes after payment creation.
    |
    */

    'fixed_rate' => env('NOWPAYMENTS_FIXED_RATE', false),

    /*
    |--------------------------------------------------------------------------
    | Fee Paid By User
    |--------------------------------------------------------------------------
    |
    | Default setting for who pays the transaction fee. When true,
    | the user pays the fee instead of the merchant.
    |
    */

    'fee_paid_by_user' => env('NOWPAYMENTS_FEE_PAID_BY_USER', false),

    /*
    |--------------------------------------------------------------------------
    | Default Payout Currency
    |--------------------------------------------------------------------------
    |
    | The default currency for payouts (your payout wallet currency).
    |
    */

    'default_payout_currency' => env('NOWPAYMENTS_DEFAULT_PAYOUT_CURRENCY', 'usdttrc20'),
];
