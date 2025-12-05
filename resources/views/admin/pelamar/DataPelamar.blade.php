@extends('layouts.admin.app')

@section('title', 'Data Pelamar')
@section('admin_page_title', 'Data Seluruh Pelamar Terdaftar')

@section('admin_content')

    <div class="p-6 bg-white shadow-xl rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Total Pelamar: {{ $applicants->count() }}</h2>

         @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if ($applicants->isEmpty())
            <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-lg">
                Saat ini belum ada Pelamar yang terdaftar di sistem.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Username / Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                Lengkap</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usia /
                                JK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak
                                (WA)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pengalaman</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($applicants as $user)
                            <tr>
                                {{-- Data Akun Dasar --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $user->username }} <br> <span
                                        class="text-xs text-gray-500">{{ $user->email }}</span>
                                </td>

                                {{-- Data Detail Profil (Cek apakah profil sudah dilengkapi) --}}
                                @if ($user->pelamar_profil)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->pelamar_profil->nama }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->pelamar_profil->usia }} Thn / {{ $user->pelamar_profil->jenis_kelamin }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($user->pelamar_profil && $user->pelamar_profil->kontak)
                                            @php
                                                // 1. Ambil nomor kontak
                                                $kontak = $user->pelamar_profil->kontak;

                                                // 2. Format nomor untuk URL WhatsApp (menghapus semua non-angka)
                                                // Penting: WhatsApp API memerlukan nomor diawali kode negara (misal 62)
                                                // Asumsi format kontak sudah benar atau akan diformat nanti.
                                                $cleanNumber = preg_replace('/[^0-9]/', '', $kontak);

                                                // Cek jika nomor tidak dimulai dengan kode negara, tambahkan 62 (Kode Indonesia) jika perlu.
                                                if (!str_starts_with($cleanNumber, '62') && strlen($cleanNumber) > 5) {
                                                    // Jika nomor dimulai dengan 0, ganti 0 dengan 62
                                                    $cleanNumber = preg_replace('/^0/', '62', $cleanNumber);
                                                }

                                                $waLink = 'https://wa.me/' . $cleanNumber;
                                            @endphp

                                            <a href="{{ $waLink }}" target="_blank"
                                                class="inline-flex items-center text-green-600 hover:text-green-800 transition font-medium">
                                                <i class="fab fa-whatsapp mr-1"></i>
                                                {{ $user->pelamar_profil->kontak }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs overflow-hidden"
                                        title="{{ $user->pelamar_profil->pengalaman }}">
                                        {{-- Menggunakan helper Str::limit untuk tampilan yang rapi --}}
                                        {{ Illuminate\Support\Str::limit($user->pelamar_profil->pengalaman, 40) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.applicant_applications', $user) }}"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            Lihat Lamaran
                                        </a>
                                    </td>
                                @else
                                    {{-- Jika Data Profil Belum Dilengkapi --}}
                                    <td colspan="5" class="px-6 py-4 text-sm text-red-500 italic">
                                        Profil belum dilengkapi oleh Pelamar.
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.applicant_edit', $user) }}"
                                        class="text-yellow-600 hover:text-yellow-800 mr-2">
                                        Edit
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.applicant_delete', $user) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('❗ Peringatan: Yakin ingin menghapus data pelamar {{ $user->username }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
