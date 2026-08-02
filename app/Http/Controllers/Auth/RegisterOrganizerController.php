<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterOrganizerController extends Controller
{
    /**
     * Tampilkan form registrasi mandiri organizer baru.
     */
    public function show()
    {
        if (Auth::check()) {
            if (Auth::user()->isOrganizer()) {
                $organizer = Auth::user()->organizer;
                if ($organizer && $organizer->status === 'approved') {
                    return redirect()->route('organizer.dashboard');
                }
                return redirect()->route('organizer.pending');
            }
        }
        return view('auth.organizer-register');
    }

    /**
     * Proses pendaftaran mandiri organizer baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:organizers,slug|alpha_dash',
            'description' => 'nullable|string|max:1000',
            'pic_name'    => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:users,email',
            'password'    => 'required|string|min:8|confirmed',
        ], [
            'name.required'     => 'Nama organisasi/HIMA wajib diisi.',
            'slug.required'     => 'Username/Slug URL organisasi wajib diisi.',
            'slug.unique'       => 'Slug URL ini sudah dipakai oleh organisasi lain.',
            'slug.alpha_dash'   => 'Slug URL hanya boleh berisi huruf, angka, strip, dan underscore.',
            'pic_name.required' => 'Nama penanggung jawab (PIC) wajib diisi.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format alamat email tidak valid.',
            'email.unique'      => 'Alamat email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal harus 8 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
        ]);

        // 1. Buat User baru dengan Role Organizer
        $user = User::create([
            'name'     => $validated['pic_name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'organizer',
        ]);

        // 2. Buat profil Organizer dengan status Pending
        $organizer = Organizer::create([
            'user_id'     => $user->id,
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['slug']),
            'description' => $validated['description'] ?? null,
            'status'      => 'pending',
        ]);

        // 3. Autentikasi user baru
        Auth::login($user);

        // 4. Redirect ke halaman Menunggu Persetujuan
        return redirect()->route('organizer.pending')->with('success', 'Pendaftaran organisasi berhasil! Akun Anda saat ini sedang dalam tinjauan Superadmin.');
    }

    /**
     * Halaman "Menunggu Persetujuan" (Pending Approval Screen).
     */
    public function pendingStatus()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'organizer') {
            return redirect()->route('home');
        }

        $organizer = $user->organizer;

        // Jika sudah disetujui, redirect ke dashboard
        if ($organizer && $organizer->status === 'approved') {
            return redirect()->route('organizer.dashboard');
        }

        return view('organizer.pending', compact('user', 'organizer'));
    }
}
