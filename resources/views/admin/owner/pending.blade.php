@extends('layouts.admin.app')

@section('title', 'Verifikasi Pemilik Kebun')
@section('admin_page_title', 'Verifikasi Pemilik Kebun')

@section('admin_content')

<div class="p-6 bg-white shadow-xl rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Pemilik Menunggu Persetujuan ({{ $pending_owners->count() }})</h2>

    @if($pending_owners->isEmpty())
        {{-- PESAN INI SEKARANG AMAN DI DALAM CONTAINER KONTEN --}}
        <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-lg">
            Saat ini tidak ada Pemilik Kebun yang menunggu verifikasi.
        </div>
    @else
        <div class="overflow-x-auto">
           <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pemilik</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi Kebun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak WhatsApp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Regis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pending_owners as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->username }}</td>

                        {{-- Data Pemilik Kebun (Relasi) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->pemilik_kebun->nama_pemilik ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->pemilik_kebun->lokasi_kebun ?? 'N/A' }}
                        </td>

                        {{-- KOLOM KONTAK WHATSAPP (DENGAN TOMBOL) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @php
                                $kontak = $user->pemilik_kebun->kontak ?? '';
                                $waLink = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $kontak);
                            @endphp

                            {{ $kontak }}
                            <a href="{{ $waLink }}" target="_blank"
                               class="ml-2 inline-flex items-center text-green-500 hover:text-green-700 transition">
                                <i class="fab fa-whatsapp text-lg"></i>
                            </a>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('d M Y') }}
                        </td>

                        {{-- Aksi Verifikasi --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            {{-- Tombol Detail/Bukti --}}
                            <button type="button"
                                    onclick="showDetailModal('{{ route('admin.owner_detail', $user) }}')"
                                    class="text-blue-600 hover:text-blue-900 mr-3 font-semibold">
                                Detail & Bukti
                            </button>
                            {{-- Form Verifikasi (Persetujuan) --}}
                            <form action="{{ route('admin.approve_owner', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900">Setujui</button>
                            </form>

                            {{-- Tombol Tolak --}}
                            <form action="{{ route('admin.reject_owner', $user->id) }}" method="POST" class="inline ml-3">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    @endif
</div>
<div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full mx-auto relative">
        <button onclick="closeDetailModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-900 text-2xl font-bold">&times;</button>
        <div id="modalContent">
            </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    /**
     * Fungsi untuk menampilkan modal dan memuat konten via AJAX
     * @param {string} url - URL route admin.owner_detail yang berisi ID User
     */
    function showDetailModal(url) {
        // 1. Tampilkan Modal Kontainer
        $('#detailModal').removeClass('hidden').addClass('flex');
        $('#modalContent').html('<div class="p-6 text-center text-lg text-gray-500">Memuat data...</div>');

        // 2. Lakukan Panggilan AJAX
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                // Saat data berhasil diterima, tampilkan kontennya
                $('#modalContent').html(response);
            },
            error: function(xhr, status, error) {
                // Tampilkan pesan error jika gagal
                $('#modalContent').html('<div class="p-6 text-center text-red-500">Gagal memuat detail: ' + error + '</div>');
                console.error("AJAX Error:", error);
            }
        });
    }

    /**
     * Fungsi untuk menutup modal
     */
    function closeDetailModal() {
        $('#detailModal').removeClass('flex').addClass('hidden');
        $('#modalContent').empty(); // Kosongkan konten saat ditutup
    }

    // Optional: Tutup modal ketika mengklik area di luar konten
    $(document).ready(function() {
        $('#detailModal').on('click', function(e) {
            if ($(e.target).is('#detailModal')) {
                closeDetailModal();
            }
        });
    });
</script>
@endsection
