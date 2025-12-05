<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PemilikKebun;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserPendingOwnerSeeder extends Seeder
{
    public function run(): void
    {
        // 1. PEMILIK PERTAMA (STATUS: PENDING)
        $ownerUser1 = User::create([
            'username' => 'petani_riauu',
            'email' => 'riau1@petani.com',
            'password' => Hash::make('password'),
            'role' => 'pemilik',
            'status' => 'pending', // KUNCI: STATUS HARUS PENDING
        ]);

        // BUAT PROFIL DETAIL UNTUK OWNER PENDING 1
        PemilikKebun::create([
            'user_id' => $ownerUser1->id,
            'nama_pemilik' => 'PT Makmur Jaya Abadi (Pending)',
            'luas_kebun' => '45 Ha',
            'lokasi_kebun' => 'Riau, Kampar',
            'foto_dokumen' => 'path/pending/dok_kampar.pdf',
            'kontak' => '081211112222', // Nomor WA
        ]);

        // 2. PEMILIK KEDUA (STATUS: PENDING)
        $ownerUser2 = User::create([
            'username' => 'kebun_sumut',
            'email' => 'sumut@kebun.com',
            'password' => Hash::make('password'),
            'role' => 'pemilik',
            'status' => 'pending', // KUNCI: STATUS HARUS PENDING
        ]);

        // BUAT PROFIL DETAIL UNTUK OWNER PENDING 2
        PemilikKebun::create([
            'user_id' => $ownerUser2->id,
            'nama_pemilik' => 'Ibu Siti Khadijah',
            'luas_kebun' => '12 Ha',
            'lokasi_kebun' => 'Sumatera Utara, Deli Serdang',
            'foto_dokumen' => 'path/pending/dok_deliserdang.jpg',
            'kontak' => '087855554444', // Nomor WA
        ]);
    }
}
