<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        $categories = Category::all();
        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        // 1. Validasi Input Pelanggan
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        // 2. Transaksi Database dengan Pessimistic Locking (Cegah Race Condition Stok)
        $transaction = null;
        try {
            $transaction = \Illuminate\Support\Facades\DB::transaction(function () use ($event, $request) {
                // Lock data event untuk mencegah 2 user checkout tiket terakhir bersamaan
                $lockedEvent = Event::where('id', $event->id)->lockForUpdate()->first();

                if (!$lockedEvent || $lockedEvent->stock <= 0) {
                    throw new Exception('Mohon maaf, tiket untuk acara ini sudah habis.');
                }

                // Reserve/hold stok tiket langsung saat checkout
                $lockedEvent->decrement('stock', 1);

                $orderId = 'TRX-' . time() . '-' . Str::random(4);
                $totalPrice = $lockedEvent->price + 5000; // Harga Tiket + Biaya Admin Rp 5.000

                // Rekam Transaksi ke Database (Status Pending + Expired 1 Menit KHUSUS TESTING)
                return Transaction::create([
                    'event_id'       => $lockedEvent->id,
                    'order_id'       => $orderId,
                    'customer_name'  => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'total_price'    => $totalPrice,
                    'status'         => 'pending',
                    'expired_at'     => now()->addMinutes(1), // KHUSUS TESTING (Ubah kembali ke 15 sebelum submit)
                ]);
            });
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        // 3. INTEGRASI SNAP MIDTRANS
        \Midtrans\Config::$serverKey = config('midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $transaction->order_id,
                'gross_amount' => $transaction->total_price,
            ],
            'customer_details' => [
                'first_name' => $transaction->customer_name,
                'email'      => $transaction->customer_email,
                'phone'      => $transaction->customer_phone,
            ],
        ];

        try {
            // Generate Snap Token dari Midtrans API
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan snap_token ke record transaksi
            $transaction->update(['snap_token' => $snapToken]);

            // Redirect ke halaman pembayaran Snap UI
            return redirect()->route('checkout.payment', $transaction->order_id);
        } catch (Exception $e) {
            // Jika Snap Midtrans gagal, kembalikan stok tiket (+1)
            if ($transaction && $transaction->event) {
                $transaction->event->increment('stock', 1);
                $transaction->update(['status' => 'failed']);
            }
            return back()->with('error', 'Gagal memproses pembayaran Midtrans: ' . $e->getMessage());
        }
    }

    public function payment($order_id)
    {
        $categories = Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success($order_id)
    {
        $categories = \App\Models\Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        // Konfigurasi Midtrans untuk mengecek status transaksi langsung ke API
        \Midtrans\Config::$serverKey = config('midtrans.server_key') ?: env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {
            // Mengecek status pesanan secara mandiri (Bypass)
            $status = \Midtrans\Transaction::status($order_id);
            if ($status) {
                $trx_status = is_array($status) ? ($status['transaction_status'] ?? '') : ($status->transaction_status ?? '');

                // Jika API Midtrans mengonfirmasi transaksi berhasil
                if (in_array($trx_status, ['settlement', 'capture'])) {
                    // Kasus 1: Order sudah expired sebelumnya saat bayar di Midtrans
                    if (in_array(strtolower($transaction->status), ['expired', 'needs_refund'])) {
                        $transaction->update(['status' => 'needs_refund']);
                        \Log::warning("PERINGATAN LATE PAYMENT (PERLU REFUND) via Redirect: Order #{$transaction->order_id} diterima setelah expired. Status diubah menjadi needs_refund.");
                    }
                    // Kasus 2: Order normal berstatus pending
                    elseif (strtolower($transaction->status) === 'pending') {
                        $transaction->update(['status' => 'success']);

                        // Kirimkan email E-Ticket ke pelanggan
                        try {
                            \Illuminate\Support\Facades\Mail::to($transaction->customer_email)
                                ->send(new \App\Mail\EventTicketMail($transaction));
                        } catch (\Exception $e) {
                            \Log::error('Gagal mengirim email E-Ticket secara manual: ' . $e->getMessage());
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses.');
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }
}