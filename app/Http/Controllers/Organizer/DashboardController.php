<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jika superadmin, peroleh organizer pertama atau redirect ke admin dashboard
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $organizer = $user->organizer;

        if (!$organizer) {
            return redirect()->route('home')->with('error', 'Profil organizer tidak ditemukan.');
        }

        // 1. Event milik organizer ini saja
        $events = Event::with('category')
            ->where('organizer_id', $organizer->id)
            ->latest()
            ->get();

        $eventIds = $events->pluck('id');

        // 2. Transaksi tiket milik event organizer ini saja
        $transactions = Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', ['success', 'settlement'])
            ->get();

        $totalEvents = $events->count();
        $totalTicketsSold = $transactions->count();
        $totalRevenue = $transactions->sum('total_price');

        return view('organizer.dashboard', compact(
            'organizer',
            'events',
            'transactions',
            'totalEvents',
            'totalTicketsSold',
            'totalRevenue'
        ));
    }
}
