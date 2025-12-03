@extends('layouts.pelamar.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Daftar Lowongan</h1>
        <p class="text-gray-600 mt-2">Temukan lowongan pekerjaan yang sesuai dengan keahlian Anda</p>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @foreach($lowongans as $lowongan)
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $lowongan->judul }}</h3>
                    <p class="text-gray-600 mb-4">{{ $lowongan->deskripsi }}</p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-users mr-2 text-emerald-600"></i>
                            <span>Dibutuhkan: {{ $lowongan->jumlah_kebutuhan }} orang</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt mr-2 text-emerald-600"></i>
                            <span>Batas: {{ \Carbon\Carbon::parse($lowongan->batas_pelamar)->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-building mr-2 text-emerald-600"></i>
                            <span>Perusahaan ID: {{ $lowongan->perusahaann_id }}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $lowongan->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($lowongan->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="ml-6">
                    <button class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition font-medium">
                        Lamar
                    </button>
                </div>
            </div>
        </div>
        @endforeach

        @if($lowongans->count() == 0)
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-briefcase text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada lowongan tersedia</h3>
            <p class="text-gray-600">Saat ini belum ada lowongan yang tersedia. Silakan cek kembali nanti.</p>
        </div>
        @endif
    </div>
</div>
@endsection
