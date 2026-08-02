@extends('layouts.app')
@section('title', 'Tentang Kami - AmikomEventHub')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 space-y-16">
    <!-- Hero Section -->
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <span class="px-4 py-1.5 bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-extrabold uppercase tracking-widest border border-indigo-100 dark:border-indigo-800">
            Tentang AmikomEventHub
        </span>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight">
            Platform Tiket Event Online <span class="text-indigo-600">Universitas AMIKOM</span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base font-medium leading-relaxed">
            Menghubungkan mahasiswa dengan event, workshop, dan seminar kampus terbaik secara praktis, cepat, dan terintegrasi dengan Payment Gateway modern.
        </p>
    </div>

    <!-- Feature Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center text-2xl font-black">
                🎟️
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Reservasi Praktis</h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                Pesan tiket acara dalam hitungan detik tanpa perlu antre fisik di lokasi kampus.
            </p>
        </div>

        <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
            <div class="w-12 h-12 bg-violet-100 dark:bg-violet-950 text-violet-600 dark:text-violet-400 rounded-2xl flex items-center justify-center text-2xl font-black">
                💳
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Midtrans Payment</h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                Dukungan pembayaran lengkap via QRIS, GoPay, Bank Transfer, dan e-wallet secara aman.
            </p>
        </div>

        <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center text-2xl font-black">
                🏢
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">Multi-Tenant Organizer</h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                Setiap HIMA, UKM, dan Organisasi Mahasiswa memiliki portal mandiri untuk mengelola event & tiket.
            </p>
        </div>
    </div>
</main>
@endsection