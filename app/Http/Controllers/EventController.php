<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Partner;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request) 
    { 
        // 1. Ambil data kategori untuk filter
        $categories = Category::all();

        // 2. Ambil data partner untuk Soal 4 UTS
        $partners = Partner::latest()->get();

        // 3. Kueri data event
        $query = Event::with('category')->orderBy('date', 'asc');

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $events = $query->get();

        // 4. Kirim semua variabel ke view 'welcome'
        return view('welcome', compact('events', 'categories', 'partners'));
    }

    /**
     * Menampilkan Halaman Detail Event dengan Fitur Rating & Review (Bagian 1)
     */
    public function show($id)
    {
        $event = Event::with(['category', 'organizer', 'reviews.user'])->findOrFail($id);
        $hasPurchased = false;
        $userReview = null;
        $isPast = \Carbon\Carbon::parse($event->date)->isPast();

        if (Auth::check()) {
            $user = Auth::user();
            $hasPurchased = Transaction::where('event_id', $event->id)
                ->whereIn('status', ['success', 'settlement', 'pending'])
                ->where('customer_email', $user->email)
                ->exists();

            $userReview = Review::where('user_id', $user->id)
                ->where('event_id', $event->id)
                ->first();
        }

        return view('event-detail', compact('event', 'hasPurchased', 'userReview', 'isPast'));
    }

    /**
     * Redirect dari route legacy /checkout/{id} ke CheckoutController
     */
    public function checkout($id)
    {
        $event = Event::findOrFail($id);
        return redirect()->route('checkout.create', $event->id);
    }

    /**
     * Menampilkan Halaman E-Ticket (Simulasi Sukses)
     */
    public function ticket($id)
    {
        $event = Event::findOrFail($id);
        $orderId = 'TRX-' . rand(10000, 99999);
        return view('ticket', compact('event', 'orderId'));
    }
}
