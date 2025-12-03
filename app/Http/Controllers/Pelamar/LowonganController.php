<?php

namespace App\Http\Controllers\Pelamar;  // UBAH INI

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    public function index()
    {
        // Ambil data lowongan dari database
        $lowongans = Lowongan::where('status', 'aktif')
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Tampilkan view lowongan
        return view('pelamar.lowongan', compact('lowongans'));
    }
}
