<!-- Menggunakan Layout Default Anda -->
@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto p-8 bg-white rounded-xl shadow-2xl my-10 border-t-4 border-emerald-600">
    <h2 class="text-2xl font-bold text-emerald-800 mb-6 text-center">Daftar Akun Pelamar</h2>
    <p class="text-center text-gray-500 mb-8">Role: <span class="font-semibold text-emerald-600">Pelamar</span></p>

    <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
        @csrf
        <!-- Hidden input untuk role -->
        <input type="hidden" name="role" value="{{ $role }}">

        <!-- Username -->
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            <!-- @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror -->
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <button type="submit" class="w-full py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 transition duration-150">
            Daftar Sebagai Pelamar
        </button>
    </form>
</div>
@endsection
