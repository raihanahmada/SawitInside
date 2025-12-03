@extends('layouts.app')
@section('content')
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

            <h2 class="text-5xl font-extrabold text-gray-900 mb-6 leading-tight">
                Kelola Pekerja Sawit Anda dengan Mudah dan Efisien
            </h2>

            <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-10">
                **Sawit Inside** adalah platform digital terintegrasi yang dirancang khusus untuk memfasilitasi pemilik kebun sawit mencari, merekrut, dan mengelola tenaga kerja panen dan pemeliharaan lapangan.
            </p>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                <div class="p-6 bg-white rounded-xl shadow-xl border border-emerald-100">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-emerald-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Pencarian Pekerja Tepat</h3>
                    <p class="text-gray-600 text-sm">Pemilik kebun dapat memasukkan kriteria spesifik (pemanen, pelangsir, dll.) dan kuota yang dibutuhkan.</p>
                </div>

                <div class="p-6 bg-white rounded-xl shadow-xl border border-emerald-100">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-emerald-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6m-3 0v-1a6 6 0 00-6-6h-2m2 8H10"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Akses Data Pelamar</h3>
                    <p class="text-gray-600 text-sm">Lihat profil lengkap pelamar termasuk pengalaman, usia, dan riwayat kerja sebelum memutuskan untuk menghubungi.</p>
                </div>

                <div class="p-6 bg-white rounded-xl shadow-xl border border-emerald-100">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-emerald-500 text-white mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.004 12.004 0 003 12c0 2.514.862 4.887 2.373 6.814M21 12c0 5.48-3.09 10.315-7.618 12.87M15 12h-2m2 0a2 2 0 11-4 0m4 0a2 2 0 10-4 0m-2 4a2 2 0 11-4 0m4 0a2 2 0 10-4 0"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Proses Validasi Admin</h3>
                    <p class="text-gray-600 text-sm">Setiap pemilik kebun dan lowongan divalidasi oleh Admin untuk memastikan keaslian dan keamanan platform.</p>
                </div>
            </div>

           <div class="mt-16">
    <a href="{{ route('register') }}" class="px-10 py-4 text-lg font-bold rounded-full text-white bg-emerald-600 hover:bg-emerald-700 transition duration-300 ease-in-out shadow-2xl shadow-emerald-400/50">
        Gabung Sekarang & Temukan Pekerja Terbaik!
    </a>
</div>

        </div>

@endsection
