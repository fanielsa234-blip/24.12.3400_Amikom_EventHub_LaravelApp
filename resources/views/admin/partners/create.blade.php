@extends('layouts.admin')
@section('title', 'Tambah Partner Baru - Admin Panel')

@section('content')
<div class="max-w-xl mx-auto space-y-5">
    <!-- Header -->
    <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">Tambah Partner Baru</h1>
            <p class="text-slate-500 dark:text-slate-400 text-xs mt-0.5">Unggah logo partner dari laptop Anda atau masukkan link gambar.</p>
        </div>
        <a href="{{ route('admin.partners.index') }}" class="px-3.5 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold rounded-xl transition">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 p-5 sm:p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4 transition-colors">
        @csrf
        
        <!-- Nama Partner -->
        <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wider">Nama Partner / Perusahaan *</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Misal: Bank Jago, PT Telkom Indonesia, Google" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium text-slate-900 dark:text-white" required>
            @error('name')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Opsi 1: Upload File Logo -->
        <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wider">Upload File Logo (PNG / JPG / SVG)</label>
            <input type="file" name="logo_file" accept="image/*" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
            <p class="text-[11px] text-slate-400 dark:text-slate-400 mt-1 font-medium">*Pilih file gambar langsung dari laptop (Max: 2MB).</p>
            @error('logo_file')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3 my-2">
            <div class="flex-1 h-px bg-slate-200 dark:bg-slate-800"></div>
            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-widest">ATAU</span>
            <div class="flex-1 h-px bg-slate-200 dark:bg-slate-800"></div>
        </div>

        <!-- Opsi 2: Link URL Logo -->
        <div>
            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 uppercase tracking-wider">URL Link Logo (Opsional)</label>
            <input type="url" name="logo_url" value="{{ old('logo_url') }}" placeholder="https://example.com/logo.png" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium text-slate-900 dark:text-white">
            <p class="text-[11px] text-slate-400 dark:text-slate-400 mt-1 font-medium">*Kosongkan jika Anda sudah memilih file unggahan di atas.</p>
        </div>
        
        <div class="pt-2 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-2.5">
            <a href="{{ route('admin.partners.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs sm:text-sm rounded-xl transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs sm:text-sm rounded-xl shadow-md shadow-indigo-200 dark:shadow-none transition">
                Simpan Partner
            </button>
        </div>
    </form>
</div>
@endsection