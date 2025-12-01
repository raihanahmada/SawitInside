<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PelamarController; // Import PelamarController
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController; // Pastikan ini ada
use App\Http\Controllers\AdminController;
Route::get('/', function () {
    return view('public.home');
});
// routes/web.php

//PROSES REGISTRASI
// 1. Halaman Pilihan Role
Route::get('/register', [RegisterController::class, 'showRoleChoice'])->name('register');

// 2. Form Registrasi Pelamar
Route::get('/register/pelamar', [RegisterController::class, 'showRegistrationForm'])->name('register.pelamar.form');

// 3. Form Registrasi Pemilik Kebun
Route::get('/register/pemilik', [RegisterController::class, 'showRegistrationForm'])->name('register.pemilik.form');

// 4. Proses Penyimpanan Data (Universal)
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
// --- ROUTE AUTENTIKASI (LOGIN & LOGOUT) ---

//PROSES LOGIN
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

// --- ROUTE UNTUK ADMIN ---
// Middleware: Hanya bisa diakses jika sudah login dan role-nya 'admin'
Route::middleware(['auth','role:admin'])->prefix('admin')->group(function () {

    // 1. Dashboard Utama
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // 2. Verifikasi & Konfirmasi
    Route::get('/verifikasi/pemilik', [AdminController::class, 'ownerPending'])->name('admin.owner_pending');
    Route::get('/konfirmasi/lowongan', [AdminController::class, 'lowonganPending'])->name('admin.lowongan_pending');
    // Route untuk menyetujui Pemilik Kebun (Mengubah status menjadi 'approved')
    Route::post('/verifikasi/approve/{user}', [AdminController::class, 'approveOwner'])->name('admin.approve_owner');
    // Route untuk menolak Pemilik Kebun (Mengubah status menjadi 'rejected')
    Route::post('/verifikasi/reject/{user}', [AdminController::class, 'rejectOwner'])->name('admin.reject_owner');
    // Route untuk menampilkan detail satu Pemilik Kebun (GET)
    // Kita gunakan parameter {user} karena AdminController@ownerPending mengambil User model
    Route::get('/verifikasi/detail/{user}', [AdminController::class, 'showOwnerDetail'])->name('admin.owner_detail');

    // 3. Manajemen Data
    Route::get('/data/pemilik-verif', [AdminController::class, 'ownerVerified'])->name('admin.owner_verified');
    Route::get('/data/pelamar', [AdminController::class, 'applicants'])->name('admin.applicants');
    Route::get('/data/lowongan-aktif', [AdminController::class, 'vacanciesActive'])->name('admin.vacancies_active');
    Route::get('/data/lowongan-pending', [AdminController::class, 'vacanciesPending'])->name('admin.lowongan_pending'); // Sudah di atas, tapi kita biarkan untuk lengkap

    // 4. Pengaturan Sistem
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/settings/lowongan-pending', [AdminController::class, 'lowonganPending'])->name('admin.lowongan_pending'); // Route duplikat tapi kita biarkan dulu
});
