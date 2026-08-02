@extends('layouts.admin')

@section('title', 'Laporan Transaksi - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Laporan Transaksi</h1>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mt-1">Pantau arus kas dan seluruh riwayat penjualan tiket secara real-time.</p>
        </div>
    </div>

    <!-- Alert Success & Error Flash Messages -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 dark:bg-emerald-950/80 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-2xl text-xs sm:text-sm font-extrabold flex items-start gap-3 shadow-sm">
            <span class="text-lg">✅</span>
            <div class="leading-relaxed">{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-rose-50 dark:bg-rose-950/80 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 rounded-2xl text-xs sm:text-sm font-extrabold flex items-start gap-3 shadow-sm">
            <span class="text-lg">⚠️</span>
            <div class="leading-relaxed">{{ session('error') }}</div>
        </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden transition-colors">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[750px]">
                <thead class="bg-slate-50 dark:bg-slate-950/80 text-slate-500 dark:text-slate-400 uppercase text-[11px] font-black tracking-widest border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-4">Kode TRX</th>
                        <th class="px-6 py-4">Detail Pembeli</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Tanggal Transaksi</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Total Tagihan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold px-3 py-1.5 rounded-xl text-xs bg-slate-100 dark:bg-slate-950 text-indigo-700 dark:text-indigo-400 border border-slate-200/60 dark:border-slate-800 inline-block">
                                {{ $trx->order_id }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900 dark:text-white">{{ $trx->customer_name }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-400 mt-0.5">{{ $trx->customer_email }} • {{ $trx->customer_phone }}</p>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-200">
                            {{ $trx->event->title ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-400 font-medium whitespace-nowrap">
                            {{ $trx->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @if(in_array(strtolower($trx->status), ['settlement', 'success']))
                                <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 rounded-lg text-xs font-bold uppercase ring-1 ring-emerald-200 dark:ring-emerald-800/60">Success</span>
                            @elseif(strtolower($trx->status) === 'pending')
                                <span class="px-3 py-1 bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 rounded-lg text-xs font-bold uppercase ring-1 ring-amber-200 dark:ring-amber-800/60">Pending</span>
                            @elseif(strtolower($trx->status) === 'needs_refund')
                                <div class="inline-flex flex-col gap-1 max-w-xs">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-500 text-white dark:bg-amber-600 rounded-lg text-xs font-black uppercase shadow-sm ring-1 ring-amber-400">
                                        <span>⚠️</span>
                                        <span>PERLU REFUND</span>
                                    </span>
                                    <span class="text-[11px] text-amber-700 dark:text-amber-300 font-semibold leading-tight">
                                        Pembayaran diterima setelah reservasi expired. Stok sudah diberikan ke pembeli lain — silakan proses refund manual ke pembeli.
                                    </span>
                                </div>
                            @elseif(strtolower($trx->status) === 'expired')
                                <span class="px-3 py-1 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg text-xs font-bold uppercase ring-1 ring-slate-300 dark:ring-slate-700">Expired</span>
                            @else
                                <span class="px-3 py-1 bg-rose-100 dark:bg-rose-950/60 text-rose-800 dark:text-rose-300 rounded-lg text-xs font-bold uppercase ring-1 ring-rose-200 dark:ring-rose-800/60">{{ $trx->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-black text-slate-900 dark:text-white whitespace-nowrap">
                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 dark:text-slate-400 font-bold">
                            Belum ada transaksi terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transactions->hasPages())
        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection