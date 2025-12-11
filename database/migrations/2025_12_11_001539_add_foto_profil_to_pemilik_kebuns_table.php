<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('pemilik_kebuns', function (Blueprint $table) {
        $table->string('foto_profil')->nullable()->after('lokasi_kebun');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemilik_kebuns', function (Blueprint $table) {
            //
        });
    }
};
