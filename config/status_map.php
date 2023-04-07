<?php

return [
    'order' => [
        'submitted' => [
            'id'      => 1,
            'name'    => 'submitted',
            'default' => true,
            'label'   => 'Submitted',
            'action'  => 'Submit',
            'customer_visibility' => true,
            'shop_user_visibility' => true,
            'permission' => true,
            'color'   => [
                'background' => '#9E9E9E',
                'font'       => '#FFFFFF'
            ],
            'to' => ['canceled', 'confirmed', 'on-hold']
        ],
        'confirmed' => [
            'id'      => 2,
            'name'    => 'confirmed',
            'default' => true,
            'label'   => 'Confirmed',
            'action'  => 'Confirm',
            'customer_visibility' => true,
            'shop_user_visibility' => true,
            'permission' => true,
            'color'   => [
                'background' => '#4CAF50',
                'font'       => '#FFFFFF'
            ],
            'to' => ['canceled', 'picked-up']
        ],
        'canceled' => [
            'id'      => 3,
            'name'    => 'canceled',
            'default' => true,
            'label'   => 'Canceled',
            'action'  => 'Cancel',
            'customer_visibility' => true,
            'shop_user_visibility' => true,
            'permission' => true,
            'color'   => [
                'background' => '#EF5350',
                'font'       => '#FFFFFF'
            ],
            'to' => []
        ],
        'picked-up' => [
            'id'      => 4,
            'name'    => 'picked-up',
            'default' => true,
            'label'   => 'Picked Up',
            'action'  => 'Pickup',
            'customer_visibility' => true,
            'shop_user_visibility' => true,
            'permission' => true,
            'color'   => [
                'background' => '#FB8C00',
                'font'       => '#FFFFFF'
            ],
            'to' => ['on-the-way']
        ],
        'on-the-way' => [
            'id'      => 5,
            'name'    => 'on-the-way',
            'default' => true,
            'label'   => 'On The Way',
            'action'  => 'On The Way',
            'customer_visibility' => true,
            'shop_user_visibility' => true,
            'permission' => true,
            'color'   => [
                'background' => '#6D4C41',
                'font'       => '#FFFFFF'
            ],
            'to' => ['delivery-failed', 'delivered']
        ],
        'on-hold' => [
            'id'      => 6,
            'name'    => 'on-hold',
            'default' => true,
            'label'   => 'On Hold',
            'action'  => 'On Hold',
            'customer_visibility' => true,
            'shop_user_visibility' => true,
            'permission' => true,
            'color'   => [
                'background' => '#00897B',
                'font'       => '#FFFFFF'
            ],
            'to' => ['canceled', 'picked-up']
        ],
        'delivered' => [
            'id'      => 7,
            'name'    => 'delivered',
            'default' => true,
            'label'   => 'Delivered',
            'action'  => 'Deliver',
            'customer_visibility' => true,
            'shop_user_visibility' => true,
            'permission' => true,
            'color'   => [
                'background' => '#00897B',
                'font'       => '#FFFFFF'
            ],
            'to' => ['returned', 'settled']
        ],
        'delivery-failed' => [
            'id'      => 8,
            'name'    => 'delivery-failed',
            'default' => true,
            'label'   => 'Delivery Failed',
            'action'  => 'Deliver Fail',
            'customer_visibility' => true,
            'shop_user_visibility' => true,
            'permission' => true,
            'color'   => [
                'background' => '#E91E63',
                'font'       => '#FFFFFF'
            ],
            'to' => ['returned']
        ],
        'returned' => [
            'id'      => 9,
            'name'    => 'returned',
            'default' => true,
            'label'   => 'Returned',
            'action'  => 'Return',
            'customer_visibility' => true,
            'shop_user_visibility' => true,
            'permission' => true,
            'color'   => [
                'background' => '#E53935',
                'font'       => '#FFFFFF'
            ],
            'to' => []
        ],
        'settled' => [
            'id'      => 10,
            'name'    => 'settled',
            'default' => true,
            'label'   => 'Settled',
            'action'  => 'Settled',
            'customer_visibility' => true,
            'shop_user_visibility' => true,
            'permission' => true,
            'color'   => [
                'background' => '#546E7A',
                'font'       => '#FFFFFF'
            ],
            'to' => []
        ],
    ]
];
