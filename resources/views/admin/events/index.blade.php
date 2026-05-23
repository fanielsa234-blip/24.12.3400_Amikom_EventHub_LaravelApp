@extends('layouts.admin')
@section('title', 'Kelola Event - Admin Panel')

@section('content')
<header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
    <div>
        <h1 class="text-3xl font-black text-slate-800">Kelola Event</h1>
        <p class="text-slate-500 font-medium">Buat dan atur acara seru Anda di sini.</p>
    </div>
    <a href="{{ route('admin.events.create') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-0.5 transition-all">
        + Tambah Event Baru
    </a>
</header>

<!-- Notifikasi Alert -->
@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-xl border border-green-200 mb-6 font-bold flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-2 md:p-4">
    
    <!-- Filter Bar (Search & Kategori) -->
    <div class="flex flex-col md:flex-row gap-4 p-4 border-b border-slate-100">
        <div class="flex-1">
            <input type="text" placeholder="Cari nama event..." class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition font-medium text-slate-700">
        </div>
        <div class="w-full md:w-48">
            <select class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition font-medium text-slate-700 appearance-none cursor-pointer">
                <option value="">Semua Kategori</option>
                <!-- Opsi kategori bisa dilooping dari database nantinya -->
                <option value="musik">Musik</option>
                <option value="teknologi">Teknologi</option>
                <option value="workshop">Workshop</option>
            </select>
        </div>
    </div>

    <!-- Tabel Data Event -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead class="text-slate-400 uppercase text-[10px] font-black tracking-widest border-b border-slate-100">
                <tr>
                    <th class="px-6 py-5 w-16 text-center">No</th>
                    <th class="px-6 py-5 w-24">Poster</th>
                    <th class="px-6 py-5">Event</th>
                    <th class="px-6 py-5">Harga / Stok</th>
                    <th class="px-6 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($events as $index => $event)
                <tr class="hover:bg-slate-50/50 transition duration-200 group">
                    <td class="px-6 py-6 font-bold text-slate-400 text-center">{{ $index + 1 }}</td>
                    <td class="px-6 py-6">
                        <!-- Menampilkan Poster (Jika ada poster_path di database, gunakan itu. Jika tidak, gunakan default berdasarkan kategori seperti di halaman depan) -->
                        @php
                            $catName = strtolower($event->category->name ?? '');
                            if (str_contains($catName, 'teknologi') || str_contains($catName, 'coding')) {
                                $defaultImg = asset('assets/hackathon.png');
                            } elseif (str_contains($catName, 'workshop') || str_contains($catName, 'seminar')) {
                                $defaultImg = asset('assets/workshop.png');
                            } else {
                                $defaultImg = asset('assets/concert.png');
                            }
                            $imgSrc = $event->poster_path ? asset($event->poster_path) : $defaultImg;
                        @endphp
                        <img src="{{ $imgSrc }}" class="w-14 h-14 rounded-xl object-cover shadow-sm border border-slate-100" alt="Poster">
                    </td>
                    <td class="px-6 py-6">
                        <p class="font-black text-slate-800 text-base mb-1">{{ $event->title }}</p>
                        <p class="text-slate-400 text-xs font-medium">{{ $event->category->name ?? 'Uncategorized' }} • {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                    </td>
                    <td class="px-6 py-6">
                        <p class="font-bold text-indigo-600 mb-1">{{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</p>
                        <p class="text-slate-400 text-xs font-medium">Stok: {{ $event->stock }}</p>
                    </td>
                    <td class="px-6 py-6">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Tombol Edit (Icon) -->
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="p-2.5 bg-indigo-50 text-indigo-500 rounded-xl hover:bg-indigo-500 hover:text-white transition shadow-sm" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            
                            <!-- Tombol Delete (Icon) -->
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-500 hover:text-white transition shadow-sm" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-bold">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            Belum ada event terdaftar.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection