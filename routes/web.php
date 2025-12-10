<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\AdminController;


// ===========================
// PUBLIC
// ===========================
Route::get('/', function () {
    return view('public.home');
});


// ===========================
// REGISTER
// ===========================
Route::get('/register', [RegisterController::class, 'showRoleChoice'])
    ->middleware('log.activity:Pilih role registrasi')
    ->name('register');

Route::get('/register/pelamar', [RegisterController::class, 'showRegistrationForm'])
    ->middleware('log.activity:Buka form registrasi pelamar')
    ->name('register.pelamar.form');

Route::get('/register/pemilik', [RegisterController::class, 'showRegistrationForm'])
    ->middleware('log.activity:Buka form registrasi pemilik kebun')
    ->name('register.pemilik.form');

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('log.activity:Registrasi akun baru')
    ->name('register.post');


// ===========================
// LOGIN / LOGOUT
// ===========================
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->middleware('log.activity:Buka halaman login')
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->middleware('log.activity:Proses login');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('log.activity:Logout akun')
    ->name('logout');


// ===========================
// PELAMAR
// ===========================
Route::middleware(['auth', 'role:pelamar'])
    ->prefix('pelamar')
    ->name('pelamar.')
    ->group(function () {

        Route::get('/dashboard', [PelamarController::class, 'index'])
            ->middleware('log.activity:Buka dashboard pelamar')
            ->name('dashboard');

        Route::get('/lowongan', [PelamarController::class, 'lowongan'])
            ->middleware('log.activity:Lihat daftar lowongan')
            ->name('lowongan');

        Route::get('/history', [PelamarController::class, 'history'])
            ->middleware('log.activity:Lihat riwayat lamaran')
            ->name('history');

        Route::get('/data-diri', [PelamarController::class, 'dataDiri'])
            ->middleware('log.activity:Buka data diri pelamar')
            ->name('dataDiri');

        Route::post('/data-diri', [PelamarController::class, 'simpanDataDiri'])
            ->middleware('log.activity:Update data diri pelamar')
            ->name('simpanDataDiri');
    });


// ===========================
// ADMIN
// ===========================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->middleware('log.activity:Buka dashboard admin')
            ->name('dashboard');

        Route::get('/verifikasi/pemilik', [AdminController::class, 'ownerPending'])
            ->middleware('log.activity:Lihat verifikasi pemilik')
            ->name('owner_pending');

        Route::get('/konfirmasi/lowongan', [AdminController::class, 'lowonganPending'])
            ->middleware('log.activity:Lihat lowongan pending')
            ->name('lowongan_pending');

        Route::get('/data/pemilik-verif', [AdminController::class, 'ownerVerified'])
            ->middleware('log.activity:Lihat data pemilik terverifikasi')
            ->name('owner_verified');

        Route::get('/data/pelamar', [AdminController::class, 'applicants'])
            ->middleware('log.activity:Lihat data pelamar')
            ->name('applicants');

        Route::get('/data/lowongan-aktif', [AdminController::class, 'vacanciesActive'])
            ->middleware('log.activity:Lihat lowongan aktif')
            ->name('vacancies_active');

        Route::get('/data/lowongan-pending', [AdminController::class, 'vacanciesPending'])
            ->middleware('log.activity:Lihat lowongan pending')
            ->name('lowongan_pending_alt');

        Route::get('/settings', [AdminController::class, 'settings'])
            ->middleware('log.activity:Buka halaman settings admin')
            ->name('settings');
    });


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
