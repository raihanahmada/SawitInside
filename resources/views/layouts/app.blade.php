<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sawit Inside | @yield('title', 'Manajemen Perkebunan')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-emerald-700">
                Sawit Inside 🌴
            </a>

            <div class="space-x-4">
                {{-- Tampilkan tombol Login/Register jika user belum login --}}
                @guest
                    <a href="{{route('login')}}" class="text-gray-600 hover:text-emerald-600 font-medium transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 transition shadow-lg">
                        Registrasi
                    </a>
                @endguest

                {{-- Tampilkan tombol Logout jika user sudah login --}}
                @auth
                    <span class="text-gray-700 mr-4">Selamat Datang, {{ Auth::user()->username }}</span>
                    <form method="POST" action="#" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Bagian untuk menampilkan notifikasi success --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 mx-4 sm:mx-0">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Slot tempat konten spesifik halaman akan dimasukkan --}}
            @yield('content')

        </div>
    </main>

    <footer class="bg-gray-100 border-t border-gray-200 mt-auto py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
            &copy; 2025 Sawit Inside. All Rights Reserved.
        </div>
    </footer>

</body>
</html>
