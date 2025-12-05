@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto p-8 bg-white rounded-xl shadow-2xl my-10 border-t-4 border-emerald-600">
    <h2 class="text-2xl font-bold text-emerald-800 mb-6 text-center">Masuk ke Sistem</h2>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <button type="submit" class="w-full py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 transition duration-150">
            Login
        </button>
    </form>

    <div class="mt-6 text-sm text-center">
        Belum punya akun? <a href="{{ route('register') }}" class="text-emerald-600 hover:underline font-medium">Daftar sekarang</a>.
    </div>
</div>
@endsection
