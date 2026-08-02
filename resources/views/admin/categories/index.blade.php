@extends('layouts.admin')
@section('title', 'Kelola Kategori - Admin Panel')

@section('content')
<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black">Kelola Kategori</h1>
        <p class="text-slate-500 font-medium">Buat dan kelola kategori event di lingkungan AmikomEventHub.</p>
    </div>
</header>

<!-- Form Pencarian (Soal 3 UTS) -->
<!-- Form Pencarian Kategori (Soal 3) -->
<div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm mb-8">
    <form action="{{ route('admin.categories.index') }}" method="GET" class="flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kategori..." class="flex-1 px-5 py-3 rounded-xl border border-slate-200 outline-none focus:ring-2 focus:ring-indigo-500 transition font-medium">
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition flex items-center">Reset</a>
        @endif
    </form>
</div>

<!-- Notifikasi -->
@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-xl border border-green-200 mb-6 font-bold">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="bg-rose-100 text-rose-700 p-4 rounded-xl border border-rose-200 mb-6 font-bold">
        {{ session('error') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Tambah (Create) -->
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm sticky top-32">
            <h3 class="text-lg font-black text-slate-800 mb-4 uppercase tracking-wide">Kategori Baru</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">Nama Kategori</label>
                    <input type="text" name="name" placeholder="Misal: Workshop Coding" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition font-medium" required>
                </div>
                <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg">
                    Simpan Kategori
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel Kategori (Read, Update, Delete) -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-4 w-16">No</th>
                            <th class="px-8 py-4">Nama Kategori</th>
                            <th class="px-8 py-4">Slug URL</th>
                            <th class="px-8 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y border-t">
                        @forelse($categories as $index => $category)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-6 font-bold text-slate-400">{{ $index + 1 }}</td>
                            <td class="px-8 py-6 font-black text-slate-800 text-base">{{ $category->name }}</td>
                            <td class="px-8 py-6 text-slate-400 font-mono text-xs">{{ $category->slug }}</td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="bukaModalEdit('{{ $category->id }}', '{{ $category->name }}')" class="p-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                    <i class="fas fa-edit"></i>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </button>
                                    
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-10 text-center text-slate-400 font-bold">Data kategori tidak ditemukan atau kosong.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit (Pop-up dinamis) -->
<div id="modal-edit-kategori" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden items-center justify-center p-6">
    <div class="bg-white w-full max-w-md rounded-3xl overflow-hidden shadow-2xl p-8 border">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-black text-slate-800">Edit Nama Kategori</h3>
            <button onclick="tutupModalEdit()" class="p-2 text-slate-400 hover:bg-slate-100 rounded-full font-bold">✕</button>
        </div>
        <form id="form-edit-kategori" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">Ubah Nama</label>
                <input type="text" id="input-edit-nama" name="name" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition font-medium" required>
            </div>
            <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<script>
    function bukaModalEdit(id, nama) {
        const modal = document.getElementById('modal-edit-kategori');
        const form = document.getElementById('form-edit-kategori');
        const input = document.getElementById('input-edit-nama');
        
        form.action = `/admin/categories/${id}`;
        input.value = nama;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function tutupModalEdit() {
        const modal = document.getElementById('modal-edit-kategori');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection