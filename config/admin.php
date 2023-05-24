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
            'label'      => 'Gateways',
            'icon'       => 'fa-solid fa-truck',
            'route'      => '#',
            'permission' => 'payment-types-read',
            'sub' => [
                [
                    'label'      => 'Payment Type',
                    'icon'       => 'fa-solid fa-credit-card',
                    'route'      => 'admin.payments.index',
                    'permission' => 'payment-types-read'
                ],
            ]
        ],
        [
            'label'      => 'Sections',
            'icon'       => 'fa-solid fa-people-roof',
            'route'      => '#',
            'permission' => 'sections-read',
            'sub' => [
                [
                    'label'      => 'Sections',
                    'icon'       => 'fa-solid fa-section',
                    'route'      => 'admin.sections.index',
                    'permission' => 'sections-read'
                ]
            ]
        ],
        [
            'label'      => 'Logs',
            'icon'       => 'fa-solid fa-people-roof',
            'route'      => '#',
            'permission' => 'price-log-read',
            'sub' => [
                [
                    'label'      => 'Product Price Logs',
                    'icon'       => 'fa-solid fa-people-roof',
                    'route'      => 'admin.logs.index',
                    'permission' => 'price-log-read'
                ],
            ]
        ],
        [
            'label'      => 'Orders Management',
            'icon'       => 'fa-solid fa-cart-shopping',
            'route'      => '#',
            'permission' => 'orders-read',
            'sub' => [
                [
                    'label'      => 'Areas',
                    'icon'       => 'fa-solid fa-tag',
                    'route'      => 'admin.areas.index',
                    'permission' => 'areas-read'
                ],
                [
                    'label'      => 'Coupons',
                    'icon'       => 'fa-solid fa-tag',
                    'route'      => 'admin.coupons.index',
                    'permission' => 'coupon-codes-read'
                ],
                [
                    'label'      => 'Orders',
                    'icon'       => 'fa-solid fa-cart-shopping',
                    'route'      => 'admin.orders.index',
                    'permission' => 'orders-read'
                ],
                [
                    'label'      => 'Order Status',
                    'icon'       => 'fa-solid fa-truck-arrow-right',
                    'route'      => 'admin.order-statuses.index',
                    'permission' => 'order-status-read'
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
                [
                    'label'      => 'Product Bulk',
                    'icon'       => 'fa-solid fa-upload',
                    'route'      => 'admin.products.bulk',
                    'permission' => 'product-bulk-create'
                ],
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
