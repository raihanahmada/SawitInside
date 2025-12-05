<?php
namespace App\Models;

use App\Models\Lamaran;
use App\Models\PemilikKebun;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lowongan extends Model
{
    protected $fillable = [
        'pemilik_id', 'judul', 'deskripsi', 'jumlah_kebutuhan', 'batas_pelamar', 'status'
        , 'upah',
        'jam_kerja',
        'lokasi_kerja',
    ];

    // Relasi M:1 ke PemilikKebun
    public function pemilik(): BelongsTo
    {
        return $this->belongsTo(PemilikKebun::class, 'pemilik_id', 'id');
    }

    // Relasi 1:M ke Lamaran
    public function lamarans(): HasMany
    {
        return $this->hasMany(Lamaran::class, 'lowongan_id', 'id');
    }
}
