@extends('layouts.pelamar')

@section('title', 'Dashboard')
@section('page-title', 'Selamat datang ')
@section('page-subtitle')
    di Dashboard Pelamar, {{ auth()->user()->name }}
@endsection

@section('content')
<div class="row fade-in">
    <!-- Statistik Cards -->
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Total Lamaran</h5>
                        <p class="h2 mb-0">{{ $totalLamaran ?? 0 }}</p>
                    </div>
                    <i class="fas fa-file-alt fa-3x opacity-50"></i>
                </div>
                <a href="{{ route('pelamar.history') }}" class="text-white-50 small d-block mt-3">Lihat detail →</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Diterima</h5>
                        <p class="h2 mb-0">{{ $diterima ?? 0 }}</p>
                    </div>
                    <i class="fas fa-check-circle fa-3x opacity-50"></i>
                </div>
                <a href="{{ route('pelamar.history') }}" class="text-white-50 small d-block mt-3">Lihat detail →</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Menunggu</h5>
                        <p class="h2 mb-0">{{ $menunggu ?? 0 }}</p>
                    </div>
                    <i class="fas fa-clock fa-3x opacity-50"></i>
                </div>
                <a href="{{ route('pelamar.history') }}" class="text-white-50 small d-block mt-3">Lihat detail →</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Lowongan Aktif</h5>
                        <p class="h2 mb-0">{{ $lowonganAktif ?? 0 }}</p>
                    </div>
                    <i class="fas fa-briefcase fa-3x opacity-50"></i>
                </div>
                <a href="{{ route('pelamar.lowongan') }}" class="text-white-50 small d-block mt-3">Cari lowongan →</a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card fade-in">
    <div class="card-header">
        <h5 class="card-title mb-0">Aksi Cepat</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-3">
                <a href="{{ route('pelamar.datadiri') }}" class="card text-center h-100 border-primary hover-shadow">
                    <div class="card-body">
                        <i class="fas fa-user-edit fa-3x text-primary mb-3"></i>
                        <h6 class="card-title">Data Diri</h6>
                        <p class="text-muted small">Lengkapi profil Anda</p>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <a href="{{ route('pelamar.lowongan') }}" class="card text-center h-100 border-success hover-shadow">
                    <div class="card-body">
                        <i class="fas fa-search fa-3x text-success mb-3"></i>
                        <h6 class="card-title">Cari Lowongan</h6>
                        <p class="text-muted small">Temukan pekerjaan</p>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <a href="{{ route('pelamar.history') }}" class="card text-center h-100 border-warning hover-shadow">
                    <div class="card-body">
                        <i class="fas fa-history fa-3x text-warning mb-3"></i>
                        <h6 class="card-title">History Lamaran</h6>
                        <p class="text-muted small">Lihat riwayat</p>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3">
                <a href="#" class="card text-center h-100 border-info hover-shadow">
                    <div class="card-body">
                        <i class="fas fa-cog fa-3x text-info mb-3"></i>
                        <h6 class="card-title">Pengaturan</h6>
                        <p class="text-muted small">Atur akun Anda</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Lowongan Terbaru -->
<div class="card fade-in mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Lowongan Terbaru</h5>
        <a href="{{ route('pelamar.lowongan') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
    </div>
    <div class="card-body">
        @if(isset($lowonganTerbaru) && count($lowonganTerbaru) > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Posisi</th>
                            <th>Lokasi</th>
                            <th>Perusahaan</th>
                            <th>Gaji</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowonganTerbaru as $lowongan)
                        <tr>
                            <td>{{ $lowongan->judul }}</td>
                            <td>{{ $lowongan->lokasi }}</td>
                            <td>{{ $lowongan->perusahaan->nama ?? 'N/A' }}</td>
                            <td>Rp {{ number_format($lowongan->gaji_min) }} - Rp {{ number_format($lowongan->gaji_max) }}</td>
                            <td>
                                <a href="{{ route('pelamar.lowongan.detail', $lowongan->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-briefcase fa-4x text-muted mb-3"></i>
                <p class="text-muted">Belum ada lowongan tersedia</p>
                <a href="{{ route('pelamar.lowongan') }}" class="btn btn-primary">Cari Lowongan</a>
            </div>
        @endif
    </div>
</div>

<!-- Lamaran Terbaru -->
<div class="card fade-in mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Lamaran Terbaru Anda</h5>
        <a href="{{ route('pelamar.history') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
    </div>
    <div class="card-body">
        @if(isset($lamaranTerbaru) && count($lamaranTerbaru) > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Lowongan</th>
                            <th>Tanggal Lamar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lamaranTerbaru as $lamaran)
                        <tr>
                            <td>{{ $lamaran->lowongan->judul ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($lamaran->created_at)->format('d/m/Y') }}</td>
                            <td>
                                @if($lamaran->status == 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($lamaran->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning">Menunggu</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pelamar.lamaran.detail', $lamaran->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                <p class="text-muted">Belum ada riwayat lamaran</p>
                <a href="{{ route('pelamar.lowongan') }}" class="btn btn-primary">Ajukan Lamaran</a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto refresh dashboard setiap 30 detik
    setTimeout(function() {
        window.location.reload();
    }, 30000);
</script>
@endsection
