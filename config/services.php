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

    'sms' => [
        'from' => env('SMS_FROM'),
        'base_url' => env('SMS_BASE_URL', 'https://api.ng.termii.com'),
        'api_key' => env('SMS_API_KEY'),
        'type' => env('SMS_TYPE', 'plain'),
        'channel' => env('SMS_CHANNEL', 'dnd'),
    ],

    'vulte' => [
        'base_url' => env('VULTE_BASE_URL', 'https://api.openbanking.vulte.ng'),
        'api_key' => env('VULTE_API_KEY'),
        'secret' => env('VULTE_SECRET'),
        'mode' => env('VULTE_MODE'),
        'webhook' => env('VULTE_WEBHOOK'),
    ],

    'fcm' => [
        'project_id' => env('FCM_PROJECT_ID'),
        'access_token' => env('FCM_ACCESS_TOKEN')
    ]

];
