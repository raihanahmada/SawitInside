<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function lamarans(): HasMany
    {
        // Menghubungkan pelamar_profils.id (PK) dengan lamarans.pelamar_id (FK)
        return $this->hasMany(Lamaran::class, 'pelamar_id', 'id');
    }
    public function user(): BelongsTo
    {
        // Menghubungkan pelamar_profils.user_id kembali ke users.id
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
