<?php
namespace Database\Seeders;

use App\Models\Lowongan;
use App\Models\PemilikKebun;
use Illuminate\Database\Seeder;

class PemilikLowonganSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID Pemilik Kebun yang sudah ada (dari UserRoleSeeder/Seeder lainnya)
        $owner = PemilikKebun::orderBy('id')->first();

        if (! $owner) {
            echo "Error: Tidak ada Pemilik Kebun yang ditemukan. Jalankan UserRoleSeeder terlebih dahulu.\n";
            return;
        }

        $ownerId = $owner->id;

        // 1. LOWONGAN URGEN (AKTIF)
        Lowongan::create([
            'pemilik_id'       => $ownerId,
            'judul'            => 'Pemanen Sawit Siap Kerja (5 Orang)',
            'deskripsi'        => 'Dibutuhkan segera tim pemanen sawit berpengalaman, wajib memiliki alat panen sendiri. Fokus pada target harian dan kualitas TBS.',
            'jumlah_kebutuhan' => 5,
            'batas_pelamar'    => 20,
            'upah'             => 'Rp 140.000 / Hari + Bonus Tandan',
            'jam_kerja'        => '07:00 - 15:00 WIB',
            'lokasi_kerja'     => 'Afdeling B - Blok 12',
            'status'           => 'aktif',
        ]);

        // 2. LOWONGAN MANAJERIAL (AKTIF)
        Lowongan::create([
            'pemilik_id'       => $ownerId,
            'judul'            => 'Asisten Kebun (Administrasi & Logistik)',
            'deskripsi'        => 'Membantu manajer dalam pencatatan logistik dan absensi harian. Menguasai dasar Excel diutamakan.',
            'jumlah_kebutuhan' => 1,
            'batas_pelamar'    => 15,
            'upah'             => 'Gaji Bulanan (Rp 3.500.000)',
            'jam_kerja'        => '08:00 - 16:00 WIB',
            'lokasi_kerja'     => 'Kantor Utama Kebun',
            'status'           => 'aktif',
        ]);

        // 3. LOWONGAN MENUNGGU ACC ADMIN (PENDING)
        Lowongan::create([
            'pemilik_id'       => $ownerId,
            'judul'            => 'Tenaga Pelangsir (Butuh Konfirmasi)',
            'deskripsi'        => 'Posisi ini membutuhkan stamina kuat untuk mengangkut TBS dari baris ke TPH.',
            'jumlah_kebutuhan' => 2,
            'batas_pelamar'    => 10,
            'upah'             => 'Borongan per Ton',
            'jam_kerja'        => 'Sesuai volume angkut',
            'lokasi_kerja'     => 'Afdeling C',
            'status'           => 'menunggu_acc', // KUNCI: Untuk diuji di Dashboard Admin
        ]);

        echo "3 Lowongan Pekerjaan berhasil ditambahkan.\n";
    }

}
