@extends('layouts.pelamar')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Cari Lowongan</h2>

    <!-- Filter dan Search -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form action="{{ route('pelamar.lowongan') }}" method="GET" class="d-flex">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                           placeholder="Cari lowongan..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div class="d-flex gap-2">
                <!-- PERBAIKAN 1: Ganti pelamar.lowongan.index -> pelamar.lowongan -->
                <select class="form-select" onchange="window.location.href='{{ route('pelamar.lowongan') }}?status='+this.value">
                    <option value="aktif" {{ request('status', 'aktif') == 'aktif' ? 'selected' : '' }}>
                        Lowongan Aktif
                    </option>
                    <option value="menunggu_acc" {{ request('status') == 'menunggu_acc' ? 'selected' : '' }}>
                        Menunggu ACC
                    </option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>
                </select>

                <!-- PERBAIKAN 2: Ganti pelamar.lowongan.index -> pelamar.lowongan -->
                <select class="form-select" onchange="window.location.href='{{ route('pelamar.lowongan') }}?sort='+this.value">
                    <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>
                        Terbaru
                    </option>
                    <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>
                        Deadline Terdekat
                    </option>
                </select>
            </div>
        </div>
    </div>

    <!-- Card Lowongan -->
    <div class="row">
        @forelse($lowongans as $lowongan)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body d-flex flex-column">
                    <!-- Badge Status -->
                    <div class="mb-2">
                        @php
                            $statusClass = [
                                'aktif' => 'bg-success',
                                'menunggu_acc' => 'bg-warning',
                                'selesai' => 'bg-secondary',
                                'ditolak' => 'bg-danger'
                            ][$lowongan->status] ?? 'bg-secondary';
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $lowongan->status)) }}</span>
                    </div>

                    <!-- Judul & Perusahaan -->
                    <h5 class="card-title fw-bold text-primary">{{ $lowongan->judul }}</h5>
                    <h6 class="card-subtitle mb-3 text-muted">
                        <i class="bi bi-building"></i> {{ $lowongan->pemilik->nama_perusahaan ?? 'N/A' }}
                    </h6>

                    <!-- Informasi Lowongan -->
                    <div class="mb-3 flex-grow-1">
                        <p class="mb-2">
                            <i class="bi bi-cash-stack"></i>
                            <strong>Upah:</strong> {{ $lowongan->upah ?? 'Negosiasi' }}
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-people"></i>
                            <strong>Kebutuhan:</strong> {{ $lowongan->jumlah_kebutuhan }} orang
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-geo-alt"></i>
                            <strong>Lokasi:</strong> {{ $lowongan->lokasi_kerja ?? 'Tidak ditentukan' }}
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-clock"></i>
                            <strong>Jam Kerja:</strong> {{ $lowongan->jam_kerja ?? 'Tidak ditentukan' }}
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-calendar-x"></i>
                            <strong>Batas Lamar:</strong> {{ \Carbon\Carbon::parse($lowongan->batas_pelamar)->format('d M Y') }}
                        </p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-grid mt-auto">
                        <!-- PERBAIKAN 3: Pastikan route detail ada di web.php -->
                        <a href="{{ route('pelamar.lowongan.detail', $lowongan->id) }}"
                           class="btn btn-primary btn-lg">
                            <i class="bi bi-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Tidak ada lowongan yang ditemukan.
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($lowongans->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <nav>
                {{ $lowongans->withQueryString()->links() }}
            </nav>
        </div>
    </div>
    @endif
</div>

<style>
.card {
    border-radius: 15px;
    transition: transform 0.3s, box-shadow 0.3s;
    border: 1px solid #e0e0e0;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.card-body {
    padding: 1.5rem;
}

.btn-primary {
    background-color: #2d6a4f;
    border-color: #2d6a4f;
    border-radius: 8px;
    padding: 10px;
    font-weight: 500;
}

.btn-primary:hover {
    background-color: #1b4332;
    border-color: #1b4332;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
@endsection
