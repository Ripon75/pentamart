<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadmin' => [
            'roles'          => 'c,r,u,d',
            'permissions'    => 'c,r,u,d',
            'districts'      => 'c,r,u,d',
            'brands'         => 'c,r,u,d',
            'categories'     => 'c,r,u,d',
            'coupons'        => 'c,r,u,d',
            'orders'         => 'c,r,u,d',
            'status'         => 'c,r,u,d',
            'products'       => 'c,r,u,d',
            'sliders'        => 'c,r,u,d',
            'sections'       => 'c,r,u,d',
            'users'          => 'r,u',
            'product-bulk'   => 'c',
            'dashboards'     => 'r',
        ],
        'admin' => [],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
