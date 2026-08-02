<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Organizer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menjumlahkan total pendapatan dari transaksi lunas
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');

        // 2. Menghitung jumlah tiket terjual (lunas)
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])->count();

        // 3. Menghitung jumlah acara mendatang yang aktif
        $activeEvents = Event::where('date', '>=', now())->count();

        // 4. Menghitung jumlah pesanan pending
        $pendingOrders = Transaction::where('status', 'pending')->count();

        // 5. Mengambil 5 riwayat transaksi terbaru
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        // --- GRAFIK ANALITIK PLATFORM ---

        // A. Pertumbuhan User Terdaftar (Per Bulan)
        $userGrowth = User::select(
                DB::raw('DATE_FORMAT(created_at, "%b %Y") as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderBy(DB::raw('MIN(created_at)'), 'asc')
            ->take(6)
            ->get();

        // B. Pertumbuhan Event (Per Bulan)
        $eventGrowth = Event::select(
                DB::raw('DATE_FORMAT(created_at, "%b %Y") as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderBy(DB::raw('MIN(created_at)'), 'asc')
            ->take(6)
            ->get();

        // C. Pertumbuhan Organizer (Per Bulan)
        $organizerGrowth = Organizer::select(
                DB::raw('DATE_FORMAT(created_at, "%b %Y") as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderBy(DB::raw('MIN(created_at)'), 'asc')
            ->take(6)
            ->get();

        // D. Pertumbuhan Pendapatan Platform (Per Bulan)
        $revenueGrowth = Transaction::whereIn('status', ['settlement', 'success'])
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%b %Y") as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->groupBy('month')
            ->orderBy(DB::raw('MIN(created_at)'), 'asc')
            ->take(6)
            ->get();

        // Format data untuk Chart.js (Labels & Datasets)
        $chartUserLabels = $userGrowth->pluck('month')->toArray();
        $chartUserData   = $userGrowth->pluck('total')->toArray();

        $chartEventLabels = $eventGrowth->pluck('month')->toArray();
        $chartEventData   = $eventGrowth->pluck('total')->toArray();

        $chartOrganizerLabels = $organizerGrowth->pluck('month')->toArray();
        $chartOrganizerData   = $organizerGrowth->pluck('total')->toArray();

        $chartRevenueLabels = $revenueGrowth->pluck('month')->toArray();
        $chartRevenueData   = $revenueGrowth->pluck('total')->toArray();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions',
            'chartUserLabels',
            'chartUserData',
            'chartEventLabels',
            'chartEventData',
            'chartOrganizerLabels',
            'chartOrganizerData',
            'chartRevenueLabels',
            'chartRevenueData'
        ));
    }
}