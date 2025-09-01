<?php

namespace Webkul\Store\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class StoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // تسجيل أي خدمات مطلوبة
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // تحميل ملفات العرض للثيم Store
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'store');

        // تحميل ملفات الترجمة
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'store');

        // تحميل المسارات مع نفس middleware group المستخدم في Store
        Route::middleware(['web', 'store'])
            ->namespace('Webkul\Store\Http\Controllers')
            ->group(__DIR__.'/../Routes/web.php');
    }
}