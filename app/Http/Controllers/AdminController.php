<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lowongan;
use App\Models\Lamaran; // Untuk metrik keberhasilan
use Illuminate\Support\Facades\DB; // Untuk kueri grafik
use Illuminate\Support\Facades\Hash;
use App\Models\PemilikKebun;
use Illuminate\Http\Request;

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

    // ... method lain untuk manajemen user, lowongan, dll.
}
