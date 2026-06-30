<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =============================
    // TAMPILKAN HALAMAN LOGIN
    // =============================
    public function showLogin()
    {
        // Jika sudah login, redirect sesuai role
        if (session('logged_in')) {
            return session('role') === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('home');
        }
        return view('login');
    }

    // =============================
    // PROSES LOGIN
    // =============================
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('user')->where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session([
                'user_id'   => $user->id_user,
                'role'      => $user->role,
                'user_name' => $user->nama_user,
                'user_email'=> $user->email,
                'user_no_hp'=> $user->no_hp,
                'logged_in' => true,
            ]);

            $redirectUrl = $user->role === 'admin' ? route('admin.dashboard') : route('home');

            return response()->json([
                'success'      => true,
                'message'      => 'Login berhasil!',
                'redirect_url' => $redirectUrl,
                'role'         => $user->role,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah!',
        ], 401);
    }

    // =============================
    // TAMPILKAN HALAMAN REGISTER
    // =============================
    public function showRegister()
    {
        if (session('logged_in')) {
            return redirect()->route('home');
        }
        return view('register');
    }

    // =============================
    // PROSES REGISTER
    // =============================
    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|min:8',
            'no_hp'    => 'nullable|max:15',
        ]);

        // Cek apakah email sudah terdaftar
        $exists = DB::table('user')->where('email', $request->email)->first();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah terdaftar. Gunakan email lain atau login.',
            ], 422);
        }

        try {
            DB::table('user')->insert([
                'nama_user'  => $request->nama,
                'email'      => $request->email,
                'no_hp'      => $request->no_hp,
                'password'   => Hash::make($request->password),
                'role'       => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Silakan login.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendaftarkan akun: ' . $e->getMessage(),
            ], 500);
        }
    }

    // =============================
    // LOGOUT
    // =============================
    public function logout(Request $request)
    {
        session()->flush();
        return response()->json([
            'success'      => true,
            'message'      => 'Logout berhasil.',
            'redirect_url' => route('home'),
        ]);
    }

    // =============================
    // CEK STATUS LOGIN (untuk JS)
    // =============================
    public function me()
    {
        if (session('logged_in') && session('user_id')) {
            $user = DB::table('user')->where('id_user', session('user_id'))->first();
            if ($user) {
                return response()->json([
                    'success' => true,
                    'user'    => [
                        'id_user'   => $user->id_user,
                        'nama_user' => $user->nama_user,
                        'email'     => $user->email,
                        'no_hp'     => $user->no_hp,
                        'role'      => $user->role,
                    ],
                ]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Not authenticated'], 401);
    }
}