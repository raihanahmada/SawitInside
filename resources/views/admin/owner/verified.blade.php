@extends('layouts.admin.app')

@section('title', 'Data Pemilik Terverifikasi')
@section('admin_page_title', 'Data Pemilik Terverifikasi')

@section('admin_content')

    <style>
        /* Pola latar belakang ringan bertema sawit (gunakan emoji '🌴' jika tidak bisa menggunakan ikon) */
        .palm-pattern {
            background-color: #f0fff4;
            /* Green-50 */
            background-image: repeating-linear-gradient(45deg,
                    rgba(34, 139, 34, 0.05),
                    /* Forest Green 5% opacity */
                    rgba(34, 139, 34, 0.05) 10px,
                    transparent 10px,
                    transparent 20px);
        }
    </style>

    <div class="p-6 bg-white shadow-xl rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Pemilik Kebun Aktif ({{ $verified_owners->count() }})</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if ($verified_owners->isEmpty())
            <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-lg">
                Tidak ada Pemilik Kebun yang berstatus Aktif/Terverifikasi.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

                {{-- Box 1: Total Lowongan Aktif --}}
                <div
                    class="p-4 rounded-xl shadow-md palm-pattern border border-green-300 transform hover:scale-[1.02] transition duration-300 cursor-pointer">
                    <p class="text-sm font-medium text-green-800 flex items-center">
                        <i class="fas fa-briefcase mr-2 text-lg"></i> Total Lowongan Aktif
                    </p>
                    <p class="text-4xl font-extrabold text-green-600 mt-1">{{ $total_lowongan_aktif }}</p>
                </div>

                {{-- Box 2: Total Unit Kebun Terdaftar --}}
                <div
                    class="p-4 rounded-xl shadow-md bg-indigo-50 border border-indigo-300 transform hover:scale-[1.02] transition duration-300 cursor-pointer">
                    <p class="text-sm font-medium text-indigo-800 flex items-center">
                        <i class="fas fa-user-check mr-2 text-lg"></i> Total Unit Kebun Terverifikasi
                    </p>
                    <p class="text-4xl font-extrabold text-indigo-600 mt-1">{{ $verified_owners->count() }} 🌴</p>
                </div>

                {{-- Box 3: Total Pekerja Dibutuhkan --}}
                <div
                    class="p-4 rounded-xl shadow-md bg-gray-100 border border-gray-300 transform hover:scale-[1.02] transition duration-300 cursor-pointer">
                    <p class="text-sm font-medium text-gray-800 flex items-center">
                        <i class="fas fa-users mr-2 text-lg"></i> Total Kebutuhan Pekerja
                    </p>
                    <p class="text-4xl font-extrabold text-gray-600 mt-1">{{ $total_pekerja_dibutuhkan }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                Pemilik</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Lokasi Kebun</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Luas
                                (Ha)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kontak WA</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($verified_owners as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $user->pemilik_kebun->nama_pemilik ?? $user->username }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->pemilik_kebun->lokasi_kebun ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->pemilik_kebun->luas_kebun ?? 'N/A' }}
                                </td>

                                {{-- Kontak WA Interaktif --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @php $kontak = $user->pemilik_kebun->kontak ?? ''; @endphp
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kontak) }}" target="_blank"
                                        class="inline-flex items-center text-green-600 hover:text-green-800 transition">
                                        <i class="fab fa-whatsapp mr-1"></i> {{ $kontak }}
                                    </a>
                                </td>

                                {{-- Aksi Blokir --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                    {{-- TOMBOL DETAIL & BUKTI (Diambil dari route owner_detail ControllerOwnerPending) --}}
                                    <button type="button"
                                        onclick="showDetailModal('{{ route('admin.owner_detail_management', $user) }}')"
                                        class="text-blue-600 hover:text-blue-900 mr-3">
                                        Lihat Detail
                                    </button>

                                    <a href="{{ route('admin.owner_edit', $user) }}"
                                        class="text-yellow-600 hover:text-yellow-800 mr-3">
                                        Edit
                                    </a>

                                    {{-- Form Blokir --}}
                                    <form action="{{ route('admin.block_owner', $user) }}" method="POST" class="inline"
                                        onsubmit="return confirm('❗ PERINGATAN: Yakin ingin MEMBLOKIR akun {{ $user->username }}?');">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900">Blokir</button>
                                    </form>
                                </td>
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
