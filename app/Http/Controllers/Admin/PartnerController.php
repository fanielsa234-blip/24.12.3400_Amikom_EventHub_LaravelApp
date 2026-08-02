<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::latest();

        // Implementasi Fitur Pencarian Data Partner
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $partners = $query->get();
        return view('admin.partners.index', compact('partners'));
    }

    /**
     * CREATE: Menampilkan form tambah partner baru.
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * CREATE: Menyimpan data partner baru ke database (Support File Upload & URL).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:partners,name',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'logo_url' => 'nullable|string',
        ], [
            'name.required' => 'Nama partner wajib diisi.',
            'name.unique' => 'Nama partner ini sudah terdaftar.',
            'logo_file.image' => 'File logo harus berupa gambar.',
            'logo_file.max' => 'Ukuran file logo tidak boleh lebih dari 2MB.',
        ]);

        $logoPath = null;

        // Opsi 1: Jika user mengunggah file logo dari laptop/PC
        if ($request->hasFile('logo_file')) {
            $file = $request->file('logo_file');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $path = $file->storeAs('partners', $filename, 'public');
            $logoPath = 'storage/' . $path;
        } 
        // Opsi 2: Jika user memberikan link URL logo
        elseif ($request->filled('logo_url')) {
            $logoPath = $request->logo_url;
        } 
        // Fallback default jika keduanya kosong
        else {
            $logoPath = 'https://ui-avatars.com/api/?name=' . urlencode($request->name) . '&background=6366f1&color=fff&size=200&bold=true';
        }

        Partner::create([
            'name' => $request->name,
            'logo_url' => $logoPath,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner baru berhasil ditambahkan!');
    }

    /**
     * UPDATE: Menampilkan form edit untuk partner tertentu.
     */
    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * UPDATE: Menyimpan pembaruan data partner di database (Support File Upload & URL).
     */
    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:partners,name,' . $id,
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'logo_url' => 'nullable|string',
        ], [
            'name.required' => 'Nama partner tidak boleh kosong.',
            'name.unique' => 'Nama partner sudah terdaftar.',
            'logo_file.image' => 'File logo harus berupa gambar.',
            'logo_file.max' => 'Ukuran file logo tidak boleh lebih dari 2MB.',
        ]);

        $logoPath = $partner->logo_url;

        // Jika user mengunggah file baru
        if ($request->hasFile('logo_file')) {
            // Hapus file lama jika ada di storage
            if ($partner->logo_url && str_starts_with($partner->logo_url, 'storage/partners/')) {
                $oldPath = str_replace('storage/', '', $partner->logo_url);
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('logo_file');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $path = $file->storeAs('partners', $filename, 'public');
            $logoPath = 'storage/' . $path;
        } 
        // Jika user memperbarui dengan link URL baru
        elseif ($request->filled('logo_url')) {
            $logoPath = $request->logo_url;
        }

        $partner->update([
            'name' => $request->name,
            'logo_url' => $logoPath,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Data partner berhasil diperbarui!');
    }

    /**
     * DELETE: Menghapus data partner secara permanen.
     */
    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);

        // Hapus file logo dari storage jika ada
        if ($partner->logo_url && str_starts_with($partner->logo_url, 'storage/partners/')) {
            $oldPath = str_replace('storage/', '', $partner->logo_url);
            Storage::disk('public')->delete($oldPath);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus!');
    }
}
