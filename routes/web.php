<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pelamar\PelamarController;
use App\Http\Controllers\Pelamar\HistoryController;
use App\Http\Controllers\Pelamar\LowonganController;
use Illuminate\Support\Facades\Route;

// --- ROUTE PUBLIC ---
Route::get('/', function () {
    return view('public.home');
});

// --- ROUTE REGISTRASI ---
Route::get('/register', [RegisterController::class, 'showRoleChoice'])->name('register');
Route::get('/register/pelamar', [RegisterController::class, 'showRegistrationForm'])->name('register.pelamar.form');
Route::get('/register/pemilik', [RegisterController::class, 'showRegistrationForm'])->name('register.pemilik.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// --- ROUTE AUTENTIKASI ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- ROUTE UNTUK PELAMAR ---
Route::middleware(['auth','role:pelamar'])->prefix('pelamar')->name('pelamar.')->group(function () {
    // DASHBOARD & PROFIL
    Route::get('/dashboard', [PelamarController::class, 'index'])->name('dashboard');
    Route::get('/profil', [PelamarController::class, 'profil'])->name('profil');

    // LOWONGAN
    Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan');
    Route::get('/lowongan/{id}', [LowonganController::class, 'detail'])->name('lowongan.detail');
    Route::post('/lowongan/{id}/lamar', [LowonganController::class, 'lamar'])->name('lamar');

    // DATA DIRI
   Route::get('/data-diri', [PelamarController::class, 'dataDiri'])->name('datadiri');
    Route::post('/data-diri', [PelamarController::class, 'simpanDataDiri'])->name('datadiri.simpan');
    
    // LAMARAN DETAIL & AKSI
    Route::get('/lamaran/{id}', [PelamarController::class, 'detailLamaran'])->name('lamaran.detail');
    Route::delete('/lamaran/{id}/batalkan', [PelamarController::class, 'batalkanLamaran'])->name('lamaran.batalkan');

    // FILE & FOTO
    Route::post('/update-foto', [PelamarController::class, 'updateFoto'])->name('update.foto');
    Route::get('/download-cv', [PelamarController::class, 'downloadCV'])->name('download.cv');

    // HISTORY ROUTES
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    Route::get('/history/{id}', [HistoryController::class, 'show'])->name('history.detail');
    Route::get('/history/export', [HistoryController::class, 'export'])->name('history.export');
    Route::delete('/history/{id}', [HistoryController::class, 'destroy'])->name('history.destroy');

    // API ROUTES
    Route::get('/api/history-statistik', [HistoryController::class, 'getStatistik'])->name('history.statistik');
});
