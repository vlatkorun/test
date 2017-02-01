<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'baidu' => [
        'exchange_rate_apikey' => ''
    ],

    'adyen' => [
        [
            'hpp_url' => env('ADYEN_HPP_URL', 'https://live.adyen.com/hpp/select.shtml'),
            'merchant_account' => '',
            'skins' => [
                'default' => [
                    'hmac_key' => env('ADYEN_SKIN_DEFAULT_HMAC', ''),
                    'skin_code' => env('ADYEN_SKIN_DEFAULT_CODE', ''),
                ],
                'desktop' => [
                    'hmac_key' => env('ADYEN_SKIN_DESKTOP_HMAC', ''),
                    'skin_code' => env('ADYEN_SKIN_DESKTOP_CODE', ''),
                ],
                'mobile' => [
                    'hmac_key' => env('ADYEN_SKIN_MOBILE_HMAC', ''),
                    'skin_code' => env('ADYEN_SKIN_MOBILE_CODE', 'RfCef4ai'),
                ],
            ],
            'app_return_url' => env('ADYEN_MOBILE_APPS_RETURN_URL', 'https://paymentstatus/'),
            'currency_codes' => [
                'EUR' => ['name' => 'Euro', 'exponent' => 2, 'code' => 'EUR'],
                'CNY' => ['name' => 'Chinese Yuean', 'exponent' => 2, 'code' => 'CNY'],
//        'CAD' => 2,
//        'CHF' => 2,
//        'CZK' => 2,
//        'CZK' => 2,
//        'DKK' => 2,
//        'NOK' => 2,

//        'HRK' => 2,
//        'JPY' => 0,
//        'SEK' => 2,
//        'SKK' => 2,
//        'USD' => 2,
            ],
            'auth_results' => [
                'AUTHORISED' => '',
                'REFUSED' => '',
                'CANCELLED' => '',
                'PENDING' => '',
                'ERROR' => '',
                'INVALID_RESPONSE' => '',
            ],
            'merchant_return_data' => [
                'platform' => ['ios', 'android']
            ],
            'languages' => [
                'zh' => ['name' => 'Chinese – Traditional', 'adyen_code' => 'zh'],
                'en' => ['name' => 'English – US', 'adyen_code' => 'en_US'],
                'de' => ['name' => 'German', 'adyen_code' => 'de']
            ],
            'default_currency' => 'EUR',
            'default_locale' => 'en_US',
        ]
    ],

];
