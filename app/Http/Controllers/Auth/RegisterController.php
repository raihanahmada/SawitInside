<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman pilihan role (Pemilik / Pelamar).
     */
    public function showRoleChoice()
    {
        return view('auth.register_choice');
    }

    /**
     * Menampilkan form registrasi berdasarkan role yang dipilih di URL.
     */
    public function showRegistrationForm(Request $request)
    {
        // Mendapatkan role dari URL (misal: 'pelamar' atau 'pemilik')
        $path = $request->path();
        $role = basename($path); // Akan menghasilkan 'pelamar' atau 'pemilik'

        if (!in_array($role, ['pelamar', 'pemilik'])) {
            // Redirect jika role tidak valid
            return redirect()->route('register')->withErrors('Role tidak valid.');
        }

        // Tampilkan form yang sesuai
        if ($role === 'pelamar') {
            return view('auth.register_pelamar', compact('role'));
        }

        if ($role === 'pemilik') {
            return view('auth.register_pemilik', compact('role'));
        }
    }

    /**
     * Memproses data registrasi dan menyimpan ke tabel users.
     */
    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['pemilik', 'pelamar'])],

            // Validasi Tambahan untuk Pemilik Kebun
            'luas_kebun' => Rule::requiredIf($request->role === 'pemilik'),
            'daerah' => Rule::requiredIf($request->role === 'pemilik'),
            'foto_bukti_kepemilikan' => Rule::requiredIf($request->role === 'pemilik'),
        ]);

        // 2. Buat User di Tabel 'users'
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // ROLE DITENTUKAN DI SINI
            'status' => $request->role === 'pemilik' ? 'pending' : null, // Pemilik status 'pending', Pelamar null
        ]);

        // 3. Tambahkan Logika Lanjutan Setelah Registrasi (Opsional)
        if ($user->role === 'pemilik') {
            // Logika untuk menyimpan data pemilik kebun (luas_kebun, daerah, dll.)
            // Karena tabel utama kita hanya users, kita asumsikan data ini disimpan di tempat lain
            // atau tambahkan kolom di tabel users (atau tabel terpisah lowongan_owner)

            // Untuk Sederhana: kita anggap data ini akan diisi di dashboard pemilik,
            // atau kamu bisa menambahkannya ke kolom users jika diperlukan.

            return redirect()->route('login')->with('success', 'Registrasi Pemilik Berhasil! Akun Anda sedang diverifikasi Admin.');
        }

        // 4. Otentikasi dan Redirect
        // Auth::login($user); // Jika ingin langsung login

        return redirect()->route('login')->with('success', 'Registrasi Pelamar Berhasil! Silakan Login.');
    }
}
