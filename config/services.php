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

    'facebook' => [
        'client_id'     => '457334907948626',
        'client_secret' => 'bf14505b22813c1376aef8d40008f158',
        'redirect'      => 'http://'.env('APP_URL').'/login/facebook/callback',
    ],

    'google' => [
        'client_id'     => '440549940820-q8l3k4lq6271fh5q28tsu4q4tp82hqca.apps.googleusercontent.com',
        'client_secret' => 'XMGFieBzyw41DxIhgqT2q72L',
        'redirect'      => 'http://'.env('APP_URL').'/login/google/callback',
    ],

];
