<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('logged_in') || !session('user_id')) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
            }
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (session('role') !== 'admin') {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Akses ditolak. Hanya admin yang bisa mengakses halaman ini.'], 403);
            }
            return redirect()->route('home')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}
