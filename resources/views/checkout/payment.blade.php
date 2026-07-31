@extends('layouts.app')

@section('title', 'Pembayaran - ' . $transaction->event->title)

@section('content')
<main class="max-w-3xl mx-auto px-6 py-12 sm:py-20 text-center">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-8 sm:p-12 shadow-sm inline-block w-full max-w-md transition-colors">
        <div class="w-20 h-20 bg-indigo-100 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center mx-auto mb-6 border border-indigo-200 dark:border-indigo-800">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-black text-slate-900 dark:text-white mb-2">Selesaikan Pembayaran</h2>
        <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mb-8">Mohon selesaikan pembayaran tiket Anda untuk event <strong class="text-slate-800 dark:text-slate-200">{{ $transaction->event->title }}</strong>.</p>

        <div class="p-6 bg-slate-50 dark:bg-slate-950 rounded-2xl border border-slate-100 dark:border-slate-800 mb-8">
            <p class="text-xs text-slate-400 dark:text-slate-400 font-bold uppercase tracking-wider mb-1">Total Tagihan</p>
            <h3 class="text-3xl sm:text-4xl font-extrabold text-indigo-600 dark:text-indigo-400">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</h3>
            <p class="text-xs text-slate-400 dark:text-slate-400 font-mono mt-2">Order ID: {{ $transaction->order_id }}</p>
        </div>

        <button id="pay-button" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-extrabold text-base sm:text-lg shadow-xl shadow-indigo-200 dark:shadow-none transition">
            Bayar Sekarang &rarr;
        </button>
    </div>
</main>

<!-- JS Midtrans Snap -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $transaction->snap_token }}', {
            onSuccess: function (result) {
                window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
            },
            onPending: function (result) {
                window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
            },
            onError: function (result) {
                alert("Pembayaran Gagal!");
            },
            onClose: function () {
                alert('Anda menutup halaman pembayaran sebelum selesai.');
            }
        });
    };

    // Auto trigger popup Snap Midtrans saat halaman selesai loading
    window.onload = function() {
        document.getElementById('pay-button').click();
    };
</script>
@endsection