<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $organizer = Auth::user()->organizer;
        $events = Event::with('category')
            ->where('organizer_id', $organizer->id)
            ->latest()
            ->paginate(10);

        return view('organizer.events.index', compact('events', 'organizer'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('organizer.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $organizer = Auth::user()->organizer;

        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'poster'      => 'nullable|image|max:2048',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        Event::create([
            'organizer_id' => $organizer->id,
            'category_id'  => $request->category_id,
            'title'        => $request->title,
            'description'  => $request->description,
            'date'         => $request->date,
            'location'     => $request->location,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'poster_path'  => $posterPath,
        ]);

        return redirect()->route('organizer.events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit(Event $event)
    {
        $organizer = Auth::user()->organizer;
        if ($event->organizer_id !== $organizer->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit event milik organizer lain.');
        }

        $categories = Category::all();
        return view('organizer.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $organizer = Auth::user()->organizer;
        if ($event->organizer_id !== $organizer->id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'date'        => 'required|date',
            'location'    => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'poster'      => 'nullable|image|max:2048',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'date'        => $request->date,
            'location'    => $request->location,
            'price'       => $request->price,
            'stock'       => $request->stock,
        ];

        if ($request->hasFile('poster')) {
            if ($event->poster_path && Storage::disk('public')->exists($event->poster_path)) {
                Storage::disk('public')->delete($event->poster_path);
            }
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update($data);

        return redirect()->route('organizer.events.index')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        $organizer = Auth::user()->organizer;
        if ($event->organizer_id !== $organizer->id) {
            abort(403, 'Akses ditolak.');
        }

        if ($event->poster_path && Storage::disk('public')->exists($event->poster_path)) {
            Storage::disk('public')->delete($event->poster_path);
        }

        $event->delete();

        return redirect()->route('organizer.events.index')->with('success', 'Event berhasil dihapus!');
    }
}
