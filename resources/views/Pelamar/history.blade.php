@extends('layouts.pelamar.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">History Lamaran</h1>
        <p class="text-gray-600 mt-2">Riwayat lamaran yang telah Anda ajukan</p>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-emerald-100 p-3 rounded-lg">
                    <i class="fas fa-file-alt text-emerald-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Lamaran</p>
                    <p class="text-2xl font-bold">{{ $totalLamaran }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-yellow-100 p-3 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Menunggu</p>
                    <p class="text-2xl font-bold">{{ $pendingLamaran }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Diterima</p>
                    <p class="text-2xl font-bold">{{ $diterimaLamaran }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel History -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Daftar Lamaran</h2>
        </div>

        @if($lamarans->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lowongan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Lamar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($lamarans as $lamaran)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $lamaran->lowongan->judul ?? 'Lowongan tidak ditemukan' }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $lamaran->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-sm {{ $lamaran->status_badge }}">
                                {{ $lamaran->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="text-emerald-600 hover:text-emerald-800">
                                <i class="fas fa-eye mr-1"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <i class="fas fa-file-alt text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-500">Belum ada riwayat lamaran</p>
            <a href="{{ route('pelamar.lowongan') }}" class="mt-2 inline-block text-emerald-600 hover:text-emerald-800">
                Cari lowongan sekarang →
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
