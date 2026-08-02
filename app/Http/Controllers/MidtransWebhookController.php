<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Mencari data transaksi di database lokal
        $transaction = Transaction::with('event')->where('order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Cegah proses ulang jika transaksi sudah lunas secara normal
        if ($transaction->status === 'settlement' || $transaction->status === 'success') {
            return response()->json(['message' => 'Already processed']);
        }

        // 1. Penanganan Pembayaran Sukses / Lunas (settlement atau capture)
        if ($transactionStatus == 'settlement' || ($transactionStatus == 'capture' && $fraudStatus == 'accept')) {
            $this->handlePaymentSuccess($transaction);
        } 
        else if ($transactionStatus == 'capture' && $fraudStatus == 'challenge') {
            $transaction->status = 'challenge';
            $transaction->save();
        } 
        // 2. Penanganan Pembayaran Gagal / Dibatalkan
        else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            // Hanya kembalikan stok jika order masih 'pending' (belum pernah di-release oleh scheduler)
            if ($transaction->status === 'pending') {
                $transaction->status = 'failed';
                if ($transaction->event) {
                    $transaction->event->increment('stock', 1);
                }
            } elseif (!in_array($transaction->status, ['expired', 'needs_refund'])) {
                $transaction->status = 'failed';
            }
            $transaction->save();
        }

        return response()->json(['message' => 'OK']);
    }

    /**
     * Memproses logika sukses bayar dengan penanganan kasus Late Payment / Expired Reservation
     */
    private function handlePaymentSuccess(Transaction $transaction)
    {
        // KASUS PENENTU: Order SUDAH EXPIRED saat pembayaran diterima
        if (in_array(strtolower($transaction->status), ['expired', 'needs_refund'])) {
            $transaction->status = 'needs_refund';
            $transaction->save();

            // Catat Log Peringatan Resmi untuk Admin
            Log::warning(
                "PERINGATAN LATE PAYMENT (PERLU REFUND): Pembayaran Midtrans diterima untuk Order #{$transaction->order_id} " .
                "sebesar Rp " . number_format($transaction->total_price, 0, ',', '.') . " pada " . now() . ". " .
                "Namun order ini telah EXPIRED sebelumnya dan stok tiket telah di-release. " .
                "Status diubah menjadi 'needs_refund'. Stok TIDAK diubah dan E-Ticket TIDAK dikirim."
            );

            // STOP PROSES! Jangan ubah stok dan jangan kirim E-Ticket.
            return;
        }

        // KASUS NORMAL: Order masih berstatus Pending
        if (strtolower($transaction->status) === 'pending') {
            $transaction->status = 'success';
            $transaction->save();

            // Kirimkan email E-Ticket resmi ke pelanggan
            try {
                \Illuminate\Support\Facades\Mail::to($transaction->customer_email)->send(
                    new \App\Mail\EventTicketMail($transaction)
                );
            } catch (\Exception $e) {
                Log::error("Gagal mengirim email E-Ticket untuk Order #{$transaction->order_id}: " . $e->getMessage());
            }
        }
    }
}
