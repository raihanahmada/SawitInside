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
        'feedback'
    ];

    // Relasi M:1 ke Lowongan (Sudah Benar)
    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id', 'id');
    }

    // Relasi M:1 ke User (pelamar)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pelamar_id', 'id');
    }

    // Helper method untuk status badge
    public function getStatusBadgeAttribute(){
         $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'diterima' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->status_lamaran] ?? 'bg-gray-100 text-gray-800';
    }
    // Relasi M:1 ke PelamarProfil (Sudah Benar)

    // Helper method untuk label status
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
        ];

        return $labels[$this->status_lamaran] ?? 'Tidak Diketahui';
    }

}
