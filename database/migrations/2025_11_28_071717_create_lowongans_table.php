<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id();
            // FK ke tabel pemilik_kebuns
            $table->foreignId('pemilik_id')->constrained('pemilik_kebuns')->onDelete('cascade');

            $table->string('judul');
            $table->text('deskripsi');
            $table->integer('jumlah_kebutuhan');
            $table->date('batas_pelamar')->nullable(); 
            $table->string('upah')->nullable(); // Skema upah (contoh: "Borongan per Kg" atau "Rp 150.000/hari")
            $table->string('jam_kerja')->nullable(); // Detail jam kerja (contoh: "07:00 - 15:00" atau "Sesuai Target")
            $table->string('lokasi_kerja')->nullable(); // Lokasi spesifik di kebun (contoh: "Afdeling B, Blok 5")
            $table->enum('status', ['menunggu_acc', 'ditolak', 'aktif', 'selesai'])->default('menunggu_acc');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};
