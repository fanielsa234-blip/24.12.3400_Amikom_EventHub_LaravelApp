@extends('layouts.app')

@section('title', 'Status Pendaftaran Organizer - AmikomEventHub')

@section('content')
<main class="min-h-[80vh] flex items-center justify-center px-4 py-12 bg-slate-50/60 dark:bg-slate-950 transition-colors">
    <div class="w-full max-w-lg bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-none p-8 sm:p-10 text-center space-y-6">
        
        <!-- Status Icon -->
        <div class="w-16 h-16 bg-amber-100 dark:bg-amber-950/80 text-amber-600 dark:text-amber-400 rounded-3xl flex items-center justify-center text-3xl mx-auto shadow-md">
            ⏳
        </div>

        <!-- Header Title -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Pendaftaran Organisasi Sedang Ditinjau</h1>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mt-2">Permohonan pendaftaran organisasi Anda telah kami terima dan sedang dalam proses peninjauan oleh Superadmin Kampus.</p>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-2xl text-xs sm:text-sm font-semibold flex items-center gap-2 text-left">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Details Card -->
        <div class="p-5 bg-slate-50 dark:bg-slate-950 border border-slate-200/80 dark:border-slate-800 rounded-2xl text-xs sm:text-sm text-slate-700 dark:text-slate-300 text-left space-y-2.5">
            <div class="flex justify-between items-center border-b border-slate-200/60 dark:border-slate-800 pb-2">
                <span class="text-slate-500 dark:text-slate-400 font-medium">Nama Organisasi:</span>
                <span class="font-bold text-slate-900 dark:text-white">{{ $organizer->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center border-b border-slate-200/60 dark:border-slate-800 pb-2">
                <span class="text-slate-500 dark:text-slate-400 font-medium">Penanggung Jawab (PIC):</span>
                <span class="font-bold text-slate-900 dark:text-white">{{ $organizer->pic_name ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-slate-500 dark:text-slate-400 font-medium">Status Saat Ini:</span>
                <span class="px-3 py-1 bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60 rounded-lg font-black text-xs uppercase tracking-wider">
                    {{ strtoupper($organizer->status ?? 'PENDING') }}
                </span>
            </div>
        </div>

        <!-- Short Notice -->
        <p class="text-xs text-slate-400 dark:text-slate-400 font-medium leading-relaxed">
            ℹ️ Pemberitahuan mengenai persetujuan akun organisasi Anda akan dikirimkan secara otomatis via email setelah verifikasi selesai dilakukan.
        </p>

        <!-- Back Home Button -->
        <a href="{{ route('home') }}" class="inline-block w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-extrabold text-xs sm:text-sm shadow-lg shadow-indigo-200 dark:shadow-none active:scale-[0.98] transition-all">
            &larr; Kembali ke Beranda
        </a>

    </div>
</main>
@endsection