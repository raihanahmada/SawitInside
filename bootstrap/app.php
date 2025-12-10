<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckUserRole; // <-- PASTIKAN IMPORT INI ADA

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // --- BLOK INI ADALAH TEMPAT UNTUK MENAMBAH MIDDEWARE ---

        $middleware->alias([
            'role' => CheckUserRole::class, // <-- ALIAS BARU ANDA TERDAFTAR DI SINI
            'log.activity' => \App\Http\Middleware\LogActivity::class,
        ]);

        // Jika Anda memiliki middleware group atau middleware global lain, daftarkan di sini

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
