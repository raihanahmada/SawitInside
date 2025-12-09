@extends('layouts.app')

@section('title', 'Pendaftaran Pelamar')

@section('content')
    <div class="min-h-screen flex bg-white">

        {{-- 🖼️ BAGIAN KIRI: Visual (Tetap Sama) --}}
        <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900 justify-center items-center overflow-hidden">
            <img src="{{ asset($global_settings['hero_image_path'] ?? 'images/default_register_bg.jpg') }}"
                alt="Pekerja Sawit" class="absolute inset-0 h-full w-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-t from-emerald-900 via-transparent to-black/40"></div>

            <div class="relative z-10 p-12 text-white max-w-lg" data-aos="fade-up">
                <div class="mb-6">
                    <span class="bg-yellow-500 text-black text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                        Mitra Pekerja
                    </span>
                </div>
                <h2 class="text-4xl font-extrabold mb-4 leading-tight">
                    Tingkatkan Taraf Hidup Anda Bersama <span class="text-emerald-400">Sawit Inside</span>
                </h2>
                <p class="text-lg text-gray-200 mb-8">
                    Dapatkan akses ke ratusan lowongan pekerjaan perkebunan terpercaya.
                </p>
            </div>
        </div>

        {{-- 📝 BAGIAN KANAN: Formulir Pendaftaran --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 overflow-y-auto">
            <div class="w-full max-w-md space-y-6">

                {{-- Header Form --}}
                <div class="text-center lg:text-left" data-aos="fade-down">
                    <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm text-gray-500 hover:text-emerald-600 mb-6 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        Buat Akun Pelamar
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Daftar cepat dengan Google atau isi form manual.
                    </p>
                </div>

                {{-- 🟢 TOMBOL DAFTAR GOOGLE (DITAMBAHKAN) --}}
                <div class="mt-8">
                    <a href="{{ route('auth.google') }}"
                       class="w-full flex justify-center items-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-black transition-all duration-300 transform hover:-translate-y-0.5">
                        {{-- Ikon Google --}}
                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="w-5 h-5 mr-3">
                        Daftar Cepat dengan Google
                    </a>
                </div>

                {{-- Divider "ATAU" --}}
                <div class="relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Atau daftar manual</span>
                    </div>
                </div>

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

                {{-- Form Manual --}}
                <form method="POST" action="{{ route('register.post') }}" class="mt-2 space-y-6">
                    @csrf
                    <input type="hidden" name="role" value="{{ $role }}">

                    {{-- Username --}}
                    <div data-aos="fade-up" data-aos-delay="100">
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <div class="mt-1 relative rounded-md shadow-sm group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                            </div>
                            <input type="text" name="username" id="username" value="{{ old('username') }}" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-all"
                                placeholder="Contoh: joko_sawit123">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div data-aos="fade-up" data-aos-delay="200">
                        <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <div class="mt-1 relative rounded-md shadow-sm group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-all"
                                placeholder="nama@email.com">
                        </div>
                    </div>

                    {{-- Password Grid --}}
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div data-aos="fade-up" data-aos-delay="300">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                </div>
                                <input type="password" name="password" id="password" required
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-all"
                                    placeholder="******">
                            </div>
                        </div>

                        <div data-aos="fade-up" data-aos-delay="400">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Ulangi Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-check-circle text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-all"
                                    placeholder="******">
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Daftar Manual --}}
                    <div data-aos="fade-up" data-aos-delay="500">
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-user-plus text-emerald-200 group-hover:text-white transition-colors"></i>
                            </span>
                            Daftar Sekarang
                        </button>
                    </div>

                    {{-- Footer Link --}}
                    <div class="text-center mt-4" data-aos="fade-in" data-aos-delay="600">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-medium text-emerald-600 hover:text-emerald-500 underline decoration-2 decoration-transparent hover:decoration-emerald-500 transition-all">
                                Login di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
