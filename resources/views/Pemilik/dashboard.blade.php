@extends('layouts.pemilik.app')

@section('pemilik_content')
<div class="space-y-6">

    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-emerald-800">Dashboard Pemilik Kebun</h2>
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

    {{-- NOTIFIKASI PELAMAR BARU (BAGIAN BARU DITAMBAHKAN) --}}
    {{-- Pastikan variabel $pelamarPending dikirim dari controller, atau gunakan logic pengecekan lain --}}
    @if(isset($pelamarPending) && $pelamarPending > 0)
    <div class="bg-amber-50 border-l-4 border-amber-500 p-5 rounded-r-lg shadow-md flex flex-col md:flex-row justify-between items-center gap-4 animate-fade-in-down">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-amber-100 rounded-full text-amber-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800">Menunggu Konfirmasi!</h3>
                <p class="text-gray-600 text-sm mt-1">
                    Terdapat <span class="font-bold text-amber-600 text-base">{{ $pelamarPending }} pelamar baru</span> yang belum Anda proses. Segera cek kualifikasi mereka.
                </p>
            </div>
        </div>

        <a href="{{ route('pemilik.Pelamar') }}" class="whitespace-nowrap px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg shadow transition transform hover:scale-105 flex items-center gap-2">
            <span>Lihat Semua Lamaran</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
        </a>
    </div>
    @endif

    {{-- KARTU PROFIL PERUSAHAAN --}}
    <div class="bg-white rounded-xl shadow-lg border-t-4 border-emerald-600 p-6">
        @if(isset($pemilik) && $pemilik)
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <div class="shrink-0">
                @if($pemilik->foto_dokumen)
                <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-emerald-100 shadow-md">
                    <img src="{{ asset('storage/foto_profil/' . $pemilik->foto_profil) }}"
                        alt="Foto Profil"
                        class="w-full h-full object-cover">
                </div>
                @else
                <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-4xl font-bold border-4 border-white shadow-md">
                    {{ substr($pemilik->nama_pemilik, 0, 1) }}
                </div>
                @endif
            </div>

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
        <div class="text-center py-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 text-yellow-600 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Profil Belum Lengkap</h3>
            <p class="text-gray-500 mb-4">Silakan lengkapi data diri dan kebun Anda untuk mulai membuat lowongan.</p>
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
            <h3 class="text-lg font-medium text-gray-500">Jumlah Lamaran Masuk</h3>
            <p class="mt-2 text-4xl font-bold text-emerald-700">{{ $totalLamaran ?? 0 }}</p>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-xl shadow-lg p-6 border-t-4 border-emerald-600">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Terakhir</h3>

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

        /* Animasi sederhana untuk notifikasi */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate3d(0, -20px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.5s ease-out;
        }
    </style>

</div>
@endsection
