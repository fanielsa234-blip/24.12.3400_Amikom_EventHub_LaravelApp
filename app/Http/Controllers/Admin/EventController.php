<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * READ: Menampilkan daftar tabel manajemen event untuk Admin.
     */
    public function index()
    {
        $events = Event::with('category')->latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Menampilkan formulir tambah event baru.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    /**
     * CREATE: Menyimpan data event baru ke dalam database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric'
        ]);

        Event::create($data);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Data Event berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit/sunting event yang sudah ada.
     */
    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    /**
     * UPDATE: Memperbarui rincian data event di database.
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'category_id' => 'required',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric'
        ]);

        $event->update($data);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Rincian data event berhasil diperbarui.');
    }

    /**
     * DELETE: Menghapus data event secara permanen dari database.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
                         ->with('success', 'Data event berhasil dihapus secara permanen.');
    }
}
