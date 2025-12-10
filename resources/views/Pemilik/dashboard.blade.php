@extends('layouts.pemilik.app')

@section('pemilik_content')
<div class="space-y-6">

    <!-- Header & Edit Profil -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-emerald-800">Dashboard Pemilik Kebun</h2>
        <!-- PERBAIKAN: Ubah 'pemilik.datadiry' menjadi 'pemilik.dataDiri' sesuai route -->
        <a href="{{ route('pemilik.dataDiri') }}" class="text-sm text-emerald-600 hover:text-emerald-800 font-medium underline flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00 2 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Profil Perusahaan
        </a>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
    <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-300 text-emerald-700 shadow-sm">
        {{ session('success') }}
    </div>
    @endif

    {{-- KARTU PROFIL PERUSAHAAN (BAGIAN BARU) --}}
    <div class="bg-white rounded-xl shadow-lg border-t-4 border-emerald-600 p-6">
        @if(isset($pemilik) && $pemilik)
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <!-- Foto Profil -->
            <div class="shrink-0">
                @if($pemilik->foto_dokumen)
                <!-- Pastikan sudah menjalankan: php artisan storage:link -->
                <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-emerald-100 shadow-md">
                    <img src="{{ asset('storage/foto_profil/' . $pemilik->foto_profil) }}"
                        alt="Foto Profil"
                        class="w-full h-full object-cover">
                </div>
                @else
                <!-- Placeholder Inisial -->
                <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-4xl font-bold border-4 border-white shadow-md">
                    {{ substr($pemilik->nama_pemilik, 0, 1) }}
                </div>
                @endif
            </div>

            <!-- Detail Informasi -->
            <div class="flex-1 w-full text-center md:text-left">
                <div class="mb-4">
                    <h3 class="text-2xl font-bold text-gray-800">{{ $pemilik->nama_pemilik }}</h3>
                    <span class="inline-block px-3 py-1 text-xs font-semibold text-emerald-800 bg-emerald-100 rounded-full mt-1">
                        Pemilik Kebun Terverifikasi
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600 bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span><strong class="text-gray-800">Lokasi:</strong> {{ $pemilik->lokasi_kebun }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </svg>
                        <span><strong class="text-gray-800">Luas Kebun:</strong> {{ $pemilik->luas_kebun }} Hektar</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span><strong class="text-gray-800">Kontak:</strong> {{ $pemilik->kontak }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span><strong class="text-gray-800">Bergabung:</strong> {{ $pemilik->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Tampilan Jika Data Belum Lengkap -->
        <div class="text-center py-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 text-yellow-600 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Profil Belum Lengkap</h3>
            <p class="text-gray-500 mb-4">Silakan lengkapi data diri dan kebun Anda untuk mulai membuat lowongan.</p>
            <!-- PERBAIKAN: Ubah 'pemilik.datadiry' menjadi 'pemilik.dataDiri' -->
            <a href="{{ route('pemilik.dataDiri') }}" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition">
                Lengkapi Profil Sekarang
            </a>
        </div>
        @endif
    </div>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-2 gap-6">
        <div class="p-6 bg-white rounded-xl shadow-lg border-t-4 border-emerald-600 text-center hover:shadow-xl transition transform hover:-translate-y-1">
            <h3 class="text-lg font-medium text-gray-500">Jumlah Lowongan</h3>
            <p class="mt-2 text-4xl font-bold text-emerald-700">{{ $totalLowongan ?? 0 }}</p>
        </div>
        <div class="p-6 bg-white rounded-xl shadow-lg border-t-4 border-emerald-600 text-center hover:shadow-xl transition transform hover:-translate-y-1">
            <h3 class="text-lg font-medium text-gray-500">Jumlah Lamaran</h3>
            <p class="mt-2 text-4xl font-bold text-emerald-700">{{ $totalLamaran ?? 0 }}</p>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-xl shadow-lg p-6 border-t-4 border-emerald-600">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Terakhir</h3>

        <!-- CONTAINER DENGAN SCROLL -->
        <div class="max-h-40 overflow-y-auto pr-2 custom-scroll">
            <ul class="divide-y">
                @forelse($logs as $log)
                <li class="py-3 flex justify-between">
                    <div>
                        <p class="text-gray-800 font-semibold">{{ $log->activity }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $log->created_at->format('d M Y H:i') }}
                        </p>
                    </div>
                    <span class="text-xs text-gray-400">{{ $log->ip_address }}</span>
                </li>
                @empty
                <p class="text-gray-500 text-sm">Belum ada aktivitas.</p>
                @endforelse
            </ul>
        </div>
    </div>

    <style>
        /* Scrollbar halus */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #c7c7c7;
            border-radius: 10px;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #a9a9a9;
        }
    </style>

</div>
@endsection