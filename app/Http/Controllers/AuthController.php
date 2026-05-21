<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('login');
    }

    // Memproses data login
    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Cari user secara manual di tabel 'user' lama kamu
        $user = DB::table('user')->where('email', $request->email)->first();

        // 3. Verifikasi Password (menggunakan password_verify bawaan laravel)
        if ($user && \Hash::check($request->password, $user->password)) {
            
            // Set session login ala Laravel manual agar sinkron dengan database lamamu
            session([
                'user_id'   => $user->id_user,
                'role'      => $user->role,
                'user_name' => $user->nama_user,
                'logged_in' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!'
            ]);
        }

        // Jika gagal
        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah!'
        ], 401);
    }
}