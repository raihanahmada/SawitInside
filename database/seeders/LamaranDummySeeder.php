<?php
namespace Database\Seeders;

use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\PelamarProfil;
use Illuminate\Database\Seeder;

class LamaranDummySeeder extends Seeder
{
    public function run(): void
    {
        // --- LOGIKA PENTING: Ambil ID yang ada, bukan mengasumsikan ID = 1 ---

        $lowongan = Lowongan::orderBy('id')->first();
        $pelamar1 = PelamarProfil::orderBy('id')->first();
        $pelamar2 = PelamarProfil::orderBy('id')->skip(1)->first(); // Mencoba mendapatkan yang kedua

        // Pastikan semua data induk ditemukan sebelum melanjutkan
        if (!$lowongan || !$pelamar1) {
             // Jika data induk tidak ditemukan, tampilkan pesan error
             throw new \Exception("Database Seeder Error: Lowongan atau PelamarProfil belum tersedia.");
        }

        // Ambil ID yang sudah terverifikasi ada
        $lowonganId = $lowongan->id;
        $pelamarId1 = $pelamar1->id;
        $pelamarId2 = $pelamar2 ? $pelamar2->id : $pelamar1->id; // Fallback jika hanya ada 1 pelamar

        // 1. Lamaran diterima - Bulan Ini
        Lamaran::create([
            'lowongan_id' => $lowonganId, // Mengambil ID yang ada
            'pelamar_id' => $pelamarId1, // Mengambil ID yang ada
            'status_lamaran' => 'diterima',
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(10),
        ]);

        // 2. Lamaran diterima - Bulan Lalu
        Lamaran::create([
            'lowongan_id' => $lowonganId,
            'pelamar_id' => $pelamarId2,
            'status_lamaran' => 'diterima',
            'created_at' => now()->subMonths(1),
            'updated_at' => now()->subMonths(1),
        ]);
    }
}
