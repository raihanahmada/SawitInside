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
            $table->integer('batas_pelamar');
            $table->enum('status', ['menunggu_acc', 'ditolak', 'aktif', 'selesai'])->default('menunggu_acc');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};
