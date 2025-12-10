@extends('layouts.pelamar')

@section('title', 'Cari Lowongan')

@section('styles')
<style>
    /* Custom CSS untuk Halaman Lowongan */
    .search-container {
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .form-control-search {
        border: 2px solid #f3f4f6;
        border-radius: 10px;
        padding: 12px 20px;
        font-size: 15px;
        transition: all 0.3s;
    }

    .form-control-search:focus {
        border-color: #10b981; /* Emerald-500 */
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .job-card {
        background: white;
        border: 1px solid #f3f4f6;
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .job-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: #d1fae5;
    }

    .company-logo-placeholder {
        width: 50px;
        height: 50px;
        background-color: #ecfdf5; /* Emerald-50 */
        color: #059669; /* Emerald-600 */
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 20px;
        margin-right: 15px;
    }

    .job-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin: 15px 0;
        font-size: 13px;
        color: #6b7280;
    }

    .job-detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f9fafb;
        padding: 8px 12px;
        border-radius: 8px;
    }

    /* Soft Badges */
    .badge-soft-success { background-color: #d1fae5; color: #065f46; }
    .badge-soft-warning { background-color: #fef3c7; color: #92400e; }
    .badge-soft-danger { background-color: #fee2e2; color: #991b1b; }
    .badge-soft-secondary { background-color: #f3f4f6; color: #374151; }

    .btn-detail {
        background-color: #fff;
        color: #059669;
        border: 1px solid #059669;
        border-radius: 10px;
        padding: 10px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-detail:hover {
        background-color: #059669;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-2">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
        <div>
            <h2 class="fw-bold text-dark mb-1">Cari Lowongan</h2>
            <p class="text-muted small mb-0">Temukan pekerjaan impian Anda di sektor perkebunan.</p>
        </div>
    </div>

    {{-- FILTER & SEARCH SECTION --}}
    <div class="search-container" data-aos="fade-up">
        <form action="{{ route('pelamar.lowongan') }}" method="GET">
            <div class="row g-3">
                {{-- Search Input --}}
                <div class="col-lg-9 col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-3 ps-3">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control form-control-search border-start-0 ps-2"
                               placeholder="Cari posisi (misal: Pemanen) atau lokasi..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                {{-- Sort Dropdown --}}
                <div class="col-lg-3 col-md-4">
                    <select class="form-select form-control-search" name="sort" onchange="this.form.submit()">
                        <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>✨ Paling Baru</option>
                        <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>⏳ Deadline Terdekat</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    {{-- JOB CARDS --}}
    <div class="row g-4">
        @forelse($lowongans as $index => $lowongan)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="job-card p-4">

                    {{-- Header Card: Logo & Title --}}
                    <div class="d-flex align-items-start mb-3">
                        <div class="company-logo-placeholder flex-shrink-0">
                            {{ substr($lowongan->pemilik->nama_perusahaan ?? ($lowongan->pemilik->nama_pemilik ?? 'U'), 0, 1) }}
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold text-dark mb-1 text-truncate">{{ $lowongan->judul }}</h5>
                            <p class="text-muted small mb-0 text-truncate">
                                {{ $lowongan->pemilik->nama_perusahaan ?? ($lowongan->pemilik->nama_pemilik ?? 'Perusahaan Tidak Diketahui') }}
                            </p>
                        </div>
                    </div>

                    {{-- Badges --}}
                    <div class="mb-3">
                        @php
                            $statusClass = match($lowongan->status) {
                                'aktif' => 'badge-soft-success',
                                'menunggu_acc' => 'badge-soft-warning',
                                'ditolak' => 'badge-soft-danger',
                                default => 'badge-soft-secondary'
                            };
                        @endphp
                        <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 fw-normal">
                            {{ ucfirst($lowongan->status) }}
                        </span>

                        {{-- Badge Waktu (Opsional: New jika < 3 hari) --}}
                        @if($lowongan->created_at->diffInDays() < 3)
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 fw-normal ms-1">Baru</span>
                        @endif
                    </div>

                    {{-- Detail Grid --}}
                    <div class="job-detail-grid">
                        <div class="job-detail-item" title="Upah">
                            <i class="fas fa-money-bill-wave text-success"></i>
                            <span class="text-truncate">{{ $lowongan->upah ?? 'Negosiasi' }}</span>
                        </div>
                        <div class="job-detail-item" title="Lokasi">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <span class="text-truncate">{{ $lowongan->lokasi_kerja ?? '-' }}</span>
                        </div>
                        <div class="job-detail-item" title="Kebutuhan">
                            <i class="fas fa-users text-info"></i>
                            <span>{{ $lowongan->jumlah_kebutuhan }} Orang</span>
                        </div>
                        <div class="job-detail-item" title="Deadline">
                            <i class="far fa-calendar-alt text-warning"></i>
                            <span>{{ \Carbon\Carbon::parse($lowongan->batas_pelamar)->format('d M') }}</span>
                        </div>
                    </div>

                    {{-- Spacer to push footer down --}}
                    <div class="mt-auto pt-3">
                        <a href="{{ route('pelamar.lowongan.detail', $lowongan->id) }}" class="btn btn-detail w-100 d-flex justify-content-center align-items-center">
                            Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12" data-aos="zoom-in">
                <div class="text-center py-5 bg-white rounded-4 shadow-sm border border-light mt-2">
                    <div class="bg-light d-inline-flex p-4 rounded-circle mb-3">
                        <i class="fas fa-search fa-3x text-secondary opacity-50"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Tidak ada lowongan ditemukan</h4>
                    <p class="text-muted mb-4">Coba ubah kata kunci pencarian atau filter Anda.</p>
                    <a href="{{ route('pelamar.lowongan') }}" class="btn btn-outline-success rounded-pill px-4">
                        Reset Pencarian
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if ($lowongans->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $lowongans->withQueryString()->links() }}
        </div>
    @endif

</div>
@endsection
