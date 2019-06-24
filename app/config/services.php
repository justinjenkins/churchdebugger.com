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
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'twitter' => [
        'consumer_key' => env('TWITTER_CONSUMER_KEY'),
        'secret_key' => env('TWITTER_SECRET_KEY'),
        'access_token' => env('TWITTER_ACCESS_TOKEN'),
        'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
    ],

    'unsplash' => [
        'appid' => env('UNSPLASH_APPLICATION_ID'),
        'access_key' => env('UNSPLASH_ACCESS_KEY'),
        'secret_key' => env('UNSPLASH_SECRET_KEY'),
    ],

    'twilio' => [
        'default_phone' => env('TWILIO_DEFAULT_PHONE'),
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_TOKEN'),
        'test_sid' => env('TWILIO_TEST_SID'),
        'test_token' => env('TWILIO_TEST_TOKEN'),
    ],

    'esv' => [
        'token' => env('ESV_TOKEN'),
    ],

    'apibible' => [
        'token' => env('APIBIBLE_TOKEN'),
    ],

];
