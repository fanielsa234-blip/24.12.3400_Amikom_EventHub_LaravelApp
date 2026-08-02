<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReleaseExpiredReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:release-expired-reservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengecek reservasi tiket yang expired (>15 menit) dan mengembalikan stok tiket (+1).';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredTransactions = Transaction::where('status', 'pending')
            ->where('expired_at', '<=', now())
            ->get();

        if ($expiredTransactions->isEmpty()) {
            $this->info('Tidak ada reservasi tiket yang expired.');
            return 0;
        }

        $releasedCount = 0;

        foreach ($expiredTransactions as $transaction) {
            DB::transaction(function () use ($transaction, &$releasedCount) {
                // Lock transaction row
                $trx = Transaction::where('id', $transaction->id)->lockForUpdate()->first();

                if ($trx && $trx->status === 'pending') {
                    // Update status transaction to expired
                    $trx->update([
                        'status' => 'expired',
                    ]);

                    // Release stock back to event (+1)
                    if ($trx->event) {
                        $event = $trx->event()->lockForUpdate()->first();
                        if ($event) {
                            $event->increment('stock', 1);
                        }
                    }

                    $releasedCount++;
                    Log::info("Reservasi #{$trx->order_id} expired. Stok tiket di-release (+1).");
                }
            });
        }

        $this->info("Berhasil melepas {$releasedCount} reservasi tiket yang telah expired.");
        return 0;
    }
}
