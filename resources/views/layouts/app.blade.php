<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sawit Inside | @yield('title', 'Manajemen Perkebunan')</title>

    {{-- 1. Font Awesome & Tailwind --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- 2. Chart JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- 3. TAMBAHAN: CSS untuk AOS (Animate On Scroll) --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-gray-50 font-sans">

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <a href="/">
                {{-- Ambil path logo dari global settings --}}
                @php
                    $logoPath = $global_settings['logo_path'] ?? null;
                @endphp

                @if ($logoPath)
                    {{-- Tampilkan GAMBAR jika logo_path tersedia --}}
                    <img src="{{ asset($logoPath) }}" alt="Logo Sawit Inside" class="h-8 w-auto">
                @else
                    {{-- Tampilkan TEKS jika logo_path kosong atau belum diatur --}}
                    <p class="text-2xl font-bold text-emerald-700">
                        Sawit Inside 🌴
                    </p>
                @endif
            </a>

            <div class="space-x-4">
                {{-- Tampilkan tombol Login/Register jika user belum login --}}
                @guest
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-emerald-600 font-medium transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 transition shadow-lg">
                        Registrasi
                    </a>
                @endguest

                {{-- Tampilkan tombol Logout jika user sudah login --}}
                @auth
                    <span class="text-gray-700 mr-4">Selamat Datang, {{ Auth::user()->username }}</span>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>

                @endauth
            </div>
        </div>
    </nav>

    <main>
        {{-- Hapus div max-w-7xl mx-auto dari sini --}}

            {{-- Bagian untuk menampilkan notifikasi success --}}
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 mx-4 sm:mx-0">
                {{ session('success') }}
            </div>
            @endif

            {{-- Slot tempat konten spesifik halaman akan dimasukkan --}}
        @if (Auth::check() && Auth::user()->role === 'admin')
            {{-- Jika ADMIN, konten akan full-width di-handle oleh layout admin --}}
            @yield('content')
        @else
            {{-- Jika GUEST atau PELAMAR/OWNER, gunakan wrapper lebar terbatas (max-w-7xl) --}}
            {{-- TAMBAHAN: overflow-x-hidden ditambahkan agar animasi AOS tidak membuat scroll samping --}}
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-10 overflow-x-hidden">
                @yield('content')
            </div>
        @endif
    </main>

    <footer class="bg-gray-100 border-t border-gray-200 mt-auto py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
            &copy; 2025 Sawit Inside. All Rights Reserved.
        </div>
    </footer>

    {{-- ========================================================================= --}}
    {{-- SCRIPTS --}}
    {{-- ========================================================================= --}}

    {{-- 1. Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- 2. TAMBAHAN: Script AOS & Inisialisasi --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true, // Animasi hanya berjalan sekali saat scroll ke bawah
            duration: 1000, // Durasi animasi dalam milidetik (1 detik)
            offset: 120, // Jarak trigger animasi dari bawah layar (pixel)
        });
    </script>

</body>


</html>

