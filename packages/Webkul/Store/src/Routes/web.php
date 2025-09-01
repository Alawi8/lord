<?php

// packages/Webkul/Store/src/Routes/web.php

use Illuminate\Support\Facades\Route;
use Webkul\Store\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Store Theme Web Routes
|--------------------------------------------------------------------------
|
| هنا يمكنك تسجيل مسارات ثيم Store. هذه المسارات سيتم تحميلها
| بواسطة StoreServiceProvider داخل مجموعة middleware التي تحتوي على
| "web" و "store" middleware groups.
|
*/

// الصفحة الرئيسية لثيم Store - استخدام نفس اسم route الموجود في Store
Route::get('/', [HomeController::class, 'index'])->name('store.home.index');

// routes إضافية للثيم إذا احتجتها
Route::get('/about-store', [HomeController::class, 'about'])->name('store.about');
Route::get('/contact-store', [HomeController::class, 'contact'])->name('store.contact');
Route::post('/contact-store', [HomeController::class, 'contactPost'])->name('store.contact.post');

// يمكنك إضافة مسارات إضافية خاصة بثيم Store هنا
// Route::get('/special-offers', [HomeController::class, 'specialOffers'])->name('store.special.offers');

// مجموعة مسارات تتطلب تسجيل الدخول
Route::middleware(['customer'])->group(function () {
    // مسارات حساب العميل المخصصة لثيم Store
    // Route::get('/my-account', [AccountController::class, 'index'])->name('store.account.index');
});

// API routes يمكن أن تكون فارغة أو تحتوي على AJAX endpoints
// Route::prefix('api')->group(function () {
//     Route::get('/products/search', [ProductController::class, 'search'])->name('store.api.products.search');
// });