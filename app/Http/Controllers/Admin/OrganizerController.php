<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrganizerStatusMail;
use Illuminate\Support\Facades\Log;

class OrganizerController extends Controller
{
    /**
     * Tampilkan daftar organizer untuk diawasi oleh Superadmin.
     */
    public function index()
    {
        $organizers = Organizer::with(['user', 'events'])->latest()->paginate(10);
        return view('admin.organizers.index', compact('organizers'));
    }

    /**
     * Ubah status kelayakan organizer (approved, rejected, suspended).
     */
    public function updateStatus(Request $request, Organizer $organizer)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,suspended',
        ]);

        $organizer->update([
            'status' => $request->status,
        ]);

        // Kirim Notifikasi Email (jika user terdaftar dan email valid)
        try {
            if ($organizer->user && $organizer->user->email) {
                Mail::to($organizer->user->email)->send(new OrganizerStatusMail($organizer, $request->status));
            }
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim email verifikasi organizer: ' . $e->getMessage());
        }

        return back()->with('success', 'Status verifikasi organizer "' . $organizer->name . '" berhasil diperbarui menjadi ' . strtoupper($request->status) . '!');
    }
}
