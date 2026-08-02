@extends('layouts.organizer')

@section('title', 'Kelola Event - Portal Organizer')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Daftar Event Saya</h1>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mt-1">Kelola event yang dipublikasikan oleh organisasi Anda.</p>
        </div>
        <a href="{{ route('organizer.events.create') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-extrabold text-xs sm:text-sm shadow-md transition self-start sm:self-auto">
            + Tambah Event Baru
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-2xl text-xs sm:text-sm font-semibold flex items-center gap-2">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden transition-colors">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead class="bg-slate-50 dark:bg-slate-950/80 text-slate-500 dark:text-slate-400 uppercase text-[11px] font-black tracking-widest border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-4">Judul Event</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Tanggal & Lokasi</th>
                        <th class="px-6 py-4">Harga / Stok</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                    @forelse($events as $event)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                        <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">
                            {{ $event->title }}
                        </td>
                        <td class="px-6 py-4 text-xs font-semibold text-indigo-600 dark:text-indigo-400">
                            {{ $event->category->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-400 font-medium">
                            <p class="font-bold text-slate-800 dark:text-slate-200">{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</p>
                            <p>{{ $event->location }}</p>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-800 dark:text-slate-200">
                            <p>Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                            <p class="text-slate-400 font-normal">Stok: {{ $event->stock }}</p>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('organizer.events.edit', $event->id) }}" class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold hover:bg-slate-200 transition">Edit</a>
                            <form action="{{ route('organizer.events.destroy', $event->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus event ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 rounded-xl text-xs font-bold hover:bg-rose-100 transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-bold">
                            Belum ada event yang Anda buat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
