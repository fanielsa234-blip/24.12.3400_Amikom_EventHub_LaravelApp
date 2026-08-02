<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organizer;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    /**
     * Redirect ke halaman autentikasi Google untuk User biasa.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect ke halaman autentikasi Google khusus pendaftaran Organizer.
     */
    public function redirectToGoogleOrganizer()
    {
        session(['registering_as_organizer' => true]);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google setelah autentikasi.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect()->route('home')->with('error', 'Gagal login via Google: ' . $e->getMessage());
        }

        $isOrganizerRegistration = session()->pull('registering_as_organizer', false);

        // 1. Cek apakah user berdasarkan email sudah terdaftar
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);
        } else {
            $user = User::create([
                'name'      => $googleUser->getName() ?? 'Google User',
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
                'role'      => $isOrganizerRegistration ? 'organizer' : 'user',
                'password'  => bcrypt(Str::random(24)),
            ]);
        }

        Auth::login($user, true);

        // 2. Alur khusus jika user adalah Organizer
        if ($user->role === 'organizer' || $isOrganizerRegistration) {
            $organizer = $user->organizer;

            // Jika belum punya data organisasi, arahkan ke form pelengkapan profil organisasi
            if (!$organizer) {
                return redirect()->route('organizer.register.complete');
            }

            if ($organizer->status === 'approved') {
                return redirect()->route('organizer.dashboard')->with('success', 'Berhasil login via Google!');
            }

            return redirect()->route('organizer.pending');
        }

        return redirect()->intended(route('home'))->with('success', 'Berhasil login menggunakan akun Google!');
    }

    /**
     * Form pelengkapan profil organisasi setelah Google OAuth.
     */
    public function showCompleteRegistration()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'organizer') {
            return redirect()->route('home');
        }

        if ($user->organizer) {
            return redirect()->route('organizer.pending');
        }

        return view('auth.organizer-register-complete', compact('user'));
    }

    /**
     * Simpan profil organisasi setelah Google OAuth.
     */
    public function storeCompleteRegistration(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'organizer') {
            return redirect()->route('home');
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:organizers,slug|alpha_dash',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required'   => 'Nama organisasi/HIMA wajib diisi.',
            'slug.required'   => 'Slug URL wajib diisi.',
            'slug.unique'     => 'Slug URL ini sudah dipakai oleh organisasi lain.',
            'slug.alpha_dash' => 'Slug URL hanya boleh berisi huruf, angka, strip, dan underscore.',
        ]);

        Organizer::create([
            'user_id'     => $user->id,
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['slug']),
            'description' => $validated['description'] ?? null,
            'status'      => 'pending',
        ]);

        return redirect()->route('organizer.pending')->with('success', 'Pendaftaran organisasi Anda berhasil diselesaikan dan menunggu tinjauan Superadmin.');
    }
}
