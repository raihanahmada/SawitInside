@extends('layouts.pelamar')

@section('title', 'Data Diri')

@section('styles')
<style>
    .profile-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        text-align: center;
        padding: 40px 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .profile-avatar-large {
        width: 100px;
        height: 100px;
        background-color: #d1fae5;
        color: #059669;
        font-size: 40px;
        font-weight: bold;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 0 0 8px rgba(209, 250, 229, 0.3);
        overflow: hidden; /* Tambahan agar gambar tidak keluar */
    }

    /* Tambahan agar gambar full */
    .profile-avatar-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-card {
        background: white;
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .form-header {
        background: #fff;
        padding: 25px 30px;
        border-bottom: 1px solid #f3f4f6;
    }

    .input-group-text {
        background-color: #f9fafb;
        border-color: #e5e7eb;
        color: #6b7280;
    }

    .form-control, .form-select {
        border-color: #e5e7eb;
        padding: 12px 15px;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    /* Readonly inputs look different */
    .form-control:disabled, .form-control[readonly] {
        background-color: #f3f4f6;
        opacity: 0.7;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-2">

    <div class="row g-4">

        {{-- KOLOM KIRI: VISUAL PROFIL --}}
        <div class="col-lg-4" data-aos="fade-right">
            <div class="profile-card h-100">

                {{-- 🖼️ AVATAR PROFIL (LOGIKA BARU) --}}
                <div class="profile-avatar-large">
                    @if(Auth::user()->google_avatar)
                        {{-- 1. Tampilkan Avatar Google --}}
                        <img src="{{ Auth::user()->google_avatar }}" alt="Google Avatar" referrerpolicy="no-referrer">
                    @elseif($profil && $profil->foto)
                        {{-- 2. Tampilkan Foto Upload Manual (Jika nanti ada fitur upload) --}}
                        <img src="{{ asset('storage/' . $profil->foto) }}" alt="Foto Profil">
                    @else
                        {{-- 3. Fallback: Inisial Nama --}}
                        {{ strtoupper(substr($profil->nama ?? auth()->user()->username ?? 'P', 0, 1)) }}
                    @endif
                </div>

                <h4 class="fw-bold text-dark mb-1">{{ $profil->nama ?? auth()->user()->username }}</h4>
                <p class="text-muted small mb-4">{{ auth()->user()->email }}</p>

                <hr class="my-4 opacity-10">

                <div class="d-flex justify-content-between px-4 mb-3">
                    <span class="text-muted small">Status Profil</span>
                    @if($profil)
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Lengkap</span>
                    @else
                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">Belum Lengkap</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between px-4">
                    <span class="text-muted small">Terakhir Update</span>
                    <span class="text-dark small fw-bold">
                        {{ $profil ? $profil->updated_at->diffForHumans() : '-' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: FORMULIR --}}
        <div class="col-lg-8" data-aos="fade-left">
            <div class="card form-card">
                <div class="form-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold m-0 text-dark">Informasi Data Diri</h5>
                        <p class="text-muted small m-0">Pastikan data yang Anda masukkan valid untuk memudahkan verifikasi.</p>
                    </div>
                    <i class="fas fa-user-edit text-success fs-4 opacity-50"></i>
                </div>

                <div class="card-body p-4">

                    {{-- Alert Messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 mb-4">
                            <div class="d-flex">
                                <i class="fas fa-exclamation-circle me-3 mt-1"></i>
                                <div>
                                    <strong>Ups! Ada kesalahan input:</strong>
                                    <ul class="mb-0 mt-1 ps-3 small">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-3 mb-4 d-flex align-items-center">
                            <i class="fas fa-check-circle me-3 fs-5"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pelamar.datadiri.simpan') }}">
                        @csrf

                        {{-- Bagian 1: Identitas Utama --}}
                        <h6 class="text-uppercase text-muted small fw-bold mb-3 ls-1">Identitas Pribadi</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap"
                                           value="{{ old('nama', $profil->nama ?? auth()->user()->username ?? '') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Jenis Kelamin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="">Pilih...</option>
                                        <option value="L" {{ (old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'L') ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ (old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'P') ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Usia</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                                    <input type="number" name="usia" class="form-control" placeholder="Contoh: 25"
                                           value="{{ old('usia', $profil->usia ?? '') }}" min="18" max="65" required>
                                    <span class="input-group-text bg-white text-muted">Tahun</span>
                                </div>
                            </div>
                        </div>

                        {{-- Bagian 2: Kontak --}}
                        <h6 class="text-uppercase text-muted small fw-bold mb-3 mt-4 ls-1">Informasi Kontak</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Nomor HP / WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="kontak" class="form-control" placeholder="08xxxxxxxxxx"
                                           value="{{ old('kontak', $profil->kontak ?? '') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control"
                                           value="{{ auth()->user()->email ?? '' }}" readonly disabled>
                                    <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                                </div>
                                <div class="form-text small">Email tidak dapat diubah (akun login).</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Alamat Domisili</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea name="alamat" class="form-control" rows="2" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan..." required>{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Bagian 3: Profesional --}}
                        <h6 class="text-uppercase text-muted small fw-bold mb-3 mt-4 ls-1">Kualifikasi</h6>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary">Pengalaman Kerja</label>
                            <textarea name="pengalaman" class="form-control" rows="4" placeholder="Ceritakan pengalaman kerja Anda secara singkat...">{{ old('pengalaman', $profil->pengalaman ?? '') }}</textarea>
                            <div class="d-flex align-items-start mt-2">
                                <i class="fas fa-info-circle text-info me-2 mt-1"></i>
                                <span class="text-muted small">Contoh: "Saya berpengalaman sebagai pemanen sawit selama 3 tahun di PT Sawit Makmur, mampu menggunakan egrek dengan baik."</span>
                            </div>
                        </div>

                        <hr class="my-4 border-light">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('pelamar.dashboard') }}" class="btn btn-light border text-muted px-4 py-2 fw-bold">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm" style="background-color: #059669; border-color: #059669;">
                                <i class="fas fa-save me-2"></i> Simpan Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
