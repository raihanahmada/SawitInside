@extends('layouts.admin.app')

@section('title', 'Riwayat Lamaran')
@section('admin_page_title', 'Riwayat Lamaran')

@section('admin_content')

<div class="p-6 bg-white shadow-xl rounded-lg">
    <a href="{{ route('admin.applicants') }}" class="text-blue-600 hover:underline mb-4 inline-block">
        &larr; Kembali ke Daftar Pelamar
    </a>

    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">Riwayat Lamaran: {{ $applicant_name }}</h2>

    @if($applicant_applications->isEmpty())
        <div class="p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-lg">
            Pelamar ini belum mengajukan lamaran pekerjaan.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Lowongan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik Kebun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Lamaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Apply</th>                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($applicant_applications as $lamaran)
                    <tr>
                        {{-- Judul Lowongan --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $lamaran->lowongan->judul }}
                        </td>

                        {{-- Pemilik Kebun --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $lamaran->lowongan->pemilik->nama_pemilik ?? 'N/A' }}
                            <br>
                            <span class="text-xs text-gray-400">({{ $lamaran->lowongan->pemilik->user->username ?? '' }})</span>
                        </td>

                        {{-- Status Lamaran --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $status = $lamaran->status_lamaran;
                                $color = $status == 'diterima' ? 'bg-green-100 text-green-800' : ($status == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800');
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>

                        {{-- Tanggal Apply --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $lamaran->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
