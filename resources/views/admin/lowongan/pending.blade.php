@extends('layouts.admin.app')

@section('title', 'Konfirmasi Lowongan')
@section('admin_page_title', 'Lowongan Butuh Konfirmasi')

@section('admin_content')

    <div class="p-6 bg-white shadow-xl rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Lowongan Menunggu Persetujuan
            ({{ $pending_vacancies->count() }})</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if ($pending_vacancies->isEmpty())
            <div class="p-4 bg-green-100 border-l-4 border-green-600 text-green-700 rounded-lg">
                Semua lowongan sudah dikonfirmasi.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul
                                Lowongan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Diajukan Oleh</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kebutuhan/Upah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deskripsi Singkat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Submit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($pending_vacancies as $lowongan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $lowongan->judul }}
                                    <br><span class="text-xs text-gray-400">Kuota Pelamar:
                                        {{ $lowongan->batas_pelamar }}</span>
                                </td>

                                {{-- Data Pemilik --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $lowongan->pemilik->nama_pemilik ?? 'N/A' }}
                                    <br><span
                                        class="text-xs text-gray-400">({{ $lowongan->pemilik->user->username ?? 'N/A' }})</span>
                                </td>

                                {{-- Kebutuhan dan Upah --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Butuh: **{{ $lowongan->jumlah_kebutuhan }}** <br>
                                    Upah: {{ $lowongan->upah ?? 'Lihat Detail' }}
                                </td>

                                {{-- Deskripsi --}}
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs overflow-hidden truncate"
                                    title="{{ $lowongan->deskripsi }}">
                                    {{ Str::limit($lowongan->deskripsi, 50) }}
                                </td>

                                {{-- Tanggal Submit --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $lowongan->created_at->format('d M Y') }}
                                </td>

                                {{-- Aksi Verifikasi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                    <button type="button"
                                        onclick="showDetailModal('{{ route('admin.vacancy_detail', $lowongan) }}')"
                                        class="text-blue-600 hover:text-blue-900 mr-3">
                                        Detail
                                    </button>

                                    {{-- Form Persetujuan --}}
                                    <form action="{{ route('admin.approve_vacancy', $lowongan) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">Setujui</button>
                                    </form>

                                    {{-- Form Penolakan --}}
                                    <form action="{{ route('admin.reject_vacancy', $lowongan) }}" method="POST"
                                        class="inline ml-3">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900">Tolak</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full mx-auto relative">
            <button onclick="closeDetailModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-900 text-2xl font-bold">&times;</button>
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
                    $('#modalContent').html('<div class="p-6 text-center text-red-500">Gagal memuat detail: ' +
                        error + '</div>');
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
