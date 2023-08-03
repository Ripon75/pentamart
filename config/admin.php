<?php

return [
    'menu' => [
        [
            'label'       => 'Dashboard',
            'icon'        => 'fa-solid fa-gauge',
            'route'       => 'admin.dashboard',
            'permission'  => 'dashboards-read',
            'sub'         => []
        ],
        [
            'label'       => 'Sliders',
            'icon'        => 'fa-solid fa-panorama',
            'route'       => 'admin.sliders.index',
            'permission'  => 'sliders-read',
            'sub'         => []
        ],
        [
            'label'      => 'Sections',
            'icon'       => 'fa-solid fa-people-roof',
            'route'      => 'admin.sections.index',
            'permission' => 'sections-read',
            'sub' => []
        ],
        [
            'label'      => 'Orders Management',
            'icon'       => 'fa-solid fa-cart-shopping',
            'route'      => '#',
            'permission' => 'orders-read',
            'sub' => [
                [
                    'label'      => 'Districts',
                    'icon'       => 'fa-solid fa-tag',
                    'route'      => 'admin.districts.index',
                    'permission' => 'districts-read'
                ],
                [
                    'label'      => 'Coupons',
                    'icon'       => 'fa-solid fa-tag',
                    'route'      => 'admin.coupons.index',
                    'permission' => 'coupons-read'
                ],
                [
                    'label'      => 'Orders',
                    'icon'       => 'fa-solid fa-cart-shopping',
                    'route'      => 'admin.orders.index',
                    'permission' => 'orders-read'
                ],
                [
                    'label'      => 'Status',
                    'icon'       => 'fa-solid fa-truck-arrow-right',
                    'route'      => 'admin.statuses.index',
                    'permission' => 'status-read'
                ]
            ]
        ],
        [
            'label'      => 'Products Management',
            'icon'       => 'fa-solid fa-barcode',
            'route'      => '#',
            'permission' => 'products-read',
            'sub' => [
                [
                    'label'      => 'Brands',
                    'icon'       => 'fa-solid fa-copyright',
                    'route'      => 'admin.brands.index',
                    'permission' => 'brands-read'
                ],
                [
                    'label'      => 'Categories',
                    'icon'       => 'fa-solid fa-tags',
                    'route'      => 'admin.categories.index',
                    'permission' => 'categories-read'
                ],
                [
                    'label'      => 'Products',
                    'icon'       => 'fa-solid fa-barcode',
                    'route'      => 'admin.products.index',
                    'permission' => 'products-read'
                ],
                // [
                //     'label'      => 'Product Bulk',
                //     'icon'       => 'fa-solid fa-upload',
                //     'route'      => 'admin.products.bulk',
                //     'permission' => 'product-bulk-create'
                // ],
            ]
        ],
        [
            'label'      => 'Users Management',
            'icon'       => 'fa-solid fa-circle-user',
            'route'      => '#',
            'permission' => 'users-read',
            'sub' => [
                [
                    'label'      => 'Users',
                    'icon'       => 'fa-solid fa-circle-user',
                    'route'      => 'admin.users.index',
                    'permission' => 'users-read'
                ],
                [
                    'label'      => 'Roles',
                    'icon'       => 'fa-solid fa-circle-user',
                    'route'      => 'admin.roles',
                    'permission' => 'roles-read'
                ],
                [
                    'label'      => 'Permissions',
                    'icon'       => 'fa-solid fa-universal-access',
                    'route'      => 'admin.permissions',
                    'permission' => 'permissions-read'
                ],
            ]
        ],
        [
            'label'      => 'Reports Management',
            'icon'       => 'fa fa-history',
            'route'      => '#',
            'permission' => 'sell-reports-read',
            'sub' => [
                [
                    'label'      => 'Sale Report',
                    'icon'       => 'fa fa-history',
                    'route'      => 'admin.orders.report',
                    'permission' => 'sell-reports-read'
                ]
            ]
        ]
    ]
];
