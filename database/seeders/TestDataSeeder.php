<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PemilikKebun;
use App\Models\PelamarProfil;
use App\Models\Lowongan;
use App\Models\Lamaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class TestDataSeeder extends Seeder
{
    public function run()
    {


        // --- 0. AKUN ADMIN ---
        User::create([
            'username' => 'admin_sawit',
            'email' => 'admin@sawit.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => null,
        ]);

        // --- 1. USER & PROFIL PEMILIK (Owner) ---
        $ownerUser = User::create([
            'username' => 'owner_kebun',
            'email' => 'owner@sawit.com',
            'password' => bcrypt('password'),
            'role' => 'pemilik',
            'status' => 'approved',
        ]);

        // 🎯 UPDATE: Disesuaikan dengan gambar struktur tabel Anda
        $pemilik = PemilikKebun::create([
            'user_id' => $ownerUser->id,
            'nama_pemilik' => 'Bapak Joni Santoso',
            'luas_kebun' => '50 Hektar',
            'lokasi_kebun' => 'Desa Suka Makmur, Riau',
            'kontak' => '081299887766',
           'foto_dokumen' => 'uploads/dokumen/dummy_izin.jpg',
        ]);

        // --- 2. USER & PROFIL PELAMAR (Applicant) ---
        $pelamarUser = User::create([
            'username' => 'test_pelamar',
            'email' => 'pelamar@sawit.com',
            'password' => bcrypt('password'),
            'role' => 'pelamar',
            'status' =>null,
        ]);

        // 🎯 UPDATE: Disesuaikan dengan request fillable Anda sebelumnya
        $pelamar = PelamarProfil::create([
            'user_id' => $pelamarUser->id,
            'nama' => 'Budi Setiawan',
            'alamat' => 'Jl. Melati No. 10, Pekanbaru',
            'usia' => 28,
            'jenis_kelamin' => 'L',
            'pengalaman' => 'Pernah bekerja di perkebunan sawit selama 3 tahun.',
            'kontak' => '081234567890',
        ]);

        // --- 3. LOWONGAN ---
        // Pastikan migrasi kolom 'batas_pelamar' sudah tipe DATE

        // Lowongan 1: Status Selesai (Diterima)
        $lowongan1 = Lowongan::create([
            'pemilik_id' => $pemilik->id,
            'judul' => 'Operator Alat Berat',
            'deskripsi' => 'Mengoperasikan Excavator untuk replanting.',
            'jumlah_kebutuhan' => 2,
            'upah' => 'Rp 200.000 / hari',
            'jam_kerja' => '08:00 - 16:00',
            'lokasi_kerja' => 'Blok A Kebun Inti',
            'status' => 'aktif',
            'batas_pelamar' => Carbon::now()->addMonths(2)->format('Y-m-d'),
        ]);

        // Lowongan 2: Status Pending Lamaran
        $lowongan2 = Lowongan::create([
            'pemilik_id' => $pemilik->id,
            'judul' => 'Pekerja Pemanen',
            'deskripsi' => 'Dibutuhkan pemanen fisik kuat, sistem target.',
            'jumlah_kebutuhan' => 10,
            'upah' => 'Rp 1.500 / tandan',
            'jam_kerja' => '07:00 - Selesai',
            'lokasi_kerja' => 'Afdeling 3',
            'status' => 'aktif',
            'batas_pelamar' => Carbon::now()->addMonths(1)->format('Y-m-d'),
        ]);

        // Lowongan 3: BENAR-BENAR AKTIF (Belum Dilamar)
        // Ini yang harus muncul di halaman "Lowongan Aktif"
        $lowongan3 = Lowongan::create([
            'pemilik_id' => $pemilik->id,
            'judul' => 'Mandor Panen',
            'deskripsi' => 'Pengalaman minimal 2 tahun sebagai mandor.',
            'jumlah_kebutuhan' => 1,
            'upah' => 'Rp 4.500.000 / bulan',
            'jam_kerja' => 'Full Time',
            'lokasi_kerja' => 'Kantor Kebun',
            'status' => 'aktif',
            'batas_pelamar' => Carbon::now()->addMonths(3)->format('Y-m-d'),
        ]);

        // Lowongan 4: EXPIRED (Kadaluarsa)
        Lowongan::create([
            'pemilik_id' => $pemilik->id,
            'judul' => 'Supir Truk Langsir',
            'deskripsi' => 'SIM B1 Polos.',
            'jumlah_kebutuhan' => 3,
            'upah' => 'Harian',
            'status' => 'aktif',
            'batas_pelamar' => Carbon::yesterday()->format('Y-m-d'),
        ]);


        // --- 4. LAMARAN ---

        // Lamaran untuk Lowongan 1 (Diterima)
        Lamaran::create([
            'lowongan_id' => $lowongan1->id,
            'pelamar_id' => $pelamar->id,
            'status_lamaran' => 'diterima',

        ]);

        // Lamaran untuk Lowongan 2 (Pending)
        Lamaran::create([
            'lowongan_id' => $lowongan2->id,
            'pelamar_id' => $pelamar->id,
            'status_lamaran' => 'menunggu',

        ]);
    }
}
