<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lamaran extends Model
{
    protected $table = 'lamarans';

    protected $fillable = [
        'lowongan_id',
        'pelamar_id',
        'status_lamaran',
        'pesan',
        'feedback',
    ];

    // Relasi ke Lowongan
    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id', 'id');
    }

    // Relasi ke Pelamar (Profil) - INI YANG PENTING
    public function pelamar(): BelongsTo
    {
        return $this->belongsTo(PelamarProfil::class, 'pelamar_id');
    }

    // --- Helper Attributes (Akses: $lamaran->status_badge) ---

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending'  => 'bg-yellow-100 text-yellow-800',
            'diterima' => 'bg-green-100 text-green-800',
            'ditolak'  => 'bg-red-100 text-red-800',
            'accepted' => 'bg-green-100 text-green-800', // Jaga-jaga jika ada status bahasa inggris
            'rejected' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->status_lamaran] ?? 'bg-gray-100 text-gray-800';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending'  => 'Menunggu',
            'diterima' => 'Diterima',
            'ditolak'  => 'Ditolak',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
        ];

        return $labels[$this->status_lamaran] ?? 'Tidak Diketahui';
    }
}
