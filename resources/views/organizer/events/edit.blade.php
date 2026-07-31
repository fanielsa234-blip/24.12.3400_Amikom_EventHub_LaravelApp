@extends('layouts.organizer')

@section('title', 'Edit Event - Organizer')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">
    <!-- Header -->
    <div class="flex items-center justify-between border-b border-slate-800 pb-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight">Edit Event</h1>
            <p class="text-slate-400 text-xs mt-0.5">Perbarui informasi event <strong>{{ $event->title }}</strong>.</p>
        </div>
        <a href="{{ route('organizer.events.index') }}" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold rounded-xl border border-slate-700 transition">
            &larr; Kembali
        </a>
    </div>

    <!-- Form Card -->
    <form action="{{ route('organizer.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="bg-slate-800/80 border border-slate-700/60 rounded-2xl p-5 sm:p-7 space-y-4 shadow-xl">
        @csrf
        @method('PUT')

        <!-- Judul Event -->
        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Judul Event *</label>
            <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 transition text-xs sm:text-sm font-medium">
            @error('title')
                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kategori & Date Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Kategori *</label>
                <select name="category_id" id="category_id" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-emerald-500 transition text-xs sm:text-sm font-medium cursor-pointer">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
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
                <input type="date" name="date" id="date" value="{{ old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d')) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-emerald-500 transition text-xs sm:text-sm font-medium">
                @error('date')
                    <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Lokasi -->
        <div>
            <label for="location" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Lokasi Event *</label>
            <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 transition text-xs sm:text-sm font-medium">
            @error('location')
                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Harga Tiket & Kuota Tiket Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="price" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Harga Tiket (Rp) *</label>
                <input type="number" name="price" id="price" min="0" value="{{ old('price', $event->price) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-emerald-500 transition text-xs sm:text-sm font-medium">
                @error('price')
                    <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stock" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Kuota Tiket (Stok) *</label>
                <input type="number" name="stock" id="stock" min="0" value="{{ old('stock', $event->stock) }}" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-emerald-500 transition text-xs sm:text-sm font-medium">
                @error('stock')
                    <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Deskripsi Event *</label>
            <textarea name="description" id="description" rows="3" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 transition text-xs sm:text-sm font-medium">{{ old('description', $event->description) }}</textarea>
            @error('description')
                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Poster Upload -->
        <div>
            <label for="poster" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">Poster Event (Opsional - Kosongkan jika tidak diubah)</label>
            @if($event->poster_path)
                <div class="mb-2 flex items-center gap-3">
                    <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}" class="w-10 h-10 object-cover rounded-lg border border-slate-700" onerror="this.style.display='none'">
                    <span class="text-xs text-slate-400">Poster saat ini</span>
                </div>
            @endif
            <input type="file" name="poster" id="poster" accept="image/*" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-slate-300 text-xs sm:text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-500 cursor-pointer">
            @error('poster')
                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Buttons -->
        <div class="pt-3 border-t border-slate-700 flex justify-end gap-2.5">
            <a href="{{ route('organizer.events.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-slate-300 font-bold text-xs sm:text-sm rounded-xl transition">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 bg-amber-600 hover:bg-amber-500 text-white font-extrabold text-xs sm:text-sm rounded-xl shadow-lg transition">
                Perbarui Event
            </button>
        </div>
    </form>
</div>
@endsection
