@extends('layouts.app')

@section('title', 'Lengkapi Profil Organisasi - AmikomEventHub')

@section('content')
<main class="min-h-[80vh] flex items-center justify-center px-4 py-8 sm:py-12 bg-slate-50/60">
    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 p-6 sm:p-10 relative overflow-hidden my-auto">
        
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white font-extrabold text-xl mx-auto mb-3 shadow-md shadow-emerald-200">
                OH
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Lengkapi Profil Organisasi</h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">Satu langkah lagi untuk mendaftarkan organisasi Anda via Google.</p>
        </div>

        <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl mb-6 flex items-center gap-3">
            @if($user->avatar)
                <img src="{{ $user->avatar }}" class="w-9 h-9 rounded-full object-cover">
            @else
                <div class="w-9 h-9 bg-indigo-600 text-white font-bold rounded-full flex items-center justify-center text-xs">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
            @endif
            <div class="min-w-0 flex-1">
                <p class="font-bold text-slate-900 text-xs truncate">{{ $user->name }}</p>
                <p class="text-[11px] text-slate-500 truncate">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Form Pelengkapan Profile Organisasi -->
        <form action="{{ route('organizer.register.complete.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Organisasi / HIMA / UKM *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-600 outline-none transition text-xs sm:text-sm font-medium text-slate-900"
                       placeholder="Contoh: HIMA Sistem Informasi (HIMASI)">
                @error('name')
                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Username / Slug URL *</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-600 outline-none transition text-xs sm:text-sm font-mono text-slate-900"
                       placeholder="himasi">
                @error('slug')
                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat (Opsional)</label>
                <textarea name="description" id="description" rows="2"
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-600 outline-none transition text-xs sm:text-sm font-medium text-slate-900"
                          placeholder="Jelaskan profil singkat organisasi...">{{ old('description') }}</textarea>
            </div>

            <button type="submit"
                    class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded-2xl shadow-lg shadow-emerald-200 active:scale-[0.98] transition-all text-xs sm:text-sm mt-2">
                Simpan & Ajukan Pendaftaran
            </button>
        </form>
    </div>
</main>
@endsection
