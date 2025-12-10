@extends('layouts.app')

@section('title', 'Kelola Pekerja Sawit Anda dengan Mudah dan Efisien')

@section('content')

    {{-- 🌴 Bagian Hero (Background Image + Animasi Teks) --}}
    <div class="relative isolate overflow-hidden pb-16 pt-14 sm:pb-20 rounded-3xl mx-4 sm:mx-0 shadow-2xl">

        {{-- Background Image --}}
        {{-- Ganti URL di bawah ini --}}
        {{-- Background Image --}}
        {{-- Ganti URL di bawah ini --}}
        <img src="{{ asset($global_settings['hero_image_path'] ?? 'images/default_sawit.jpg') }}" alt="Kebun Sawit"
            class="absolute inset-0 -z-20 h-full w-full object-cover">

        {{-- Overlay Gelap --}}
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-gray-900/60 via-gray-900/80 to-gray-900"></div>

        <div class="mx-auto max-w-7xl px-6 lg:px-8 relative z-10 text-center py-24 sm:py-32">

            {{-- Animasi: Fade Down (Turun dari atas) --}}
            <div class="mb-8 flex justify-center" data-aos="fade-down" data-aos-duration="1000">
                <span
                    class="relative rounded-full px-4 py-1.5 text-sm leading-6 text-emerald-300 ring-1 ring-emerald-500/50 hover:ring-emerald-400 bg-emerald-900/40 backdrop-blur-sm">
                    #1 Platform Manajemen Kebun Sawit
                </span>
            </div>

            {{-- Animasi: Zoom In (Heading Tagline Utama) --}}
            <h1 class="text-5xl font-extrabold tracking-tight text-white sm:text-7xl mb-6 drop-shadow-lg" data-aos="zoom-in"
                data-aos-delay="200">
                {{-- Mengambil Tagline dari DB. Fallback jika kosong. --}}
                {{ $global_settings['hero_tagline'] ?? 'Kelola Pekerja Sawit Anda dengan Mudah dan Efisien' }}
            </h1>

            {{-- Animasi: Fade Up (Subtitle) --}}
            <p class="mt-6 text-lg leading-8 text-gray-200 max-w-3xl mx-auto drop-shadow-md" data-aos="fade-up"
                data-aos-delay="400">
                {{-- Mengambil Subtitle dari DB. Fallback jika kosong. --}}
                {{ $global_settings['hero_subtitle'] ?? 'Sawit Inside adalah platform digital terintegrasi yang dirancang khusus untuk memfasilitasi pemilik kebun sawit mencari, merekrut, dan mengelola tenaga kerja panen dan pemeliharaan lapangan.' }}
            </p>

            <div class="mt-10 flex items-center justify-center gap-x-6" data-aos="fade-up" data-aos-delay="600">
                <a href="{{ route('register') }}"
                    class="group rounded-full bg-emerald-500 px-8 py-3.5 text-lg font-bold text-white shadow-sm hover:bg-emerald-400 transition-all duration-300 transform hover:scale-105">
                    Gabung Sekarang
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- 📊 Statistik (Card Melayang Berurutan) --}}
    {{-- Container ini kita beri margin negatif (-mt) biar numpuk ke atas --}}
    <div class="relative z-20 -mt-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">

                {{-- Card 1: Delay 0ms --}}
                <div class="group bg-white p-8 rounded-2xl shadow-xl border-b-4 border-blue-500 hover:shadow-2xl transition duration-300"
                    data-aos="fade-up" data-aos-delay="0">
                    <i class="fas fa-users text-5xl text-blue-600 mb-4 opacity-75 group-hover:opacity-100 transition"></i>
                    <p class="text-5xl font-extrabold text-gray-900">{{ $stats['total_applicants'] ?? '150+' }}</p>
                    <p class="text-lg text-gray-500 mt-2 font-semibold">Pelamar Terdaftar</p>
                </div>

                {{-- Card 2: Delay 200ms (Muncul sedikit lebih lambat) --}}
                <div class="group bg-white p-8 rounded-2xl shadow-xl border-b-4 border-green-500 hover:shadow-2xl transition duration-300"
                    data-aos="fade-up" data-aos-delay="200">
                    <i
                        class="fas fa-briefcase text-5xl text-green-600 mb-4 opacity-75 group-hover:opacity-100 transition"></i>
                    <p class="text-5xl font-extrabold text-gray-900">{{ $stats['total_active_vacancies'] ?? '24' }}</p>
                    <p class="text-lg text-gray-500 mt-2 font-semibold">Lowongan Aktif</p>
                </div>

                {{-- Card 3: Delay 400ms --}}
                <div class="group bg-white p-8 rounded-2xl shadow-xl border-b-4 border-yellow-500 hover:shadow-2xl transition duration-300"
                    data-aos="fade-up" data-aos-delay="400">
                    <i
                        class="fas fa-hard-hat text-5xl text-yellow-600 mb-4 opacity-75 group-hover:opacity-100 transition"></i>
                    <p class="text-5xl font-extrabold text-gray-900">{{ $stats['total_needed'] ?? '500+' }}</p>
                    <p class="text-lg text-gray-500 mt-2 font-semibold">Kebutuhan Pekerja</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 🚀 Fitur (Tabs) --}}
    <div class="py-24 bg-gray-50" x-data="{ activeTab: 'pemilik' }">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-gray-800 mb-10 text-center" data-aos="fade-down">Fokus Utama Sawit Inside
            </h2>

            {{-- Tab Buttons --}}
            <div class="flex justify-center mb-10" data-aos="zoom-in">
                <button @click="activeTab = 'pemilik'"
                    :class="activeTab === 'pemilik' ? 'bg-emerald-600 text-white shadow-lg' :
                        'bg-white text-gray-700 hover:bg-gray-100 border'"
                    class="px-8 py-3 text-lg font-semibold rounded-l-full transition duration-300">
                    Untuk Pemilik Kebun
                </button>
                <button @click="activeTab = 'pekerja'"
                    :class="activeTab === 'pekerja' ? 'bg-emerald-600 text-white shadow-lg' :
                        'bg-white text-gray-700 hover:bg-gray-100 border'"
                    class="px-8 py-3 text-lg font-semibold rounded-r-full transition duration-300">
                    Untuk Pekerja Sawit
                </button>
            </div>

            {{-- Konten Tab (Disini kita pakai x-transition bawaan Alpine aja biar gak bentrok sama AOS saat ganti tab) --}}
            <div class="relative min-h-[300px]">
                {{-- Tab Pemilik --}}
                <div x-show="activeTab === 'pemilik'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                    class="grid grid-cols-1 md:grid-cols-3 gap-8 absolute w-full top-0">

                    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-emerald-500">
                        <i class="fas fa-search text-3xl text-emerald-600 mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Perekrutan Cepat</h3>
                        <p class="text-gray-600">Saring pelamar berdasarkan pengalaman dan lokasi secara instan.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-emerald-500">
                        <i class="fas fa-chart-line text-3xl text-emerald-600 mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Manajemen Produktivitas</h3>
                        <p class="text-gray-600">Dashboard lengkap untuk memantau hasil panen harian.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-emerald-500">
                        <i class="fas fa-wallet text-3xl text-emerald-600 mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Sistem Upah</h3>
                        <p class="text-gray-600">Hitung upah otomatis dan transparan.</p>
                    </div>
                </div>

                {{-- Tab Pekerja --}}
                <div x-show="activeTab === 'pekerja'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                    style="display: none;" class="grid grid-cols-1 md:grid-cols-3 gap-8 absolute w-full top-0">

                    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500">
                        <i class="fas fa-map-marker-alt text-3xl text-blue-600 mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Lowongan Dekat Anda</h3>
                        <p class="text-gray-600">Cari kerja di lokasi terdekat dengan rumah.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500">
                        <i class="fas fa-star text-3xl text-blue-600 mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Profil Profesional</h3>
                        <p class="text-gray-600">CV digital khusus pekerja sawit.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500">
                        <i class="fas fa-lock text-3xl text-blue-600 mb-3"></i>
                        <h3 class="text-xl font-bold mb-2">Aman</h3>
                        <p class="text-gray-600">Lowongan terverifikasi anti penipuan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 🌟 Lowongan Unggulan (Card Melayang dengan Efek Flip/Fade) --}}
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-gray-800 mb-10 text-center" data-aos="fade-up">Lowongan <span
                    class="text-emerald-600">Unggulan</span> Terbaru</h2>

            @if ($featured_vacancies->isEmpty())
                <p class="text-center text-gray-500 py-8 border-2 border-dashed rounded-xl" data-aos="fade-in">Belum ada
                    lowongan aktif saat ini.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($featured_vacancies as $index => $lowongan)
                        {{-- Gunakan $index untuk membuat delay bertingkat (staggered animation) --}}
                        <div class="group bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:border-emerald-500 transition duration-300"
                            data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" {{-- Delay bertambah 100ms setiap card --}}
                            data-aos-anchor-placement="top-bottom">

                            <div class="flex justify-between items-start mb-4">
                                <div class="bg-emerald-100 p-3 rounded-lg text-emerald-600">
                                    <i class="fas fa-tree text-xl"></i>
                                </div>
                                <span
                                    class="text-xs font-semibold bg-green-100 text-green-800 px-2 py-1 rounded-full">Baru</span>
                            </div>

                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition">
                                {{ $lowongan->judul }}</h3>
                            <p class="text-sm text-gray-500 mb-4">{{ $lowongan->pemilik->nama_pemilik ?? 'Pemilik' }}</p>

                            <div class="space-y-2 text-sm text-gray-600 mb-6">
                                <p class="flex items-center"><i
                                        class="fas fa-money-bill-wave w-6 text-center mr-2 text-gray-400"></i>
                                    {{ $lowongan->upah ?? 'Negosiasi' }}</p>
                                <p class="flex items-center"><i
                                        class="fas fa-map-marker-alt w-6 text-center mr-2 text-gray-400"></i>
                                    {{ $lowongan->lokasi_kerja ?? 'Indonesia' }}</p>
                            </div>

                            <a href="{{ route('login') }}"
                                class="block w-full text-center py-2 rounded-lg border border-emerald-600 text-emerald-600 font-semibold hover:bg-emerald-600 hover:text-white transition duration-300">
                                Lamar Sekarang
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- 📣 CTA Akhir --}}
    <div class="py-20 bg-emerald-600 text-center text-white overflow-hidden">
        <div class="max-w-4xl mx-auto px-4" data-aos="zoom-in-up">
            <h2 class="text-4xl font-extrabold mb-4">Mulai Kelola Kebun Anda Hari Ini!</h2>
            <p class="text-xl mb-8 opacity-90">Bergabunglah dengan jaringan terbesar pekerja sawit.</p>
            <a href="{{ route('register') }}"
                class="inline-block px-12 py-4 text-xl font-bold rounded-full text-emerald-700 bg-white shadow-2xl hover:bg-gray-100 transform hover:scale-105 transition duration-300">
                Daftar Gratis
            </a>
        </div>
    </div>

@endsection
