<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Jika belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Debug: cek role user
        // dd(['user_role' => $user->role, 'required_role' => $role]);

        // 3. Jika role TIDAK sesuai
        if ($user->role !== $role) {
            // TIDAK redirect ke route yang sama (ini penyebab loop!)
            // Redirect ke halaman sesuai role

            if ($user->role === 'pelamar') {
                // Jika user sudah pelamar dan akses route pelamar, biarkan
                if ($request->is('pelamar/*')) {
                    return $next($request);
                }
                return redirect()->route('pelamar.dashboard');
            }

            // Role lainnya
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        // 4. Jika role sesuai
        return $next($request);
    }
}
