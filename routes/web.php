<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - AmikomEventHub (UTS Terpadu)
|--------------------------------------------------------------------------
*/

// ==========================================
// RUTE USER / PENGUNJUNG UMUM (FRONTEND)
// ==========================================
Route::get('/', [\App\Http\Controllers\EventController::class, 'index'])->name('home');
Route::get('/event/{id}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{id}', [\App\Http\Controllers\EventController::class, 'checkout'])->name('checkout');
Route::get('/ticket/{id}', [\App\Http\Controllers\EventController::class, 'ticket'])->name('ticket');

// Rute Halaman Tentang Kami (Penyelenggara)
Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

// Rute Halaman Bantuan / Cara Pesan
Route::get('/bantuan', function () {
    return view('bantuan');
})->name('bantuan');


// ==========================================
// RUTE ADMINISTRATOR (BACKEND CRUD)
// ==========================================
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    
    // Halaman Utama Dashboard Admin
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Event Admin
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    
    // SOAL 1: CRUD Kategori Admin
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['create', 'show', 'edit']);
    
    // SOAL 2: CRUD Partner Admin
    Route::resource('partners', \App\Http\Controllers\Admin\PartnerController::class);
    
});