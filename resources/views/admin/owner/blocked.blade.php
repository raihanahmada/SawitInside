@extends('layouts.admin.app')

@section('title', 'Data Pemilik Diblokir')
@section('admin_page_title', 'Data Pemilik Diblokir')

@section('admin_content')

<div class="p-6 bg-white shadow-xl rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Pemilik Kebun Diblokir ({{ $blocked_owners->count() }})</h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($blocked_owners->isEmpty())
        <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg">
            Tidak ada Pemilik Kebun yang berstatus Diblokir (Rejected) saat ini.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pemilik</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi Kebun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Akun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($blocked_owners as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $user->pemilik_kebun->nama_pemilik ?? $user->username }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->pemilik_kebun->lokasi_kebun ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>

                            {{-- Aksi Buka Blokir --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                {{-- Tombol Detail (Menggunakan route management) --}}
                                <button type="button"
                                    onclick="showDetailModal('{{ route('admin.owner_detail_management', $user) }}')"
                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                    Lihat Detail
                                </button>

                                {{-- Form Buka Blokir --}}
                                <form action="{{ route('admin.unblock_owner', $user) }}" method="POST" class="inline"
                                    onsubmit="return confirm('✅ Yakin ingin MENGAKTIFKAN kembali akun {{ $user->username }}?');">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 font-semibold">Buka Blokir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

{{-- CATATAN: Pastikan Anda menambahkan Modal Container dan Script showDetailModal di view ini juga --}}
<div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full mx-auto relative">
        <button onclick="closeDetailModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-900 text-2xl font-bold">&times;</button>
        <div id="modalContent">
            {{-- Konten detail akan dimuat di sini --}}
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function showDetailModal(url) {
        $('#detailModal').removeClass('hidden').addClass('flex');
        $('#modalContent').html('<div class="p-6 text-center text-lg text-gray-500">Memuat data...</div>');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#modalContent').html(response);
            },
            error: function(xhr, status, error) {
                $('#modalContent').html('<div class="p-6 text-center text-red-500">Gagal memuat detail: ' + error + '</div>');
                console.error("AJAX Error:", error);
            }
        });
    }

    function closeDetailModal() {
        $('#detailModal').removeClass('flex').addClass('hidden');
        $('#modalContent').empty();
    }

    $(document).ready(function() {
        $('#detailModal').on('click', function(e) {
            if ($(e.target).is('#detailModal')) {
                closeDetailModal();
            }
        });
    });
</script>
@endsection
