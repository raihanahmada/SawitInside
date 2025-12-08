<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PelamarProfil;
use App\Models\Lowongan;
use App\Models\Lamaran;
use Carbon\Carbon; // TAMBAHKAN INI

class PelamarController extends Controller
{
    /**
     * Menampilkan Dashboard untuk role Pelamar.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil data untuk dashboard
        $totalLowongan = Lowongan::where('status', 'aktif')
            ->whereDate('batas_pelamar', '>=', now())
            ->count();

        $profilLengkap = false;
        $lamaranTerbaru = [];

        if ($user->pelamar_profil) {
            $profilLengkap = true;

            // Ambil 5 lamaran terbaru
            $lamaranTerbaru = $user->pelamar_profil->lamarans()
                ->with('lowongan')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        // Memuat view dashboard pelamar
        return view('pelamar.dashboard', compact(
            'totalLowongan',
            'profilLengkap',
            'lamaranTerbaru'
        ));
    }

    /**
     * Method untuk menampilkan Halaman Data Diri / Profil
     */
    public function dataDiri()
    {
        // Mendapatkan user_id dari sesi
        $user_id = Auth::id();

        // Cari apakah Pelamar sudah memiliki data profil
        $profil = PelamarProfil::where('user_id', $user_id)->first();

        // Jika data sudah ada, tampilkan form Edit, jika belum ada, tampilkan form Create (Kosong)
        return view('pelamar.data_diri', compact('profil'));
    }

    /**
     * Method untuk menyimpan/update Data Diri
     */
    public function simpanDataDiri(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'pengalaman_kerja' => 'nullable|string',
            'keahlian' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // 2. Ambil User ID dari Sesi
        $user_id = Auth::id();

        // 3. Cek apakah sudah ada profil untuk user ini
        $profil = PelamarProfil::where('user_id', $user_id)->first();

        // 4. Siapkan data untuk disimpan
        $data = $request->except(['_token', 'foto', 'cv']);
        $data['user_id'] = $user_id;

        // 5. Handle upload foto
        if ($request->hasFile('foto')) {
            $fotoName = time() . '_foto.' . $request->foto->extension();
            $request->foto->move(public_path('uploads/foto'), $fotoName);
            $data['foto'] = 'uploads/foto/' . $fotoName;

            // Hapus foto lama jika ada
            if ($profil && $profil->foto && file_exists(public_path($profil->foto))) {
                unlink(public_path($profil->foto));
            }
        }

        // 6. Handle upload CV
        if ($request->hasFile('cv')) {
            $cvName = time() . '_cv.' . $request->cv->extension();
            $request->cv->move(public_path('uploads/cv'), $cvName);
            $data['cv'] = 'uploads/cv/' . $cvName;

            // Hapus CV lama jika ada
            if ($profil && $profil->cv && file_exists(public_path($profil->cv))) {
                unlink(public_path($profil->cv));
            }
        }

        // 7. Simpan atau Update data
        if ($profil) {
            // Jika sudah ada (Edit/Update)
            $profil->update($data);
            $message = 'Data diri berhasil diperbarui!';
        } else {
            // Jika belum ada (Create/Store)
            PelamarProfil::create($data);
            $message = 'Data diri berhasil disimpan!';
        }

        return redirect()->route('pelamar.datadiri')->with('success', $message);
    }

    /**
     * Method untuk menampilkan Halaman Lowongan
     */
    public function lowongan(Request $request) // TAMBAHKAN Request $request
    {
        $query = Lowongan::query();
        // Query dengan eager loading untuk pemilik
        // $query = Lowongan::with(['pemilik' => function($q) {
        //     $q->select('id', 'nama_perusahaan');
        // }]);

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

        // Pagination
        $lowongans = $query->paginate(12)->withQueryString();

        return view('pelamar.lowongan', compact('lowongans'));
    }

    /**
     * Method untuk menampilkan Detail Lowongan
     * TAMBAHKAN METHOD INI
     */
   public function lowonganDetail($id)
{
    $lowongan = Lowongan::findOrFail($id);

    // UNCOMMENT INI untuk load data pemilik
    $lowongan->load('pemilik');

    $sudahLamar = false;
    $user = Auth::user();

    if ($user && $user->pelamar_profil) {
        $sudahLamar = $user->pelamar_profil->lamarans()
            ->where('lowongan_id', $id)
            ->exists();
    }

    return view('pelamar.lowongan_detail', compact('lowongan', 'sudahLamar'));
}

