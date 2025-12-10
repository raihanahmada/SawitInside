<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang bisa diisi massal (mass assignable).
     * Kolom 'name' dihapus, diganti dengan 'username', 'role', dan 'status'.
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'status',
        'foto_profile',
    ];

    /**
     * Kolom yang harus disembunyikan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts untuk tipe data.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Pastikan password selalu di-hash
    ];

    // ------------------------------------------------------------------
    // RELASI
    // ------------------------------------------------------------------

    /**
     * Relasi One-to-One: User (role 'pelamar') memiliki satu PelamarProfil.
     */
    public function pelamar_profil(): HasOne
    {
        // Menghubungkan users.id dengan pelamar_profils.user_id
        return $this->hasOne(PelamarProfil::class, 'user_id', 'id');
    }
    public function pemilik_kebun(): HasOne
    {
        return $this->hasOne(PemilikKebun::class, 'user_id', 'id');
    }

    // TODO: Tambahkan relasi lain seperti pemilik_profil jika diperlukan di masa depan
}
