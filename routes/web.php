<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CategoryController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/profil', [HomeController::class, 'profil']);
Route::get('/bantuan', [HomeController::class, 'bantuan']);
Route::get('/kontak', [HomeController::class, 'kontak']);
Route::get('/katalog', [EventController::class, 'index']);

// Rute Admin Kategori (Tugas)
Route::get('/admin/categories', [CategoryController::class, 'indexAdmin']);