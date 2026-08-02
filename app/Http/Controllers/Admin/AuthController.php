<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Menampilkan halaman formulir login admin & organizer
    public function showLogin()
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
        return view('auth.login');
    }

    // 2. Memproses autentikasi login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang kembali, Superadmin!');
            }

            if ($user->isOrganizer()) {
                $organizer = $user->organizer;
                if ($organizer && $organizer->status === 'approved') {
                    return redirect()->intended(route('organizer.dashboard'))->with('success', 'Selamat datang di Dashboard Organizer!');
                }
                return redirect()->route('organizer.pending');
            }

            return redirect()->intended(route('home'))->with('success', 'Berhasil masuk!');
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda berikan tidak terdaftar di rekaman kami.',
        ])->onlyInput('email');
    }

    // 3. Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
