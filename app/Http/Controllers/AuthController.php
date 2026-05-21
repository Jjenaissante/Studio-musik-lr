<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // 2. Attempt login using Laravel's Auth facade
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            
            // Sync session variables if needed for legacy compatibility
            session([
                'user_id'   => $user->id_user,
                'role'      => $user->role,
                'user_name' => $user->nama_user,
                'logged_in' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'user' => [
                    'id_user' => $user->id_user,
                    'role' => $user->role,
                    'nama_user' => $user->nama_user
                ]
            ]);
        }

        // Jika gagal
        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah!'
        ], 401);
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'nama_user' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => $request->password, // Will be hashed by model cast
            'role' => 'user',
        ]);

        return response()->json(['success' => true, 'message' => 'Registrasi berhasil!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['success' => true, 'message' => 'Logout berhasil']);
    }

    public function me()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'user' => [
                    'id_user' => $user->id_user,
                    'role' => $user->role,
                    'nama_user' => $user->nama_user
                ]
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Not logged in']);
    }

    public function profile()
    {
        return view('profile');
    }
}
