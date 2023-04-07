<?php

return [

    'default' => env('SMS_GATEWAY', 'dstbd'),

    'driver' => [
        'dstbd' => [
            'end_point' => env('SMS_GATEWAY_ENDDPOINT'),
            'username'  => env('SMS_GATEWAY_USERNAME'),
            'password'  => env('SMS_GATEWAY_PASSWORD'),
            'source'    => env('SMS_GATEWAY_SOURCE'),
        ],
        'reve' => [
            'end_point'  => env('SMS_GATEWAY_ENDDPOINT'),
            'api_key'    => env('SMS_GATEWAY_API_KEY'),
            'secret_key' => env('SMS_GATEWAY_SECRET_KEY'),
            'source'     => env('SMS_GATEWAY_SOURCE'),
        ]
    ]
];
