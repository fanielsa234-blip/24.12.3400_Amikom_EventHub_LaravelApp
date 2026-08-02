<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReviewController extends Controller
{
    /**
     * Menyimpan ulasan & rating dari user untuk sebuah event.
     */
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        if (!Auth::check()) {
            return back()->with('error', 'Silakan login terlebih dahulu untuk memberikan ulasan.');
        }

        $user = Auth::user();

        // 1. Cek apakah tanggal acara sudah lewat (Superadmin dikecualikan untuk keperluan testing/demo UAS)
        if ($user->role !== 'admin' && Carbon::parse($event->date)->isFuture()) {
            return back()->with('error', 'Ulasan hanya dapat diberikan setelah acara berlangsung.');
        }

        // 2. Cek transaksi pembelian tiket
        $transaction = Transaction::where('event_id', $event->id)
            ->whereIn('status', ['success', 'settlement', 'pending'])
            ->where('customer_email', $user->email)
            ->first();

        if ($user->role !== 'admin' && !$transaction) {
            return back()->with('error', 'Anda hanya dapat memberikan ulasan untuk event yang pernah Anda beli tiketnya.');
        }

        // 3. Cek apakah user sudah pernah memberi ulasan untuk event ini
        $existingReview = Review::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk event ini.');
        }

        // 4. Simpan ulasan ke database
        Review::create([
            'user_id'        => $user->id,
            'event_id'       => $event->id,
            'transaction_id' => $transaction->id ?? null,
            'rating'         => $request->rating,
            'comment'        => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan dan rating yang Anda berikan!');
    }
}
