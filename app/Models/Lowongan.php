<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongans';

    protected $fillable = [
        'perusahaann_id',
        'judul',
        'deskripsi',
        'jumlah_kebutuhan',
        'batas_pelamar',
        'status',
        'created_at',
        'updated_at'
    ];

    // Jika perlu relasi dengan perusahaan
    public function perusahaan()
    {
        return $this->belongsTo(PemilikKebun::class, 'perusahaann_id');
    }
}
