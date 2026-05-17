<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;

class EventController extends Controller
{
    // Menampilkan Halaman Utama & Filter Kategori
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Event::with('category')->where('date', '>', now())->orderBy('date', 'asc');

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $events = $query->get();
        return view('welcome', compact('events', 'categories'));
    }

    // Menampilkan Halaman Detail Event
    public function show($id)
    {
        $event = Event::with('category')->findOrFail($id);
        return view('event-detail', compact('event'));
    }

    // Menampilkan Halaman Checkout
    public function checkout($id)
    {
        $event = Event::findOrFail($id);
        return view('checkout', compact('event'));
    }

    // Menampilkan Halaman E-Ticket (Simulasi Sukses)
    public function ticket($id)
    {
        $event = Event::findOrFail($id);
        // Generate Order ID Acak untuk simulasi
        $orderId = 'TRX-' . rand(10000, 99999);
        return view('ticket', compact('event', 'orderId'));
    }
}
