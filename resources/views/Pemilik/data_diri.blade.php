@extends('layouts.pemilik.app')

@section('pemilik_content')
<div class="p-6 bg-white rounded-xl shadow-lg border-t-4 border-emerald-600">

    <h2 class="text-2xl font-bold text-emerald-800">Data Diri Pemilik Kebun</h2>

    <form action="{{ route('pemilik.simpan_dataDiri') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Informasi Akun --}}
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-1">Informasi Akun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-600">Username</label>
                    <input type="text" value="{{ Auth::user()->username }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-600">Email</label>
                    <input type="email" value="{{ Auth::user()->email }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-600">Password</label>
                    <input type="password" value="********" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-600">Role</label>
                    <input type="text" value="{{ Auth::user()->role }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed focus:outline-none">
                </div>
                <div>
                    <label class="block text-gray-600">Dibuat pada</label>
                    <input type="text" value="{{ Auth::user()->created_at->format('d M Y H:i') }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed focus:outline-none">
                </div>
            </div>
        </div>

        {{-- Informasi Kepemilikan Kebun --}}
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-1">Informasi Kepemilikan Kebun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-600">Nama Pemilik</label>
                    <input type="text" name="nama" value="{{ $profil->nama_pemilik ?? '' }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
                <div>
                    <label class="block text-gray-600">Luas Kebun (m²)</label>
                    <input type="number" name="luas_kebun" value="{{ $profil->luas_kebun ?? '' }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
                <div>
                    <label class="block text-gray-600">Lokasi Kebun</label>
                    <input type="text" name="lokasi_kebun" value="{{ $profil->lokasi_kebun ?? '' }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
                <div>
                    <label class="block text-gray-600">Kontak</label>
                    <input type="text" name="kontak" value="{{ $profil->kontak ?? '' }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-600">Foto Dokumen</label>
                    @if(!empty($profil->foto_dokumen))
                        <div class="mb-2">
                            <img src="{{ asset('storage/foto_pemilik/'.$profil->foto_dokumen) }}" alt="Dokumen" class="w-32 h-32 object-cover rounded border">
                        </div>
                    @endif
                    <input type="file" name="foto_dokumen" accept="image/*" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection