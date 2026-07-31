@extends('layouts.organizer')

@section('title', 'Dashboard - ' . $organizer->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-700/60 dark:border-slate-800 pb-5">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <h1 class="text-2xl sm:text-3xl font-black text-white dark:text-white tracking-tight">Dashboard {{ $organizer->name }}</h1>
                @if($organizer->status === 'approved')
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 shadow-sm flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span> Verified Partner
                    </span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> {{ ucfirst($organizer->status) }}
                    </span>
                @endif
            </div>
            <p class="text-slate-400 text-xs sm:text-sm">Pantau ringkasan statistik performa penjualan tiket & event Anda secara real-time.</p>
        </div>
        <div>
            <a href="{{ route('organizer.events.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-black text-xs sm:text-sm rounded-xl shadow-lg shadow-indigo-600/30 active:scale-[0.98] transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Buat Event Baru</span>
            </a>
        </div>
    </div>

    <!-- Stat Cards Grid with Modern Glassmorphism -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
        <!-- Card 1: Total Event -->
        <div class="bg-slate-800/80 dark:bg-slate-900/90 backdrop-blur-xl border border-slate-700/50 dark:border-slate-800 rounded-2xl p-5 relative overflow-hidden shadow-xl hover:border-indigo-500/40 transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-slate-400 text-[11px] font-extrabold uppercase tracking-wider">Total Event Diselenggarakan</span>
                <div class="w-9 h-9 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center border border-indigo-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-3 group-hover:scale-105 transition-transform origin-left">{{ number_format($totalEvents) }}</div>
            <p class="text-[11px] text-indigo-400 mt-1 font-semibold flex items-center gap-1">
                <span>Event aktif atas nama {{ $organizer->name }}</span>
            </p>
        </div>

        <!-- Card 2: Tiket Terjual -->
        <div class="bg-slate-800/80 dark:bg-slate-900/90 backdrop-blur-xl border border-slate-700/50 dark:border-slate-800 rounded-2xl p-5 relative overflow-hidden shadow-xl hover:border-violet-500/40 transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-slate-400 text-[11px] font-extrabold uppercase tracking-wider">Total Tiket Terjual</span>
                <div class="w-9 h-9 rounded-xl bg-violet-500/10 text-violet-400 flex items-center justify-center border border-violet-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-white mt-3 group-hover:scale-105 transition-transform origin-left">{{ number_format($totalTicketsSold) }}</div>
            <p class="text-[11px] text-violet-400 mt-1 font-semibold">Transaksi tiket terkonfirmasi</p>
        </div>

        <!-- Card 3: Total Pendapatan -->
        <div class="bg-slate-800/80 dark:bg-slate-900/90 backdrop-blur-xl border border-slate-700/50 dark:border-slate-800 rounded-2xl p-5 relative overflow-hidden shadow-xl hover:border-emerald-500/40 transition-all group">
            <div class="flex items-center justify-between">
                <span class="text-slate-400 text-[11px] font-extrabold uppercase tracking-wider">Total Pendapatan</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center border border-emerald-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-emerald-400 mt-3 group-hover:scale-105 transition-transform origin-left">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <p class="text-[11px] text-slate-400 mt-1 font-semibold">Akumulasi hasil penjualan tiket</p>
        </div>
    </div>

    <!-- Event List Preview Table -->
    <div class="bg-slate-800/80 dark:bg-slate-900/90 backdrop-blur-xl border border-slate-700/50 dark:border-slate-800 rounded-2xl p-5 space-y-4 shadow-xl">
        <div class="flex items-center justify-between">
            <h2 class="text-base sm:text-lg font-black text-white tracking-tight">Daftar Event {{ $organizer->name }}</h2>
            <a href="{{ route('organizer.events.index') }}" class="text-indigo-400 hover:text-indigo-300 transition text-xs font-bold flex items-center gap-1">
                <span>Lihat Semua</span>
                <span>&rarr;</span>
            </a>
        </div>

        @if($events->isEmpty())
            <div class="text-center py-12 bg-slate-900/40 rounded-xl border border-dashed border-slate-700/60 dark:border-slate-800">
                <p class="text-slate-400 text-xs sm:text-sm font-medium">Belum ada event yang dibuat oleh {{ $organizer->name }}.</p>
                <a href="{{ route('organizer.events.create') }}" class="inline-flex items-center gap-1.5 mt-3 text-xs font-extrabold text-indigo-400 hover:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Buat Event Pertama</span>
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm text-slate-300 min-w-[650px]">
                    <thead class="bg-slate-900/90 text-[10px] uppercase tracking-widest text-slate-400 border-b border-slate-700 dark:border-slate-800">
                        <tr>
                            <th class="py-3.5 px-4">Event</th>
                            <th class="py-3.5 px-4">Kategori</th>
                            <th class="py-3.5 px-4">Tanggal</th>
                            <th class="py-3.5 px-4">Harga Tiket</th>
                            <th class="py-3.5 px-4 text-center">Stok</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/60 dark:divide-slate-800">
                        @foreach($events as $event)
                            <tr class="hover:bg-slate-700/30 dark:hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-white text-sm">{{ $event->title }}</div>
                                    <div class="text-[11px] text-slate-400 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-700/80 text-indigo-300 border border-slate-600/50">
                                        {{ $event->category->name ?? 'Umum' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-slate-300 font-medium">
                                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}
                                </td>
                                <td class="py-3.5 px-4 font-bold text-indigo-400">
                                    {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-bold">
                                    <span class="px-2.5 py-1 rounded-md text-xs {{ $event->stock > 10 ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                        {{ $event->stock }} Tiket
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('events.show', $event->id) }}" class="p-2 bg-slate-700 hover:bg-slate-600 text-slate-200 rounded-lg transition" title="Lihat Publik">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('organizer.events.edit', $event->id) }}" class="p-2 bg-indigo-600/20 hover:bg-indigo-600 text-indigo-300 hover:text-white rounded-lg transition border border-indigo-500/30" title="Edit Event">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
