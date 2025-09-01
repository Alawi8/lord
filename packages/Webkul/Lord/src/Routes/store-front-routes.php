<?php

use Illuminate\Support\Facades\Route;
use Webkul\Lord\Http\Controllers\BookingProductController;
use Webkul\Lord\Http\Controllers\CompareController;
use Webkul\Lord\Http\Controllers\HomeController;
use Webkul\Lord\Http\Controllers\PageController;
use Webkul\Lord\Http\Controllers\ProductController;
use Webkul\Lord\Http\Controllers\ProductsCategoriesProxyController;
use Webkul\Lord\Http\Controllers\SearchController;
use Webkul\Lord\Http\Controllers\SubscriptionController;

/**
 * CMS pages.
 */
Route::get('page/{slug}', [PageController::class, 'view'])
    ->name('lord.cms.page')
    ->middleware('cache.response');

/**
 * Fallback route.
 */
Route::fallback(ProductsCategoriesProxyController::class.'@index')
    ->name('lord.product_or_category.index')
    ->middleware('cache.response');

/**
 * Store front home.
 */
Route::get('/', [HomeController::class, 'index'])
    ->name('lord.home.index')
    ->middleware('cache.response');

Route::get('contact-us', [HomeController::class, 'contactUs'])
    ->name('lord.home.contact_us')
    ->middleware('cache.response');

Route::post('contact-us/send-mail', [HomeController::class, 'sendContactUsMail'])
    ->name('lord.home.contact_us.send_mail')
    ->middleware('cache.response');

/**
 * Store front search.
 */
Route::get('search', [SearchController::class, 'index'])
    ->name('lord.search.index')
    ->middleware('cache.response');

Route::post('search/upload', [SearchController::class, 'upload'])->name('lord.search.upload');

/**
 * Subscription routes.
 */
Route::controller(SubscriptionController::class)->group(function () {
    Route::post('subscription', 'store')->name('lord.subscription.store');

    Route::get('subscription/{token}', 'destroy')->name('lord.subscription.destroy');
});

/**
 * Compare products
 */
Route::get('compare', [CompareController::class, 'index'])
    ->name('lord.compare.index')
    ->middleware('cache.response');

/**
 * Downloadable products
 */
Route::controller(ProductController::class)->group(function () {
    Route::get('downloadable/download-sample/{type}/{id}', 'downloadSample')->name('lord.downloadable.download_sample');

    Route::get('product/{id}/{attribute_id}', 'download')->name('lord.product.file.download');
});

/**
 * Booking products
 */
Route::get('booking-slots/{id}', [BookingProductController::class, 'index'])
    ->name('lord.booking-product.slots.index');
