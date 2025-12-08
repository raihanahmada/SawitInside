@extends('layouts.app')

@section('title', 'Pilih Jenis Akun')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">

    {{-- Hiasan Background (Pattern Daun Samar) --}}
    <div class="absolute inset-0 z-0 opacity-5 pointer-events-none">
        <i class="fas fa-leaf text-9xl absolute -top-10 -left-10 text-emerald-800 transform -rotate-45"></i>
        <i class="fas fa-leaf text-9xl absolute bottom-10 right-10 text-emerald-800 transform rotate-180"></i>
    </div>

    <div class="max-w-4xl w-full space-y-8 relative z-10">

        {{-- Header Section --}}
        <div class="text-center" data-aos="fade-down" data-aos-duration="1000">
            <h2 class="mt-6 text-4xl font-extrabold text-gray-900 tracking-tight">
                Bergabung dengan <span class="text-emerald-600">Sawit Inside</span>
            </h2>
            <p class="mt-2 text-lg text-gray-600 max-w-2xl mx-auto">
                Tentukan peran Anda dalam ekosistem perkebunan ini untuk melanjutkan pendaftaran.
            </p>
        </div>

        {{-- Grid Pilihan Akun --}}
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 mt-10">

            <a href="{{ route('register.pemilik.form') }}"
               class="group relative bg-white rounded-2xl shadow-xl hover:shadow-2xl border-2 border-transparent hover:border-emerald-500 transition-all duration-300 transform hover:-translate-y-2 overflow-hidden flex flex-col items-center text-center p-8 cursor-pointer"
               data-aos="fade-right" data-aos-delay="100">

                {{-- Efek Glow di Background saat Hover --}}
                <div class="absolute inset-0 bg-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                {{-- Icon --}}
                <div class="relative z-10 w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-emerald-600 transition-colors duration-300 shadow-inner">
                    <i class="fas fa-user-tie text-4xl text-emerald-600 group-hover:text-white transition-colors duration-300"></i>
                </div>

                {{-- Text Content --}}
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">Pemilik Kebun</h3>
                    <p class="mt-3 text-gray-500 text-sm leading-relaxed px-4">
                        Saya memiliki lahan sawit dan ingin mencari tenaga kerja profesional untuk panen atau perawatan.
                    </p>
                </div>

                {{-- Fake Button --}}
                <div class="relative z-10 mt-8">
                    <span class="inline-flex items-center px-6 py-2 border border-emerald-600 text-emerald-600 font-semibold rounded-full group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                        Daftar sebagai Pemilik <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </a>

            {{-- Menggunakan warna Amber/Kuning untuk membedakan visual --}}
            <a href="{{ route('register.pelamar.form') }}"
               class="group relative bg-white rounded-2xl shadow-xl hover:shadow-2xl border-2 border-transparent hover:border-amber-500 transition-all duration-300 transform hover:-translate-y-2 overflow-hidden flex flex-col items-center text-center p-8 cursor-pointer"
               data-aos="fade-left" data-aos-delay="200">

                {{-- Efek Glow di Background saat Hover --}}
                <div class="absolute inset-0 bg-amber-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                {{-- Icon --}}
                <div class="relative z-10 w-24 h-24 bg-amber-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-amber-500 transition-colors duration-300 shadow-inner">
                    <i class="fas fa-hard-hat text-4xl text-amber-600 group-hover:text-white transition-colors duration-300"></i>
                </div>

                {{-- Text Content --}}
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-amber-700 transition-colors">Pelamar Pekerjaan</h3>
                    <p class="mt-3 text-gray-500 text-sm leading-relaxed px-4">
                        Saya ingin mencari lowongan pekerjaan di perkebunan sawit sebagai pemanen, supir, atau perawatan.
                    </p>
                </div>

                {{-- Fake Button --}}
                <div class="relative z-10 mt-8">
                    <span class="inline-flex items-center px-6 py-2 border border-amber-500 text-amber-600 font-semibold rounded-full group-hover:bg-amber-500 group-hover:text-white transition-all duration-300">
                        Daftar sebagai Pelamar <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </div>
            </a>

        </div>

        {{-- Footer Link --}}
        <div class="text-center mt-8" data-aos="fade-up" data-aos-delay="300">
            <p class="text-gray-600">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-500 hover:underline transition">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
