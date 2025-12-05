<div class="p-6">
    <h3 class="text-2xl font-bold text-gray-800 border-b pb-3 mb-4">Detail Lowongan: {{ $lowongan->judul }}</h3>

    <div class="grid grid-cols-2 gap-4 mb-6 text-gray-700">
        <div>
            <p class="font-semibold text-sm text-gray-500 uppercase">Rincian Pekerjaan</p>
            <p><span class="font-medium">Kebutuhan:</span> {{ $lowongan->jumlah_kebutuhan }} pekerja</p>
            <p><span class="font-medium">Upah:</span> {{ $lowongan->upah ?? 'N/A' }}</p>
            <p><span class="font-medium">Jam Kerja:</span> {{ $lowongan->jam_kerja ?? 'N/A' }}</p>
            <p><span class="font-medium">Lokasi Kerja:</span> {{ $lowongan->lokasi_kerja ?? 'N/A' }}</p>
            <p><span class="font-medium">Batas Pelamar:</span> {{ $lowongan->batas_pelamar }}</p>
             <p><span class="font-medium">Batas Pelamar:</span>  {{$lowongan->deskripsi }}</p>
        </div>

        <div>
            <p class="font-semibold text-sm text-gray-500 uppercase">Data Pemilik</p>

            @php
                $pemilik = $lowongan->pemilik;
                $userPemilik = $pemilik->user ?? null; // Dapatkan objek User, atau null jika tidak ada
            @endphp

            <p><span class="font-medium">Nama Pemilik:</span> {{ $pemilik->nama_pemilik ?? 'N/A' }}</p>

            {{-- SAFEGUARD: Cek apakah relasi User ada sebelum mengakses username --}}
            <p><span class="font-medium">Username:</span> {{ $userPemilik->username ?? 'Akun User Hilang' }}</p>

            <p><span class="font-medium">Lokasi Kebun:</span> {{ $pemilik->lokasi_kebun ?? 'N/A' }}</p>
            <p><span class="font-medium">Kontak (WA):</span> {{ $pemilik->kontak ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="mt-8 flex justify-end space-x-3 border-t pt-4">
        @if ($lowongan->status === 'menunggu_acc')
            {{-- Tombol Setujui --}}
            <form action="{{ route('admin.approve_vacancy', $lowongan) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Setujui & Aktifkan</button>
            </form>

            {{-- Tombol Tolak --}}
            <form action="{{ route('admin.reject_vacancy', $lowongan) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Tolak Lowongan</button>
            </form>
        @else
            <p class="text-lg font-medium text-gray-500">Status: {{ ucfirst($lowongan->status) }}</p>
        @endif
    </div>
</div>
