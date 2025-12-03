<?php
namespace App\Http\Controllers\Admin; // <-- BARU

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ControllerOwnerPanding extends Controller
{
   public function ownerPending()
    {
        // Mengambil semua user dengan role 'pemilik' dan status 'pending'
        // Eager load relasi pemilik_kebun untuk mendapatkan kontak dan detail lain
        $pending_owners = User::where('role', 'pemilik')
                            ->where('status', 'pending')
                            ->with('pemilik_kebun')
                            ->get();

        return view('Admin.owner.pending', compact('pending_owners'));
    }

    public function approveOwner(User $user): RedirectResponse
    {
        // Pengecekan keamanan tambahan (Opsional, tapi direkomendasikan)
        if ($user->role !== 'pemilik') {
            return back()->withErrors('Aksi tidak valid. User bukan pemilik.');
        }

        $user->status = 'approved';
        $user->save();

        // Di sini Anda bisa menambahkan logic untuk mengirim notifikasi (WhatsApp/Email)

        return redirect()->route('admin.owner_pending')->with('success',
            "Pemilik Kebun '{$user->username}' berhasil diverifikasi dan disetujui."
        );
    }

    /**
     * Menolak akun pemilik kebun (Mengubah status menjadi 'rejected').
     */
    public function rejectOwner(User $user): RedirectResponse
    {
        if ($user->role !== 'pemilik') {
            return back()->withErrors('Aksi tidak valid. User bukan pemilik.');
        }

        $user->status = 'rejected';
        $user->save();

        return redirect()->route('admin.owner_pending')->with('success',
            "Pemilik Kebun '{$user->username}' berhasil ditolak."
        );
    }

    public function showOwnerDetail(User $user): View
    {
        // Pengecekan keamanan tambahan: Pastikan user ini adalah Pemilik dan statusnya Pending
        if ($user->role !== 'pemilik' || $user->status !== 'pending') {
            abort(404, 'Data verifikasi tidak ditemukan.');
        }

        // Ambil data Pemilik Kebun secara eager load
        $owner_detail = $user->load('pemilik_kebun');

        return view('admin.owner.detail_modal', compact('owner_detail'));
    }
}
