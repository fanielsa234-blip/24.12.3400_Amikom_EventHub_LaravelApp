@extends('layouts.organizer')

@section('title', 'Tambah Event Baru - Organizer')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">
    <!-- Header -->
    <div class="flex items-center justify-between border-b border-slate-800 pb-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight">Tambah Event Baru</h1>
            <p class="text-slate-400 text-xs mt-0.5">Isi formulir di bawah ini untuk menambahkan event baru ke platform.</p>
        </div>
        <a href="{{ route('organizer.events.index') }}" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold rounded-xl border border-slate-700 transition">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" class="bg-slate-800/80 border border-slate-700/60 rounded-2xl p-5 sm:p-7 space-y-4 shadow-xl">
        @csrf

        <!-- Judul Event -->
        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Judul Event *</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition text-xs sm:text-sm font-medium" placeholder="Contoh: Seminar Nasional Teknologi 2026">
            @error('title')
                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kategori & Date Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Kategori *</label>
                <select name="category_id" id="category_id" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-indigo-500 transition text-xs sm:text-sm font-medium cursor-pointer">
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="date" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Tanggal Event *</label>
                <input type="date" name="date" id="date" value="{{ old('date') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-indigo-500 transition text-xs sm:text-sm font-medium">
                @error('date')
                    <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Lokasi -->
        <div>
            <label for="location" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Lokasi Event *</label>
            <input type="text" name="location" id="location" value="{{ old('location') }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition text-xs sm:text-sm font-medium" placeholder="Contoh: Ruang Cinema Amikom / Online via Zoom">
            @error('location')
                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Harga Tiket & Kuota Tiket Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="price" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Harga Tiket (Rp) *</label>
                <input type="number" name="price" id="price" min="0" value="{{ old('price', 0) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-indigo-500 transition text-xs sm:text-sm font-medium" placeholder="0 untuk Gratis">
                @error('price')
                    <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stock" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Kuota Tiket (Stok) *</label>
                <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', 100) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-indigo-500 transition text-xs sm:text-sm font-medium">
                @error('stock')
                    <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Deskripsi Event *</label>
            <textarea name="description" id="description" rows="3" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500 transition text-xs sm:text-sm font-medium" placeholder="Jelaskan detail acara, syarat peserta, fasilitas, dan narasumber...">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Poster Upload -->
        <div>
            <label for="poster" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Poster Event (Opsional)</label>
            <input type="file" name="poster" id="poster" accept="image/*" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-slate-300 text-xs sm:text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer">
            <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Max: 2MB)</p>
            @error('poster')
                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Buttons -->
        <div class="pt-3 border-t border-slate-700 flex justify-end gap-2.5">
            <a href="{{ route('organizer.events.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-300 font-bold text-xs sm:text-sm rounded-xl transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-extrabold text-xs sm:text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition">
                Simpan Event
            </button>
        </div>
    </form>
</div>
@endsection
