<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    public function handle($request, Closure $next, $activity = null)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id'    => Auth::id(),
                'activity'   => $activity ?? $request->path(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $next($request);
    }
}

