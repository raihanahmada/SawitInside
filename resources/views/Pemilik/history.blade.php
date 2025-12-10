@extends('layouts.pemilik.app')

@section('title', 'History Lamaran — SAWIT INSIDE')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <!-- Header -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-emerald-800">Riwayat Lamaran Masuk</h1>
            <p class="text-gray-500 text-sm mt-1">Pantau semua pelamar yang masuk ke lowongan Anda.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('pemilik.dashboard') }}" class="text-gray-600 hover:text-emerald-600 text-sm font-medium transition">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Tabel History -->
    <div class="bg-white rounded-xl shadow-lg border-t-4 border-emerald-600 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-emerald-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Tanggal Masuk</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Pelamar</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Lowongan</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($riwayat as $item)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <!-- Tanggal -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="font-medium text-gray-900">{{ $item->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-400">{{ $item->created_at->format('H:i') }} WIB</div>
                        </td>

                        <!-- Pelamar -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-xs mr-3 border border-emerald-200">
                                    {{ substr($item->pelamar->nama_pelamar ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $item->pelamar->nama_pelamar ?? 'Nama Tidak Tersedia' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $item->pelamar->kontak ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Lowongan -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-semibold">{{ $item->lowongan->judul ?? 'Lowongan Dihapus' }}</div>
                            <div class="text-xs text-gray-500 truncate max-w-[150px]">
                                {{ Str::limit($item->lowongan->deskripsi ?? '-', 30) }}
                            </div>
                        </td>

                        <!-- Status Badge -->
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                                $statusClass = match($item->status_lamaran) {
                                    'accepted' => 'bg-green-100 text-green-800 border-green-200',
                                    'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                    'pending'  => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    default    => 'bg-gray-100 text-gray-800'
                                };
                                $statusLabel = match($item->status_lamaran) {
                                    'accepted' => 'Diterima',
                                    'rejected' => 'Ditolak',
                                    'pending'  => 'Menunggu Review',
                                    default    => ucfirst($item->status_lamaran)
                                };
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>

                        <!-- Aksi -->
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <!-- Jika status masih pending, tampilkan tombol review -->
                            @if($item->status_lamaran == 'pending')
                                <a href="{{ route('pemilik.lowongan.lamaran', $item->lowongan_id) }}" 
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-emerald-700 bg-emerald-100 hover:bg-emerald-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                                    Review
                                </a>
                            @else
                                <span class="text-gray-400 text-xs italic">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-gray-500 bg-gray-50">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-lg font-medium text-gray-600">Belum ada riwayat lamaran.</p>
                                <p class="text-sm text-gray-400 mt-1">Saat pelamar melamar pekerjaan Anda, datanya akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination (Jika perlu nanti) -->
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            <p class="text-xs text-gray-500 text-center sm:text-left">
                Menampilkan {{ count($riwayat) }} data terakhir.
            </p>
        </div>
    </div>
</div>
@endsection