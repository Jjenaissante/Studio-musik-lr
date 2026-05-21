<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            // Manual session for compatibility with frontend if needed
            session([
                'user_id'   => $user->id_user,
                'role'      => $user->role,
                'user_name' => $user->nama_user,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'user' => [
                    'id_user' => $user->id_user,
                    'name' => $user->nama_user,
                    'role' => $user->role,
                    'email' => $user->email
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah!'
        ], 401);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'nama_user' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil!'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
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

        return response()->json(['success' => false, 'message' => 'Not logged in'], 401);
    }
}
