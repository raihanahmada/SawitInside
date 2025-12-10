<?php

namespace App\Models;

use App\Models\User;
use App\Models\Lowongan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemilikKebun extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pemilik',
        'luas_kebun',
        'lokasi_kebun',
        'foto_dokumen',
        'foto_profil',   // DITAMBAHKAN
        'kontak',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship dengan lowongan
     */
    public function lowongans()
    {
        return $this->hasMany(Lowongan::class, 'pemilik_id');
    }
}
