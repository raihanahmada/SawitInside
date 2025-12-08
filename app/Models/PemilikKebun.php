<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemilikKebun extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'alamat',
        'no_telepon',
        'luas_kebun',
        'jumlah_pekerja',
    ];

    /**
     * Relationship dengan user
     */
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
