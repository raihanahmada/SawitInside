<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use App\Models\PelamarProfil;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        // Cari profil pelamar berdasarkan user login
        $user = Auth::user();
        $pelamarProfil = PelamarProfil::where('user_id', $user->id)->first();

        // Jika belum punya profil
        if (!$pelamarProfil) {
            return view('Pelamar.history', [
                'lamarans' => collect(),
                'totalLamaran' => 0,
                'pendingLamaran' => 0,
                'diterimaLamaran' => 0
            ]);
        }

        // Ambil data lamaran
        $lamarans = Lamaran::with('lowongan')
            ->where('pelamar_id', $pelamarProfil->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung statistik
        $totalLamaran = $lamarans->count();
        $pendingLamaran = $lamarans->where('status_lamaran', 'menunggu')->count();
        $diterimaLamaran = $lamarans->where('status_lamaran', 'diterima')->count();

        // Kirim data ke view
        return view('Pelamar.history', compact(
            'lamarans',
            'totalLamaran',
            'pendingLamaran',
            'diterimaLamaran'
        ));
    }
}
