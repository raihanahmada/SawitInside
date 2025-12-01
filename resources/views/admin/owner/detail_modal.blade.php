<div class="p-6">
    <h3 class="text-2xl font-bold text-gray-800 border-b pb-3 mb-4">Verifikasi Detail Pemilik Kebun</h3>

    <div class="grid grid-cols-2 gap-4 mb-6 text-gray-700">
        <div>
            <p class="font-semibold text-sm text-gray-500 uppercase">Data Akun</p>
            <p><span class="font-medium">Username:</span> {{ $owner_detail->username }}</p>
            <p><span class="font-medium">Email:</span> {{ $owner_detail->email }}</p>
            <p><span class="font-medium">Tanggal Regis:</span> {{ $owner_detail->created_at->format('d M Y') }}</p>
        </div>

        <div>
            <p class="font-semibold text-sm text-gray-500 uppercase">Data Kebun & Kontak</p>
            <p><span class="font-medium">Nama Pemilik:</span> {{ $owner_detail->pemilik_kebun->nama_pemilik }}</p>
            <p><span class="font-medium">Lokasi:</span> {{ $owner_detail->pemilik_kebun->lokasi_kebun }}</p>
            <p><span class="font-medium">Luas Kebun:</span> {{ $owner_detail->pemilik_kebun->luas_kebun }}</p>
            <p><span class="font-medium">Kontak (WA):</span> {{ $owner_detail->pemilik_kebun->kontak }}</p>
        </div>
    </div>

    <div class="mt-4 p-4 border-t border-gray-200">
        <p class="font-semibold text-lg text-red-600 mb-3">Bukti Kepemilikan Dokumen:</p>

        @php
            $docPath = $owner_detail->pemilik_kebun->foto_dokumen;
            // Asumsi file disimpan di storage/app/public dan diakses via /storage
            $publicUrl = asset('storage/' . $docPath);
        @endphp

        <a href="{{ $publicUrl }}" target="_blank" class="text-blue-600 hover:underline">
            <i class="fas fa-file-image mr-2"></i> Lihat Dokumen Bukti
        </a>

        {{-- Anda bisa menampilkan gambar pratinjau di sini, contoh: --}}
        {{-- <img src="{{ $publicUrl }}" class="mt-4 max-w-full h-auto border rounded shadow-md" alt="Bukti Dokumen"> --}}

    </div>

</div>
