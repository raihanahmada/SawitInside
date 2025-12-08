@extends('layouts.app')

@section('title', 'Login Masuk Sistem')

@section('content')
{{-- Container Utama: Full Height, Split Screen pada Desktop --}}
<div class="min-h-screen flex items-center justify-center bg-gray-50 overflow-hidden lg:bg-white">

    {{-- 🖼️ Bagian KIRI: Gambar Visual & Branding (Hanya terlihat di layar besar/LG ke atas) --}}
    <div class="hidden lg:block relative w-0 flex-1 bg-cover bg-center h-screen shadow-2xl"
         style="background-image: url('https://images.unsplash.com/photo-1598155523122-38423bb4d6c1?q=80&w=2000&auto=format&fit=crop');">
        {{-- Overlay Gelap untuk Keterbacaan Teks --}}
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-900/80 to-gray-900/40 mix-blend-multiply"></div>

        <div class="absolute inset-0 flex flex-col justify-center px-12 text-white z-10">
            <div data-aos="fade-right" data-aos-duration="1000">
                <span class="inline-block px-3 py-1 mb-4 text-sm font-semibold text-emerald-300 bg-emerald-900/50 rounded-full border border-emerald-500/30">
                    Sawit Inside Ecosystem
                </span>
                <h1 class="text-5xl font-extrabold mb-4 leading-tight">
                    Selamat Datang <br> Kembali!
                </h1>
                <p class="text-lg text-gray-200 max-w-md">
                    Masuk untuk mengelola produktivitas kebun, memantau pekerja, dan mengakses data operasional Anda.
                </p>
            </div>
        </div>
    </div>

    {{-- 📝 Bagian KANAN: Formulir Login --}}
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 w-full lg:w-[600px] h-screen bg-white z-10 relative">
        {{-- Hiasan Background Abstrak di sisi kanan --}}
        <div class="absolute top-0 right-0 -mt-20 -mr-20 overflow-hidden opacity-10 z-0 pointer-events-none">
            <i class="fas fa-leaf text-[300px] text-emerald-600 transform rotate-45"></i>
        </div>

        <div class="mx-auto w-full max-w-sm lg:w-96 z-10 relative" data-aos="fade-up" data-aos-duration="800">
            {{-- Header Mobile (Logo/Judul Kecil) --}}
            <div class="text-center lg:text-left mb-8">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Masuk ke Akun
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Atau
                    <a href="{{ route('register') }}" class="font-medium text-emerald-600 hover:text-emerald-500 transition underline decoration-2 decoration-emerald-200 hover:decoration-emerald-500">
                        daftar sebagai pengguna baru
                    </a>
                </p>
            </div>

            {{-- Alerts: Success & Errors --}}
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg animate-fade-in-up">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg animate-shake">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg animate-shake" data-aos="shake">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                            <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ======================================================= --}}
            {{-- 🔥 FITUR BARU: LOGIN GOOGLE (Integrasi dari Teman) --}}
            {{-- ======================================================= --}}
            <div class="mt-2">
                <a href="{{ route('auth.google') }}"
                   class="w-full flex justify-center items-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-300 transform hover:-translate-y-0.5">
                    {{-- Ikon Google berwarna asli --}}
                    <i class="fab fa-google text-lg mr-3" style="color: #DB4437;"></i>
                    Masuk dengan Google
                </a>
            </div>

            {{-- Divider "ATAU" --}}
            <div class="mt-6 relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Atau lanjutkan dengan email</span>
                </div>
            </div>
            {{-- ======================================================= --}}

            {{-- Form Login Manual --}}
            <div class="mt-6">
                <form method="POST" action="{{ url('/login') }}" class="space-y-6">
                    @csrf

                    {{-- Input Email --}}
                    <div data-aos="fade-up" data-aos-delay="100">
                        <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <div class="mt-2 relative rounded-md shadow-sm group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400 group-focus-within:text-emerald-600 transition-colors"></i>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-all duration-300"
                                   placeholder="nama@email.com">
                        </div>
                    </div>

                    {{-- Input Password --}}
                    <div data-aos="fade-up" data-aos-delay="200">
                        <div class="flex justify-between items-center">
                             <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                        </div>

                        <div class="mt-2 relative rounded-md shadow-sm group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400 group-focus-within:text-emerald-600 transition-colors"></i>
                            </div>
                            <input type="password" name="password" id="password" required
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-all duration-300"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div data-aos="fade-up" data-aos-delay="300">
                        <button type="submit"
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-sign-in-alt text-emerald-200 group-hover:text-white group-hover:translate-x-1 transition-transform duration-300"></i>
                            </span>
                            Masuk Sekarang
                        </button>
                    </div>
                </form>
            </div>

            {{-- Footer Mobile Only --}}
            <div class="mt-10 lg:hidden text-center">
                 <p class="text-xs text-gray-500">&copy; 2025 Sawit Inside. Aman & Terpercaya.</p>
            </div>
        </div>
    </div>
</div>
@endsection
