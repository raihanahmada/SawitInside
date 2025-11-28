<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PelamarProfil extends Model
{
    use HasFactory;

    // Default nama tabel di Laravel adalah bentuk plural dari nama Model (pelamar_profils)

    /**
     * Kolom yang bisa diisi massal.
     */
    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'usia',
        'jenis_kelamin',
        'pengalaman',
        'kontak',
    ];

    // ------------------------------------------------------------------
    // RELASI
    // ------------------------------------------------------------------

    /**
     * Relasi Balik: Setiap Profil Pelamar dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        // Menghubungkan pelamar_profils.user_id kembali ke users.id
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
