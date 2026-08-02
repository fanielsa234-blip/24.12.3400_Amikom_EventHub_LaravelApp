@extends('layouts.app')

@section('title', 'Pendaftaran Organizer Baru - AmikomEventHub')

@section('content')
<main class="min-h-[85vh] flex items-center justify-center px-4 py-8 sm:py-12 bg-slate-50/60">
    <div class="w-full max-w-xl bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 p-6 sm:p-10 relative overflow-hidden my-auto">
        
        <!-- Back Button -->
        <div class="mb-2">
            <a href="{{ route('home') }}" onclick="if(window.history.length > 1) { window.history.back(); return false; }"
               class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-indigo-600 transition group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-extrabold text-xl mx-auto mb-3 shadow-md shadow-indigo-200">
                OH
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Daftarkan Organisasimu</h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">Gabung sebagai Mitra Penyelenggara Event di AmikomEventHub</p>
        </div>

        <!-- Google SSO Organizer Registration Button -->
        <a href="{{ route('auth.google.organizer') }}"
           class="w-full py-3.5 px-4 bg-white border-2 border-slate-200 hover:border-indigo-400 hover:bg-slate-50/80 text-slate-700 font-bold rounded-2xl transition-all duration-200 shadow-sm flex items-center justify-center gap-3 group mb-6">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110 shrink-0" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
            </svg>
            <span class="text-xs sm:text-sm">Lanjutkan dengan Google</span>
        </a>

        <!-- Divider -->
        <div class="relative my-6 text-center">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200/80"></div></div>
            <div class="relative inline-block px-3 bg-white text-[11px] text-slate-400 font-extrabold uppercase tracking-wider">atau isi formulir pendaftaran manual</div>
        </div>

        <!-- Registration Form -->
        <form action="{{ route('organizer.register.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nama Organisasi -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Organisasi / HIMA / UKM *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium text-slate-900"
                       placeholder="Contoh: HIMA Informatika (HMIF)">
                @error('name')
                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug URL -->
            <div>
                <label for="slug" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Username / Slug URL Organisasi *</label>
                <div class="flex items-center">
                    <span class="px-3 py-2.5 bg-slate-100 border border-r-0 border-slate-200 rounded-l-xl text-xs font-mono text-slate-500 shrink-0">organizer/</span>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-r-xl focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-mono text-slate-900"
                           placeholder="hima-if">
                </div>
                <p class="text-[11px] text-slate-400 mt-1">Slug unik yang dipakai untuk profil publik organizer.</p>
                @error('slug')
                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi Singkat -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat Organisasi</label>
                <textarea name="description" id="description" rows="2"
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium text-slate-900"
                          placeholder="Jelaskan profil singkat organisasi Anda...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Penanggung Jawab -->
            <div>
                <label for="pic_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Penanggung Jawab (PIC) *</label>
                <input type="text" name="pic_name" id="pic_name" value="{{ old('pic_name') }}" required
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium text-slate-900"
                       placeholder="Nama lengkap pengurus/ketua">
                @error('pic_name')
                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Akun -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Email Kontak / Akun *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium text-slate-900"
                       placeholder="organisasi@amikom.ac.id">
                @error('email')
                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password & Konfirmasi Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password *</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium text-slate-900"
                           placeholder="Min. 8 karakter">
                    @error('password')
                        <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium text-slate-900"
                           placeholder="Ulangi password">
                </div>
            </div>

            <button type="submit"
                    class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold rounded-2xl shadow-lg shadow-indigo-200 active:scale-[0.98] transition-all text-xs sm:text-sm mt-2">
                Daftarkan Organisasi
            </button>
        </form>

        <!-- Footer Link -->
        <div class="mt-6 pt-4 border-t border-slate-100 text-center text-xs text-slate-500 font-medium">
            Sudah memiliki akun panitia?
            <a href="{{ route('organizer.login') }}" class="text-indigo-600 font-bold hover:underline ml-1">Masuk Portal Organizer &rarr;</a>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        if (nameInput && slugInput) {
            nameInput.addEventListener('input', function () {
                if (!slugInput.dataset.touched) {
                    slugInput.value = nameInput.value
                        .toLowerCase()
                        .replace(/[^a-z0-9 -]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                }
            });

            slugInput.addEventListener('input', function () {
                slugInput.dataset.touched = "true";
            });
        }
    });
</script>
@endsection
