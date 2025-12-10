<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lowongan;
use Illuminate\View\View;

class ControllerPublic extends Controller
{
   public function index()
{
    // Ambil statistik
    $stats = [
        'total_pelamar' => User::where('role', 'pelamar')->count(),
        'total_lowongan' => Lowongan::where('status', 'aktif')->count(),
    ];

    // Ambil 3 Lowongan Aktif Terbaru untuk Lowongan Unggulan
    // HAPUS ->with('pemilik.user') jika error
    $featured_vacancies = Lowongan::where('status', 'aktif')
        ->orderByDesc('created_at')
        ->limit(3)
        ->with('pemilik') // hanya pemilik saja
        ->get();

    return view('public.home', compact('stats', 'featured_vacancies'));
}
}
