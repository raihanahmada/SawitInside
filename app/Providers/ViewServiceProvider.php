<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Target '*' agar setting tersedia di SEMUA view (app.blade, home.blade, register.blade)
        View::composer('*', function ($view) {

            // Mengambil dan menyimpan setting di cache selama 24 jam (60*60*24 detik)
            $global_settings = Cache::remember('global_settings', 60*60*24, function () {
                return Setting::pluck('value', 'key')->toArray();
            });

            $view->with('global_settings', $global_settings);
        });
    }
}
