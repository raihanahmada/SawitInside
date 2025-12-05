{{-- resources/views/Admin/management/edit_applicant.blade.php --}}

@extends('layouts.admin.app')

@section('title', 'Edit Pelamar')
@section('admin_page_title', 'Edit Data Pelamar: ' . $user->username)

@section('admin_content')

<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <a href="{{ route('admin.applicants') }}" class="text-blue-600 hover:underline mb-4 inline-block">&larr; Kembali ke Daftar Pelamar</a>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Data Akun & Profil</h2>

    <form method="POST" action="{{ route('admin.applicant_update', $user) }}">
        @csrf
        @method('PUT') {{-- Gunakan method PUT untuk update --}}

        <h3 class="text-xl font-semibold text-emerald-700 mb-4 border-b pb-2">Data Akun Login</h3>
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg">
                @error('username')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg">
                <p class="text-gray-500 text-xs mt-1">Isi hanya jika ingin mengganti password.</p>
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg">
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="px-6 py-3 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 shadow-md">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
