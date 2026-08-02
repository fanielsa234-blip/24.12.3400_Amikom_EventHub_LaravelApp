<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        // Mengambil transaksi terbaru dengan Eager Loading event & pagenasi
        $transactions = Transaction::with('event')->latest()->paginate(20);
        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * SIMULASI DEMO: Rilis seluruh transaksi pending yang expired (+1 stok)
     */
    public function releaseExpired()
    {
        Artisan::call('app:release-expired-reservations');
        $output = Artisan::output();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'DEMO RELEASE EXPIRED: ' . trim($output));
    }

    /**
     * SIMULASI DEMO PER-TRANSAKSI: Paksa set status transaksi pending menjadi EXPIRED & kembalikan stok (+1)
     */
    public function simulateExpireSingle($id)
    {
        $trx = Transaction::with('event')->findOrFail($id);

        if ($trx->status !== 'pending') {
            return redirect()->route('admin.transactions.index')
                ->with('error', "Transaksi #{$trx->order_id} sudah berstatus '{$trx->status}', tidak dapat di-release lagi.");
        }

        DB::transaction(function () use ($trx) {
            $trx->update(['status' => 'expired']);
            if ($trx->event) {
                $trx->event->increment('stock', 1);
            }
        });

        $stockNow = $trx->event ? $trx->event->fresh()->stock : '-';

        return redirect()->route('admin.transactions.index')
            ->with('success', "DEMO SUKSES! Transaksi #{$trx->order_id} disimulasikan EXPIRED! Stok tiket event '{$trx->event->title}' berhasil dikembalikan (+1). Stok sekarang: {$stockNow} Tiket.");
    }
}
