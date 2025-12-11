<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lowongan; // Import Model Lowongan
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;


class ControllerLowongan extends Controller
{
    // ... (ownerPending, approveOwner, rejectOwner, showOwnerDetail methods sudah ada) ...

    /**
     * Menampilkan daftar lowongan yang menunggu persetujuan Admin.
     */
    public function lowonganPending(): View
    {
        // Mengambil lowongan dengan status 'menunggu_acc', eager load Pemilik dan User Pemilik
        $pending_vacancies = Lowongan::where('status', 'menunggu_acc')
                                     ->with('pemilik.user')
                                     ->get();

        return view('Admin.lowongan.pending', compact('pending_vacancies'));
    }

    /**
     * Menyetujui Lowongan (Mengubah status menjadi 'aktif').
     */
    public function approveVacancy(Lowongan $lowongan): RedirectResponse
    {
        // Pengecekan keamanan: Pastikan status saat ini adalah 'menunggu_acc'
        if ($lowongan->status !== 'menunggu_acc') {
            return back()->withErrors('Aksi tidak valid. Lowongan sudah diproses.');
        }

        $lowongan->status = 'aktif';
        $lowongan->save();

        return redirect()->route('admin.lowongan_pending')->with('success',
            "Lowongan '{$lowongan->judul}' berhasil disetujui dan diaktifkan."
        );
    }

    /**
     * Menolak Lowongan (Mengubah status menjadi 'ditolak').
     */
    public function rejectVacancy(Lowongan $lowongan): RedirectResponse
    {
        if ($lowongan->status !== 'menunggu_acc') {
            return back()->withErrors('Aksi tidak valid. Lowongan sudah diproses.');
        }

        $lowongan->status = 'ditolak';
        $lowongan->save();

        return redirect()->route('admin.lowongan_pending')->with('success',
            "Lowongan '{$lowongan->judul}' berhasil ditolak dan dinonaktifkan."
        );
    }

    public function showVacancyDetail(Lowongan $lowongan): View
    {
        // Pengecekan keamanan: Pastikan lowongan masih menunggu persetujuan (optional)
        if ($lowongan->status !== 'menunggu_acc' && $lowongan->status !== 'aktif') {
            abort(404, 'Lowongan tidak ditemukan atau sudah selesai.');
        }

        // Eager load data Pemilik Kebun dan User Pemilik
        $lowongan->load('pemilik.user');

        return view('Admin.lowongan.detail_modal', compact('lowongan'));
    }

    public function vacanciesActive(): View
    {
        // Ambil lowongan dengan status 'aktif' DAN batas pelamar belum lewat
        $active_vacancies = Lowongan::where('status', 'aktif')
                                    ->whereDate('batas_pelamar', '>=', Carbon::today()) // <--- TAMBAHAN FILTER TANGGAL
                                    ->with('pemilik.user')
                                    ->get();

        // Hitung metrik ringkasan untuk header
        $total_needed = $active_vacancies->sum('jumlah_kebutuhan');

        return view('admin.lowongan.active', compact('active_vacancies', 'total_needed'));
    }
}
