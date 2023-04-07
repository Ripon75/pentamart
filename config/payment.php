<?php

return [
    'default' => env('PGW_DRIVER', 'ssl'),


    'drivers' => [

        'ssl' => [
            'endpoint'              => env('SSL_ENDPOINT'),
            'store_id'              => env('SSL_STORE_ID'),
            'store_password'        => env('SSL_STORE_PASSWORD'),
            'callback_success'      => env('SSL_CALLBACK_SUCCESS'),
            'callback_fail'         => env('SSL_CALLBACK_FAIL'),
            'callback_cancel'       => env('SSL_CALLBACK_CANCEL'),
            'callback_ipn'          => env('SSL_CALLBACK_IPN'),
            'woking_customer_email' => env('SSL_WOKING_CUSTOMER_EMAIL')
        ],

        'bkash' => [
            'endpoint'  => env('BKASH_ENDPOINT', 'url'),
            'appkey'    => env('BKASH_APP_KEY', ''),
            'appSecret' => env('BKASH_APP_SECRET', ''),
            'username'  => env('BKASH_USERNAME', ''),
            'password'  => env('BKASH_PASSWORD', ''),
            'callback'  => env('BKASH_CALLBACK', '')
        ],
        'nagad' => [
            'merchantId'         => env('NAGAD_MERCHANT_ID', ''),
            'endpoint'           => env('NAGAD_ENDPOINT', ''),
            'publicKey'          => env('NAGAD_PUBLIC_KEY', ''),
            'merchantPrivateKey' => env('NAGAD_MERCHANT_PRIVATE_KEY', ''),
            'callback'           => env('NAGAD_CALLBACK', '')
        ]
    ]
];
