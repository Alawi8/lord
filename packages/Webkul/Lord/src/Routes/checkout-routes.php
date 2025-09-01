<?php

use Illuminate\Support\Facades\Route;
use Webkul\Lord\Http\Controllers\CartController;
use Webkul\Lord\Http\Controllers\OnepageController;

/**
 * Cart routes.
 */
Route::controller(CartController::class)->prefix('checkout/cart')->group(function () {
    Route::get('', 'index')->name('lord.checkout.cart.index');
});

Route::controller(OnepageController::class)->prefix('checkout/onepage')->group(function () {
    Route::get('', 'index')->name('lord.checkout.onepage.index');

    Route::get('success', 'success')->name('lord.checkout.onepage.success');
});
