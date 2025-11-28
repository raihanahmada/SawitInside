<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PelamarProfil;
class PelamarController extends Controller
{
    /**
     * Menampilkan Dashboard untuk role Pelamar.
     */
    public function index()
    {

        // Memuat view dashboard pelamar
        return view('Pelamar.dashboard');
    }


    // Method untuk menampilkan Halaman Lowongan
    public function lowongan()
    {
        // TODO: Tambahkan logika untuk mengambil data lowongan
        return view('pelamar.lowongan');
    }

    // Method untuk menampilkan Halaman History Lamaran
    public function history()
    {
        // TODO: Tambahkan logika untuk mengambil riwayat lamaran
        return view('pelamar.history');
    }

    // Method untuk menampilkan Halaman Data Diri / Profil
    public function dataDiri()
    {
        // Mendapatkan user_id dari sesi
        $user_id = Auth::id();

        // Cari apakah Pelamar sudah memiliki data profil
        $profil = PelamarProfil::where('user_id', $user_id)->first();

        // Jika data sudah ada, tampilkan form Edit, jika belum ada, tampilkan form Create (Kosong)
        return view('pelamar.data_diri', compact('profil'));
    }

    public function simpanDataDiri(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'usia' => 'required|integer|min:15',
            'jenis_kelamin' => 'required|in:L,P',
            'pengalaman' => 'nullable|string',
            'kontak' => 'required|string|max:15',
        ]);

        // 2. Ambil User ID dari Sesi (Logika Kunci)
        $user_id = Auth::id();

        // 3. Cek apakah sudah ada profil untuk user ini
        $profil = PelamarProfil::where('user_id', $user_id)->first();

        $data = $request->except(['_token']);
        $data['user_id'] = $user_id; // Tambahkan user_id ke array data (optional, tapi aman)

        if ($profil) {
            // Jika sudah ada (Edit/Update)
            $profil->update($data);
            $message = 'Data diri berhasil diperbarui!';
        } else {
            // Jika belum ada (Create/Store)
            PelamarProfil::create($data);
            $message = 'Data diri berhasil disimpan!';
        }

        return redirect()->route('pelamar.datadiry')->with('success', $message);
    }
}

