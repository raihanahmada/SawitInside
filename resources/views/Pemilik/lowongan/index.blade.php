@extends('layouts.pemilik.app')

@section('title', 'Daftar Lowongan — SAWIT INSIDE')


@section('pemilik_content')
<div class="space-y-6">

    <!-- Header Page & Tombol Tambah -->
    <div class="bg-white p-6 rounded-t-xl border-b border-gray-200 shadow-sm flex flex-col md:flex-row justify-between items-center border-t-4 border-emerald-600">
        <div class="mb-4 md:mb-0 text-center md:text-left">
            <h1 class="text-2xl font-bold text-emerald-800">Daftar Lowongan Saya</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola pekerjaan dan lihat pelamar yang masuk.</p>
        </div>

        <a href="{{ route('pemilik.lowongan.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg shadow-md transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Lowongan Baru
        </a>
    </div>

    <!-- Alert Sukses -->
    @if(session('success'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mt-4 shadow-sm rounded-r" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-emerald-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Tabel Data -->
    <div class="bg-white rounded-b-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-emerald-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider w-10">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Judul & Lokasi</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider">Kebutuhan</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider">Batas Pendaftaran</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($lowongan as $index => $l)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <!-- Nomor -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $loop->iteration }}
                        </td>

                        <!-- Judul & Detail -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $l->judul }}</div>
                            <div class="text-xs text-gray-500 mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $l->lokasi_kerja ?? 'Lokasi tidak spesifik' }}
                            </div>
                        </td>

                        <!-- Kebutuhan -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $l->jumlah_kebutuhan }} Orang
                            </span>
                        </td>

                        <!-- Kuota Max (Batas Pelamar) -->
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">
                            {{-- Perbaikan: Batas pelamar adalah Angka (Integer), bukan Tanggal --}}
                            {{ $l->batas_pelamar }}
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                                $statusClass = match($l->status) {
                                    'aktif' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                    'menunggu_acc' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'ditolak' => 'bg-red-100 text-red-800 border-red-200',
                                    'selesai' => 'bg-gray-100 text-gray-800 border-gray-200',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                                $statusLabel = match($l->status) {
                                    'menunggu_acc' => 'Menunggu ACC',
                                    'aktif' => 'Aktif',
                                    'ditolak' => 'Ditolak',
                                    'selesai' => 'Selesai',
                                    default => ucfirst($l->status)
                                };
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>

                        <!-- Aksi -->
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center space-x-2">
                            

                                <!-- Tombol Edit -->
                                <a href="{{ route('pemilik.lowongan.edit', $l->id) }}" class="text-yellow-600 hover:text-yellow-900 bg-yellow-50 hover:bg-yellow-100 p-2 rounded-lg transition" title="Edit Data">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00 2 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('pemilik.lowongan.destroy', $l->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini? Data tidak bisa dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition" title="Hapus Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 bg-gray-50">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 01 2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-lg font-medium text-gray-600">Belum ada lowongan.</p>
                                <p class="text-sm text-gray-400 mt-1">Buat lowongan pekerjaan baru untuk mulai merekrut.</p>
                                <a href="{{ route('pemilik.lowongan.create') }}" class="mt-4 text-emerald-600 hover:text-emerald-800 font-medium">
                                    + Buat Lowongan Sekarang
                                </a>
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
