@extends('layouts.pemilik.app')

@section('pemilik_content')
<div class="p-6 bg-white rounded-xl shadow-lg border-t-4 border-emerald-600">
      {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="rounded-md bg-red-50 p-4 border-l-4 border-red-500 animate-shake">
                        <div class="flex">
                            <div class="flex-shrink-0"><i class="fas fa-times-circle text-red-400"></i></div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Perhatikan hal berikut:</h3>
                                <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-emerald-800">Data Diri Pemilik Kebun</h2>
    </div>

    <form action="{{ route('pemilik.simpan_dataDiri') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        {{-- BAGIAN FOTO PROFIL --}}
        <div class="flex flex-col items-center justify-center p-6 bg-emerald-50 rounded-lg border border-emerald-100">
            <div class="relative group">
                {{-- Tampilkan Foto --}}
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-md bg-gray-200 flex items-center justify-center">
                    @if(isset($profil) && $profil->foto_profil)
                        <img src="{{ asset('storage/foto_profil/' . $profil->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-user text-4xl text-gray-400"></i>
                    @endif
                </div>

                {{-- Input File Overlay --}}
                <label for="foto_profil" class="absolute bottom-0 right-0 bg-emerald-600 text-white p-2 rounded-full cursor-pointer hover:bg-emerald-700 shadow-lg transition transform hover:scale-110">
                    <i class="fas fa-camera"></i>
                    <input type="file" name="foto_profil" id="foto_profil" class="hidden" accept="image/*" onchange="previewImage(this)">
                </label>
            </div>
            <p class="text-sm text-gray-500 mt-2">Klik ikon kamera untuk ubah foto</p>
        </div>

        {{-- Informasi Akun --}}
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-1">Informasi Akun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-600 text-sm font-medium mb-1">Username</label>
                    <input type="text" value="{{ Auth::user()->username }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed text-gray-500">
                </div>
                <div>
                    <label class="block text-gray-600 text-sm font-medium mb-1">Email</label>
                    <input type="email" value="{{ Auth::user()->email }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed text-gray-500">
                </div>
                <div>
                    <label class="block text-gray-600 text-sm font-medium mb-1">Role</label>
                    <input type="text" value="{{ ucfirst(Auth::user()->role) }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed text-gray-500">
                </div>
                <div>
                    <label class="block text-gray-600 text-sm font-medium mb-1">Bergabung Sejak</label>
                    <input type="text" value="{{ Auth::user()->created_at->format('d M Y') }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed text-gray-500">
                </div>
            </div>
        </div>

        {{-- Informasi Kepemilikan Kebun --}}
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-1">Informasi Kepemilikan Kebun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-600 text-sm font-medium mb-1">Nama Lengkap Pemilik</label>
                    <input type="text" name="nama" value="{{ $profil->nama_pemilik ?? '' }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400 placeholder-gray-300" placeholder="Contoh: Budi Santoso" required>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm font-medium mb-1">Nomor Kontak / WA</label>
                    <input type="text" name="kontak" value="{{ $profil->kontak ?? '' }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400 placeholder-gray-300" placeholder="08xxxxxxxxxx" required>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm font-medium mb-1">Luas Kebun (m²)</label>
                    <div class="relative">
                        <input type="number" name="luas_kebun" value="{{ $profil->luas_kebun ?? '' }}" class="w-full border rounded pl-3 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400" placeholder="5000" required>
                        <span class="absolute right-3 top-2 text-gray-400">m²</span>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-600 text-sm font-medium mb-1">Lokasi Kebun</label>
                    <input type="text" name="lokasi_kebun" value="{{ $profil->lokasi_kebun ?? '' }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400 placeholder-gray-300" placeholder="Nama Desa / Kecamatan" required>
                </div>

                {{-- Foto Dokumen --}}
                <div class="md:col-span-2">
                    <label class="block text-gray-600 text-sm font-medium mb-2">Foto Dokumen Kebun (Opsional)</label>
                    <div class="flex items-start space-x-4">
                        @if(!empty($profil->foto_dokumen))
                            <div class="shrink-0">
                                <p class="text-xs text-gray-500 mb-1">Saat ini:</p>
                                <img src="{{ asset('storage/foto_pemilik/'.$profil->foto_dokumen) }}" alt="Dokumen" class="w-24 h-24 object-cover rounded border shadow-sm">
                            </div>
                        @endif
                        <div class="w-full">
                            <input type="file" name="foto_dokumen" accept="image/*" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-emerald-50 file:text-emerald-700
                                hover:file:bg-emerald-100
                            "/>
                            <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks: 2MB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Simpan --}}
        <div class="pt-4 border-t flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-200 transition shadow-lg transform hover:-translate-y-0.5">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

{{-- Script Preview Gambar (Opsional untuk UX) --}}
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Mencari elemen img terdekat di dalam div pembungkus
                let imgPreview = input.closest('.relative').querySelector('img');
                if(imgPreview) {
                    imgPreview.src = e.target.result;
                } else {
                    // Jika belum ada gambar (masih icon), reload halaman atau manipulasi DOM lebih lanjut
                    // Cara sederhana:
                    location.reload();
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
