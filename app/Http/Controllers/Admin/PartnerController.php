<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;

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
     * CREATE: Menyimpan data partner baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:partners,name',
            'logo_url' => 'required|url',
        ], [
            'name.required' => 'Nama partner wajib diisi.',
            'name.unique' => 'Nama partner ini sudah terdaftar.',
            'logo_url.required' => 'URL logo wajib diisi.',
            'logo_url.url' => 'Format URL logo tidak valid (harus berupa link/alamat website).',
        ]);

        Partner::create([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
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
     * UPDATE: Menyimpan pembaruan data partner di database.
     */
    public function update(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:partners,name,' . $id,
            'logo_url' => 'required|url',
        ], [
            'name.required' => 'Nama partner tidak boleh kosong.',
            'name.unique' => 'Nama partner sudah terdaftar.',
            'logo_url.required' => 'URL logo tidak boleh kosong.',
            'logo_url.url' => 'Format URL logo tidak valid (harus berupa link/alamat website).',
        ]);

        $partner->update([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Data partner berhasil diperbarui!');
    }

    /**
     * DELETE: Menghapus data partner secara permanen.
     */
    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus secara permanen!');
    }
}
