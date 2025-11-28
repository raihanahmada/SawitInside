@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white p-8 md:p-12 rounded-xl shadow-2xl border-t-4 border-emerald-600 max-w-xl mx-auto text-center">

        <h2 class="text-3xl font-bold text-gray-800 mb-6">Pilih Jenis Akun Anda</h2>
        <p class="text-gray-500 mb-10">Daftar sebagai pemilik kebun sawit yang ingin mencari pekerja, atau sebagai pelamar yang mencari lowongan.</p>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            <!-- Tombol untuk Pemilik Kebun -->
            <a href="{{ route('register.pemilik.form') }}" class="block p-6 bg-emerald-50 hover:bg-emerald-100 border-2 border-emerald-300 rounded-xl transition duration-300 transform hover:scale-[1.02]">
                <div class="text-4xl mb-3 text-emerald-600">🌴</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-1">Pemilik Kebun</h3>
                <p class="text-sm text-gray-500">Mencari tenaga kerja (pemanen, pelangsir, dll.).</p>
            </a>

            <!-- Tombol untuk Pelamar -->
            <a href="{{ route('register.pelamar.form') }}" class="block p-6 bg-yellow-50 hover:bg-yellow-100 border-2 border-yellow-300 rounded-xl transition duration-300 transform hover:scale-[1.02]">
                <div class="text-4xl mb-3 text-yellow-600">👨‍🌾</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-1">Pelamar Pekerjaan</h3>
                <p class="text-sm text-gray-500">Melamar lowongan kerja di perkebunan sawit.</p>
            </a>

        </div>

        <div class="mt-8 text-sm text-gray-600">
            Sudah punya akun? <a href="#" class="text-emerald-600 hover:underline font-medium">Masuk di sini</a>.
        </div>
    </div>
</div>
@endsection
