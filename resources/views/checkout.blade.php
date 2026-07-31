@extends('layouts.app')
@section('title', 'Checkout Tiket')
@section('content')
    <main class="max-w-3xl mx-auto px-6 py-10">
        <div class="mb-8 sm:mb-12">
            <a href="{{ route('events.show', $event->id) }}" class="text-indigo-600 dark:text-indigo-400 font-bold flex items-center gap-2 mb-6 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
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
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm transition-colors">
                <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 dark:text-white mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">Pesanan Anda</h3>
                <div class="flex flex-col sm:flex-row gap-6 items-start">
                    <img src="{{ ($event->poster_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->poster_path)) ? asset('storage/' . $event->poster_path) : asset('assets/concert.png') }}" class="w-24 h-24 rounded-2xl object-cover border border-slate-200 dark:border-slate-800 shrink-0">
                    <div class="space-y-1">
                        <h4 class="font-extrabold text-slate-900 dark:text-white text-base sm:text-lg">{{ $event->title }}</h4>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 font-medium">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} • {{ $event->location }}</p>
                        <p class="text-indigo-600 dark:text-indigo-400 font-extrabold text-sm sm:text-base mt-2">1 x {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800 space-y-3">
                    <div class="flex justify-between items-center text-xl sm:text-2xl font-black text-slate-900 dark:text-white mt-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <span>Total Bayar</span>
                        <span class="text-indigo-600 dark:text-indigo-400">{{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm relative z-0 transition-colors">
                <h3 class="text-lg sm:text-xl font-extrabold mb-6 text-indigo-600 dark:text-indigo-400 flex items-center gap-2">
                    <span>📦</span>
                    <span>Data Pemesan</span>
                </h3>
                
                <!-- Tag Form -->
                <form action="{{ route('checkout.store', $event->id) }}" method="POST" id="checkout-form" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">Nama Lengkap *</label>
                        <input type="text" name="customer_name" placeholder="Masukkan nama sesuai identitas" class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium" required value="{{ old('customer_name', Auth::check() ? Auth::user()->name : '') }}">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">Email Aktif *</label>
                        <input type="email" name="customer_email" placeholder="contoh@email.com" class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium" required value="{{ old('customer_email', Auth::check() ? Auth::user()->email : '') }}">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wide">No. WhatsApp *</label>
                        <input type="tel" name="customer_phone" placeholder="08xxxxxxxxxx" class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition text-xs sm:text-sm font-medium" required value="{{ old('customer_phone', '081234567890') }}">
                    </div>

                    <button type="button" onclick="showMidtrans()" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-base sm:text-lg shadow-xl shadow-indigo-200 dark:shadow-none active:scale-[0.98] transition-all mt-2">
                        Bayar Sekarang &rarr;
                    </button>

                    <!-- Overlay Midtrans Simulation -->
                    <div id="midtrans-overlay" class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-50 hidden flex-col items-center justify-center p-4">
                        <div class="bg-white dark:bg-slate-900 w-full max-w-sm rounded-3xl overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-800">
                            <div class="bg-slate-50 dark:bg-slate-950 p-5 flex justify-between items-center border-b border-slate-200 dark:border-slate-800">
                                <span class="font-extrabold text-indigo-600 dark:text-indigo-400 text-sm">Simulasi Pembayaran Midtrans</span>
                                <button type="button" onclick="hideMidtrans()" class="p-1 text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-lg font-bold text-xs">✕</button>
                            </div>
                            <div class="p-6 text-center">
                                <p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">Total Tagihan</p>
                                <h2 class="text-2xl sm:text-3xl font-black text-indigo-600 dark:text-indigo-400 my-2">{{ $event->price == 0 ? 'Rp 0' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</h2>
                                <div class="mt-6">
                                    <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-extrabold text-xs sm:text-sm shadow-md transition">
                                        Bayar Pakai QRIS / GoPay →
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function showMidtrans() {
            document.getElementById('midtrans-overlay').classList.remove('hidden');
            document.getElementById('midtrans-overlay').classList.add('flex');
        }
        function hideMidtrans() {
            document.getElementById('midtrans-overlay').classList.add('hidden');
            document.getElementById('midtrans-overlay').classList.remove('flex');
        }
    </script>
@endsection