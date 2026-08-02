@extends('layouts.app')

@section('title', 'Checkout - ' . $event->title)

@section('content')
<main class="max-w-3xl mx-auto px-6 py-12 sm:py-20">
    <!-- Top Back Link & Header -->
    <div class="mb-8 sm:mb-12">
        <a href="{{ route('events.show', $event->id) }}" class="text-indigo-600 dark:text-indigo-400 font-bold flex items-center gap-2 mb-6 hover:underline text-xs sm:text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <span>Kembali ke Event</span>
        </a>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Checkout Tiket</h1>
        <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mt-2">Lengkapi data Anda untuk mendapatkan tiket resmi.</p>
    </div>

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 rounded-2xl font-bold text-xs sm:text-sm flex items-center gap-2">
            <span>⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8">
        <!-- Summary Card -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 shadow-sm transition-colors">
            <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 dark:text-white mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">Pesanan Anda</h3>
            
            @php
                $catName = strtolower($event->category->name ?? '');
                if (str_contains($catName, 'teknologi') || str_contains($catName, 'coding')) {
                    $defaultImg = asset('assets/hackathon.png');
                } elseif (str_contains($catName, 'workshop') || str_contains($catName, 'seminar')) {
                    $defaultImg = asset('assets/workshop.png');
                } else {
                    $defaultImg = asset('assets/concert.png');
                }

                if ($event->poster_path) {
                    $posterUrl = str_starts_with($event->poster_path, 'http') ? $event->poster_path : asset('storage/' . $event->poster_path);
                } else {
                    $posterUrl = $defaultImg;
                }
            @endphp

            <div class="flex flex-col sm:flex-row gap-6 items-start">
                <img src="{{ $posterUrl }}" alt="{{ $event->title }}" class="w-24 h-24 rounded-2xl object-cover border border-slate-200 dark:border-slate-800 shadow-sm shrink-0" onerror="this.src='{{ $defaultImg }}'">
                <div class="space-y-1">
                    <h4 class="font-extrabold text-slate-900 dark:text-white text-base sm:text-lg">{{ $event->title }}</h4>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 font-medium">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} • {{ $event->location }}</p>
                    <p class="text-indigo-600 dark:text-indigo-400 font-extrabold text-sm sm:text-base mt-2">1 x {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800 space-y-3 text-xs sm:text-sm font-medium">
                <div class="flex justify-between text-slate-500 dark:text-slate-400">
                    <span>Harga Tiket</span>
                    <span class="text-slate-800 dark:text-slate-200 font-semibold">{{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-slate-500 dark:text-slate-400">
                    <span>Biaya Layanan</span>
                    <span class="text-slate-800 dark:text-slate-200 font-semibold">Rp 5.000</span>
                </div>
                <div class="flex justify-between items-center text-xl sm:text-2xl font-black text-slate-900 dark:text-white mt-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <span>Total Bayar</span>
                    <span class="text-indigo-600 dark:text-indigo-400">{{ $event->price == 0 ? 'Rp 5.000' : 'Rp ' . number_format($event->price + 5000, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-8 shadow-sm transition-colors">
            <h3 class="text-lg sm:text-xl font-extrabold mb-6 text-indigo-600 dark:text-indigo-400 flex items-center gap-2">
                <span>📦</span>
                <span>Data Pemesan</span>
            </h3>

            @guest
                <div class="mb-6 p-4 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white text-sm">Punya Akun Google?</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Lanjutkan dengan Google untuk pengisian nama & email otomatis.</p>
                    </div>
                    <a href="{{ route('auth.google') }}" class="px-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-200 rounded-xl font-bold text-xs sm:text-sm shadow-sm hover:border-indigo-400 transition flex items-center gap-2.5 shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>Lanjutkan dengan Google</span>
                    </a>
                </div>
            @else
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 rounded-2xl flex items-center gap-3">
                    <span class="text-xl">✅</span>
                    <div>
                        <h4 class="font-bold text-emerald-900 dark:text-emerald-300 text-sm">Terautentikasi sebagai {{ Auth::user()->name }}</h4>
                        <p class="text-xs text-emerald-700 dark:text-emerald-400 mt-0.5">Data nama dan email terisi otomatis dari akun Google Anda.</p>
                    </div>
                </div>
            @endguest

            <form action="{{ route('checkout.store', $event->id) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Nama Lengkap *</label>
                    <input type="text" name="customer_name" placeholder="Masukkan nama sesuai identitas" class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium text-slate-900 dark:text-white" required value="{{ old('customer_name', Auth::check() ? Auth::user()->name : '') }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Email Aktif *</label>
                        <input type="email" name="customer_email" placeholder="contoh@gmail.com" class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium text-slate-900 dark:text-white" required value="{{ old('customer_email', Auth::check() ? Auth::user()->email : '') }}">
                        <p class="text-[11px] text-slate-400 dark:text-slate-400 mt-1.5 font-medium">*E-Ticket akan dikirim ke alamat email ini</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">No. WhatsApp *</label>
                        <input type="tel" name="customer_phone" placeholder="08xxxxxxxxxx" class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium text-slate-900 dark:text-white" required value="{{ old('customer_phone') }}">
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-extrabold text-base sm:text-lg shadow-xl shadow-indigo-200 dark:shadow-none active:scale-[0.98] transition-all mt-2">
                    Lanjut Pembayaran &rarr;
                </button>
                <p class="text-center text-xs text-slate-400 dark:text-slate-400">Dengan menekan tombol di atas, Anda menyetujui Syarat & Ketentuan AmikomEventHub.</p>
            </form>
        </div>
    </div>
</main>
@endsection