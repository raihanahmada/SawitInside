<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

// database/seeders/DatabaseSeeder.php

public function run(): void
{
    $this->call([
        // PENTING: UserRoleSeeder harus dijalankan pertama
        UserRoleSeeder::class,
        PemilikLowonganSeeder::class,
        LamaranDummySeeder::class, // Jika sudah Anda siapkan
        LowonganSeeder::class, // Tambahkan ini
    ]);
}
}
