<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - AmikomEventHub
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\EventController as PublicEventController;

// ==========================================
// RUTE USER / PENGUNJUNG UMUM (FRONTEND)
// ==========================================
Route::get('/', [PublicEventController::class, 'index'])->name('home');
Route::get('/event/{id}', [PublicEventController::class, 'show'])->name('events.show');
Route::get('/checkout/{id}', [PublicEventController::class, 'checkout'])->name('checkout');
Route::get('/ticket/{id}', [PublicEventController::class, 'ticket'])->name('ticket');
// Rute Baru: Halaman Tentang Kami
Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');
// Rute Baru: Halaman Bantuan / Cara Pesan
Route::get('/bantuan', function () {
    return view('bantuan');
})->name('bantuan');
// ==========================================
// RUTE ADMINISTRATOR (BACKEND CRUD)
// ==========================================
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    
    // Halaman Utama Dashboard Admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // RUTE RESOURCE UNTUK CRUD EVENT (Memanggil Controller di dalam folder Admin secara spesifik)
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    
    // Halaman Kelola Kategori (Tugas Praktikum 3)
    Route::get('/categories', function () {
        return view('admin.categories.index');
    })->name('categories.index');
    
    // RUTE RESOURCE UNTUK CRUD PARTNER (Tugas Praktikum 4)
    Route::resource('partners', \App\Http\Controllers\Admin\PartnerController::class);
});