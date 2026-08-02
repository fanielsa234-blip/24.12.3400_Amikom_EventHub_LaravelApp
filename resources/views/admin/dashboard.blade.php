@extends('layouts.admin')
@section('title', 'Dashboard Analytics - Admin')

@section('content')
    <!-- Script Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Dashboard Ringkasan & Analitik</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-xs sm:text-sm mt-1">Selamat datang kembali, Admin Super! Pantau statistik performa platform di bawah ini.</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <div class="text-right hidden sm:block">
                <p class="font-bold text-slate-800 dark:text-slate-200 text-sm">{{ Auth::user()->name ?? 'Admin Super' }}</p>
                <p class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold">Superadmin</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-600 text-white font-black text-base sm:text-lg rounded-2xl shadow-md flex items-center justify-center">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
            </div>
        </div>
    </header>

    <!-- Responsive Stats Grid (1 col mobile, 2 col tablet, 4 col desktop) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden transition-colors">
            <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm transition-colors">
            <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Tiket Terjual</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm transition-colors">
            <div class="w-12 h-12 bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Event Mendatang</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white">{{ $activeEvents }} Event</h3>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm transition-colors">
            <div class="w-12 h-12 bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Pesanan Pending</p>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white">{{ $pendingOrders }} Pesanan</h3>
        </div>
    </div>

    <!-- Quick Action Shortcuts (Bagian 2) -->
    <div class="mb-10">
        <h2 class="text-lg font-black text-slate-900 dark:text-white mb-4">Akses Cepat (Quick Actions)</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('admin.events.index') }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:border-indigo-500 dark:hover:border-indigo-500 transition-all flex items-center gap-3 group">
                <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    🎫
                </div>
                <div>
                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">Kelola Event</h4>
                    <p class="text-[11px] text-slate-400">Buat & edit event</p>
                </div>
            </a>

            <a href="{{ route('admin.transactions.index') }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:border-emerald-500 dark:hover:border-emerald-500 transition-all flex items-center gap-3 group">
                <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    💳
                </div>
                <div>
                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-800 dark:text-slate-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">Kelola Transaksi</h4>
                    <p class="text-[11px] text-slate-400">Laporan & release</p>
                </div>
            </a>

            <a href="{{ route('admin.organizers.index') }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:border-amber-500 dark:hover:border-amber-500 transition-all flex items-center gap-3 group">
                <div class="w-10 h-10 bg-amber-50 dark:bg-amber-950/80 text-amber-600 dark:text-amber-400 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    🏢
                </div>
                <div>
                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">Kelola Organizer</h4>
                    <p class="text-[11px] text-slate-400">Verifikasi tenant</p>
                </div>
            </a>

            <a href="{{ route('admin.partners.index') }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:border-purple-500 dark:hover:border-purple-500 transition-all flex items-center gap-3 group">
                <div class="w-10 h-10 bg-purple-50 dark:bg-purple-950/80 text-purple-600 dark:text-purple-400 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    🤝
                </div>
                <div>
                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-800 dark:text-slate-200 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">Kelola Partner</h4>
                    <p class="text-[11px] text-slate-400">Mitra sponsor</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Section Grafik Analitik (Chart.js) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <!-- Grafik 1: Pertumbuhan User Terdaftar -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm transition-colors">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Pertumbuhan User Terdaftar</h3>
                    <p class="text-xs text-slate-400">Jumlah pengguna baru terdaftar per bulan</p>
                </div>
                <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 text-xs font-bold rounded-lg">User Growth</span>
            </div>
            <div class="relative h-64">
                @if(empty($chartUserData))
                    <div class="absolute inset-0 flex items-center justify-center bg-slate-50/50 dark:bg-slate-950/50 rounded-2xl text-xs text-slate-400 font-semibold">
                        📊 Belum ada data analitik user terdaftar
                    </div>
                @endif
                <canvas id="userGrowthChart"></canvas>
            </div>
        </div>

        <!-- Grafik 2: Pertumbuhan Event & Organizer -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm transition-colors">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Pertumbuhan Event & Organizer</h3>
                    <p class="text-xs text-slate-400">Statistik penambahan event dan penyelenggara</p>
                </div>
                <span class="px-3 py-1 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 text-xs font-bold rounded-lg">Multi-Tenant</span>
            </div>
            <div class="relative h-64">
                @if(empty($chartEventData) && empty($chartOrganizerData))
                    <div class="absolute inset-0 flex items-center justify-center bg-slate-50/50 dark:bg-slate-950/50 rounded-2xl text-xs text-slate-400 font-semibold">
                        📊 Belum ada data analitik event & tenant
                    </div>
                @endif
                <canvas id="tenantGrowthChart"></canvas>
            </div>
        </div>

        <!-- Grafik 3: Pendapatan Platform -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm lg:col-span-2 transition-colors">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Trend Pendapatan Platform (Rp)</h3>
                    <p class="text-xs text-slate-400">Akumulasi transaksi sukses per periode waktu</p>
                </div>
                <span class="px-3 py-1 bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 text-xs font-bold rounded-lg">Revenue Trend</span>
            </div>
            <div class="relative h-64">
                @if(empty($chartRevenueData))
                    <div class="absolute inset-0 flex items-center justify-center bg-slate-50/50 dark:bg-slate-950/50 rounded-2xl text-xs text-slate-400 font-semibold">
                        💰 Belum ada data transaksi pendapatan
                    </div>
                @endif
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi Terakhir -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden transition-colors">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
            <h3 class="font-black text-xl text-slate-900 dark:text-white">Transaksi Terakhir</h3>
            <a href="{{ route('admin.transactions.index') }}" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline text-sm">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-950/80 text-slate-400 dark:text-slate-400 uppercase text-[10px] font-black tracking-widest border-b border-slate-100 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-4">Tgl Transaksi</th>
                        <th class="px-6 py-4">Pembeli</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                    @forelse($recentTransactions as $trx)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            <div class="font-semibold text-slate-800 dark:text-slate-200">{{ $trx->created_at->format('d M Y - H:i') }}</div>
                            <span class="text-xs text-slate-400 font-mono">{{ $trx->order_id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900 dark:text-white">{{ $trx->customer_name }}</p>
                            <p class="text-xs text-slate-400">{{ $trx->customer_email }}</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-700 dark:text-slate-300">{{ $trx->event->title ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(in_array(strtolower($trx->status), ['settlement', 'success']))
                                <span class="px-2.5 py-1 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 rounded-lg text-xs font-bold uppercase border border-emerald-200 dark:border-emerald-800/60">Success</span>
                            @elseif(strtolower($trx->status) === 'pending')
                                <span class="px-2.5 py-1 bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 rounded-lg text-xs font-bold uppercase border border-amber-200 dark:border-amber-800/60">Pending</span>
                            @elseif(strtolower($trx->status) === 'needs_refund')
                                <span class="px-2.5 py-1 bg-amber-500 text-white rounded-lg text-xs font-black uppercase">⚠️ Needs Refund</span>
                            @elseif(strtolower($trx->status) === 'expired')
                                <span class="px-2.5 py-1 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg text-xs font-bold uppercase">Expired</span>
                            @else
                                <span class="px-2.5 py-1 bg-rose-100 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400 rounded-lg text-xs font-bold uppercase border border-rose-200 dark:border-rose-800/60">{{ $trx->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-black text-indigo-600 dark:text-indigo-400 text-right">
                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script chart.js dynamic theme support -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#94a3b8' : '#64748b';
            const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';

            // Data User Growth
            const userLabels = @json($chartUserLabels ?? []);
            const userData = @json($chartUserData ?? []);

            if (userLabels.length > 0) {
                new Chart(document.getElementById('userGrowthChart'), {
                    type: 'line',
                    data: {
                        labels: userLabels,
                        datasets: [{
                            label: 'Pengguna Baru',
                            data: userData,
                            borderColor: '#6366f1',
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { ticks: { color: textColor }, grid: { color: gridColor } },
                            y: { ticks: { color: textColor }, grid: { color: gridColor }, beginAtZero: true }
                        }
                    }
                });
            }

            // Data Tenant Growth
            const eventLabels = @json($chartEventLabels ?? []);
            const eventData = @json($chartEventData ?? []);
            const organizerData = @json($chartOrganizerData ?? []);

            if (eventLabels.length > 0) {
                new Chart(document.getElementById('tenantGrowthChart'), {
                    type: 'bar',
                    data: {
                        labels: eventLabels,
                        datasets: [
                            {
                                label: 'Jumlah Event',
                                data: eventData,
                                backgroundColor: '#10b981',
                                borderRadius: 6
                            },
                            {
                                label: 'Organizer (Tenant)',
                                data: organizerData,
                                backgroundColor: '#3b82f6',
                                borderRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { ticks: { color: textColor }, grid: { color: gridColor } },
                            y: { ticks: { color: textColor }, grid: { color: gridColor }, beginAtZero: true }
                        }
                    }
                });
            }

            // Data Revenue Trend
            const revenueLabels = @json($chartRevenueLabels ?? []);
            const revenueData = @json($chartRevenueData ?? []);

            if (revenueLabels.length > 0) {
                new Chart(document.getElementById('revenueChart'), {
                    type: 'bar',
                    data: {
                        labels: revenueLabels,
                        datasets: [{
                            label: 'Pendapatan (Rp)',
                            data: revenueData,
                            backgroundColor: '#f59e0b',
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { ticks: { color: textColor }, grid: { color: gridColor } },
                            y: { ticks: { color: textColor }, grid: { color: gridColor }, beginAtZero: true }
                        }
                    }
                });
            }
        });
    </script>
@endsection