@extends('layouts.pelamar')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0">Detail Lowongan</h2>
                <a href="{{ route('pelamar.lowongan') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h3 class="text-primary">{{ $lowongan->judul }}</h3>

                    <h5 class="text-muted">
                        <i class="bi bi-person-badge"></i>
                        @if($lowongan->pemilik && $lowongan->pemilik->nama_pemilik)
                            {{ $lowongan->pemilik->nama_pemilik }}
                        @else
                            Pemilik Tidak Diketahui
                        @endif
                    </h5>

                    @php
                        $statusClass = [
                            'aktif' => 'bg-success',
                            'menunggu_acc' => 'bg-warning',
                            'selesai' => 'bg-secondary',
                            'ditolak' => 'bg-danger'
                        ][$lowongan->status] ?? 'bg-secondary';
                    @endphp
                    <span class="badge {{ $statusClass }} mb-3">
                        {{ ucfirst(str_replace('_', ' ', $lowongan->status)) }}
                    </span>
                </div>

                <div class="col-md-4 text-end">
                    @if($sudahLamar)
                        <button class="btn btn-success" disabled>
                            <i class="bi bi-check-circle"></i> Sudah Lamar
                        </button>
                    @else
                        {{-- FORM UNTUK MELAMAR --}}
                        <form action="{{ route('pelamar.lowongan.lamar', $lowongan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin melamar posisi ini?');">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Lamar Lowongan Ini
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">Informasi Lowongan</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Gaji/Upah</th>
                                    <td>{{ $lowongan->upah ?? 'Negosiasi' }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Kebutuhan</th>
                                    <td>{{ $lowongan->jumlah_kebutuhan }} orang</td>
                                </tr>
                                <tr>
                                    <th>Lokasi Kerja</th>
                                    <td>{{ $lowongan->lokasi_kerja ?? 'Tidak ditentukan' }}</td>
                                </tr>
                                <tr>
                                    <th>Jam Kerja</th>
                                    <td>{{ $lowongan->jam_kerja ?? 'Tidak ditentukan' }}</td>
                                </tr>
                                <tr>
                                    <th>Batas Pendaftaran</th>
                                    <td>
                                        @if($lowongan->batas_pelamar)
                                            {{ \Carbon\Carbon::parse($lowongan->batas_pelamar)->format('d F Y') }}
                                        @else
                                            Tidak ditentukan
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge {{ $statusClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $lowongan->status)) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                @if($lowongan->pemilik)
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">Informasi Pemilik Kebun</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Nama Pemilik</th>
                                    <td>{{ $lowongan->pemilik->nama_pemilik ?? 'Tidak diketahui' }}</td>
                                </tr>
                                @if($lowongan->pemilik->alamat_perusahaan) <tr>
                                    <th>Alamat</th>
                                    <td>{{ $lowongan->pemilik->alamat_perusahaan }}</td>
                                </tr>
                                @endif
                                @if($lowongan->pemilik->kontak) <tr>
                                    <th>Kontak/Telepon</th>
                                    <td>{{ $lowongan->pemilik->kontak }}</td>
                                </tr>
                                @endif
                                @if($lowongan->pemilik->luas_kebun)
                                <tr>
                                    <th>Luas Kebun</th>
                                    <td>{{ $lowongan->pemilik->luas_kebun }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Deskripsi Lowongan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        @if($lowongan->deskripsi)
                            {!! nl2br(e($lowongan->deskripsi)) !!}
                        @else
                            <p class="text-muted">Tidak ada deskripsi tambahan.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('pelamar.lowongan') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>

                <button class="btn btn-outline-info" onclick="window.print()">
                    <i class="bi bi-printer"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 10px;
}
.card-header {
    border-radius: 10px 10px 0 0 !important;
}
.table th {
    font-weight: 600;
    color: #495057;
}
.table td {
    color: #6c757d;
}
.badge {
    font-size: 0.8rem;
    padding: 0.4em 0.8em;
}
</style>
@endsection
