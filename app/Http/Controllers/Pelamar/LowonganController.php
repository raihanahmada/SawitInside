<?php
namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        // Pastikan pengguna sudah login dan memiliki profil pelamar
        if (! Auth::check() || ! Auth::user()->pelamar_profil) {
            // Arahkan ke halaman lain atau tampilkan pesan error jika tidak memenuhi syarat
            return redirect()->route('dashboard')->with('error', 'Profil pelamar tidak ditemukan.');
        }

        $pelamarId = Auth::user()->pelamar_profil->id;

        $query = Lowongan::with(['pemilik' => function ($q) {
            $q->select('id', 'nama_perusahaan');
        }]);

        $status = $request->input('status', 'aktif');

        if ($status === 'aktif') {
            // Lowongan yang masih aktif dan belum dilamar oleh user ini
            $query->where('status', 'aktif')
                ->whereDate('batas_pelamar', '>=', Carbon::today())
                ->whereDoesntHave('lamarans', function ($q) use ($pelamarId) {
                    $q->where('pelamar_id', $pelamarId);
                });

        } elseif ($status === 'menunggu_acc') {
            // Lowongan yang sudah dilamar oleh user ini dengan status lamaran 'menunggu_acc'
            $query->whereHas('lamarans', function ($q) use ($pelamarId) {
                $q->where('pelamar_id', $pelamarId)
                    ->where('status_lamaran', 'menunggu_acc'); // Asumsi field di tabel lamaran adalah 'status_lamaran'
            });

        } elseif ($status === 'selesai') {
            // Lowongan yang sudah dilamar oleh user ini dengan status lamaran 'diterima' atau 'ditolak'
            $query->whereHas('lamarans', function ($q) use ($pelamarId) {
                $q->where('pelamar_id', $pelamarId)
                    ->whereIn('status_lamaran', ['diterima', 'ditolak']); // Sesuaikan status
            });
        }
        // ... (Lanjutkan dengan kode Search dan Sortir Anda)

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
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

        $lowongans = $query->paginate(12)->withQueryString();

        return view('pelamar.lowongan', compact('lowongans'));
    }

    public function detail($id)
    {
        $lowongan = Lowongan::with(['pemilik' => function ($q) {
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
