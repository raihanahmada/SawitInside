@extends('layouts.pelamar')

@section('title', 'Riwayat Lamaran')

@section('styles')
<style>
    .stat-card-modern {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s;
        overflow: hidden;
        position: relative;
    }
    .stat-card-modern:hover {
        transform: translateY(-5px);
    }
    .stat-card-modern .icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 80px;
        opacity: 0.1;
        transform: rotate(15deg);
    }

    .application-card {
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        transition: all 0.3s;
        background: white;
    }
    .application-card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: #d1fae5; /* Emerald border on hover */
    }

    .company-avatar {
        width: 50px;
        height: 50px;
        background-color: #ecfdf5;
        color: #059669;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 20px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">

    {{-- 1. HEADER & STATISTIK --}}
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
        <div>
            <h2 class="fw-bold text-dark mb-1">Riwayat Lamaran</h2>
            <p class="text-muted small">Pantau status semua lamaran kerja yang telah Anda kirimkan.</p>
        </div>
        <a href="{{ route('pelamar.lowongan') }}" class="btn btn-outline-success rounded-pill btn-sm px-4">
            <i class="fas fa-plus me-2"></i> Lamaran Baru
        </a>
    </div>

    <div class="row g-4 mb-5">
        {{-- Card Total --}}
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
            <div class="card stat-card-modern bg-primary text-white h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="icon-bg"><i class="fas fa-file-alt"></i></div>
                    <h2 class="fw-bold mb-0 display-5">{{ $counts['total'] }}</h2>
                    <p class="mb-0 opacity-75 fw-medium">Total Lamaran Dikirim</p>
                </div>
            </div>
        </div>
        {{-- Card Menunggu --}}
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card stat-card-modern bg-warning text-dark h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="icon-bg text-dark"><i class="fas fa-clock"></i></div>
                    <h2 class="fw-bold mb-0 display-5">{{ $counts['menunggu'] }}</h2>
                    <p class="mb-0 opacity-75 fw-medium">Menunggu Konfirmasi</p>
                </div>
            </div>
        </div>
        {{-- Card Diterima --}}
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card stat-card-modern bg-success text-white h-100 shadow-sm">
                <div class="card-body p-4">
                    <div class="icon-bg"><i class="fas fa-check-circle"></i></div>
                    <h2 class="fw-bold mb-0 display-5">{{ $counts['diterima'] }}</h2>
                    <p class="mb-0 opacity-75 fw-medium">Lamaran Diterima</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. DAFTAR LAMARAN --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" data-aos="fade-up" data-aos-delay="300">
        <div class="card-header bg-white py-3 border-bottom border-light">
            <div class="d-flex align-items-center">
                <i class="fas fa-list-ul text-success me-2"></i>
                <h5 class="card-title mb-0 fw-bold text-dark">Daftar Lamaran Anda</h5>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="list-group list-group-flush">
                @forelse($lamarans as $lamaran)
                    <div class="list-group-item p-4 border-bottom hover-bg-light transition">
                        <div class="row align-items-center">
                            {{-- Kolom 1: Icon & Info Utama --}}
                            <div class="col-md-6 mb-3 mb-md-0 d-flex align-items-center">
                                <div class="company-avatar me-3 flex-shrink-0">
                                    {{ substr($lamaran->lowongan->pemilik->nama_perusahaan ?? ($lamaran->lowongan->pemilik->nama_pemilik ?? 'U'), 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">
                                        <a href="{{ route('pelamar.lowongan.detail', $lamaran->lowongan_id) }}" class="text-decoration-none text-dark hover-text-success">
                                            {{ $lamaran->lowongan->judul ?? 'Lowongan Tidak Tersedia' }}
                                        </a>
                                    </h5>
                                    <div class="text-muted small">
                                        <i class="fas fa-building me-1 text-secondary"></i>
                                        {{ $lamaran->lowongan->pemilik->nama_perusahaan ?? ($lamaran->lowongan->pemilik->nama_pemilik ?? 'Perusahaan Tidak Diketahui') }}
                                    </div>
                                </div>
                            </div>

                            {{-- Kolom 2: Tanggal --}}
                            <div class="col-md-3 mb-3 mb-md-0">
                                <div class="text-muted small mb-1">Tanggal Melamar</div>
                                <div class="fw-medium text-dark">
                                    <i class="far fa-calendar-alt me-1 text-primary"></i>
                                    {{ $lamaran->created_at->translatedFormat('d M Y') }}
                                </div>
                                <div class="text-muted small" style="font-size: 0.75rem;">
                                    {{ $lamaran->created_at->format('H:i') }} WIB
                                </div>
                            </div>

                            {{-- Kolom 3: Status & Aksi --}}
                            <div class="col-md-3 text-md-end">
                                @php
                                    $status = strtolower($lamaran->status_lamaran);
                                    $badgeClass = match($status) {
                                        'diterima' => 'bg-success bg-opacity-10 text-success border border-success border-opacity-25',
                                        'ditolak' => 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25',
                                        'pending' => 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25',
                                        'menunggu' => 'bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25',
                                        default => 'bg-secondary bg-opacity-10 text-secondary'
                                    };
                                    $icon = match($status) {
                                        'diterima' => 'fa-check-circle',
                                        'ditolak' => 'fa-times-circle',
                                        default => 'fa-hourglass-half'
                                    };
                                    $label = match($status) {
                                        'pending' => 'Menunggu',
                                        'menunggu' => 'Menunggu',
                                        'diterima' => 'Diterima',
                                        'ditolak' => 'Ditolak',
                                        default => ucfirst($status)
                                    };
                                @endphp

                                <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill fw-bold mb-2 d-inline-flex align-items-center">
                                    <i class="fas {{ $icon }} me-1"></i> {{ $label }}
                                </span>

                                <div class="mt-1">
                                    <a href="{{ route('pelamar.lowongan.detail', $lamaran->lowongan_id) }}" class="text-decoration-none small text-muted hover-text-primary">
                                        Detail Lowongan <i class="fas fa-chevron-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- EMPTY STATE --}}
                    <div class="text-center py-5">
                        <div class="bg-light d-inline-flex p-4 rounded-circle mb-3">
                            <i class="fas fa-folder-open fa-3x text-secondary opacity-50"></i>
                        </div>
                        <h5 class="text-dark fw-bold">Belum ada riwayat lamaran</h5>
                        <p class="text-muted mb-4">Anda belum mengajukan lamaran untuk posisi apapun saat ini.</p>
                        <a href="{{ route('pelamar.lowongan') }}" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                            <i class="fas fa-search me-2"></i> Cari Lowongan Sekarang
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($lamarans->hasPages())
                <div class="card-footer bg-white py-3 border-top border-light">
                    <div class="d-flex justify-content-center">
                        {{ $lamarans->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
