@extends('layouts.pelamar.app')

@section('title', 'Data Diri')

@section('dashboard_content')
<div class="p-6 bg-white shadow-xl rounded-lg">
    <h1 class="text-3xl font-bold text-emerald-700 mb-6">
        {{ $profil ? 'Edit Data Diri' : 'Lengkapi Data Diri' }}
    </h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <p class="font-bold">Gagal menyimpan data:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pelamar.simpan_datadiry') }}">
        @csrf

        <div class="space-y-4">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" required
                       value="{{ old('nama', $profil->nama ?? '') }}"
                       class="mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:border-emerald-500 focus:ring-emerald-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="usia" class="block text-sm font-medium text-gray-700">Usia (Tahun)</label>
                    <input type="number" name="usia" id="usia" required
                           value="{{ old('usia', $profil->usia ?? '') }}"
                           class="mt-1 block w-full p-3 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" required
                            class="mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="kontak" class="block text-sm font-medium text-gray-700">Kontak/No. HP</label>
                <input type="text" name="kontak" id="kontak" required
                       value="{{ old('kontak', $profil->kontak ?? '') }}"
                       class="mt-1 block w-full p-3 border border-gray-300 rounded-lg">
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" rows="3" required
                          class="mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:border-emerald-500 focus:ring-emerald-500">{{ old('alamat', $profil->alamat ?? '') }}</textarea>
            </div>

            <div>
                <label for="pengalaman" class="block text-sm font-medium text-gray-700">Pengalaman Kerja (Opsional)</label>
                <textarea name="pengalaman" id="pengalaman" rows="4"
                          class="mt-1 block w-full p-3 border border-gray-300 rounded-lg">{{ old('pengalaman', $profil->pengalaman ?? '') }}</textarea>
            </div>

        </div>

        <div class="mt-6">
            <button type="submit" class="py-3 px-6 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 transition duration-150">
                {{ $profil ? 'Update Data Diri' : 'Simpan Data Diri' }}
            </button>
        </div>
    </form>
</div>
@endsection
