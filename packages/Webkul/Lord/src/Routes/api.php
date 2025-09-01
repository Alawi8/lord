<?php

use Illuminate\Support\Facades\Route;
use Webkul\Lord\Http\Controllers\API\AddressController;
use Webkul\Lord\Http\Controllers\API\CartController;
use Webkul\Lord\Http\Controllers\API\CategoryController;
use Webkul\Lord\Http\Controllers\API\CompareController;
use Webkul\Lord\Http\Controllers\API\CoreController;
use Webkul\Lord\Http\Controllers\API\CustomerController;
use Webkul\Lord\Http\Controllers\API\OnepageController;
use Webkul\Lord\Http\Controllers\API\ProductController;
use Webkul\Lord\Http\Controllers\API\ReviewController;
use Webkul\Lord\Http\Controllers\API\WishlistController;

Route::group(['prefix' => 'api'], function () {
    Route::controller(CoreController::class)->prefix('core')->group(function () {
        Route::get('countries', 'getCountries')->name('lord.api.core.countries');

        Route::get('states', 'getStates')->name('lord.api.core.states');
    });

    Route::controller(CategoryController::class)->prefix('categories')->group(function () {
        Route::get('', 'index')->name('lord.api.categories.index');

        Route::get('tree', 'tree')->name('lord.api.categories.tree');

        Route::get('attributes', 'getAttributes')->name('lord.api.categories.attributes');

        Route::get('attributes/{attribute_id}/options', 'getAttributeOptions')->name('lord.api.categories.attribute_options');

        Route::get('max-price/{id?}', 'getProductMaxPrice')->name('lord.api.categories.max_price');
    });

    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('', 'index')->name('lord.api.products.index');

        Route::get('{id}/related', 'relatedProducts')->name('lord.api.products.related.index');

        Route::get('{id}/up-sell', 'upSellProducts')->name('lord.api.products.up-sell.index');
    });

    Route::controller(ReviewController::class)->prefix('product/{id}')->group(function () {
        Route::get('reviews', 'index')->name('lord.api.products.reviews.index');

        Route::post('review', 'store')->name('lord.api.products.reviews.store');

        Route::get('reviews/{review_id}/translate', 'translate')->name('lord.api.products.reviews.translate');
    });

    Route::controller(CompareController::class)->prefix('compare-items')->group(function () {
        Route::get('', 'index')->name('lord.api.compare.index');

        Route::post('', 'store')->name('lord.api.compare.store');

        Route::delete('', 'destroy')->name('lord.api.compare.destroy');

        Route::delete('all', 'destroyAll')->name('lord.api.compare.destroy_all');
    });

    Route::controller(CartController::class)->prefix('checkout/cart')->group(function () {
        Route::get('', 'index')->name('lord.api.checkout.cart.index');

        Route::post('', 'store')->name('lord.api.checkout.cart.store');

        Route::put('', 'update')->name('lord.api.checkout.cart.update');

        Route::delete('', 'destroy')->name('lord.api.checkout.cart.destroy');

        Route::delete('selected', 'destroySelected')->name('lord.api.checkout.cart.destroy_selected');

        Route::post('move-to-wishlist', 'moveToWishlist')->name('lord.api.checkout.cart.move_to_wishlist');

        Route::post('coupon', 'storeCoupon')->name('lord.api.checkout.cart.coupon.apply');

        Route::post('estimate-shipping-methods', 'estimateShippingMethods')->name('lord.api.checkout.cart.estimate_shipping');

        Route::delete('coupon', 'destroyCoupon')->name('lord.api.checkout.cart.coupon.remove');

        Route::get('cross-sell', 'crossSellProducts')->name('lord.api.checkout.cart.cross-sell.index');
    });

    Route::controller(OnepageController::class)->prefix('checkout/onepage')->group(function () {
        Route::get('summary', 'summary')->name('lord.checkout.onepage.summary');

        Route::post('addresses', 'storeAddress')->name('lord.checkout.onepage.addresses.store');

        Route::post('shipping-methods', 'storeShippingMethod')->name('lord.checkout.onepage.shipping_methods.store');

        Route::post('payment-methods', 'storePaymentMethod')->name('lord.checkout.onepage.payment_methods.store');

        Route::post('orders', 'storeOrder')->name('lord.checkout.onepage.orders.store');
    });

    /**
     * Login routes.
     */
    Route::controller(CustomerController::class)->prefix('customer')->group(function () {
        Route::post('login', 'login')->name('lord.api.customers.session.create');
    });

    Route::group(['middleware' => ['customer'], 'prefix' => 'customer'], function () {
        Route::controller(AddressController::class)->prefix('addresses')->group(function () {
            Route::get('', 'index')->name('lord.api.customers.account.addresses.index');

            Route::post('', 'store')->name('lord.api.customers.account.addresses.store');

            Route::put('edit/{id?}', 'update')->name('lord.api.customers.account.addresses.update');
        });

        Route::controller(WishlistController::class)->prefix('wishlist')->group(function () {
            Route::get('', 'index')->name('lord.api.customers.account.wishlist.index');

            Route::post('', 'store')->name('lord.api.customers.account.wishlist.store');

            Route::post('{id}/move-to-cart', 'moveToCart')->name('lord.api.customers.account.wishlist.move_to_cart');

            Route::delete('all', 'destroyAll')->name('lord.api.customers.account.wishlist.destroy_all');

            Route::delete('{id}', 'destroy')->name('lord.api.customers.account.wishlist.destroy');
        });
    });
});
