<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // Kita hanya mengizinkan dua kolom ini diisi
    protected $fillable = ['key', 'value'];
}
