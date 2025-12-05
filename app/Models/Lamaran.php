<?php
namespace App\Models;
use App\Models\Lowongan;
use App\Models\PelamarProfil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lamaran extends Model
{
    protected $fillable = [
        'lowongan_id', 'pelamar_id', 'status_lamaran',
    ];

    // Relasi M:1 ke Lowongan (Sudah Benar)
    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id', 'id');
    }

    // Relasi M:1 ke PelamarProfil (Sudah Benar)
    public function pelamar(): BelongsTo
    {
        return $this->belongsTo(PelamarProfil::class, 'pelamar_id', 'id');
    }

}
