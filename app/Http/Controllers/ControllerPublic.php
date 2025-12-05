<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lowongan;
use Illuminate\View\View;

class ControllerPublic extends Controller
{
    public function index(): View
    {
        // Statistik Cepat untuk ditampilkan
        $stats = [
            'total_applicants' => User::where('role', 'pelamar')->count(),
            'total_active_vacancies' => Lowongan::where('status', 'aktif')->count(),
        ];

        // Ambil 3 Lowongan Aktif Terbaru untuk Lowongan Unggulan
        $featured_vacancies = Lowongan::where('status', 'aktif')
            ->orderByDesc('created_at')
            ->limit(3)
            ->with('pemilik.user')
            ->get();

        return view('public.home', compact('stats', 'featured_vacancies'));
    }
}
