<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('logged_in') || !session('user_id')) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['success' => false, 'message' => 'Unauthorized. Silakan login terlebih dahulu.'], 401);
            }
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
