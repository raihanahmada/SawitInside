<?php

namespace Database\Seeders;

use App\Models\Lowongan;
use App\Models\PemilikKebun;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LowonganSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil pemilik pertama
        $pemilik = PemilikKebun::first();

        if (!$pemilik) {
            $this->command->warn('⚠️  Tidak ada pemilik kebun. Buat dulu seeder PemilikKebunSeeder.');
            return;
        }

        // Data dummy - hanya buat jika belum ada
        $data = [
            [
                'judul' => 'Pemanen Sawit Slap Kerja (5 Orang)',
                'pemilik_id' => $pemilik->id,
                'deskripsi' => 'Membutuhkan pemanen sawit berpengalaman.',
                'jumlah_kebutuhan' => 5,
                'batas_pelamar' => Carbon::now()->addDays(30)->format('Y-m-d'), // FORMAT TANGGAL SAJA
                'upah' => 'Rp 140.000 / Hari + Bonus Tandan',
                'jam_kerja' => '07:00 - 15:00', // TAMBAHKAN
                'lokasi_kerja' => 'Afdeling 6 - Blok 12',
                'status' => 'aktif',
            ],
            [
                'judul' => 'Asisten Kebun (Administrasi & Logistik)',
                'pemilik_id' => $pemilik->id,
                'deskripsi' => 'Membantu administrasi kebun.',
                'jumlah_kebutuhan' => 2,
                'batas_pelamar' => Carbon::now()->addDays(45)->format('Y-m-d'), // FORMAT TANGGAL SAJA
                'upah' => 'Gaji Bulanan (Rp 3.500.000)',
                'jam_kerja' => '08:00 - 16:00', // TAMBAHKAN
                'lokasi_kerja' => 'Kantor Utama Kebun',
                'status' => 'aktif',
            ],
            [
                'judul' => 'Tenaga Pelangsir TBS',
                'pemilik_id' => $pemilik->id,
                'deskripsi' => 'Membutuhkan tenaga pelangsir TBS dengan sistem borongan.',
                'jumlah_kebutuhan' => 10,
                'batas_pelamar' => Carbon::now()->addDays(20)->format('Y-m-d'),
                'upah' => 'Borongan per Ton (Rp 15.000/ton)',
                'jam_kerja' => '06:00 - 14:00',
                'lokasi_kerja' => 'Afdeling C',
                'status' => 'aktif',
            ],
        ];

        $createdCount = 0;
        foreach ($data as $item) {
            // Cek dulu apakah sudah ada
            if (!Lowongan::where('judul', $item['judul'])->exists()) {
                Lowongan::create($item);
                $createdCount++;
            }
        }

        $this->command->info("✅ $createdCount data lowongan berhasil ditambahkan!");
    }
}
