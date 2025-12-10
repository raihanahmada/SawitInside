<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use App\Models\Lamaran;
use App\Models\PelamarProfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class ControllerDatapelamar extends Controller
{
    /**
     * Menampilkan daftar semua Pelamar terdaftar beserta data profil mereka.
     */
    public function applicants(): View
    {
        // Mengambil semua user dengan role 'pelamar', eager load data profilnya
        $applicants = User::where('role', 'pelamar')
                          ->with('pelamar_profil')
                          ->get();

        // View path yang digunakan sebelumnya
        return view('admin.pelamar.DataPelamar', compact('applicants'));
    }

    public function showApplicantApplications(User $user): View
    {
        // Pengecekan keamanan: Pastikan user ini memang Pelamar
        if ($user->role !== 'pelamar') {
            abort(404, 'Data tidak ditemukan: Akun bukan Pelamar.');
        }

        // Ambil data profil Pelamar dan semua lamaran yang diajukan
       $applicant_applications = $user->pelamar_profil // Panggil objek profil
            ->lamarans() // <-- Method relasi yang baru Anda buat
            ->with(['lowongan.pemilik.user'])
            ->get();
        // ...

        // Ambil data nama Pelamar (dari tabel profil) untuk judul halaman
        $applicant_name = $user->pelamar_profil->nama ?? $user->username;

        return view('admin.pelamar.DetailLamaran', compact('applicant_applications', 'applicant_name', 'user'));
    }

    public function edit(User $user): View
    {
        // Eager load profil untuk form
        $user->load('pelamar_profil');

        // Pastikan ada instance kosong jika profil belum ada untuk mencegah error
        $profil = $user->pelamar_profil ?? new PelamarProfil();

        return view('Admin.pelamar.Edit', compact('user', 'profil'));
    }

    public function destroy(User $user): RedirectResponse
    {
        // Hapus user. Karena relasi foreign key dengan onDelete('cascade') sudah diatur,
        // semua data terkait di pelamar_profils, lowongan, dan lamaran akan otomatis terhapus.
        if ($user->role !== 'pelamar') {
            return back()->withErrors('Hanya data pelamar yang dapat dihapus dari halaman ini.');
        }

        $user->delete();

        return redirect()->route('admin.applicants')->with('success', 'Data Pelamar berhasil dihapus secara permanen.');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        // 1. Validasi Input (Hanya Data Akun)
        $request->validate([
            // Username dan Email harus unik, kecuali untuk user yang sedang diedit
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // 2. Update Data Akun (users)
        $userData = $request->only(['username', 'email']);

        // Hanya update password jika field diisi
        if ($request->filled('password')) {
            // Pastikan Anda mengimpor Hash di bagian atas file
            $userData['password'] = Hash::make($request->password);
        }

        // Update user
        $user->update($userData);

        // 3. TIDAK ADA UPDATE DATA PROFIL

        return redirect()->route('admin.applicants')->with('success', 'Data Akun Pelamar berhasil diperbarui.');
    }
}
