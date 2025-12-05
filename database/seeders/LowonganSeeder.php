<?php

namespace Database\Seeders;

use App\Models\Lowongan;
use App\Models\PemilikKebun;
use Illuminate\Database\Seeder;

class LowonganSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah sudah ada data
        if (Lowongan::count() == 0) {
            $pemilik = PemilikKebun::first();

            if (!$pemilik) {
                $pemilik = PemilikKebun::create([
                    'user_id' => 1,
                    'nama_perusahaan' => 'Kebun Sawit Contoh',
                ]);
            }

            Lowongan::create([
                'pemilik_id' => $pemilik->id,
                'judul' => 'Contoh Lowongan 1',
                'deskripsi' => 'Ini contoh lowongan pertama',
                'jumlah_kebutuhan' => 3,
                'batas_pelamar' => now()->addDays(30),
                'upah' => 'Rp 100.000/hari',
                'status' => 'aktif',
            ]);

            $this->command->info('Data lowongan contoh berhasil dibuat!');
        }
    }
}
