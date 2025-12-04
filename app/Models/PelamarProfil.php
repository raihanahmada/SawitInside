<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelamarProfil extends Model
{
    use HasFactory;

    protected $table = 'pelamar_profils';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'pendidikan_terakhir',
        'pengalaman_kerja',
        'keahlian',
        'foto',
        'cv',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class, 'pelamar_id');
    }

    /**
     * Check if profile is complete
     */
    public function isComplete()
    {
        return !empty($this->nama_lengkap) &&
               !empty($this->alamat) &&
               !empty($this->no_telepon) &&
               !empty($this->jenis_kelamin);
    }
}
