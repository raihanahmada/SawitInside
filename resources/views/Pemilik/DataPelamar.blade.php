@extends('layouts.pemilik.app')

@section('pemilik_content')
<div class="space-y-6">

    {{-- Header Halaman --}}
    <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-emerald-600 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Semua Lamaran Masuk</h2>
            <p class="text-gray-500 text-sm mt-1">Kelola semua pelamar dari seluruh lowongan kerja Anda di sini.</p>
        </div>
        <div class="text-right">
            <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-3 py-1 rounded-full">
                Total: {{ $riwayat->count() }} Pelamar
            </span>
        </div>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 shadow-sm flex items-center">
            <i class="fas fa-check-circle mr-2 text-lg"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Semua Pelamar --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4">Pelamar</th>
                        <th class="px-6 py-4">Posisi Dilamar</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($riwayat as $item)
                    <tr class="hover:bg-gray-50 transition duration-150">

                        {{-- 1. Info Pelamar --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                {{-- Avatar --}}
                                <div class="flex-shrink-0">
                                    <div class="relative w-10 h-10">
                                        @if($item->pelamar->user->google_avatar)
                                            <img class="w-10 h-10 rounded-full border border-gray-200 object-cover" src="{{ $item->pelamar->user->google_avatar }}" alt="Avatar">
                                        @elseif($item->pelamar->foto)
                                            <img class="w-10 h-10 rounded-full border border-gray-200 object-cover" src="{{ asset('storage/foto_profil/' . $item->pelamar->foto) }}" alt="Avatar">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold border border-emerald-200">
                                                {{ substr($item->pelamar->nama, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                {{-- Nama --}}
                                <div>
                                    <div class="text-sm font-bold text-gray-900">{{ $item->pelamar->nama }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->pelamar->usia }} Tahun / {{ $item->pelamar->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>

                                    {{-- Tombol Lihat Detail --}}
                                    <button onclick="openModal('modal-{{ $item->id }}')" class="mt-1 text-xs text-blue-600 hover:underline flex items-center">
                                        <i class="fas fa-eye mr-1"></i> Detail
                                    </button>
                                </div>
                            </div>
                        </td>

                        {{-- 2. Posisi Dilamar --}}
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-emerald-700">
                                {{ $item->lowongan->judul }}
                            </div>
                            <div class="text-xs text-gray-500 truncate w-32">
                                <i class="fas fa-map-marker-alt mr-1"></i> {{ $item->lowongan->lokasi_kerja }}
                            </div>
                        </td>

                        {{-- 3. Kontak (WA) --}}
                        <td class="px-6 py-4">
                            @if($item->pelamar->kontak)
                                @php
                                    $hp = preg_replace('/[^0-9]/', '', $item->pelamar->kontak);
                                    if(substr($hp, 0, 2) == '08') $hp = '62' . substr($hp, 1);
                                @endphp
                                <a href="https://wa.me/{{ $hp }}" target="_blank" class="inline-flex items-center text-green-600 hover:text-green-800 font-medium transition">
                                    <i class="fab fa-whatsapp text-lg mr-1"></i> Hubungi
                                </a>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $item->pelamar->kontak }}</div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        {{-- 4. Tanggal --}}
                        <td class="px-6 py-4">
                            <div class="text-gray-900">{{ $item->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-400">{{ $item->created_at->format('H:i') }} WIB</div>
                        </td>

                        {{-- 5. Status --}}
                        <td class="px-6 py-4 text-center">
                            @if($item->status_lamaran == 'menunggu')
                                <span class="px-3 py-1 text-xs font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full border border-yellow-200">
                                    Menunggu
                                </span>
                            @elseif($item->status_lamaran == 'diterima')
                                <span class="px-3 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded-full border border-green-200">
                                    Diterima
                                </span>
                            @elseif($item->status_lamaran == 'ditolak')
                                <span class="px-3 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded-full border border-red-200">
                                    Ditolak
                                </span>
                            @endif
                        </td>

                        {{-- 6. Aksi --}}
                        <td class="px-6 py-4 text-center">
                            @if($item->status_lamaran == 'menunggu')
                                <div class="flex justify-center gap-2">
                                    <form action="{{ route('pemilik.lamaran.accept', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Terima pelamar ini?')" class="text-white bg-emerald-500 hover:bg-emerald-600 focus:ring-4 focus:ring-emerald-300 font-medium rounded-lg text-xs px-3 py-1.5 transition shadow-sm" title="Terima">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('pemilik.lamaran.reject', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Tolak lamaran ini?')" class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 transition shadow-sm" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-400 text-xs italic"><i class="fas fa-lock mr-1"></i> Selesai</span>
                            @endif
                        </td>
                    </tr>

                    {{-- 🔥 MODAL DETAIL PELAMAR (Di dalam loop) --}}
                    <div id="modal-{{ $item->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 transition-opacity backdrop-blur-sm" onclick="closeModal('modal-{{ $item->id }}')"></div>
                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                                {{-- Header Modal --}}
                                <div class="bg-emerald-600 px-6 py-4 flex justify-between items-center">
                                    <h3 class="text-lg leading-6 font-bold text-white flex items-center">
                                        <i class="fas fa-id-card mr-2"></i> Biodata Pelamar
                                    </h3>
                                    <button onclick="closeModal('modal-{{ $item->id }}')" class="text-emerald-100 hover:text-white focus:outline-none">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>

                                <div class="px-6 py-6">
                                    {{-- Info Utama --}}
                                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 mb-6">
                                        <div class="shrink-0">
                                            @if($item->pelamar->user->google_avatar)
                                                <img src="{{ $item->pelamar->user->google_avatar }}" class="w-24 h-24 rounded-full object-cover border-4 border-emerald-50 shadow-md">
                                            @elseif($item->pelamar->foto)
                                                <img src="{{ asset('storage/foto_profil/' . $item->pelamar->foto) }}" class="w-24 h-24 rounded-full object-cover border-4 border-emerald-50 shadow-md">
                                            @else
                                                <div class="w-24 h-24 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-4xl border-4 border-emerald-50 shadow-md">
                                                    {{ substr($item->pelamar->nama, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-center sm:text-left w-full">
                                            <h4 class="text-2xl font-bold text-gray-800">{{ $item->pelamar->nama }}</h4>
                                            <p class="text-emerald-600 font-medium mb-2">Pelamar untuk: {{ $item->lowongan->judul }}</p>
                                            <div class="text-sm text-gray-500">
                                                <span class="block mb-1"><i class="fas fa-envelope mr-1.5"></i> {{ $item->pelamar->user->email }}</span>
                                                <span class="block"><i class="fas fa-calendar-alt mr-1.5"></i> Gabung: {{ $item->pelamar->user->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="border-gray-200 mb-6">

                                    {{-- Grid Detail --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                                        <div class="space-y-4">
                                            <div>
                                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Usia & Gender</label>
                                                <p class="font-medium text-gray-800">{{ $item->pelamar->usia }} Tahun - {{ $item->pelamar->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                            </div>
                                            <div>
                                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Kontak</label>
                                                <p class="font-medium text-gray-800">{{ $item->pelamar->kontak ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Alamat Domisili</label>
                                                <p class="font-medium text-gray-800 leading-relaxed">{{ $item->pelamar->alamat ?? 'Belum diisi' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Pengalaman --}}
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2 block">Pengalaman Kerja</label>
                                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 text-gray-700 text-sm leading-relaxed max-h-40 overflow-y-auto">
                                            @if($item->pelamar->pengalaman)
                                                {!! nl2br(e($item->pelamar->pengalaman)) !!}
                                            @else
                                                <span class="text-gray-400 italic">Tidak ada data pengalaman.</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Footer Modal --}}
                                <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-2">
                                    <button type="button" onclick="closeModal('modal-{{ $item->id }}')" class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:text-sm transition">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END MODAL --}}

                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-clipboard-list text-5xl mb-4 text-gray-200"></i>
                                <p class="text-lg font-medium text-gray-500">Belum ada riwayat lamaran.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection
