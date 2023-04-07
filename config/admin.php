<?php

return [
    'menu' => [
        [
            'label'       => 'Dashboard',
            'icon'        => 'fa-solid fa-gauge',
            'title'       => 'Dashboard',
            'route'       => 'admin.dashboard',
            'permission'  => 'dashboards-read',
            'sub'         => []
        ],
        [
            'label'       => 'Banners',
            'icon'        => 'fa-solid fa-panorama',
            'title'       => 'Banners',
            'route'       => 'admin.banners',
            'permission'  => 'banners-read',
            'sub'         => []
        ],
        [
            'label'      => 'Offers',
            'icon'       => 'fa-solid fa-gift',
            'title'      => 'Offers',
            'route'      => '#',
            'permission' => 'offers-read',
            'sub' => [
                [
                    'label'      => 'Offers On Quantity',
                    'icon'       => 'fa-solid fa-truck',
                    'title'      => 'Offers On Quantity',
                    'route'      => 'admin.offers.quantity.index',
                    'permission' => 'offers-read'
                ],
                [
                    'label'      => 'Offers On BSGS',
                    'icon'       => 'fa-solid fa-truck',
                    'title'      => 'Offers On Quantity',
                    'route'      => 'admin.offers.bsgs.index',
                    'permission' => 'offers-read'
                ]
            ]
        ],
        [
            'label'      => 'Gateways',
            'icon'       => 'fa-solid fa-truck',
            'title'      => 'Delivery Type',
            'route'      => '#',
            'permission' => 'payment-types-read',
            'sub' => [
                [
                    'label'      => 'Delivery Type',
                    'icon'       => 'fa-solid fa-truck',
                    'title'      => 'Delivery Type',
                    'route'      => 'admin.deliveries.index',
                    'permission' => 'delivery-types-read'
                ],
                [
                    'label'      => 'Payment Type',
                    'icon'       => 'fa-solid fa-credit-card',
                    'title'      => 'Payment Type',
                    'route'      => 'admin.payments.index',
                    'permission' => 'payment-types-read'
                ],
            ]
        ],
        [
            'label'      => 'Attributes',
            'icon'       => 'fa-solid fa-people-roof',
            'title'      => 'Families',
            'route'      => '#',
            'permission' => 'families-read',
            'sub' => [
                [
                    'label'      => 'Families',
                    'icon'       => 'fa-solid fa-people-roof',
                    'title'      => 'Families',
                    'route'      => 'admin.families',
                    'permission' => 'families-read'
                ],
                [
                    'label'      => 'Sections',
                    'icon'       => 'fa-solid fa-section',
                    'title'      => 'Sections',
                    'route'      => 'admin.sections.index',
                    'permission' => 'sections-read'
                ]
            ]
        ],
        [
            'label'      => 'Logs',
            'icon'       => 'fa-solid fa-people-roof',
            'title'      => 'Logs',
            'route'      => '#',
            'permission' => 'price-log-read',
            'sub' => [
                [
                    'label'      => 'Product Price Logs',
                    'icon'       => 'fa-solid fa-people-roof',
                    'title'      => 'Product Price Logs',
                    'route'      => 'admin.logs.index',
                    'permission' => 'price-log-read'
                ],
            ]
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
                    'route'      => 'admin.orders.index',
                    'permission' => 'orders-read'
                ],
                [
                    'label'      => 'Order Bulk',
                    'icon'       => 'fa-solid fa-cart-shopping',
                    'title'      => 'Orders',
                    'route'      => 'admin.orders.bulk.onclogy.create',
                    'permission' => 'orders-create'
                ],
                [
                    'label'      => 'Order Status',
                    'icon'       => 'fa-solid fa-truck-arrow-right',
                    'title'      => 'Order Status',
                    'route'      => 'admin.order-statuses.index',
                    'permission' => 'order-status-read'
                ],
                [
                    'label'      => 'Areas',
                    'icon'       => 'fa-solid fa-tag',
                    'title'      => 'Areas',
                    'route'      => 'admin.areas.index',
                    'permission' => 'areas-read'
                ],
                [
                    'label'      => 'Coupon Code',
                    'icon'       => 'fa-solid fa-tag',
                    'title'      => 'Coupon Code',
                    'route'      => 'admin.coupon-codes.index',
                    'permission' => 'coupon-codes-read'
                ]
            ]
        ],
        [
            'label'      => 'Purchase Order',
            'icon'       => 'fa fa-history',
            'title'      => 'Purchase Order',
            'route'      => '#',
            'permission' => 'purchase-order-read',
            'sub' => [
                [
                    'label'      => 'Purchase Orders',
                    'icon'       => 'fa fa-history',
                    'title'      => 'Purchase Orders',
                    'route'      => 'admin.purchase.orders.index',
                    'permission' => 'purchase-order-read'
                ]
            ]
        ],
        [
            'label'      => 'Products Management',
            'icon'       => 'fa-solid fa-barcode',
            'title'      => 'Products',
            'route'      => '#',
            'permission' => 'products-read',
            'sub' => [
                [
                    'label'      => 'Products',
                    'icon'       => 'fa-solid fa-barcode',
                    'title'      => 'Products',
                    'route'      => 'admin.products.index',
                    'permission' => 'products-read'
                ],
                [
                    'label'      => 'Product Bulk',
                    'icon'       => 'fa-solid fa-upload',
                    'title'      => 'Product Bulk',
                    'route'      => 'admin.products.bulk',
                    'permission' => 'product-bulk-create'
                ],
                [
                    'label'      => 'Brands',
                    'icon'       => 'fa-solid fa-copyright',
                    'title'      => 'Brands',
                    'route'      => 'admin.brands.index',
                    'permission' => 'brands-read'
                ],
                [
                    'label'      => 'Companies',
                    'icon'       => 'fa-solid fa-building',
                    'title'      => 'Companies',
                    'route'      => 'admin.companies.index',
                    'permission' => 'companies-read'
                ],
                [
                    'label'      => 'Dosage Form',
                    'icon'       => 'fa-solid fa-pills',
                    'title'      => 'Dosage Form',
                    'route'      => 'admin.dosage-forms.index',
                    'permission' => 'dosage-forms-read'
                ],
                [
                    'label'      => 'Generics',
                    'icon'       => 'fa-solid fa-dna',
                    'title'      => 'Generics',
                    'route'      => 'admin.generics.index',
                    'permission' => 'generics-read'
                ],
                [
                    'label'      => 'Categories',
                    'icon'       => 'fa-solid fa-tags',
                    'title'      => 'Categories',
                    'route'      => 'admin.categories.index',
                    'permission' => 'categories-read'
                ],
            ]
        ],
        [
            'label'      => 'Users Management',
            'icon'       => 'fa-solid fa-circle-user',
            'title'      => 'Users',
            'route'      => '#',
            'permission' => 'users-read',
            'sub' => [
                [
                    'label'      => 'Users',
                    'icon'       => 'fa-solid fa-circle-user',
                    'title'      => 'Users',
                    'route'      => 'admin.users.index',
                    'permission' => 'users-read'
                ],
                [
                    'label'      => 'Roles',
                    'icon'       => 'fa-solid fa-circle-user',
                    'title'      => 'Roles',
                    'route'      => 'admin.roles',
                    'permission' => 'roles-read'
                ],
                [
                    'label'      => 'Permissions',
                    'icon'       => 'fa-solid fa-universal-access',
                    'title'      => 'Permissions',
                    'route'      => 'admin.permissions',
                    'permission' => 'permissions-read'
                ],
                [
                    'label'      => 'Sell Partners',
                    'icon'       => 'fa-solid fa-universal-access',
                    'title'      => 'Sell Partners',
                    'route'      => 'admin.sell-partners.index',
                    'permission' => 'sell-partners-read'
                ],
            ]
        ],
        [
            'label'      => 'Reports Management',
            'icon'       => 'fa fa-history',
            'title'      => 'Sections',
            'route'      => '#',
            'permission' => 'sell-reports-read',
            'sub' => [
                [
                    'label'      => 'Sale Report',
                    'icon'       => 'fa fa-history',
                    'title'      => 'Sale Report',
                    'route'      => 'admin.orders.report',
                    'permission' => 'sell-reports-read'
                ]
            ]
        ],
        // [
        //     'label'      => 'Setting',
        //     'icon'       => 'fa fa-history',
        //     'title'      => 'Sections',
        //     'route'      => '#',
        //     'permission' => 'app-version-update',
        //     'sub' => []
        // ],
    ]
];
