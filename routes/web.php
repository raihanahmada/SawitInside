<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\AdminController;

// ===========================
// PEMILIK KEBUN
// ===========================
Route::middleware(['auth', 'role:pemilik'])
    ->prefix('pemilik')
    ->name('pemilik.')
    ->group(function () {

        Route::get('/dashboard', [PemilikController::class, 'index'])
            ->middleware('log.activity:Buka dashboard pemilik')
            ->name('dashboard');

        // CRUD Lowongan
        Route::get('/lowongan', [PemilikController::class, 'lowonganIndex'])
            ->middleware('log.activity:Lihat daftar lowongan')
            ->name('lowongan.index');

        Route::get('/lowongan/create', [PemilikController::class, 'lowonganCreate'])
            ->middleware('log.activity:Buka form tambah lowongan')
            ->name('lowongan.create');

        Route::post('/lowongan', [PemilikController::class, 'lowonganStore'])
            ->middleware('log.activity:Tambah lowongan baru')
            ->name('lowongan.store');

        Route::get('/lowongan/{id}/edit', [PemilikController::class, 'lowonganEdit'])
            ->middleware('log.activity:Buka form edit lowongan')
            ->name('lowongan.edit');

        Route::put('/lowongan/{id}', [PemilikController::class, 'lowonganUpdate'])
            ->middleware('log.activity:Update lowongan')
            ->name('lowongan.update');

        Route::delete('/lowongan/{id}', [PemilikController::class, 'lowonganDestroy'])
            ->middleware('log.activity:Hapus lowongan')
            ->name('lowongan.destroy');

        // Lamaran
        Route::get('/lowongan/{id}/lamaran', [PemilikController::class, 'cekLamaran'])
            ->middleware('log.activity:Lihat lamaran masuk')
            ->name('lowongan.lamaran');

        Route::post('/lamaran/{id}/accept', [PemilikController::class, 'acceptLamaran'])
            ->middleware('log.activity:Terima lamaran')
            ->name('lamaran.accept');

        Route::post('/lamaran/{id}/reject', [PemilikController::class, 'rejectLamaran'])
            ->middleware('log.activity:Tolak lamaran')
            ->name('lamaran.reject');

        // Data Diri
        Route::get('/data-diri', [PemilikController::class, 'dataDiri'])
            ->middleware('log.activity:Buka data diri pemilik')
            ->name('dataDiri');

        Route::post('/data-diri', [PemilikController::class, 'simpanDataDiri'])
            ->middleware('log.activity:Update data diri pemilik')
            ->name('simpan_dataDiri');

        // History
        Route::get('/history', [PemilikController::class, 'history'])
            ->middleware('log.activity:Buka riwayat aktivitas pemilik')
            ->name('history');
    });
