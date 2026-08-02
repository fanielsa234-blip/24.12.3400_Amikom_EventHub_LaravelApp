@extends('layouts.app')

@section('title', 'Masuk - AmikomEventHub')

@section('content')
<main class="min-h-[80vh] flex items-center justify-center px-4 py-10 sm:py-16 bg-slate-50/60 dark:bg-slate-950">
    <div class="w-full max-w-md bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-8 sm:p-10 relative overflow-hidden transition-colors">
        
        <!-- Back Button -->
        <div class="mb-2">
            <a href="{{ route('home') }}" onclick="if(window.history.length > 1) { window.history.back(); return false; }"
               class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-extrabold text-xl mx-auto mb-4 shadow-md shadow-indigo-200 dark:shadow-none">
                AH
            </div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Masuk ke Akun</h1>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mt-1">Masuk untuk memesan tiket & mengelola pesananmu</p>
        </div>

        <!-- Alert Messages -->
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 rounded-2xl text-xs sm:text-sm font-medium flex items-center gap-2">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-2xl text-xs sm:text-sm font-medium flex items-center gap-2">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 text-amber-800 dark:text-amber-300 rounded-2xl text-xs sm:text-sm font-medium">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Google SSO Button -->
        <a href="{{ route('auth.google') }}"
           class="w-full py-3.5 px-4 bg-white dark:bg-slate-950 border-2 border-slate-200 dark:border-slate-800 hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-slate-50/80 text-slate-700 dark:text-slate-200 font-bold rounded-2xl transition-all duration-200 shadow-sm flex items-center justify-center gap-3 group">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110 shrink-0" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
            </svg>
            <span class="text-sm">Lanjutkan dengan Google</span>
        </a>

        <!-- Divider -->
        <div class="relative my-6 text-center">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200/80 dark:border-slate-800"></div></div>
            <div class="relative inline-block px-3 bg-white dark:bg-slate-900 text-[11px] text-slate-400 font-extrabold uppercase tracking-wider">atau masuk email</div>
        </div>

        <!-- Manual Email/Password Form -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" required
                       class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-sm font-medium text-slate-900 dark:text-white"
                       placeholder="nama@email.com" value="{{ old('email') }}">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-sm font-medium text-slate-900 dark:text-white"
                       placeholder="••••••••">
            </div>

            <button type="submit"
                    class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold rounded-2xl shadow-lg shadow-indigo-200 dark:shadow-none active:scale-[0.98] transition-all text-sm mt-2">
                Masuk ke Akun
            </button>
        </form>

        <!-- Footer Links: 2 Baris Terpisah (Organizer & Superadmin) -->
        <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800 text-center text-xs text-slate-500 dark:text-slate-400 font-medium space-y-2">
            <div>
                Panitia HIMA atau Organizer?
                <a href="{{ route('organizer.login') }}" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline ml-1">Portal Organizer &rarr;</a>
            </div>
            <div>
                Login sebagai Superadmin?
                <a href="{{ route('admin.login') }}" class="text-slate-700 dark:text-slate-300 font-bold hover:underline ml-1">Portal Admin &rarr;</a>
            </div>
        </div>
    </div>
</main>
@endsection
