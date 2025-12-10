<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PemilikKebun;
use App\Models\PelamarProfil;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN PEMILIK KEBUH (ROLE: pemilik)
        $ownerUser = User::create([
            'username' => 'owner_sawit1',
            'email' => 'owner1@sawit.com',
            'password' => Hash::make('password'),
            'role' => 'pemilik',
            'status' => 'approved', // Langsung diset approved agar bisa posting lowongan
        ]);

    //     // BUAT PROFIL DETAIL PEMILIK KEBUH
    //     PemilikKebun::create([
    //         'user_id' => $ownerUser->id,
    //         'nama_pemilik' => 'Budi Sawit Jaya',
    //         'luas_kebun' => '150 Ha',
    //         'lokasi_kebun' => 'Riau, Pekanbaru',
    //         'foto_dokumen' => 'path/to/doc_owner.jpg',
    //         'kontak' => '081234567890',
    //     ]);

    //     // 2. BUAT AKUN PELAMAR (ROLE: pelamar)
    //     $pelamarUser = User::create([
    //         'username' => 'andi_pemanen',
    //         'email' => 'andi@mail.com',
    //         'password' => Hash::make('password'),
    //         'role' => 'pelamar',
    //         'status' => null,
    //     ]);

    //     // BUAT PROFIL DETAIL PELAMAR
    //     PelamarProfil::create([
    //         'user_id' => $pelamarUser->id,
    //         'nama' => 'Andi Purnomo',
    //         'alamat' => 'Jl. Durian No. 12',
    //         'usia' => 28,
    //         'jenis_kelamin' => 'L',
    //         'pengalaman' => 'Pernah menjadi pemanen selama 3 tahun.',
    //         'kontak' => '087654321098',
    //     ]);

    //     // Buat user pelamar kedua untuk kebutuhan lamaran
    //      $pelamarUser2 = User::create([
    //         'username' => 'siti_asisten',
    //         'email' => 'siti@mail.com',
    //         'password' => Hash::make('password'),
    //         'role' => 'pelamar',
    //         'status' => null,
    //     ]);

    //     PelamarProfil::create([
    //         'user_id' => $pelamarUser2->id,
    //         'nama' => 'Siti Aminah',
    //         'alamat' => 'Jl. Mawar No. 5',
    //         'usia' => 25,
    //         'jenis_kelamin' => 'P',
    //         'pengalaman' => 'Pernah menjadi asisten kebun selama 1 tahun.',
    //         'kontak' => '081122334455',
    //     ]);
    }
}
