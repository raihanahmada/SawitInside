@extends('layouts.pelamar.app') {{-- MENGGUNAKAN LAYOUT PELAMAR BARU --}}

@section('title', 'Dashboard')

@section('dashboard_content')
<div class="p-6 bg-white shadow-xl rounded-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Ringkasan Akun Anda</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-emerald-50 p-6 rounded-lg shadow-md border-l-4 border-emerald-500">
            <h3 class="text-xl font-semibold text-emerald-800">Lamaran Aktif</h3>
            <p class="mt-2 text-3xl font-bold text-emerald-600">3</p>
            <p class="text-sm text-gray-500">Lihat di History Lamaran</p>
        </div>

        <div class="bg-blue-50 p-6 rounded-lg shadow-md border-l-4 border-blue-500">
            <h3 class="text-xl font-semibold text-blue-800">Kelengkapan Data Diri</h3>
            <p class="mt-2 text-3xl font-bold text-blue-600">60%</p>
            <a href="{{ route('pelamar.datadiry') }}" class="text-sm mt-2 block text-blue-600 hover:underline">Lengkapi Sekarang &rarr;</a>
        </div>

        <div class="bg-yellow-50 p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
            <h3 class="text-xl font-semibold text-yellow-800">Lowongan Baru</h3>
            <p class="mt-2 text-3xl font-bold text-yellow-600">5</p>
            <a href="{{ route('pelamar.lowongan') }}" class="text-sm mt-2 block text-yellow-600 hover:underline">Cari Lowongan &rarr;</a>
        </div>
    </div>
</div>
@endsection
