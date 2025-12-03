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
    public function blockOwner(User $user): RedirectResponse
    {
        // Pengecekan keamanan
        if ($user->role !== 'pemilik' || $user->status !== 'approved') {
            return back()->withErrors('Aksi tidak valid. Akun belum diverifikasi atau bukan pemilik.');
        }

        $user->status = 'rejected'; // Mengubah status menjadi rejected (blokir)
        $user->save();

        return redirect()->route('admin.owner_verified')->with('success',
            "Akun Pemilik Kebun '{$user->username}' berhasil diblokir."
        );
    }

    public function unblockOwner(User $user): RedirectResponse
    {
    // Pengecekan keamanan
    if ($user->role !== 'pemilik' || $user->status !== 'rejected') {
        return back()->withErrors('Aksi tidak valid. Akun tidak dalam status terblokir atau bukan pemilik.');
    }

    // Mengubah status menjadi approved
    $user->status = 'approved';
    $user->save();

    return redirect()->route('admin.owner_verified')->with('success',
        "Akun Pemilik Kebun '{$user->username}' berhasil diaktifkan kembali (Unblocked)."
    );
}
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
}
