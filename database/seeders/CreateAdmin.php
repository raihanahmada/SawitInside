<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class CreateAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    User::create([
        'username' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('gatotkaca'),
        'role' => 'admin',
        'status'=>null
    ]);
}
}
