@extends('layouts.admin.app')

@section('title', 'Lowongan Aktif')
@section('admin_page_title', 'Daftar Lowongan Aktif')

@section('admin_content')

<div class="space-y-8">

    {{-- 📊 BAGIAN 1: STATISTIK RINGKAS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-down">

        {{-- Stat Card 1: Total Lowongan --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 relative overflow-hidden group hover:shadow-md transition duration-300">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition transform group-hover:scale-110">
                <i class="fas fa-briefcase text-6xl text-emerald-600"></i>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Lowongan Aktif</p>
            <p class="text-4xl font-extrabold text-emerald-600 mt-2">{{ $active_vacancies->count() }}</p>
            <div class="mt-2 flex items-center text-xs text-emerald-600 font-medium">
                <span class="flex h-2 w-2 relative mr-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                Sedang Tayang
            </div>
        </div>

        {{-- Stat Card 2: Total Kebutuhan --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100 relative overflow-hidden group hover:shadow-md transition duration-300">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition transform group-hover:scale-110">
                <i class="fas fa-users text-6xl text-blue-600"></i>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Kebutuhan Pekerja</p>
            <p class="text-4xl font-extrabold text-blue-600 mt-2">{{ $total_needed }}</p>
            <p class="text-xs text-gray-400 mt-1">Posisi yang dicari</p>
        </div>

        {{-- Stat Card 3: Info Deadline (DIPERBAIKI) --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-yellow-100 relative overflow-hidden group hover:shadow-md transition duration-300">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition transform group-hover:scale-110">
                <i class="fas fa-calendar-alt text-6xl text-yellow-600"></i>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Info Batas Waktu</p>
            {{-- 🛠️ PERBAIKAN DI SINI: Variabel $total_limit dihapus --}}
            <p class="text-4xl font-extrabold text-yellow-600 mt-2">-</p>
            <p class="text-xs text-gray-400 mt-1">Lihat detail per lowongan</p>
        </div>
    </div>

    {{-- 📋 BAGIAN 2: DAFTAR KARTU LOWONGAN --}}
    @if($active_vacancies->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-200 text-center" data-aos="zoom-in">
            <div class="bg-gray-50 p-6 rounded-full mb-4">
                <i class="fas fa-folder-open text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Tidak Ada Data</h3>
            <p class="text-gray-500 text-sm max-w-sm mt-2">Saat ini tidak ada lowongan yang berstatus 'Aktif'. Lowongan baru akan muncul di sini setelah disetujui.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($active_vacancies as $index => $lowongan)
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-xl hover:border-emerald-300 transition-all duration-300 flex flex-col h-full"
                 data-aos="fade-up"
                 data-aos-delay="{{ $index * 100 }}">

                {{-- A. Header Kartu (Status & Tanggal) --}}
                <div class="px-5 pt-5 pb-3 flex justify-between items-start">
                    <div class="flex items-center space-x-2">
                        <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wide flex items-center shadow-sm">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span> Live
                        </span>
                        {{-- Menampilkan Tanggal Posting --}}
                        <span class="text-gray-400 text-xs flex items-center">
                            <i class="far fa-clock mr-1"></i> {{ $lowongan->created_at ? $lowongan->created_at->format('d M Y') : '-' }}
                        </span>
                    </div>

                    {{-- Menu Titik Tiga --}}
                    <button class="text-gray-300 hover:text-gray-600 transition">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>

                {{-- B. Judul & Pemilik --}}
                <div class="px-5 pb-4 border-b border-gray-100 border-dashed">
                    <h3 class="text-lg font-bold text-gray-800 leading-snug group-hover:text-emerald-700 transition mb-3">
                        {{ $lowongan->judul }}
                    </h3>

                    {{-- Info Pemilik (Highlight Biru) --}}
                    <div class="flex items-center bg-blue-50 rounded-lg p-2 border border-blue-100">
                        <div class="h-8 w-8 rounded-full bg-blue-200 flex items-center justify-center text-blue-700 font-bold text-xs mr-3 shadow-sm">
                            {{ substr($lowongan->pemilik->nama_pemilik ?? 'U', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-blue-500 font-bold uppercase tracking-wide">Pemilik Kebun</p>
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $lowongan->pemilik->nama_pemilik ?? 'Tidak Diketahui' }}</p>
                        </div>
                    </div>
                </div>

                {{-- C. Detail Informasi (Grid 2 Kolom) --}}
                <div class="p-5 flex-grow space-y-4">
                    <div class="grid grid-cols-2 gap-y-4 gap-x-2">

                        {{-- 1. Lokasi --}}
                        <div class="col-span-2">
                            <p class="text-gray-400 text-[10px] font-bold uppercase mb-0.5">Lokasi Kerja</p>
                            <p class="text-sm font-medium text-gray-700 flex items-start">
                                <i class="fas fa-map-marker-alt text-red-500 mt-1 mr-2 w-4 text-center"></i>
                                <span class="line-clamp-1">{{ $lowongan->lokasi_kerja ?? '-' }}</span>
                            </p>
                        </div>

                        {{-- 2. Upah --}}
                        <div>
                            <p class="text-gray-400 text-[10px] font-bold uppercase mb-0.5">Estimasi Upah</p>
                            <p class="text-sm font-bold text-emerald-600 flex items-center">
                                <i class="fas fa-money-bill-wave text-emerald-400 mr-2 w-4 text-center"></i>
                                {{ $lowongan->upah ?? '-' }}
                            </p>
                        </div>

                        {{-- 3. Jam Kerja --}}
                        <div>
                            <p class="text-gray-400 text-[10px] font-bold uppercase mb-0.5">Jam Kerja</p>
                            <p class="text-sm font-medium text-gray-700 flex items-center">
                                <i class="fas fa-clock text-indigo-400 mr-2 w-4 text-center"></i>
                                {{ $lowongan->jam_kerja ?? '-' }}
                            </p>
                        </div>

                         {{-- 4. Kebutuhan (Full Width) --}}
                         <div class="col-span-2 bg-gray-50 rounded-lg p-2 flex justify-between items-center border border-gray-100 mt-1">
                            <div class="flex items-center">
                                <i class="fas fa-users text-orange-400 mr-2 ml-1"></i>
                                <span class="text-xs text-gray-500 font-medium">Kebutuhan Tenaga:</span>
                            </div>
                            <span class="text-sm font-extrabold text-gray-800 bg-white px-2 py-0.5 rounded shadow-sm border border-gray-200">
                                {{ $lowongan->jumlah_kebutuhan }} Orang
                            </span>
                        </div>
                    </div>

                    {{-- 5. Deskripsi Singkat --}}
                    <div class="relative pt-2">
                        <p class="text-xs text-gray-500 italic line-clamp-2 leading-relaxed pl-3 border-l-2 border-gray-200">
                            "{{ $lowongan->deskripsi }}"
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
