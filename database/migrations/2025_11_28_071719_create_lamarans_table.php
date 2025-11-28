<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lamarans', function (Blueprint $table) {
            $table->id();
            // FK ke tabel lowongans
            $table->foreignId('lowongan_id')->constrained('lowongans')->onDelete('cascade');
            // FK ke tabel pelamar_profils
            $table->foreignId('pelamar_id')->constrained('pelamar_profils')->onDelete('cascade');

            $table->enum('status_lamaran', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');

            // Tambahkan index unik untuk mencegah pelamar melamar lowongan yang sama dua kali
            $table->unique(['lowongan_id', 'pelamar_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lamarans');
    }
};
