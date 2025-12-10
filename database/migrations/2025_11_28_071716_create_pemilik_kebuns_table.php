<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemilik_kebuns', function (Blueprint $table) {
            $table->id();

            // Relasi ke user
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('nama_pemilik');
            $table->string('luas_kebun');
            $table->string('lokasi_kebun');
            $table->string('foto_dokumen');  // Dokumen lahan
            $table->string('foto_profil')->nullable(); // FOTO PROFIL PEMILIK
            $table->string('kontak'); // Nomor WA

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemilik_kebuns');
    }
};
