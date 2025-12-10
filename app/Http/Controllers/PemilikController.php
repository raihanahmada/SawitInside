<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PemilikKebun;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\ActivityLog;

class PemilikController extends Controller
{
    // ========================
    // DASHBOARD
    // ========================
    public function index()
{
    // Log aktivitas masuk ke dashboard pemilik
    ActivityLog::addToLog('Pemilik membuka dashboard.');

    // Ambil profil pemilik sesuai user login
    $pemilik = PemilikKebun::where('user_id', Auth::id())->first();

    if (!$pemilik) {

        $totalLowongan = 0;
        $totalLamaran = 0;

        ActivityLog::addToLog('Pemilik belum memiliki data profil.');

    } else {

        // Hitung jumlah lowongan milik pemilik
        $totalLowongan = Lowongan::where('pemilik_id', $pemilik->id)->count();

        // Hitung jumlah lamaran dari semua lowongan pemilik
        $totalLamaran = Lamaran::whereIn('lowongan_id', function ($query) use ($pemilik) {
            $query->select('id')
                ->from('lowongans')
                ->where('pemilik_id', $pemilik->id);
        })->count();

        ActivityLog::addToLog("Pemilik melihat dashboard ($totalLowongan lowongan, $totalLamaran lamaran)");
    }

    // 🔥 Ambil log aktivitas (misal 10 terakhir)
    $logs = \App\Models\ActivityLog::orderBy('created_at', 'desc')
        ->limit(40)
        ->get();

    // Kirim semua data ke view
    return view('pemilik.dashboard', compact(
        'totalLowongan',
        'totalLamaran',
        'pemilik',
        'logs'
    ));
}


    // ========================
    // DATA DIRI
    // ========================
    public function dataDiri()
    {
        $user_id = Auth::id();
        $profil = PemilikKebun::where('user_id', $user_id)->first();
        return view('pemilik.data_diri', compact('profil'));
    }

    public function simpanDataDiri(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:15',
            'luas_kebun' => 'required|integer',
            'lokasi_kebun' => 'required|string',
            'foto_dokumen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user_id = Auth::id();
        $profil = PemilikKebun::where('user_id', $user_id)->first();

        $data = [
            'nama_pemilik' => $request->nama,
            'kontak' => $request->kontak,
            'luas_kebun' => $request->luas_kebun,
            'lokasi_kebun' => $request->lokasi_kebun,
            'user_id' => $user_id,
        ];

        if ($request->hasFile('foto_dokumen')) {
            $file = $request->file('foto_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('foto_pemilik', $filename, 'public');
            $data['foto_dokumen'] = $filename;
        }

        if ($profil) {
            $profil->update($data);
            $message = 'Data diri berhasil diperbarui!';
        } else {
            PemilikKebun::create($data);
            $message = 'Data diri berhasil disimpan!';
        }

        return redirect()->route('pemilik.dataDiri')->with('success', $message);
    }

    // ========================
    // CRUD LOWONGAN
    // ========================
    public function lowonganIndex()
    {
        $user_id_login = Auth::id();
        $pemilik = PemilikKebun::where('user_id', $user_id_login)->first();

        // 🛡️ CEK: Jika data pemilik kebun belum ada
        if (!$pemilik) {
            return redirect()->route('pemilik.dataDiri') // Ganti dengan route profil pemilik Anda
                ->with('error', 'Harap lengkapi data profil kebun Anda sebelum mengelola lowongan.');
        }

        // Jika ada, baru ambil ID-nya
        $lowongan = Lowongan::where('pemilik_id', $pemilik->id)->get();

        return view('pemilik.lowongan.index', compact('lowongan'));
    }

    public function lowonganCreate()
    {
        return view('pemilik.lowongan.create');
    }

    public function lowonganStore(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jumlah_kebutuhan' => 'required|integer|min:1',
            'batas_pelamar' => 'nullable|date',
            // Validasi string biasa untuk input pecahan
            'jenis_upah' => 'nullable|string',
            'nilai_upah' => 'nullable|string',
            'nilai_manual' => 'nullable|string',
            'jam_masuk' => 'nullable|string',
            'jam_pulang' => 'nullable|string',
            'lokasi_kerja' => 'nullable|string|max:255',
        ]);

        $pemilik = PemilikKebun::where('user_id', Auth::id())->first();

        // 2. PROSES UPAH
        $upahFinal = null;
        if ($request->jenis_upah) {
            $jenis = ucfirst($request->jenis_upah);
            $nominal = $request->filled('nilai_manual') ? $request->nilai_manual : $request->nilai_upah;

            // Format Rupiah jika nominal ada
            if ($nominal) {
                $nominal = number_format((float)$nominal, 0, ',', '.');
                $upahFinal = "{$jenis}: Rp {$nominal}";
            } else {
                $upahFinal = $jenis; // Hanya jenis saja jika nominal kosong
            }
        }

        // 3. PROSES JAM KERJA (PENTING: Gabungkan manual di sini)
        $jamKerjaFinal = null;
        if ($request->filled('jam_masuk') && $request->filled('jam_pulang')) {
            // Hasil: "08:00 - 16:00 WIB"
            $jamKerjaFinal = "{$request->jam_masuk} - {$request->jam_pulang} WIB";
        } elseif ($request->filled('jam_masuk')) {
            $jamKerjaFinal = "{$request->jam_masuk} s/d Selesai";
        }

