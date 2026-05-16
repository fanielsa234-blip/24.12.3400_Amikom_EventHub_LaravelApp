<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Menampilkan halaman manajemen kategori untuk Admin
     */
    public function indexAdmin()
    {
        // Memanggil file view yang ada di resources/views/admin/categories/index.blade.php
        return view('admin.categories.index');
    }
}