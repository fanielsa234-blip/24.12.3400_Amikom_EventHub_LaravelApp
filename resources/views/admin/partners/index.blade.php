@extends('layouts.admin')
@section('title', 'Kelola Partner - Admin Panel')

@section('content')
<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black">Kelola Partner</h1>
        <p class="text-slate-500 font-medium">Atur data partner pendukung platform AmikomEventHub.</p>
    </div>
    <a href="{{ route('admin.partners.create') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
        + Tambah Partner Baru
    </a>
</header>

<!-- Form Pencarian Partner (Soal 3 UTS) -->
<div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm mb-8">
    <form action="{{ route('admin.partners.index') }}" method="GET" class="flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama partner atau instansi..." class="flex-1 px-5 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-indigo-500 transition font-medium">
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.partners.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition flex items-center">Reset</a>
        @endif
    </form>
</div>

<!-- Notifikasi Alert -->
@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-xl border border-green-200 mb-6 font-bold">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Logo Partner</th>
                    <th class="px-8 py-4">Nama Perusahaan / Instansi</th>
                    <th class="px-8 py-4">Tanggal Bergabung</th>
                    <th class="px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($partners as $index => $partner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $index + 1 }}</td>
                    <td class="px-8 py-6">
                        <img src="{{ $partner->logo_url }}" class="w-16 h-16 rounded-2xl object-cover bg-slate-50 border shadow-sm" alt="Logo">
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-black text-slate-800 text-lg">{{ $partner->name }}</p>
                    </td>
                    <td class="px-8 py-6 text-slate-500 font-medium">
                        {{ $partner->created_at->format('d M Y') }}
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white font-bold text-sm transition">
                                Edit
                            </a>
                            
                            <!-- Tombol Delete -->
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white font-bold text-sm transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-bold">Data partner tidak ditemukan atau kosong.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection