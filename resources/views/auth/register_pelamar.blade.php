@extends('layouts.app')

@section('title', 'Pendaftaran Pelamar')

@section('content')
<div class="min-h-screen flex bg-white">

    {{-- 🖼️ BAGIAN KIRI: Visual & Motivasi (Desktop Only) --}}
    <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900 justify-center items-center overflow-hidden">
        {{-- Background Image: Suasana Panen/Kebun --}}
        <img src="https://images.unsplash.com/photo-1595245873264-706798e22f2f?q=80&w=2000&auto=format&fit=crop"
             alt="Pekerja Sawit"
             class="absolute inset-0 h-full w-full object-cover opacity-60">

        {{-- Overlay Gradient --}}
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
                Dapatkan akses ke ratusan lowongan pekerjaan perkebunan terpercaya. Mulai dari pemanen, perawatan, hingga tenaga ahli.
            </p>

            {{-- Testimonial Kecil (Opsional) --}}
            <div class="flex items-center space-x-4 bg-white/10 p-4 rounded-xl backdrop-blur-sm border border-white/20">
                <div class="flex-shrink-0">
                    <i class="fas fa-quote-left text-yellow-400 text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm italic">"Platform ini membantu saya mendapatkan pekerjaan di kebun besar dengan gaji yang transparan."</p>
                    <p class="text-xs font-bold mt-1 text-emerald-300">- Budi Santoso, Pemanen</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 📝 BAGIAN KANAN: Formulir Pendaftaran --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 overflow-y-auto">
        <div class="w-full max-w-md space-y-8">

            {{-- Header Form --}}
            <div class="text-center lg:text-left" data-aos="fade-down">
                <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm text-gray-500 hover:text-emerald-600 mb-6 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke pemilihan role
                </a>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                    Buat Akun Pelamar
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Lengkapi data diri Anda untuk mulai melamar pekerjaan.
                </p>
            </div>

            <form method="POST" action="{{ route('register.post') }}" class="mt-8 space-y-6">
                @csrf
                <input type="hidden" name="role" value="{{ $role }}">

                {{-- Alert Error Global (Jika ada) --}}
                @if($errors->any())
                    <div class="rounded-md bg-red-50 p-4 border-l-4 border-red-500 animate-shake">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-times-circle text-red-400"></i>
                            </div>
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

                {{-- Input Username --}}
                <div data-aos="fade-up" data-aos-delay="100">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <div class="mt-1 relative rounded-md shadow-sm group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400 group-focus-within:text-emerald-500 transition-colors"></i>
                        </div>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-all"
                            placeholder="Contoh: joko_sawit123">
                    </div>
                </div>

                {{-- Input Email --}}
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

                {{-- Grid Password (Kiri Kanan di layar besar) --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    {{-- Input Password --}}
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

                    {{-- Input Konfirmasi Password --}}
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

                {{-- Tombol Daftar --}}
                <div data-aos="fade-up" data-aos-delay="500">
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
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
