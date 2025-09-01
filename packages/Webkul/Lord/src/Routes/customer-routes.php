<?php

use Illuminate\Support\Facades\Route;
use Webkul\Core\Http\Middleware\NoCacheMiddleware;
use Webkul\Lord\Http\Controllers\Customer\Account\AddressController;
use Webkul\Lord\Http\Controllers\Customer\Account\DownloadableProductController;
use Webkul\Lord\Http\Controllers\Customer\Account\OrderController;
use Webkul\Lord\Http\Controllers\Customer\Account\WishlistController;
use Webkul\Lord\Http\Controllers\Customer\CustomerController;
use Webkul\Lord\Http\Controllers\Customer\ForgotPasswordController;
use Webkul\Lord\Http\Controllers\Customer\GDPRController;
use Webkul\Lord\Http\Controllers\Customer\RegistrationController;
use Webkul\Lord\Http\Controllers\Customer\ResetPasswordController;
use Webkul\Lord\Http\Controllers\Customer\SessionController;
use Webkul\Lord\Http\Controllers\DataGridController;

Route::prefix('customer')->group(function () {
    /**
     * Forgot password routes.
     */
    Route::controller(ForgotPasswordController::class)->prefix('forgot-password')->group(function () {
        Route::get('', 'create')->name('lord.customers.forgot_password.create');

        Route::post('', 'store')->name('lord.customers.forgot_password.store');
    });

    /**
     * Reset password routes.
     */
    Route::controller(ResetPasswordController::class)->prefix('reset-password')->group(function () {
        Route::get('{token}', 'create')->name('lord.customers.reset_password.create');

        Route::post('', 'store')->name('lord.customers.reset_password.store');
    });

    /**
     * Login routes.
     */
    Route::controller(SessionController::class)->prefix('login')->group(function () {
        Route::get('', 'index')->name('lord.customer.session.index');

        Route::post('', 'store')->name('lord.customer.session.create');
    });

    /**
     * Registration routes.
     */
    Route::controller(RegistrationController::class)->group(function () {
        Route::prefix('register')->group(function () {
            Route::get('', 'index')->name('lord.customers.register.index');

            Route::post('', 'store')->name('lord.customers.register.store');
        });

        /**
         * Customer verification routes.
         */
        Route::get('verify-account/{token}', 'verifyAccount')->name('lord.customers.verify');

        Route::get('resend/verification/{email}', 'resendVerificationEmail')->name('lord.customers.resend.verification_email');
    });

    /**
     * Customer authenticated routes. All the below routes only be accessible
     * if customer is authenticated.
     */
    Route::group(['middleware' => ['customer', NoCacheMiddleware::class]], function () {
        /**
         * Datagrid routes.
         */
        Route::get('datagrid/look-up', [DataGridController::class, 'lookUp'])->name('lord.customer.datagrid.look_up');

        /**
         * Logout.
         */
        Route::delete('logout', [SessionController::class, 'destroy'])->name('lord.customer.session.destroy');

        /**
         * Customer account. All the below routes are related to
         * customer account details.
         */
        Route::prefix('account')->group(function () {
            Route::get('', [CustomerController::class, 'account'])->name('lord.customers.account.index');

            /**
             * Wishlist.
             */
            Route::get('wishlist', [WishlistController::class, 'index'])->name('lord.customers.account.wishlist.index');

            /**
             * Profile.
             */
            Route::controller(CustomerController::class)->group(function () {
                Route::prefix('profile')->group(function () {
                    Route::get('', 'index')->name('lord.customers.account.profile.index');

                    Route::get('edit', 'edit')->name('lord.customers.account.profile.edit');

                    Route::post('edit', 'update')->name('lord.customers.account.profile.update');

                    Route::post('destroy', 'destroy')->name('lord.customers.account.profile.destroy');
                });

                Route::get('reviews', 'reviews')->name('lord.customers.account.reviews.index');
            });

            /**
             * GDPR.
             */
            Route::controller(GDPRController::class)->prefix('gdpr')->group(function () {
                Route::get('', 'index')->name('lord.customers.account.gdpr.index');

                Route::post('', 'store')->name('lord.customers.account.gdpr.store');

                Route::get('pdf-view', 'pdfView')->name('lord.customers.account.gdpr.pdf-view');

                Route::get('html-view', 'htmlView')->name('lord.customers.account.gdpr.html-view');

                Route::get('revoke/{id}', 'revoke')->name('lord.customers.account.gdpr.revoke');
            });

            /**
             * Cookie consent.
             */
            Route::get('your-cookie-consent-preferences', [GDPRController::class, 'cookieConsent'])
                ->name('lord.customers.gdpr.cookie-consent');

            /**
             * Addresses.
             */
            Route::controller(AddressController::class)->prefix('addresses')->group(function () {
                Route::get('', 'index')->name('lord.customers.account.addresses.index');

                Route::get('create', 'create')->name('lord.customers.account.addresses.create');

                Route::post('create', 'store')->name('lord.customers.account.addresses.store');

                Route::get('edit/{id}', 'edit')->name('lord.customers.account.addresses.edit');

                Route::put('edit/{id}', 'update')->name('lord.customers.account.addresses.update');

                Route::patch('edit/{id}', 'makeDefault')->name('lord.customers.account.addresses.update.default');

                Route::delete('delete/{id}', 'destroy')->name('lord.customers.account.addresses.delete');
            });

            /**
             * Orders.
             */
            Route::controller(OrderController::class)->prefix('orders')->group(function () {
                Route::get('', 'index')->name('lord.customers.account.orders.index');

                Route::get('view/{id}', 'view')->name('lord.customers.account.orders.view');

                Route::get('reorder/{id}', 'reorder')->name('lord.customers.account.orders.reorder');

                Route::post('cancel/{id}', 'cancel')->name('lord.customers.account.orders.cancel');

                Route::get('print/Invoice/{id}', 'printInvoice')->name('lord.customers.account.orders.print-invoice');
            });

            /**
             * Downloadable products.
             */
            Route::controller(DownloadableProductController::class)->prefix('downloadable-products')->group(function () {
                Route::get('', 'index')->name('lord.customers.account.downloadable_products.index');

                Route::get('download/{id}', 'download')->name('lord.customers.account.downloadable_products.download');
            });
        });
    });
});
