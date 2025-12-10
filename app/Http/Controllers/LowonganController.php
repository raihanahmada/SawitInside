<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\PemilikKebun; // Pastikan model ini sesuai dengan yang Anda miliki
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LowonganController extends Controller
{
    /**
     * Menampilkan daftar lowongan milik user yang sedang login.
     * View: resources/views/Pemilik/lowongan/index.blade.php
     */
    public function index()
    {
        // 1. Ambil ID Pemilik dari User yang login
        $pemilik = PemilikKebun::where('user_id', Auth::id())->first();

        // Cek jika profil belum ada
        if (!$pemilik) {
            return redirect()->route('pemilik.datadiry')->with('error', 'Lengkapi profil pemilik terlebih dahulu.');
        }

        // 2. Ambil data berdasarkan 'pemilik_id'
        // SAYA UBAH JADI $lowongans (JAMAK) AGAR TIDAK ERROR DI VIEW
        $lowongans = Lowongan::where('pemilik_id', $pemilik->id)
            ->latest()
            ->get();

        return view('Pemilik.lowongan.index', compact('lowongans'));
    }

    /**
     * Menampilkan form tambah lowongan.
     * View: resources/views/Pemilik/lowongan/create.blade.php
     */
    public function create()
    {
        return view('Pemilik.lowongan.create');
    }

    /**
     * Menyimpan data lowongan baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Ambil Data Pemilik
        $pemilik = PemilikKebun::where('user_id', Auth::id())->firstOrFail();

        // 2. Validasi Input
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jumlah_kebutuhan' => 'required|integer|min:1',
            'batas_pelamar' => 'nullable|date', // <-- berubah
            'upah' => 'nullable|string|max:255',
            'jam_kerja' => 'nullable|string|max:255',
            'lokasi_kerja' => 'nullable|string|max:255',
        ]);

        // 3. Simpan Data
        Lowongan::create([
            'pemilik_id' => $pemilik->id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'jumlah_kebutuhan' => $request->jumlah_kebutuhan,
            'batas_pelamar' => $request->batas_pelamar, // format 'YYYY-MM-DD' dari input date
            'upah' => $request->upah,
            'jam_kerja' => $request->jam_kerja,
            'lokasi_kerja' => $request->lokasi_kerja,
            'status' => 'menunggu_acc',
        ]);

        return redirect()->route('pemilik.lowongan.index')
            ->with('success', 'Lowongan berhasil dibuat dan menunggu persetujuan Admin.');
    }

    /**
     * Menampilkan form edit lowongan.
     * View: resources/views/Pemilik/lowongan/edit.blade.php
     */
    public function edit($id)
    {
        $pemilik = PemilikKebun::where('user_id', Auth::id())->firstOrFail();

        // Pastikan hanya bisa edit milik sendiri
        $lowongan = Lowongan::where('pemilik_id', $pemilik->id)->findOrFail($id);

        return view('Pemilik.lowongan.edit', compact('lowongan'));
    }

    /**
     * Memperbarui data lowongan yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $pemilik = PemilikKebun::where('user_id', Auth::id())->firstOrFail();
        $lowongan = Lowongan::where('pemilik_id', $pemilik->id)->findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jumlah_kebutuhan' => 'required|integer|min:1',
            // VALIDASI INI SUDAH BENAR (INTEGER), JANGAN DIUBAH KE DATE
            'batas_pelamar' => 'nullable|integer|min:1',
            'upah' => 'nullable|string|max:255',
            'jam_kerja' => 'nullable|string|max:255',
            'lokasi_kerja' => 'nullable|string|max:255',
        ]);

        $lowongan->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'jumlah_kebutuhan' => $request->jumlah_kebutuhan,
            'batas_pelamar' => $request->batas_pelamar,
            'upah' => $request->upah,
            'jam_kerja' => $request->jam_kerja,
            'lokasi_kerja' => $request->lokasi_kerja,
        ]);

        return redirect()->route('pemilik.lowongan.index')
            ->with('success', 'Data lowongan berhasil diperbarui!');
    }

    /**
     * Menghapus data lowongan.
     */
    public function destroy($id)
    {
        $pemilik = PemilikKebun::where('user_id', Auth::id())->firstOrFail();

        $lowongan = Lowongan::where('pemilik_id', $pemilik->id)->findOrFail($id);

        $lowongan->delete();

        return redirect()->route('pemilik.lowongan.index')
            ->with('success', 'Lowongan berhasil dihapus.');
    }
}
