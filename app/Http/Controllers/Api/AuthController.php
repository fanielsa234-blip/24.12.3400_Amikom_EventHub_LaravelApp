<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'status'  => 'success',
                'message' => 'Login berhasil!',
                'data'    => $user
            ], 200);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Email atau password salah'
        ], 401);
    }
}