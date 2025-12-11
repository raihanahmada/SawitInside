@extends('layouts.pemilik.app')

@section('title', 'Data Pekerja')

@section('pemilik_content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-lg border-l-4 border-emerald-600">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Pekerja Aktif</h2>
            <p class="text-gray-500 text-sm mt-1">Daftar pelamar yang telah Anda terima bekerja di kebun.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-emerald-100 text-emerald-800">
                <i class="fas fa-user-check mr-2"></i> {{ $pekerja->count() }} Pekerja
            </span>
        </div>
    </div>

    {{-- Tabel Pekerja --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4">Nama Pekerja</th>
                        <th class="px-6 py-4">Posisi / Lowongan</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Tanggal Diterima</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pekerja as $item)
                    <tr class="hover:bg-gray-50 transition duration-150">

                        {{-- 1. Nama & Foto --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    @if($item->pelamar->user->google_avatar)
                                        <img class="w-10 h-10 rounded-full border border-gray-200" src="{{ $item->pelamar->user->google_avatar }}" alt="Avatar">
                                    @elseif($item->pelamar->foto)
                                        <img class="w-10 h-10 rounded-full border border-gray-200 object-cover" src="{{ asset('storage/foto_profil/' . $item->pelamar->foto) }}" alt="Avatar">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold border border-emerald-200">
                                            {{ substr($item->pelamar->nama, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">{{ $item->pelamar->nama }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->pelamar->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} - {{ $item->pelamar->usia }} Thn</div>
                                </div>
                            </div>
                        </td>

                        {{-- 2. Posisi --}}
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-emerald-700">
                                {{ $item->lowongan->judul }}
                            </div>
                            <div class="text-xs text-gray-500">
                                <i class="fas fa-map-pin mr-1"></i> {{ \Illuminate\Support\Str::limit($item->lowongan->lokasi_kerja, 20) }}
                            </div>
                        </td>

                        {{-- 3. Kontak --}}
                        <td class="px-6 py-4">
                            @if($item->pelamar->kontak)
                                <div class="text-gray-800 font-medium">{{ $item->pelamar->kontak }}</div>
                                <div class="text-xs text-gray-400 truncate w-32" title="{{ $item->pelamar->alamat }}">
                                    {{ $item->pelamar->alamat }}
                                </div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        {{-- 4. Tanggal Diterima --}}
                        <td class="px-6 py-4">
                            <div class="text-gray-900 font-medium">{{ $item->updated_at->format('d M Y') }}</div>
                            <div class="text-xs text-green-600">Aktif Bekerja</div>
                        </td>

                        {{-- 5. Aksi (WA) --}}
                        <td class="px-6 py-4 text-center">
                            @if($item->pelamar->kontak)
                                @php
                                    $hp = preg_replace('/[^0-9]/', '', $item->pelamar->kontak);
                                    if(substr($hp, 0, 2) == '08') $hp = '62' . substr($hp, 1);
                                @endphp
                                <a href="https://wa.me/{{ $hp }}?text=Halo%20{{ urlencode($item->pelamar->nama) }},%20terkait%20pekerjaan%20di%20kebun..."
                                   target="_blank"
                                   class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 hover:bg-green-100 border border-green-200 rounded-lg text-xs font-semibold transition">
                                    <i class="fab fa-whatsapp text-lg mr-1.5"></i> Hubungi
                                </a>
                            @else
                                <span class="text-gray-300 text-xs">No Contact</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-user-friends text-5xl mb-4 text-gray-200"></i>
                                <p class="text-lg font-medium text-gray-500">Belum ada pekerja aktif.</p>
                                <p class="text-sm">Terima lamaran pelamar untuk melihat data mereka di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
