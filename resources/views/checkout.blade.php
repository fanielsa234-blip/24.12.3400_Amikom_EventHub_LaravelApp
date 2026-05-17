@extends('layouts.app')
@section('title', 'Checkout Tiket')
@section('content')
    <main class="max-w-3xl mx-auto px-6 py-10">
        <div class="mb-12">
            <a href="{{ route('events.show', $event->id) }}" class="text-indigo-600 font-bold flex items-center gap-2 mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Event
            </a>
            <h1 class="text-4xl font-extrabold">Checkout</h1>
            <p class="text-slate-500 mt-2">Lengkapi data Anda untuk mendapatkan tiket.</p>
        </div>

        <div class="grid grid-cols-1 gap-8">
            <!-- Summary Card -->
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                <h3 class="text-xl font-bold mb-6 border-b pb-4">Pesanan Anda</h3>
                <div class="flex gap-6 items-start">
                    <img src="{{ $event->poster_path ? asset($event->poster_path) : asset('assets/concert.png') }}" class="w-24 h-24 rounded-2xl object-cover">
                    <div>
                        <h4 class="font-extrabold text-lg">{{ $event->title }}</h4>
                        <p class="text-slate-500">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} • {{ $event->location }}</p>
                        <p class="text-indigo-600 font-bold mt-2">1 x {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="mt-8 pt-6 border-t space-y-3">
                    <div class="flex justify-between text-2xl font-black mt-4 pt-4 border-t">
                        <span>Total Bayar</span>
                        <span class="text-indigo-600">{{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm relative z-0">
                <h3 class="text-xl font-bold mb-6 italic text-indigo-600 underline underline-offset-8">📦 Data Pemesan</h3>
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Lengkap</label>
                        <input type="text" placeholder="Masukkan nama" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:border-indigo-600 outline-none" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Email Aktif</label>
                        <input type="email" placeholder="contoh@gmail.com" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:border-indigo-600 outline-none" required>
                    </div>
                    <button type="button" onclick="showMidtrans()" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all">
                        Bayar Sekarang
                    </button>
                </form>
            </div>
        </div>
    </main>

    <!-- Overlay Midtrans Simulation -->
    <div id="midtrans-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex-col items-center justify-center p-6">
        <div class="bg-white w-full max-w-sm rounded-4xl overflow-hidden shadow-2xl">
            <div class="bg-slate-50 p-6 flex justify-between items-center border-b">
                <span class="font-black text-indigo-600">Simulasi Bayar</span>
                <button onclick="hideMidtrans()" class="p-2 hover:bg-slate-200 rounded-full font-bold">X</button>
            </div>
            <div class="p-8 text-center">
                <p class="text-slate-500 font-medium">Total Tagihan</p>
                <h2 class="text-3xl font-black text-indigo-700 my-2">{{ $event->price == 0 ? 'Rp 0' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</h2>
                <div class="mt-8">
                    <!-- Tombol ini langsung lempar ke tiket sukses -->
                    <a href="{{ route('ticket', $event->id) }}" class="block w-full py-4 border-2 border-indigo-600 bg-indigo-50 text-indigo-600 rounded-2xl font-bold hover:bg-indigo-600 hover:text-white transition">Bayar Pakai QRIS / GoPay →</a>
                </div>
            </div>
        </div>
    </div>

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

