@extends('layouts.pelamar')

@section('title', 'Data Diri')
@section('page-title', 'Data Diri')
@section('page-subtitle', 'Lengkapi informasi pribadi Anda')

@section('content')
<div class="card fade-in">
    <div class="card-header">
        <h5 class="card-title mb-0">Informasi Data Diri</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- GUNAKAN URL LANGSUNG UNTUK MENGHINDARI ERROR ROUTE -->
        <form method="POST" action="{{ url('/pelamar/data-diri') }}">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control"
                           value="{{ old('nama', $profil->nama ?? auth()->user()->name ?? '') }}" required>
                </div>

                <div class="col-md-3">
                    <label for="usia" class="form-label">Usia (Tahun)</label>
                    <input type="number" name="usia" id="usia" class="form-control"
                           value="{{ old('usia', $profil->usia ?? '') }}" min="18" max="65">
                </div>

                <div class="col-md-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ (old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ (old('jenis_kelamin', $profil->jenis_kelamin ?? '') == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="no_hp" class="form-label">Kontak/No. HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control"
                           value="{{ old('no_hp', $profil->no_hp ?? '') }}" required>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                           value="{{ old('email', auth()->user()->email ?? '') }}" readonly>
                </div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat', $profil->alamat ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="pengalaman_kerja" class="form-label">Pengalaman Kerja (Opsional)</label>
                <textarea name="pengalaman_kerja" id="pengalaman_kerja" class="form-control" rows="4">{{ old('pengalaman_kerja', $profil->pengalaman_kerja ?? '') }}</textarea>
                <div class="form-text">Contoh: Pernah menjadi pemanen selama 3 tahun</div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('pelamar.dashboard') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
