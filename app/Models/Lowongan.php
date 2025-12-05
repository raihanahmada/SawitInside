<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Lamaran;
use App\Models\PemilikKebun;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongans';

    protected $fillable = [

        'pemilik_id',
        'judul',
        'deskripsi',
        'jumlah_kebutuhan',
        'batas_pelamar',
        'status',
        'upah',
        'jam_kerja',
        'lokasi_kerja',
    ];

    // Relasi dengan PemilikKebun
    public function pemilik()
    {
        return $this->belongsTo(PemilikKebun::class, 'pemilik_id');
    }
}
