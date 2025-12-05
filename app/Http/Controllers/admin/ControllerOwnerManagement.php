<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lowongan; // Asumsi Anda memiliki model Lowongan
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ControllerOwnerManagement extends Controller
{
    /**
     * Menampilkan daftar pemilik kebun yang sudah terverifikasi (Status: approved).
     */
    public function ownerVerified(): View
    {
        // Mengambil user dengan role 'pemilik' dan status 'approved', eager load detail profil
        $verified_owners = User::where('role', 'pemilik')
                            ->where('status', 'approved')
                            ->with('pemilik_kebun')
                            ->get();

        // --- Statistik Cepat ---
        // Asumsi Model Lowongan tersedia
        $total_lowongan_aktif = Lowongan::where('status', 'aktif')->count();
        // Asumsi Lowongan memiliki kolom 'jumlah_dibutuhkan'
        $total_pekerja_dibutuhkan = Lowongan::where('status', 'aktif')->sum('jumlah_kebutuhan');

        return view('Admin.owner.verified', compact('verified_owners', 'total_lowongan_aktif', 'total_pekerja_dibutuhkan'));
    }

    /**
     * Memblokir/Menolak akun pemilik kebun (Mengubah status menjadi 'rejected').
     */



public function showOwnerDetail(User $user): View
{
    // Cek keamanan: Hanya tampilkan jika role-nya pemilik, terlepas dari status (approved/rejected)
    if ($user->role !== 'pemilik') {
        abort(404, 'Data verifikasi tidak ditemukan.');
    }

    // Eager load data detail profil
    $owner_detail = $user->load('pemilik_kebun');

    // Karena view modal (Admin.owner.detail_modal) sudah ada, kita gunakan lagi
    return view('Admin.owner.detail_modal', compact('owner_detail'));
}


    // --- METHOD UNTUK HALAMAN DATA PEMILIK DIBLOKIR ---

    /**
     * Menampilkan daftar pemilik kebun yang diblokir (Status: rejected).
     */
    public function ownerBlocked(): View
    {
        $blocked_owners = User::where('role', 'pemilik')
                            ->where('status', 'rejected')
                            ->with('pemilik_kebun')
                            ->get();

        return view('Admin.owner.blocked', compact('blocked_owners'));
    }

    /**
     * Memblokir akun (Status: approved -> rejected). Digunakan dari halaman verified.
     */
    public function blockOwner(User $user): RedirectResponse
    {
        if ($user->role !== 'pemilik' || $user->status !== 'approved') {
            return back()->withErrors('Aksi tidak valid. Akun belum diverifikasi atau bukan pemilik.');
        }

        $user->status = 'rejected';
        $user->save();

        // Redirect ke halaman akun diblokir untuk melihat perubahan
        return redirect()->route('admin.owner_blocked')->with('success',
            "Akun Pemilik Kebun '{$user->username}' berhasil diblokir."
        );
    }

    /**
     * Membuka blokir akun (Mengubah status dari 'rejected' ke 'approved').
     */
    public function unblockOwner(User $user): RedirectResponse
    {
        if ($user->role !== 'pemilik' || $user->status !== 'rejected') {
            return back()->withErrors('Aksi tidak valid. Akun tidak dalam status terblokir atau bukan pemilik.');
        }

        $user->status = 'approved';
        $user->save();

        // Redirect ke halaman akun terverifikasi untuk melihat akun yang diaktifkan kembali
        return redirect()->route('admin.owner_verified')->with('success',
            "Akun Pemilik Kebun '{$user->username}' berhasil diaktifkan kembali dan dipindahkan ke daftar terverifikasi."
        );
    }

    public function editOwner(User $user): View
    {
        // Pengecekan keamanan: Pastikan akun adalah pemilik
        if ($user->role !== 'pemilik') {
            abort(403, 'Akses ditolak.');
        }

        // Tidak perlu eager load profil, karena kita hanya edit data users
        return view('Admin.owner.Edit', compact('user'));
    }

    /**
     * Memperbarui data akun pemilik (Username, Email, Password).
     */
    public function updateOwner(Request $request, User $user): RedirectResponse
    {
        // 1. Pengecekan Keamanan
        if ($user->role !== 'pemilik') {
            return back()->withErrors('Aksi tidak valid.');
        }

        // 2. Validasi Input (Hanya Data Akun)
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // 3. Update Data Akun (users)
        $userData = $request->only(['username', 'email']);

        // Hanya update password jika field diisi
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.owner_verified')->with('success',
            "Data Akun Pemilik '{$user->username}' berhasil diperbarui."
        );
    }

}

