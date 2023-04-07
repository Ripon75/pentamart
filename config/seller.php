<?php

return [
    'menu' => [
        [
            'label'       => 'Dashboard',
            'icon'        => 'fa-solid fa-gauge',
            'title'       => 'Dashboard',
            'route'       => 'seller.dashboard',
            'permission'  => 'dashboards-read',
            'sub'         => []
        ],
        [
            'label'      => 'Orders Management',
            'icon'       => 'fa-solid fa-cart-shopping',
            'title'      => 'Orders',
            'route'      => '#',
            'permission' => 'orders-read',
            'sub' => [
                [
                    'label'      => 'Orders',
                    'icon'       => 'fa-solid fa-cart-shopping',
                    'title'      => 'Orders',
                    'route'      => 'seller.orders.index',
                    'permission' => 'orders-read'
                ]
            ]
                ],
        [
            'label'      => 'Products Management',
            'icon'       => 'fa-solid fa-cart-shopping',
            'title'      => 'Products',
            'route'      => '#',
            'permission' => 'products-read',
            'sub' => [
                [
                    'label'      => 'products',
                    'icon'       => 'fa-solid fa-cart-shopping',
                    'title'      => 'products',
                    'route'      => 'seller.products.index',
                    'permission' => 'products-read'
                ]
            ]
        ]
    ]
];
