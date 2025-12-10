<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
// Import Model Lain
use App\Models\PelamarProfil;
use App\Models\PemilikKebun;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',      // 🛠️ PERBAIKAN: Sesuai tabel database Anda (bukan 'name')
        'email',
        'password',
        'role',
        'status',
        'foto_profile',
        'istatus',   // ✅ PENTING: Agar bisa set status verifikasi
        'google_id',     // ✅ PENTING: Untuk Login Google
        'google_avatar', // ✅ PENTING: Untuk Foto Google
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --- HELPER METHODS UNTUK ROLE ---
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function isPelamar()
    {
        return $this->role === 'pelamar';
    }

    public function isPemilik()
    {
        return $this->role === 'pemilik';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // --- RELASI (RELATIONSHIPS) ---

    // 1. User -> Pelamar Profil
    public function pelamar_profil(): HasOne
    {
        return $this->hasOne(PelamarProfil::class, 'user_id', 'id');
    }

    // 2. User -> Pemilik Kebun
    public function pemilik_kebun(): HasOne
    {
        return $this->hasOne(PemilikKebun::class, 'user_id', 'id');
    }

}
