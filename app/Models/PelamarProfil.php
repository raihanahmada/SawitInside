<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function user(): BelongsTo
    {
        // Menghubungkan pelamar_profils.user_id kembali ke users.id
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Check if profile is complete
     */
    public function lamarans(): HasMany
    {
        // Menghubungkan pelamar_profils.id (PK) dengan lamarans.pelamar_id (FK)
        return $this->hasMany(Lamaran::class, 'pelamar_id', 'id');
    }

}
