<?php
namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\PelamarProfil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// TAMBAHKAN INI

class PelamarController extends Controller
{
    /**
     * Menampilkan Dashboard untuk role Pelamar.
     */
   public function index()
    {
        $user = Auth::user();
        $profil = $user->pelamar_profil;

        // Inisialisasi default
        $stats = ['totalLamaran' => 0, 'diterima' => 0, 'menunggu' => 0];
        $lamaranTerbaru = collect([]);
        $jadwalKerja = collect([]); // <--- VARIABEL BARU

        if ($profil) {
            $stats['totalLamaran'] = $profil->lamarans()->count();

            $stats['diterima'] = $profil->lamarans()
                ->where('status_lamaran', 'diterima')
                ->count();

            $stats['menunggu'] = $profil->lamarans()
                ->whereIn('status_lamaran', ['pending', 'menunggu', 'menunggu_acc'])
                ->count();

            // Ambil 5 Lamaran Terakhir
            $lamaranTerbaru = $profil->lamarans()
                ->with(['lowongan.pemilik'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // 🟢 AMBIL JADWAL KERJA (Hanya yang DITERIMA)
            $jadwalKerja = $profil->lamarans()
                ->where('status_lamaran', 'diterima')
                ->with(['lowongan.pemilik']) // Eager load relasi
                ->get();
        }

        // Lowongan Aktif & Terbaru (Sistem)
        $lowonganAvailableQuery = Lowongan::where('status', 'aktif')
            ->whereDate('batas_pelamar', '>=', now());

        if ($profil) {
            $lowonganAvailableQuery->whereDoesntHave('lamarans', function($q) use ($profil) {
                $q->where('pelamar_id', $profil->id);
            });
        }

        $lowonganAktifCount = $lowonganAvailableQuery->count();

        $lowonganTerbaru = $lowonganAvailableQuery->with('pemilik')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pelamar.dashboard', [
            'totalLamaran'    => $stats['totalLamaran'],
            'diterima'        => $stats['diterima'],
            'menunggu'        => $stats['menunggu'],
            'lowonganAktif'   => $lowonganAktifCount,
            'lamaranTerbaru'  => $lamaranTerbaru,
            'lowonganTerbaru' => $lowonganTerbaru,
            'profilLengkap'   => (bool) $profil,
            'jadwalKerja'     => $jadwalKerja // <--- KIRIM KE VIEW
        ]);
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
        // 1. Validasi Input (Sesuaikan dengan Form)
        $request->validate([
            'nama'            => 'required|string|max:255', // Ganti 'nama_lengkap' jadi 'nama'
            'alamat'          => 'required|string',
            'usia'            => 'required|integer',       // Tambahkan usia
            'jenis_kelamin'   => 'required|in:L,P',
            'kontak'          => 'required|string|max:20', // Ganti 'no_telepon' jadi 'kontak'
            'pengalaman'      => 'nullable|string',        // Ganti 'pengalaman_kerja' jadi 'pengalaman'

        ]);

        $user_id = Auth::id();
        $profil = PelamarProfil::where('user_id', $user_id)->first();

        // 2. Siapkan Data
        $data = [
            'user_id'       => $user_id,
            'nama'          => $request->nama,
            'alamat'        => $request->alamat,
            'usia'          => $request->usia,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kontak'        => $request->kontak,
            'pengalaman'    => $request->pengalaman,
        ];

        // 3. Handle File Upload (Jika ada kolom foto/cv di DB)
        // ... (kode upload foto tetap sama jika kolomnya ada)

        // 4. Simpan/Update
        if ($profil) {
            $profil->update($data);
            $message = 'Data diri berhasil diperbarui!';
        } else {
            PelamarProfil::create($data);
            $message = 'Data diri berhasil disimpan!';
        }

        return redirect()->route('pelamar.datadiri')->with('success', $message);
    }

    /**
     * Method untuk menampilkan Halaman Lowongan
     */
    // App\Http\Controllers\Pelamar\PelamarController.php

