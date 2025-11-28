<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PelamarController; // Import PelamarController
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController; // Pastikan ini ada
Route::get('/', function () {
    return view('public.home');
});
// routes/web.php


// 1. Halaman Pilihan Role
Route::get('/register', [RegisterController::class, 'showRoleChoice'])->name('register');

// 2. Form Registrasi Pelamar
Route::get('/register/pelamar', [RegisterController::class, 'showRegistrationForm'])->name('register.pelamar.form');

// 3. Form Registrasi Pemilik Kebun
Route::get('/register/pemilik', [RegisterController::class, 'showRegistrationForm'])->name('register.pemilik.form');

// 4. Proses Penyimpanan Data (Universal)
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
// --- ROUTE AUTENTIKASI (LOGIN & LOGOUT) ---

// 1. Tampilkan Form Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// 2. Proses Otentikasi (Login)
Route::post('/login', [LoginController::class, 'login']);

// 3. Proses Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// --- ROUTE UNTUK PELAMAR ---

// Group Route untuk Pelamar (Hanya bisa diakses jika sudah login)
Route::middleware(['auth','role:pelamar'])->prefix('pelamar')->group(function () {
    // Dashboard Pelamar
    Route::get('/dashboard', [PelamarController::class, 'index'])->name('pelamar.dashboard');

    // Menu Lowongan
    Route::get('/lowongan', [PelamarController::class, 'lowongan'])->name('pelamar.lowongan'); // BARU

    // Menu History Lowongan
    Route::get('/history', [PelamarController::class, 'history'])->name('pelamar.history'); // BARU

    // Menu Data Diri

    Route::get('/data-diri', [PelamarController::class, 'dataDiri'])->name('pelamar.datadiry');

    // Proses Simpan Data Diri (POST - Simpan/Update)
    Route::post('/data-diri', [PelamarController::class, 'simpanDataDiri'])->name('pelamar.simpan_datadiry');
});
