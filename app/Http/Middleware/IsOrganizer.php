<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsOrganizer
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->role === 'organizer' || Auth::user()->role === 'admin')) {
            if (Auth::user()->role === 'organizer') {
                $organizer = Auth::user()->organizer;

                // Jika belum punya record organizer atau status belum approved
                if (!$organizer || $organizer->status !== 'approved') {
                    // Izinkan akses ke rute status pending atau logout
                    if ($request->routeIs('organizer.pending') || $request->routeIs('user.logout') || $request->routeIs('organizer.register.complete') || $request->routeIs('organizer.register.complete.store')) {
                        return $next($request);
                    }
                    return redirect()->route('organizer.pending');
                }
            }
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Akses ditolak! Khusus untuk akun Organizer/Panitia.');
    }
}
