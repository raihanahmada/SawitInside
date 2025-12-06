<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Pelamar\PelamarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
// Controllers Admin yang sudah di-refactor
use App\Http\Controllers\Admin\ControllerDashboard;
use App\Http\Controllers\Admin\ControllerOwnerPanding; // DIPERBAIKI (Panding -> Pending)
use App\Http\Controllers\Admin\ControllerOwnerManagement;
use App\Http\Controllers\Admin\ControllerDatapelamar;
use App\Http\Controllers\Admin\ControllerLowongan; // Untuk Lowongan
use App\Http\Controllers\ControllerPublic;
use App\Http\Controllers\Pelamar\GoogleAuthController;

// --- ROUTE PUBLIC, REGISTRASI, LOGIN (Tetap Sama) ---
Route::get('/', [ControllerPublic::class, 'index'])->name('public');
Route::get('/register', [RegisterController::class, 'showRoleChoice'])->name('register');
Route::get('/register/pelamar', [RegisterController::class, 'showRegistrationForm'])->name('register.pelamar.form');
Route::get('/register/pemilik', [RegisterController::class, 'showRegistrationForm'])->name('register.pemilik.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// --- PERBAIKI ROUTE LOGIN INI ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); // GET untuk tampilan
Route::post('/login', [LoginController::class, 'login'])->name('login'); // POST untuk proses (TAMBAHKAN ->name('login'))
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// --- GOOGLE AUTH ---
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// --- ROUTE UNTUK PELAMAR ---
Route::middleware(['auth', 'checkuserrole:pelamar'])->prefix('pelamar')->name('pelamar.')->group(function () {
    Route::get('/dashboard', [PelamarController::class, 'index'])->name('dashboard');
    Route::get('/lowongan', [PelamarController::class, 'lowongan'])->name('lowongan');
    Route::get('/lowongan/{id}/detail', [PelamarController::class, 'lowonganDetail'])->name('lowongan.detail');
    Route::get('/history', [PelamarController::class, 'history'])->name('history');
    Route::get('/data-diri', [PelamarController::class, 'dataDiri'])->name('datadiri');
    Route::post('/data-diri', [PelamarController::class, 'simpanDataDiri'])->name('datadiri.simpan');
});

// --- ROUTE UNTUK ADMIN ---
Route::middleware(['auth','role:admin'])->prefix('admin')->group(function () {

    // 1. Dashboard Utama
    Route::get('/dashboard', [ControllerDashboard::class, 'index'])->name('admin.dashboard');

    // 2. Verifikasi & Konfirmasi (Owner Pending - OwnerPanding/Pending)
    Route::get('/verifikasi/pemilik', [ControllerOwnerPanding::class, 'ownerPending'])->name('admin.owner_pending');
    Route::post('/verifikasi/approve/{user}', [ControllerOwnerPanding::class, 'approveOwner'])->name('admin.approve_owner');
    Route::post('/verifikasi/reject/{user}', [ControllerOwnerPanding::class, 'rejectOwner'])->name('admin.reject_owner');
    Route::get('/verifikasi/detail/{user}', [ControllerOwnerPanding::class, 'showOwnerDetail'])->name('admin.owner_detail');

    // Verifikasi Lowongan (Lowongan Pending - ControllerLowongan)
    Route::get('/konfirmasi/lowongan', [ControllerLowongan::class, 'lowonganPending'])->name('admin.lowongan_pending');
    Route::post('/konfirmasi/approve-lowongan/{lowongan}', [ControllerLowongan::class, 'approveVacancy'])->name('admin.approve_vacancy');
    Route::post('/konfirmasi/reject-lowongan/{lowongan}', [ControllerLowongan::class, 'rejectVacancy'])->name('admin.reject_vacancy');
    Route::get('/konfirmasi/detail/{lowongan}', [ControllerLowongan::class, 'showVacancyDetail'])->name('admin.vacancy_detail');


    // 3. Manajemen Data
    // Pemilik Terverifikasi (ControllerOwnerManagement)
    Route::get('/data/pemilik-verif', [ControllerOwnerManagement::class, 'ownerVerified'])->name('admin.owner_verified');
    Route::post('/data/block-owner/{user}', [ControllerOwnerManagement::class, 'blockOwner'])->name('admin.block_owner');
    Route::get('/data/pemilik-blocked', [ControllerOwnerManagement::class, 'ownerBlocked'])->name('admin.owner_blocked');
    Route::post('/data/unblock-owner/{user}', [ControllerOwnerManagement::class, 'unblockOwner'])->name('admin.unblock_owner');
    Route::get('/data/detail/{user}', [ControllerOwnerManagement::class, 'showOwnerDetail'])->name('admin.owner_detail_management');
    Route::get('/data/owner/edit/{user}', [ControllerOwnerManagement::class, 'editOwner'])->name('admin.owner_edit');
    Route::put('/data/owner/update/{user}', [ControllerOwnerManagement::class, 'updateOwner'])->name('admin.owner_update');

    // Pelamar (ControllerDatapelamar)
    Route::get('/data/pelamar', [ControllerDatapelamar::class, 'applicants'])->name('admin.applicants');
    Route::get('/data/pelamar/applications/{user}', [ControllerDatapelamar::class, 'showApplicantApplications'])->name('admin.applicant_applications');
    Route::get('/data/pelamar/edit/{user}', [ControllerDatapelamar::class, 'edit'])->name('admin.applicant_edit');
    Route::put('/data/pelamar/update/{user}', [ControllerDatapelamar::class, 'update'])->name('admin.applicant_update');
    Route::delete('/data/pelamar/delete/{user}', [ControllerDatapelamar::class, 'destroy'])->name('admin.applicant_delete');


    // Lowongan Aktif (ControllerLowongan)
    Route::get('/data/lowongan-aktif', [ControllerLowongan::class, 'vacanciesActive'])->name('admin.vacancies_active');


    // 4. Pengaturan Sistem (Kembalikan ke ControllerLowongan jika AdminController dihapus)
    Route::get('/settings', [ControllerLowongan::class, 'settings'])->name('admin.settings'); // Defaultkan ke ControllerLowongan
});
