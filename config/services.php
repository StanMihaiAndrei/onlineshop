<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],
    'sameday' => [
        'base_url' => env('SAMEDAY_BASE_URL'),
        'username' => env('SAMEDAY_USERNAME'),
        'password' => env('SAMEDAY_PASSWORD'),
    ],
    'smartbill' => [
        'base_url' => env('SMARTBILL_BASE_URL', 'https://ws.smartbill.ro/SBORO/api'),
        'username' => env('SMARTBILL_USERNAME'),
        'token' => env('SMARTBILL_TOKEN'),
        'cif' => env('SMARTBILL_CIF'),
        'series_name' => env('SMARTBILL_SERIES_NAME', 'TEST'),
    ],
];