    /**
     * Method untuk menampilkan Halaman History Lamaran
     */
    public function history()
    {
        $user = Auth::user();
        $lamarans = [];

        if ($user->pelamar_profil) {
            $lamarans = $user->pelamar_profil->lamarans()
                ->with(['lowongan' => function($query) {
                    $query->with('pemilik');
                }])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('pelamar.history', compact('lamarans'));
    }

    /**
     * Method untuk melihat detail lamaran
     */
    public function detailLamaran($id)
    {
        $user = Auth::user();

        if (!$user->pelamar_profil) {
            return redirect()->route('pelamar.datadiri')
                ->with('error', 'Silakan lengkapi profil terlebih dahulu');
        }

        $lamaran = $user->pelamar_profil->lamarans()
            ->with(['lowongan' => function($query) {
                $query->with('pemilik');
            }])
            ->findOrFail($id);

        return view('pelamar.detail_lamaran', compact('lamaran'));
    }

    /**
     * Method untuk batalkan lamaran
     */
    public function batalkanLamaran($id)
    {
        $user = Auth::user();

        if (!$user->pelamar_profil) {
            return redirect()->route('pelamar.datadiri')
                ->with('error', 'Silakan lengkapi profil terlebih dahulu');
        }

        $lamaran = $user->pelamar_profil->lamarans()
            ->where('id', $id)
            ->where('status_lamaran', 'menunggu')
            ->first();

        if (!$lamaran) {
            return redirect()->route('pelamar.history')
                ->with('error', 'Lamaran tidak dapat dibatalkan');
        }

        $lamaran->delete();

        return redirect()->route('pelamar.history')
            ->with('success', 'Lamaran berhasil dibatalkan');
    }

    /**
     * Method untuk menampilkan profil
     */
    public function profil()
    {
        $user = Auth::user();
        $profil = $user->pelamar_profil;

        if (!$profil) {
            return redirect()->route('pelamar.datadiri')
                ->with('error', 'Silakan lengkapi data diri terlebih dahulu');
        }

        return view('pelamar.profil', compact('profil'));
    }

    /**
     * Method untuk update foto profil
     */
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $profil = $user->pelamar_profil;

        if (!$profil) {
            return response()->json(['error' => 'Profil tidak ditemukan'], 404);
        }

        // Hapus foto lama jika ada
        if ($profil->foto && file_exists(public_path($profil->foto))) {
            unlink(public_path($profil->foto));
        }

        // Upload foto baru
        $fotoName = time() . '_foto.' . $request->foto->extension();
        $request->foto->move(public_path('uploads/foto'), $fotoName);

        $profil->update(['foto' => 'uploads/foto/' . $fotoName]);

        return response()->json([
            'success' => true,
            'foto_url' => asset('uploads/foto/' . $fotoName)
        ]);
    }

    /**
     * Method untuk download CV
     */
    public function downloadCV()
    {
        $user = Auth::user();
        $profil = $user->pelamar_profil;

        if (!$profil || !$profil->cv) {
            return redirect()->back()->with('error', 'CV tidak ditemukan');
        }

        $path = public_path($profil->cv);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'File CV tidak ditemukan');
        }

        return response()->download($path);
    }

    /**
     * Method untuk mendapatkan statistik pelamar
     */
    public function getStatistik()
    {
        $user = Auth::user();

        if (!$user->pelamar_profil) {
            return response()->json(['error' => 'Profil tidak ditemukan'], 404);
        }

        $pelamarProfil = $user->pelamar_profil;

        $statistik = [
            'total_lamaran' => $pelamarProfil->lamarans()->count(),
            'lamaran_diproses' => $pelamarProfil->lamarans()->where('status_lamaran', 'diproses')->count(),
            'lamaran_diterima' => $pelamarProfil->lamarans()->where('status_lamaran', 'diterima')->count(),
            'lamaran_ditolak' => $pelamarProfil->lamarans()->where('status_lamaran', 'ditolak')->count(),
            'profil_lengkap' => $pelamarProfil->isComplete(),
        ];

        return response()->json($statistik);
    }
}
