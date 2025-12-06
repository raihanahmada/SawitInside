<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
// TAMBAHKAN IMPORT INI
use App\Models\PelamarProfil;
use App\Models\PemilikKebun;
use App\Models\Lamaran;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'foto', // field yang sudah ada
        'google_id', // tambahan baru
        'google_avatar', // tambahan baru
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // METHOD TAMBAHAN UNTUK ROLE
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

    // RELASI
    public function pelamar_profil(): HasOne
    {
        return $this->hasOne(PelamarProfil::class, 'user_id', 'id');
    }

    public function pemilik_kebun(): HasOne
    {
        return $this->hasOne(PemilikKebun::class, 'user_id', 'id');
    }

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class, 'pelamar_id');
    }
}
