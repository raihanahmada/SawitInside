<?php

namespace App\Models;

use App\Models\User;
use App\Models\Lowongan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PemilikKebun extends Model
{
    protected $fillable = [
        'user_id',
        'nama_pemilik',
        'luas_kebun',
        'lokasi_kebun',
        'foto_dokumen',
        'foto_profil',   // DITAMBAHKAN
        'kontak',
    ];

    // Relasi 1:1 ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi 1:M ke Lowongan
    public function lowongan(): HasMany
    {
        return $this->hasMany(Lowongan::class, 'pemilik_id', 'id');
    }
}
