<?php

return [
    [
        'key'   => 'account',
        'name'  => 'store::app.layouts.my-account',
        'route' => 'store.customers.account.profile.index',
        'icon'  => '',
        'sort'  => 1,
    ], [
        'key'   => 'account.profile',
        'name'  => 'store::app.layouts.profile',
        'route' => 'store.customers.account.profile.index',
        'icon'  => 'icon-users',
        'sort'  => 1,
    ], [
        'key'   => 'account.address',
        'name'  => 'store::app.layouts.address',
        'route' => 'store.customers.account.addresses.index',
        'icon'  => 'icon-location',
        'sort'  => 2,
    ], [
        'key'   => 'account.orders',
        'name'  => 'store::app.layouts.orders',
        'route' => 'store.customers.account.orders.index',
        'icon'  => 'icon-orders',
        'sort'  => 3,
    ], [
        'key'   => 'account.downloadables',
        'name'  => 'store::app.layouts.downloadable-products',
        'route' => 'store.customers.account.downloadable_products.index',
        'icon'  => 'icon-download',
        'sort'  => 4,
    ], [
        'key'   => 'account.reviews',
        'name'  => 'store::app.layouts.reviews',
        'route' => 'store.customers.account.reviews.index',
        'icon'  => 'icon-star',
        'sort'  => 5,
    ], [
        'key'   => 'account.wishlist',
        'name'  => 'store::app.layouts.wishlist',
        'route' => 'store.customers.account.wishlist.index',
        'icon'  => 'icon-heart',
        'sort'  => 6,
    ],
];
