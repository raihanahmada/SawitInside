<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        // Query dengan eager loading
        $query = Lowongan::with(['pemilik' => function($q) {
            $q->select('id', 'nama_perusahaan');
        }]);

        // Filter status (default: aktif yang belum lewat deadline)
        $status = $request->input('status', 'aktif');

        if ($status === 'aktif') {
            $query->where('status', 'aktif')
                  ->whereDate('batas_pelamar', '>=', Carbon::today());
        } elseif (in_array($status, ['menunggu_acc', 'selesai', 'ditolak'])) {
            $query->where('status', $status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('lokasi_kerja', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'deadline') {
            $query->orderBy('batas_pelamar', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination dengan withQueryString untuk menjaga filter
        $lowongans = $query->paginate(12)->withQueryString();

        return view('pelamar.lowongan', compact('lowongans'));
    }

    public function detail($id)
    {
        $lowongan = Lowongan::with(['pemilik' => function($q) {
            $q->with('user:id,username');
        }])->findOrFail($id);

        $sudahLamar = false;
        if (Auth::check() && Auth::user()->pelamar_profil) {
            $sudahLamar = Auth::user()->pelamar_profil->lamarans()
                ->where('lowongan_id', $id)
                ->exists();
        }

        return view('pelamar.lowongan-detail', compact('lowongan', 'sudahLamar'));
    }
}
