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
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba proses otentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Mendapatkan data user yang berhasil login
            $user = Auth::user();

            // LOGIKA MULTI-ROLE REDIRECT
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role === 'pemilik') {
                // Pengecekan status (sesuai skenario Pemilik)
                if ($user->status === 'pending') {
                    Auth::logout();
                    return back()->withErrors([
                        'username' => 'Akun Pemilik Kebun Anda masih menunggu verifikasi Admin.',
                    ]);
                }
                return redirect()->intended('/owner/dashboard');
            } elseif ($user->role === 'pelamar') {
                // Arahkan Pelamar ke Dashboard Pelamar
                return redirect()->intended(route('pelamar.dashboard'));
            }
        }

        // Jika otentikasi gagal
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