        // 4. Simpan Data
        Lowongan::create([
            'pemilik_id' => $pemilik->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'jumlah_kebutuhan' => $request->jumlah_kebutuhan,
            'batas_pelamar' => $request->batas_pelamar,
            'upah' => $upahFinal,
            'jam_kerja' => $jamKerjaFinal, // Simpan hasil gabungan string
            'lokasi_kerja' => $request->lokasi_kerja,
            'status' => 'menunggu_acc',
        ]);

        return redirect()->route('pemilik.lowongan.index')->with('success', 'Lowongan berhasil dibuat!');
    }

    public function lowonganEdit($id)
    {
        $pemilik = PemilikKebun::where('user_id', Auth::id())->firstOrFail();
        // Pastikan lowongan milik pemilik yang login
        $lowongan = Lowongan::where('pemilik_id', $pemilik->id)->findOrFail($id);

        return view('pemilik.lowongan.edit', compact('lowongan'));
    }

    public function lowonganUpdate(Request $request, $id)
    {
        // 1. Validasi
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jumlah_kebutuhan' => 'required|integer|min:1',
            'batas_pelamar' => 'required|date',
            'lokasi_kerja' => 'nullable|string|max:255',

            // Validasi input pecahan
            'jenis_upah' => 'nullable|string',
            'nilai_upah' => 'nullable|string',
            'nilai_manual' => 'nullable|string',
            'jam_masuk' => 'nullable|string',
            'jam_pulang' => 'nullable|string',
        ]);

        $pemilik = PemilikKebun::where('user_id', Auth::id())->firstOrFail();
        $lowongan = Lowongan::where('pemilik_id', $pemilik->id)->findOrFail($id);

        // 2. Olah Data Upah (Re-construct string)
        $upahFinal = $lowongan->upah; // Default pakai lama jika tidak diubah

        // Cek jika ada input upah yang dikirim
        if ($request->filled('jenis_upah') || $request->filled('nilai_manual')) {
            if ($request->jenis_upah) {
                $jenis = ucfirst($request->jenis_upah);
                $nominal = $request->filled('nilai_manual') ? $request->nilai_manual : $request->nilai_upah;

                if ($nominal) {
                    $nominal = number_format((float)$nominal, 0, ',', '.');
                    $upahFinal = "{$jenis}: Rp {$nominal}";
                } else {
                    $upahFinal = $jenis;
                }
            } else {
                $upahFinal = null; // Jika jenis dikosongkan
            }
        }

        // 3. Olah Data Jam Kerja (Re-construct string)
        $jamKerjaFinal = $lowongan->jam_kerja; // Default pakai lama

        // Cek jika ada input jam yang dikirim
        if ($request->filled('jam_masuk')) {
            if ($request->filled('jam_pulang')) {
                $jamKerjaFinal = "{$request->jam_masuk} - {$request->jam_pulang} WIB";
            } else {
                $jamKerjaFinal = "{$request->jam_masuk} s/d Selesai";
            }
        }

        // 4. Update
        $lowongan->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'jumlah_kebutuhan' => $request->jumlah_kebutuhan,
            'batas_pelamar' => $request->batas_pelamar,
            'upah' => $upahFinal,
            'jam_kerja' => $jamKerjaFinal,
            'lokasi_kerja' => $request->lokasi_kerja,
        ]);

        return redirect()->route('pemilik.lowongan.index')->with('success', 'Lowongan berhasil diperbarui!');
    }
    public function lowonganDestroy($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $lowongan->delete();

        return redirect()->route('pemilik.lowongan.index')->with('success', 'Lowongan berhasil dihapus!');
    }

    // ========================
    // RUPDATE LAMARAN
    // ========================
    public function cekLamaran($lowongan_id)
    {
        // Ambil lowongan
        $lowongan = Lowongan::findOrFail($lowongan_id);

        // Ambil lamaran berdasarkan lowongan
        $lamaran = Lamaran::with('pelamar')->where('lowongan_id', $lowongan_id)->get();

        return view('pemilik.lamaran.index', compact('lamaran', 'lowongan'));
    }

    public function acceptLamaran($lamaran_id)
    {
        $lamaran = Lamaran::findOrFail($lamaran_id);
        $lamaran->status_lamaran = 'accepted';
        $lamaran->save();

        return back()->with('success', 'Lamaran diterima.');
    }

    public function rejectLamaran($lamaran_id)
    {
        $lamaran = Lamaran::findOrFail($lamaran_id);
        $lamaran->status_lamaran = 'rejected';
        $lamaran->save();

        return back()->with('success', 'Lamaran ditolak.');
    }
    // ========================
    // FITUR HISTORY LAMARAN
    // ========================
    public function history()
    {
        // 1. Ambil Profil Pemilik
        $pemilik = PemilikKebun::where('user_id', Auth::id())->first();

        // Cek validasi profil
        if (!$pemilik) {
            return redirect()->route('pemilik.dataDiri')->with('error', 'Silakan lengkapi profil pemilik terlebih dahulu.');
        }

        // 2. Ambil Riwayat Lamaran
        // Query: Cari semua lamaran di mana lowongan-nya milik $pemilik->id
        $riwayat = Lamaran::with(['lowongan', 'pelamar']) // Eager load relasi biar cepat
            ->whereHas('lowongan', function ($query) use ($pemilik) {
                $query->where('pemilik_id', $pemilik->id);
            })
            ->latest() // Urutkan dari yang terbaru
            ->get();

        // 3. Tampilkan View
        return view('Pemilik.history', compact('riwayat'));
    }
}
