<?php

return [
    [
        'key'   => 'account',
        'name'  => 'lord::app.layouts.my-account',
        'route' => 'lord.customers.account.profile.index',
        'icon'  => '',
        'sort'  => 1,
    ], [
        'key'   => 'account.profile',
        'name'  => 'lord::app.layouts.profile',
        'route' => 'lord.customers.account.profile.index',
        'icon'  => 'icon-users',
        'sort'  => 1,
    ], [
        'key'   => 'account.address',
        'name'  => 'lord::app.layouts.address',
        'route' => 'lord.customers.account.addresses.index',
        'icon'  => 'icon-location',
        'sort'  => 2,
    ], [
        'key'   => 'account.orders',
        'name'  => 'lord::app.layouts.orders',
        'route' => 'lord.customers.account.orders.index',
        'icon'  => 'icon-orders',
        'sort'  => 3,
    ], [
        'key'   => 'account.downloadables',
        'name'  => 'lord::app.layouts.downloadable-products',
        'route' => 'lord.customers.account.downloadable_products.index',
        'icon'  => 'icon-download',
        'sort'  => 4,
    ], [
        'key'   => 'account.reviews',
        'name'  => 'lord::app.layouts.reviews',
        'route' => 'lord.customers.account.reviews.index',
        'icon'  => 'icon-star',
        'sort'  => 5,
    ], [
        'key'   => 'account.wishlist',
        'name'  => 'lord::app.layouts.wishlist',
        'route' => 'lord.customers.account.wishlist.index',
        'icon'  => 'icon-heart',
        'sort'  => 6,
    ], [
        'key'   => 'account.gdpr_data_request',
        'name'  => 'lord::app.layouts.gdpr-request',
        'route' => 'lord.customers.account.gdpr.index',
        'icon'  => 'icon-gdpr-safe',
        'sort'  => 7,
    ],
];
