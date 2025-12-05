<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        // View 'auth.login' akan kita buat di bagian selanjutnya
        return view('auth.login');
    }

    /**
     * Menangani proses login.
     */
    public function login(Request $request)

    {
        $credentials = $request->validate([
            // Login menggunakan 'username'
            'email' => 'required',
            'password' => 'required|string',
        ]);

    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->role === 'pemilik' || $user->role === 'owner') {
            return redirect()->intended('/owner/dashboard');
        } elseif ($user->role === 'pelamar') {
            // Cek dulu apakah route ada
            try {
                return redirect()->intended(route('pelamar.dashboard'));
            } catch (\Exception $e) {
                // Fallback jika route tidak ditemukan
                return redirect()->intended('/pelamar/dashboard');
            }
        }
    }

    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ])->onlyInput('username');
}

    /**
     * Menangani proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
