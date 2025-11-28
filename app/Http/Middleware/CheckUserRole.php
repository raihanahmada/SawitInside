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
        // 1. Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role pengguna yang sedang login sesuai dengan role yang diminta ($role)
        // Kita bandingkan role dari database (Auth::user()->role) dengan role yang di-pass ke middleware
        if (Auth::user()->role !== $role) {

          abort(403, 'Unauthorized action.');
        }

        // 3. Jika role sesuai, lanjutkan request
        return $next($request);
    }
}
