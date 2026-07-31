@extends('layouts.admin')
@section('title', 'Kelola Event - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Kelola Event</h1>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mt-1">Buat, perbarui, dan atur seluruh daftar acara di platform.</p>
        </div>
        <div>
            <a href="{{ route('admin.events.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs sm:text-sm rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none hover:-translate-y-0.5 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Tambah Event Baru</span>
            </a>
        </div>
    </div>

    <!-- Notifikasi Alert -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-2xl text-sm font-medium flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table Card Container -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden p-2 sm:p-4 transition-colors">
        
        <!-- Filter Bar -->
        <div class="flex flex-col sm:flex-row gap-3 p-3 sm:p-4 border-b border-slate-100 dark:border-slate-800 mb-2">
            <div class="flex-1">
                <input type="text" id="eventSearchInput" placeholder="Cari nama event..." class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-sm font-medium text-slate-800 dark:text-slate-100">
            </div>
        </div>

        <!-- Tabel Data Event -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead class="bg-slate-50 dark:bg-slate-950/80 text-slate-500 dark:text-slate-400 uppercase text-[11px] font-black tracking-widest border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-4 w-16 text-center">No</th>
                        <th class="px-6 py-4 w-20">Poster</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Harga / Stok</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                    @forelse($events as $index => $event)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                        <td class="px-6 py-4 font-bold text-slate-400 dark:text-slate-500 text-center">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            @php
                                $catName = strtolower($event->category->name ?? '');
                                if (str_contains($catName, 'teknologi') || str_contains($catName, 'coding')) {
                                    $defaultImg = asset('assets/hackathon.png');
                                } elseif (str_contains($catName, 'workshop') || str_contains($catName, 'seminar')) {
                                    $defaultImg = asset('assets/workshop.png');
                                } else {
                                    $defaultImg = asset('assets/concert.png');
                                }
                                $imgSrc = $event->poster_path ? asset('storage/' . $event->poster_path) : $defaultImg;
                            @endphp
                            <img src="{{ $imgSrc }}" class="w-12 h-12 rounded-xl object-cover shadow-sm border border-slate-200 dark:border-slate-800" alt="Poster" onerror="this.src='{{ $defaultImg }}'">
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-extrabold text-slate-900 dark:text-white text-base mb-0.5">{{ $event->title }}</p>
                            <div class="flex items-center gap-2 text-xs text-slate-400 dark:text-slate-400 font-medium">
                                <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-800 rounded-md text-slate-600 dark:text-slate-300 font-bold">{{ $event->category->name ?? 'Umum' }}</span>
                                <span>•</span>
                                <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-black text-indigo-600 dark:text-indigo-400 mb-0.5">{{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</p>
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Sisa Stok: <span class="font-bold text-slate-800 dark:text-slate-200">{{ $event->stock }}</span></p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.events.edit', $event->id) }}" class="p-2.5 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 hover:text-white rounded-xl transition shadow-sm" title="Edit Event">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 hover:bg-rose-600 hover:text-white rounded-xl transition shadow-sm" title="Hapus Event">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 dark:text-slate-400 font-bold">
                            Belum ada event terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('eventSearchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        }
    });
</script>
@endsection