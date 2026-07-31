<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterOrganizerController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes - AmikomEventHub
|--------------------------------------------------------------------------
*/

// Rute Dedicated Auth Pelanggan & SSO Google
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/organizer/login', [LoginController::class, 'showOrganizerLoginForm'])->name('organizer.login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::post('/user/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home')->with('success', 'Berhasil keluar.');
})->name('user.logout');

// Rute Pendaftaran Mandiri Organizer Baru (TAHAP E)
Route::get('/organizer/register', [RegisterOrganizerController::class, 'show'])->name('organizer.register');
Route::post('/organizer/register', [RegisterOrganizerController::class, 'store'])->name('organizer.register.store');
Route::get('/auth/google/organizer', [SocialiteController::class, 'redirectToGoogleOrganizer'])->name('auth.google.organizer');
Route::get('/organizer/register/complete', [SocialiteController::class, 'showCompleteRegistration'])->middleware('auth')->name('organizer.register.complete');
Route::post('/organizer/register/complete', [SocialiteController::class, 'storeCompleteRegistration'])->middleware('auth')->name('organizer.register.complete.store');

// Rute Rating & Review Event
Route::post('/events/{event}/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('events.reviews.store');

// Route Guest Checkout & Midtrans Payment
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

// Route Webhook Notification dari Midtrans
Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handle']);

// ==========================================
// RUTE USER / PENGUNJUNG UMUM (FRONTEND UTS)
// ==========================================
Route::get('/', [\App\Http\Controllers\EventController::class, 'index'])->name('home');
Route::get('/event/{id}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{id}', [\App\Http\Controllers\EventController::class, 'checkout'])->name('checkout');
Route::get('/ticket/{id}', [\App\Http\Controllers\EventController::class, 'ticket'])->name('ticket');

// Rute Halaman Tentang Kami & Bantuan
Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

Route::get('/bantuan', function () {
    return view('bantuan');
})->name('bantuan');

// ==========================================
// RUTE ORGANIZER (MULTI-TENANT PORTAL)
// ==========================================
Route::middleware(['auth', 'organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    Route::get('pending', [RegisterOrganizerController::class, 'pendingStatus'])->name('pending');
    Route::get('dashboard', [\App\Http\Controllers\Organizer\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('events', \App\Http\Controllers\Organizer\EventController::class);
});

// ==========================================
// RUTE ADMINISTRATOR (BACKEND - PROTECTED)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {

    // Rute Auth Admin (Bebas Akses / Guest)
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Rute Administrasi Terproteksi Middleware (Wajib Login & Role Admin)
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('events', EventController::class);
        Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
        Route::resource('partners', PartnerController::class);
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('organizers', [\App\Http\Controllers\Admin\OrganizerController::class, 'index'])->name('organizers.index');
        Route::patch('organizers/{organizer}/status', [\App\Http\Controllers\Admin\OrganizerController::class, 'updateStatus'])->name('organizers.updateStatus');
    });
});