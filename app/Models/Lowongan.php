<?php

namespace App\Models;

use App\Models\PemilikKebun;
use App\Models\Lamaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{

    use HasFactory;

    protected $fillable = [
        'pemilik_id',
        'judul',
        'deskripsi',
        'jumlah_kebutuhan',
        'batas_pelamar',
        'upah',
        'jam_kerja',
        'lokasi_kerja',
        'status',
    ];

    protected $casts = [
        'batas_pelamar' => 'date',
    ];


    public function pemilik()
    {
        return $this->belongsTo(PemilikKebun::class, 'pemilik_id');
    }

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class);
    }
}