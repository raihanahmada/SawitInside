@extends('layouts.admin.app')

@section('title', 'Lowongan Aktif')
@section('admin_page_title', 'Daftar Lowongan Aktif')

@section('admin_content')

<div class="space-y-6">

    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-green-500">
            <p class="text-sm font-medium text-gray-500">Total Lowongan Aktif</p>
            <p class="text-3xl font-bold text-green-600">{{ $active_vacancies->count() }}</p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-blue-500">
            <p class="text-sm font-medium text-gray-500">Total Kebutuhan Pekerja</p>
            <p class="text-3xl font-bold text-blue-600">{{ $total_needed }}</p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-md border-l-4 border-yellow-500">
            <p class="text-sm font-medium text-gray-500">Total Kuota Pelamar</p>
            <p class="text-3xl font-bold text-yellow-600">{{ $total_limit }}</p>
        </div>
    </div>

    @if($active_vacancies->isEmpty())
        <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-lg">
            Tidak ada lowongan yang berstatus aktif saat ini.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($active_vacancies as $lowongan)
            <div class="bg-white p-5 rounded-xl shadow-lg border-t-4 border-green-500 hover:shadow-xl transition duration-600">

                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $lowongan->judul }}</h3>
                <p class="text-xs text-gray-500 mb-4">Diajukan oleh: **{{ $lowongan->pemilik->nama_pemilik ?? 'N/A' }}**</p>

                <div class="space-y-2 text-sm text-gray-700">
                    <p class="flex justify-between items-center">
                        <span class="font-semibold">Kebutuhan:</span>
                        <span class="text-lg font-extrabold text-red-600">{{ $lowongan->jumlah_kebutuhan }}</span> Pekerja
                    </p>
                    <p>
                        <i class="fas fa-money-bill-wave mr-2 text-green-600"></i> Upah: {{ $lowongan->upah ?? 'N/A' }}
                    </p>
                    <p>
                        <i class="fas fa-clock mr-2 text-indigo-600"></i> Jam Kerja: {{ $lowongan->jam_kerja ?? 'N/A' }}
                    </p>
                    <p>
                        <i class="fas fa-map-marker-alt mr-2 text-red-600"></i> Lokasi: {{ $lowongan->lokasi_kerja ?? 'N/A' }}
                    </p>
                </div>

                <p class="mt-4 text-xs italic text-gray-500">
                      {{$lowongan->deskripsi }}
                </p>

                <div class="mt-4 pt-3 border-t items-center flex justify-end space-x-3">
                    {{-- Tombol Edit (Arahkan ke form edit lowongan) --}}

                    {{-- Tombol Blokir --}}
                    <form action="{{ route('admin.reject_vacancy', $lowongan) }}" method="POST" onsubmit="return confirm('Yakin ingin menonaktifkan lowongan ini?');">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Nonaktifkan</button>
                    </form>
                </div>

            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
