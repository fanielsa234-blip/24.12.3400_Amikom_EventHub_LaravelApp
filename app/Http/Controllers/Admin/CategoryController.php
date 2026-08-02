<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * READ: Menampilkan halaman tabel daftar Kategori.
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * CREATE: Menyimpan Kategori Baru ke Database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.unique' => 'Nama kategori ini sudah ada di database.',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * UPDATE: Menyimpan Perubahan Nama Kategori (Edit).
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.unique' => 'Nama kategori sudah digunakan.',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * DELETE: Menghapus Kategori.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Mencegah error foreign key constraint jika kategori masih terikat dengan event
        if ($category->events()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Gagal menghapus! Kategori ini masih digunakan oleh event aktif.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus secara permanen!');
    }
}