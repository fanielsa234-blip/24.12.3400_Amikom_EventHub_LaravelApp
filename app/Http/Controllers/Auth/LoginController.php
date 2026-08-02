<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login dedicated untuk user / pelanggan.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isOrganizer()) {
                return redirect()->route('organizer.dashboard');
            }
            return redirect()->route('home');
        }
        return view('auth.user-login');
    }

    /**
     * Tampilkan halaman login dedicated untuk Organizer / Panitia.
     */
    public function showOrganizerLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isOrganizer()) {
                return redirect()->route('organizer.dashboard');
            }
            return redirect()->route('home');
        }
        return view('auth.organizer-login');
    }

    /**
     * Memproses login manual user / organizer.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect berdasarkan role user
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Berhasil masuk sebagai Superadmin!');
            }

            if ($user->isOrganizer()) {
                $organizer = $user->organizer;
                if ($organizer && $organizer->status === 'approved') {
                    return redirect()->intended(route('organizer.dashboard'))->with('success', 'Berhasil masuk ke Dashboard Organizer!');
                }
                return redirect()->route('organizer.pending');
            }

            return redirect()->intended(route('home'))->with('success', 'Berhasil masuk!');
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }
}
