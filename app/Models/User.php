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
    // METHOD TAMBAHAN UNTUK ROLE
    // ------------------------------------------------------------------

    /**
     * Check if user has specific role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Check if user is pelamar
     */
    public function isPelamar()
    {
        return $this->role === 'pelamar';
    }

    /**
     * Check if user is pemilik
     */
    public function isPemilik()
    {
        return $this->role === 'pemilik';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

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

    /**
     * Relasi One-to-One: User (role 'pemilik') memiliki satu PemilikKebun.
     */
    public function pemilik_kebun(): HasOne
    {
        return $this->hasOne(PemilikKebun::class, 'user_id', 'id');
    }

    public function lamarans()
{
    return $this->hasMany(Lamaran::class, 'pelamar_id');
}
    // TODO: Tambahkan relasi lain seperti pemilik_profil jika diperlukan di masa depan
}