    public function lowongan(Request $request)
    {
        // 1. Cek Profil
        $user = Auth::user();
        if (! $user || ! $user->pelamar_profil) {
            return redirect()->route('pelamar.datadiri')->with('error', 'Harap lengkapi data diri Anda terlebih dahulu.');
        }

        $pelamarId = $user->pelamar_profil->id;

        // 2. Inisiasi Query (Hanya Lowongan Aktif & Belum Expired)
        $query = Lowongan::with('pemilik')
            ->where('status', 'aktif')
            ->whereDate('batas_pelamar', '>=', Carbon::today());

        // 3. FILTER WAJIB: HANYA YANG BELUM DILAMAR
        // Kita gunakan whereDoesntHave untuk mengecualikan lowongan yang sudah ada di tabel lamaran user ini
        $query->whereDoesntHave('lamarans', function ($q) use ($pelamarId) {
            $q->where('pelamar_id', $pelamarId);
        });

        // 4. Fitur Search (Tetap dipertahankan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('lokasi_kerja', 'like', "%{$search}%");
            });
        }

        // 5. Fitur Sort (Tetap dipertahankan)
        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'deadline') {
            $query->orderBy('batas_pelamar', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // 6. Pagination
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
        $user       = Auth::user();

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

        // Cek profil
        if (! $user || ! $user->pelamar_profil) {
            return redirect()->route('pelamar.datadiri');
        }

        $profil = $user->pelamar_profil;

        // 1. Ambil Data Lamaran (Paginated)
        $lamarans = $profil->lamarans()
            ->with(['lowongan' => function ($query) {
                $query->with('pemilik');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // 2. Hitung Statistik untuk Kartu di Atas
        $counts = [
            'total'    => $profil->lamarans()->count(),
            'menunggu' => $profil->lamarans()->where('status_lamaran', 'menunggu')->count(),
            'diterima' => $profil->lamarans()->where('status_lamaran', 'diterima')->count(),
        ];

        return view('pelamar.history', compact('lamarans', 'counts'));
    }

    /**
     * Method untuk melihat detail lamaran
     */
    public function detailLamaran($id)
    {
        $user = Auth::user();

        if (! $user->pelamar_profil) {
            return redirect()->route('pelamar.datadiri')
                ->with('error', 'Silakan lengkapi profil terlebih dahulu');
        }

        $lamaran = $user->pelamar_profil->lamarans()
            ->with(['lowongan' => function ($query) {
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

        if (! $user->pelamar_profil) {
            return redirect()->route('pelamar.datadiri')
                ->with('error', 'Silakan lengkapi profil terlebih dahulu');
        }

        $lamaran = $user->pelamar_profil->lamarans()
            ->where('id', $id)
            ->where('status_lamaran', 'menunggu')
            ->first();

        if (! $lamaran) {
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
        $user   = Auth::user();
        $profil = $user->pelamar_profil;

        if (! $profil) {
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

        $user   = Auth::user();
        $profil = $user->pelamar_profil;

        if (! $profil) {
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
            'success'  => true,
            'foto_url' => asset('uploads/foto/' . $fotoName),
        ]);
    }

    /**
     * Method untuk download CV
     */
    public function downloadCV()
    {
        $user   = Auth::user();
        $profil = $user->pelamar_profil;

        if (! $profil || ! $profil->cv) {
            return redirect()->back()->with('error', 'CV tidak ditemukan');
        }

        $path = public_path($profil->cv);

        if (! file_exists($path)) {
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

        if (! $user->pelamar_profil) {
            return response()->json(['error' => 'Profil tidak ditemukan'], 404);
        }

        $pelamarProfil = $user->pelamar_profil;

        $statistik = [
            'total_lamaran'    => $pelamarProfil->lamarans()->count(),
            'lamaran_diproses' => $pelamarProfil->lamarans()->where('status_lamaran', 'diproses')->count(),
            'lamaran_diterima' => $pelamarProfil->lamarans()->where('status_lamaran', 'diterima')->count(),
            'lamaran_ditolak'  => $pelamarProfil->lamarans()->where('status_lamaran', 'ditolak')->count(),
            'profil_lengkap'   => $pelamarProfil->isComplete(),
        ];

        return response()->json($statistik);
    }
    public function lamarLowongan(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->pelamar_profil) {
            return redirect()->route('pelamar.datadiri')
                ->with('error', 'Silakan lengkapi data diri Anda sebelum melamar.');
        }

        $pelamarId = $user->pelamar_profil->id;

        // Cek duplikasi
        $sudahLamar = Lamaran::where('lowongan_id', $id)
            ->where('pelamar_id', $pelamarId)
            ->exists();

        if ($sudahLamar) {
            return back()->with('error', 'Anda sudah melamar posisi ini sebelumnya.');
        }

        // Simpan Lamaran
        Lamaran::create([
            'lowongan_id'    => $id,
            'pelamar_id'     => $pelamarId,

            // 🛠️ PERBAIKAN DI SINI: Ganti 'pending' menjadi 'menunggu'
            'status_lamaran' => 'menunggu',
        ]);

        return redirect()->route('pelamar.history')
            ->with('success', 'Lamaran berhasil dikirim! Pantau statusnya di sini.');
    }
}
