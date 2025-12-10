@extends('layouts.pemilik.app')

@section('dashboard_content')
<div class="p-6 bg-white rounded-xl shadow-lg border-t-4 border-emerald-600">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 md:gap-0">
        <h2 class="text-2xl font-bold text-emerald-800">
            Lamaran Lowongan: {{ $lowongan->judul }}
        </h2>
        <a href="{{ route('pemilik.lowongan.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
            Kembali ke Lowongan
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse min-w-[600px]">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">Nama Pelamar</th>
                    <th class="border px-4 py-2 text-left">Status Lamaran</th>
                    <th class="border px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lamaran as $l)
                    <tr>
                        <td class="border px-4 py-2">{{ $l->pelamar->nama ?? '-' }}</td>
                        <td class="border px-4 py-2 capitalize">{{ $l->status_lamaran ?? 'menunggu' }}</td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex justify-center gap-1 flex-wrap items-center">
                                <form action="{{ route('pemilik.lamaran.accept', $l->id) }}" method="POST" onsubmit="return confirm('Terima lamaran ini?')">
                                    @csrf
                                    <button type="submit" class="px-2 py-2 bg-green-500 text-white rounded text-[10px] hover:bg-green-600 transition">
                                        TERIMA
                                    </button>
                                </form>
                                <form action="{{ route('pemilik.lamaran.reject', $l->id) }}" method="POST" onsubmit="return confirm('Tolak lamaran ini?')">
                                    @csrf
                                    <button type="submit" class="px-2 py-2 bg-red-500 text-white rounded text-[10px] hover:bg-red-600 transition">
                                        TOLAK
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border px-4 py-2 text-center text-gray-500">Belum ada lamaran</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection