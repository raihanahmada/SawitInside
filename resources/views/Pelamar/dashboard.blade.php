@extends('layouts.pelamar')

@section('title', 'Dashboard Pelamar')

@section('styles')
<style>
    /* Custom Modern Styles untuk Dashboard */
    .welcome-banner {
        background: linear-gradient(135deg, #059669 0%, #0d9488 100%); /* Emerald to Teal */
        border-radius: 20px;
        padding: 40px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.4);
        margin-bottom: 40px;
    }

    .welcome-decoration {
        position: absolute;
        top: -20px;
        right: -20px;
        font-size: 150px;
        opacity: 0.1;
        transform: rotate(15deg);
        color: white;
    }

    .stat-card {
        background: white;
        border: 1px solid #f0f0f0;
        border-radius: 16px;
        padding: 25px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: #d1fae5;
    }

    .stat-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 15px;
    }

    /* Varian Warna Card */
    .card-blue .stat-icon-wrapper { background-color: #eff6ff; color: #3b82f6; }
    .card-blue:hover .stat-icon-wrapper { background-color: #3b82f6; color: white; }

    .card-amber .stat-icon-wrapper { background-color: #fffbeb; color: #f59e0b; }
    .card-amber:hover .stat-icon-wrapper { background-color: #f59e0b; color: white; }

    .card-emerald .stat-icon-wrapper { background-color: #ecfdf5; color: #10b981; }
    .card-emerald:hover .stat-icon-wrapper { background-color: #10b981; color: white; }

    .card-dark { background: #1f2937; color: white; border: none; }
    .card-dark .stat-icon-wrapper { background-color: rgba(255,255,255,0.1); color: white; }

    .modern-table {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .modern-table tbody tr {
        background-color: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        transition: transform 0.2s;
    }

    .modern-table tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .modern-table td {
        border-top: 1px solid transparent;
        border-bottom: 1px solid transparent;
        padding: 20px;
    }

    .modern-table td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .modern-table td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .avatar-initial {
        width: 45px;
        height: 45px;
        background-color: #d1fae5;
        color: #059669;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
    }

    .btn-search-hero {
        background: white;
        color: #059669;
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-search-hero:hover {
        background: #f0fdf4;
        transform: scale(1.05);
        color: #047857;
    }
</style>
@endsection

@section('content')

{{-- 1. WELCOME HEADER --}}
<div class="welcome-banner" data-aos="fade-down">
    <div class="welcome-decoration">
        <i class="fas fa-leaf"></i>
    </div>
    <div class="position-relative">
        <h1 class="fw-bold mb-2">Halo, {{ Auth::user()->pelamar_profil->nama ?? Auth::user()->username }} 👋</h1>
        <p class="lead mb-4 opacity-75" style="font-size: 1.1rem;">
            Selamat datang kembali. Pantau lamaran Anda dan temukan peluang karir terbaik di perkebunan sawit hari ini.
        </p>
        <a href="{{ route('pelamar.lowongan') }}" class="btn-search-hero text-decoration-none shadow">
            <i class="fas fa-search me-2"></i> Cari Lowongan Baru
        </a>
    </div>
</div>

{{-- 2. STATISTIK CARDS --}}
<div class="row g-4 mb-5">

    {{-- Card 1: Total Lamaran --}}
    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
        <div class="stat-card card-blue">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-uppercase text-muted fw-bold small mb-1">Total Lamaran</div>
                    <h2 class="fw-bold text-primary mb-0">{{ $totalLamaran }}</h2>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
            <hr class="my-3 opacity-25">
            <a href="{{ route('pelamar.history') }}" class="text-decoration-none small fw-bold text-primary">
                Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    {{-- Card 2: Menunggu --}}
    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-card card-amber">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-uppercase text-muted fw-bold small mb-1">Menunggu</div>
                    <h2 class="fw-bold text-warning mb-0">{{ $menunggu }}</h2>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <hr class="my-3 opacity-25">
            <a href="{{ route('pelamar.history') }}" class="text-decoration-none small fw-bold text-warning">
                Cek Status <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    {{-- Card 3: Diterima --}}
    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
        <div class="stat-card card-emerald">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-uppercase text-muted fw-bold small mb-1">Diterima</div>
                    <h2 class="fw-bold text-success mb-0">{{ $diterima }}</h2>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <hr class="my-3 opacity-25">
            <a href="{{ route('pelamar.history') }}" class="text-decoration-none small fw-bold text-success">
                Lihat Tawaran <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    {{-- Card 4: Lowongan Aktif --}}
    <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
        <div class="stat-card card-dark">
            <div class="position-absolute bottom-0 end-0 p-3 opacity-25">
                <i class="fas fa-briefcase fa-4x"></i>
            </div>
            <div class="position-relative">
                <div class="text-uppercase fw-bold small mb-1 opacity-75">Lowongan Aktif</div>
                <h2 class="fw-bold mb-3">{{ $lowonganAktif }}</h2>
                <a href="{{ route('pelamar.lowongan') }}" class="btn btn-sm btn-light fw-bold rounded-pill px-3">
                    Jelajahi <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- 3. LOWONGAN TERBARU --}}
    <div class="col-lg-8" data-aos="fade-right" data-aos-delay="400">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold text-dark m-0">Lowongan Terbaru</h5>
            <a href="{{ route('pelamar.lowongan') }}" class="text-decoration-none small fw-bold text-success">
                Lihat Semua
            </a>
        </div>

        @if(count($lowonganTerbaru) > 0)
            <div class="table-responsive">
                <table class="table table-borderless modern-table w-100">
                    <tbody>
                        @foreach($lowonganTerbaru as $lowongan)
                        <tr>
                            <td width="60">
                                <div class="avatar-initial">
                                    {{ substr($lowongan->pemilik->nama_perusahaan ?? ($lowongan->pemilik->nama_pemilik ?? 'U'), 0, 1) }}
                                </div>
                            </td>
                            <td>
                                <h6 class="fw-bold mb-1 text-dark">{{ $lowongan->judul }}</h6>
                                <small class="text-muted">{{ $lowongan->pemilik->nama_perusahaan ?? ($lowongan->pemilik->nama_pemilik ?? 'N/A') }}</small>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i> {{ $lowongan->lokasi_kerja ?? '-' }}
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <div class="d-flex align-items-center text-success small fw-bold">
                                    <i class="fas fa-money-bill-wave me-2"></i> {{ $lowongan->upah ?? 'Negosiasi' }}
                                </div>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('pelamar.lowongan.detail', $lowongan->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5 bg-white rounded-4 shadow-sm border border-light">
                <div class="bg-light d-inline-flex p-4 rounded-circle mb-3">
                    <i class="fas fa-search fa-2x text-secondary"></i>
                </div>
                <h5 class="fw-bold text-dark">Belum ada lowongan baru</h5>
                <p class="text-muted small">Coba cari lowongan di menu pencarian.</p>
                <a href="{{ route('pelamar.lowongan') }}" class="btn btn-success rounded-pill px-4">Cari Lowongan</a>
            </div>
        @endif
    </div>

    {{-- 4. AKTIVITAS TERAKHIR (SIDEBAR KANAN) --}}
    <div class="col-lg-4" data-aos="fade-left" data-aos-delay="500">
        <div class="bg-white p-4 rounded-4 shadow-sm border border-light h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-dark m-0">Lamaran Anda</h5>
                <a href="{{ route('pelamar.history') }}" class="text-decoration-none small fw-bold text-success">Semua</a>
            </div>

            @if(count($lamaranTerbaru) > 0)
                <div class="d-flex flex-column gap-3">
                    @foreach($lamaranTerbaru as $lamaran)
                    <div class="p-3 border rounded-3 bg-light position-relative">
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted"><i class="far fa-clock me-1"></i> {{ $lamaran->created_at->format('d M Y') }}</small>
                            @php
                                $status = strtolower($lamaran->status_lamaran);
                                $badgeClass = match($status) {
                                    'diterima' => 'bg-success',
                                    'ditolak' => 'bg-danger',
                                    default => 'bg-warning text-dark'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} rounded-pill" style="font-size: 10px;">
                                {{ ucfirst($status) }}
                            </span>
                        </div>
                        <h6 class="fw-bold mb-1 text-dark text-truncate">{{ $lamaran->lowongan->judul ?? 'Lowongan Dihapus' }}</h6>
                        <p class="small text-muted mb-2 text-truncate">{{ $lamaran->lowongan->pemilik->nama_perusahaan ?? 'Perusahaan' }}</p>
                        <a href="{{ route('pelamar.history') }}" class="stretched-link text-decoration-none small fw-bold text-secondary">
                            Lihat Status &rarr;
                        </a>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-muted small mb-3">Belum ada riwayat lamaran.</p>
                    <a href="{{ route('pelamar.lowongan') }}" class="btn btn-sm btn-outline-primary rounded-pill">Ajukan Lamaran</a>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
