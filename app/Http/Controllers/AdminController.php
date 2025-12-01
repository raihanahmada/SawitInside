<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lowongan;
use Illuminate\View\View;
use App\Models\Lamaran; // Untuk metrik keberhasilan
use Illuminate\Support\Facades\DB; // Untuk kueri grafik
use Illuminate\Support\Facades\Hash;
use App\Models\PemilikKebun;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function index()
    {
        // 1. METRIK UTAMA (KARTU)
        $metrics = [
            'pending_owners' => User::where('role', 'pemilik')->where('status', 'pending')->count(),
            'approved_owners' => User::where('role', 'pemilik')->where('status', 'approved')->count(),
            'total_applicants' => User::where('role', 'pelamar')->count(),
            'pending_vacancies' => Lowongan::where('status', 'menunggu_acc')->count(),
            'active_vacancies' => Lowongan::where('status', 'aktif')->count(),
            'total_success_hires' => Lamaran::where('status_lamaran', 'diterima')->count(),
        ];

        // 2. DATA GRAFIK (KPI Keberhasilan Penempatan Kerja)
        $success_trend = Lamaran::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where('status_lamaran', 'diterima')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('Admin.dashboard', compact('metrics', 'success_trend'));
    }

   // app/Http/Controllers/AdminController.php

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
