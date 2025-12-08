<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckUserRole; // <-- PASTIKAN IMPORT INI ADA

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        // ... middleware lainnya ...
        'checkuserrole' => \App\Http\Middleware\CheckUserRole::class,
        // atau jika sudah pakai nama 'role':
        'role' => \App\Http\Middleware\CheckUserRole::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
