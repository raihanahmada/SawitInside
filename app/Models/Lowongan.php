<?php

namespace App\Models;

use App\Models\PemilikKebun;
use App\Models\Lamaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lowongan extends Model
{
    // Bagian ini diupdate agar bisa menyimpan data baru (upah, jam, lokasi)
    protected $fillable = [
        'pemilik_id', 
        'judul', 
        'deskripsi', 
        'jumlah_kebutuhan', 
        'batas_pelamar', 
        'status',
        'upah',         // Baru
        'jam_kerja',    // Baru
        'lokasi_kerja'  // Baru
    ];

    // Relasi M:1 ke PemilikKebun (Tetap, tidak diubah)
    public function pemilik(): BelongsTo
    {
        return $this->belongsTo(PemilikKebun::class, 'pemilik_id', 'id');
    }

    // Relasi 1:M ke Lamaran (Tetap, tidak diubah)
    public function lamarans(): HasMany
    {
        return $this->hasMany(Lamaran::class, 'lowongan_id', 'id');
    }
}