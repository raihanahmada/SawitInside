<?php

namespace Database\Seeders;

use App\Models\Lowongan;
use App\Models\PemilikKebun;
use Illuminate\Database\Seeder;

class PemilikLowonganSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID Pemilik Kebun yang sudah dibuat oleh UserRoleSeeder
        $owner = PemilikKebun::where('nama_pemilik', 'Budi Sawit Jaya')->first();

        if ($owner) {
            Lowongan::create([
                'pemilik_id' => $owner->id,
                'judul' => 'Pemanen Sawit Urgent',
                'deskripsi' => 'Dibutuhkan 5 pemanen dengan pengalaman minimal 2 tahun. Upah harian.',
                'jumlah_kebutuhan' => 5,
                'batas_pelamar' => 20,
                'status' => 'aktif', // Langsung aktif agar terlihat di dashboard
            ]);

            Lowongan::create([
                'pemilik_id' => $owner->id,
                'judul' => 'Tenaga Pengangkut (Pelangsir)',
                'deskripsi' => 'Dibutuhkan 2 tenaga pelangsir sawit siap kerja keras.',
                'jumlah_kebutuhan' => 2,
                'batas_pelamar' => 10,
                'status' => 'aktif',
            ]);
        }
    }
}
