<?php
namespace Database\Seeders;

use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\PelamarProfil;
use App\Models\User;
use Illuminate\Database\Seeder;

class LamaranDummySeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah sudah ada data lamaran
        if (Lamaran::count() > 0) {
            $this->command->info('Data lamaran sudah ada, skipping seeder...');
            return;
        }

        // --- AMBIL DATA YANG DIBUTUHKAN ---

        // 1. Ambil lowongan aktif
        $lowongan = Lowongan::where('status', 'aktif')->first();

        if (!$lowongan) {
            $this->command->warn('Tidak ada lowongan aktif. Membuat lowongan dummy...');
            $lowongan = Lowongan::create([
                'perusahaann_id' => 1,
                'judul' => 'Lowongan Dummy untuk Testing',
                'deskripsi' => 'Lowongan ini dibuat untuk testing history lamaran',
                'jumlah_kebutuhan' => 5,
                'batas_pelamar' => now()->addDays(30),
                'status' => 'aktif'
            ]);
        }

        // 2. Ambil user dengan role pelamar
        $userPelamar = User::where('role', 'pelamar')->first();

        if (!$userPelamar) {
            $this->command->warn('Tidak ada user dengan role pelamar. Seeder dihentikan.');
            return;
        }

        // 3. Ambil atau buat profil pelamar
        $pelamarProfil = PelamarProfil::where('user_id', $userPelamar->id)->first();

        if (!$pelamarProfil) {
            $this->command->warn('Membuat profil pelamar dummy...');
            $pelamarProfil = PelamarProfil::create([
                'user_id' => $userPelamar->id,
                'nama_lengkap' => $userPelamar->username,
                'tanggal_lahir' => '1990-01-01',
                'alamat' => 'Alamat dummy',
                'no_telepon' => '08123456789',
                'pengalaman' => 'Tidak ada pengalaman'
            ]);
        }

        // --- BUAT DATA LAMARAN DUMMY ---

        $this->command->info('Membuat data lamaran dummy...');

        // 1. Lamaran dengan status MENUNGGU (baru diajukan)
        Lamaran::create([
            'lowongan_id' => $lowongan->id,
            'pelamar_id' => $pelamarProfil->id,
            'status_lamaran' => 'menunggu',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);

        // 2. Lamaran dengan status DITERIMA
        Lamaran::create([
            'lowongan_id' => $lowongan->id,
            'pelamar_id' => $pelamarProfil->id,
            'status_lamaran' => 'diterima',
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(10),
        ]);

        // 3. Lamaran dengan status DITOLAK
        Lamaran::create([
            'lowongan_id' => $lowongan->id,
            'pelamar_id' => $pelamarProfil->id,
            'status_lamaran' => 'ditolak',
            'created_at' => now()->subDays(15),
            'updated_at' => now()->subDays(15),
        ]);

        // 4. Lamaran lama (bulan lalu)
        Lamaran::create([
            'lowongan_id' => $lowongan->id,
            'pelamar_id' => $pelamarProfil->id,
            'status_lamaran' => 'diterima',
            'created_at' => now()->subMonths(1),
            'updated_at' => now()->subMonths(1),
        ]);

        $this->command->info('Berhasil membuat 4 data lamaran dummy!');
        $this->command->info('Status: Menunggu: 1, Diterima: 2, Ditolak: 1');
    }
}
