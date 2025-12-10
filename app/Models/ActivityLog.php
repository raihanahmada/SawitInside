<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 
        'activity', 
        'ip_address', 
        'user_agent'
    ];

    /**
     * Tambahkan catatan log aktivitas
     */
    public static function addToLog($message)
    {
        self::create([
            'user_id'   => Auth::id(),
            'activity'  => $message,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ]);
    }
}
