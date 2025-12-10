<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sawit Inside | @yield('title', 'Manajemen Perkebunan')</title>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    {{-- Chart JS & Tailwind --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Transisi halus untuk margin konten saat sidebar toggle */
        #main-content, #main-footer {
            transition: margin-left 0.3s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">

    <!-- 1. NAVBAR FIXED -->
    <nav class="bg-white shadow-sm fixed top-0 left-0 right-0 z-50 h-16 flex items-center border-b border-gray-200">
        <div class="w-full px-4 flex justify-between items-center">

            <!-- KIRI: Toggle & Logo -->
            <div class="flex items-center gap-3">
                <!-- Tombol Toggle (Muncul di Mobile & Desktop) -->
                <button onclick="toggleSidebar()" 
                        class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <a href="{{ route('pemilik.dashboard') }}" class="text-xl md:text-2xl font-bold text-emerald-700 tracking-tight">
                    Sawit Inside 🌴
                </a>
            </div>

            <!-- KANAN: Menu User -->
            <div class="flex items-center space-x-4">
                @auth
                    <div class="hidden md:block text-right">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->username }}</p>
                        <p class="text-xs text-gray-500">Pemilik Kebun</p>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" 
                                class="p-2 text-gray-500 hover:text-red-600 transition" 
                                title="Logout">
                            <i class="fas fa-sign-out-alt text-xl"></i>
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-emerald-600">Login</a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- 2. SIDEBAR -->
    <!-- Mobile: Hidden by default (-translate-x-full) -->
    <!-- Desktop: Visible by default (lg:translate-x-0) -->
    <aside id="sidebar"
        class="fixed left-0 top-16 w-64 h-[calc(100vh-64px)] bg-white border-r border-gray-200 shadow-lg overflow-y-auto 
               transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">

        <!-- User Info (Mobile Only) -->
        <div class="md:hidden p-6 border-b border-gray-100 bg-emerald-50">
            <h2 class="text-lg font-bold text-emerald-800">{{ Auth::user()->username ?? 'Guest' }}</h2>
            <p class="text-xs text-emerald-600">Pemilik Kebun</p>
        </div>

        <!-- Menu Navigasi -->
        @php
            $currentRoute = Route::currentRouteName();
            // Helper untuk class aktif/tidak aktif
            $navClass = function($route) use ($currentRoute) {
                return $currentRoute === $route 
                    ? 'flex items-center p-3 text-sm font-bold rounded-lg bg-emerald-50 text-emerald-700 border-r-4 border-emerald-600' 
                    : 'flex items-center p-3 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-emerald-600 transition-colors';
            };
        @endphp

        <nav class="p-4 space-y-2">
            <a href="{{ route('pemilik.dashboard') }}" class="{{ $navClass('pemilik.dashboard') }}">
                <i class="fas fa-home w-6 text-center"></i> 
                <span class="ml-2">Dashboard</span>
            </a>

            <a href="{{ route('pemilik.lowongan.index') }}" class="{{ $navClass('pemilik.lowongan.index') }}">
                <i class="fas fa-briefcase w-6 text-center"></i> 
                <span class="ml-2">Lowongan</span>
            </a>

            <a href="{{ route('pemilik.dataDiri') }}" class="{{ $navClass('pemilik.dataDiri') }}">
                <i class="fas fa-user w-6 text-center"></i> 
                <span class="ml-2">Data Diri</span>
            </a>
        </nav>
    </aside>

    <!-- 3. OVERLAY (Untuk Mobile) -->
    <!-- Muncul saat sidebar terbuka di layar kecil -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" 
         class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden transition-opacity duration-300">
    </div>

    <!-- 4. MAIN CONTENT -->
    <!-- lg:ml-64 artinya di desktop konten geser ke kanan 64 (lebar sidebar) -->
    <main id="main-content" class="pt-20 pb-20 px-4 sm:px-6 lg:px-8 lg:ml-64 min-h-screen transition-all duration-300">
        
        {{-- Flash Message Global --}}
        @if(session('success'))
            <div id="flash-message" class="mb-6 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm flex justify-between items-center">
                <div>{{ session('success') }}</div>
                <button onclick="document.getElementById('flash-message').remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-xl p-6 min-h-[400px] border border-gray-100">
            @yield('pemilik_content')
        </div>

    </main>

    <!-- 5. FOOTER -->
    <footer id="main-footer" class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 py-3 text-center text-xs text-gray-500 z-20 lg:ml-64 transition-all duration-300">
        &copy; {{ date('Y') }} Sawit Inside. All Rights Reserved.
    </footer>

    <!-- 6. SCRIPT JAVASCRIPT -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("sidebar-overlay");
            const mainContent = document.getElementById("main-content");
            const footer = document.getElementById("main-footer");
            
            // Cek apakah sedang di tampilan Desktop (>= 1024px)
            const isDesktop = window.innerWidth >= 1024;

            if (isDesktop) {
                // LOGIKA DESKTOP:
                // Sidebar default: lg:translate-x-0 (Visible)
                // Kita toggle class khusus untuk menyembunyikannya
                sidebar.classList.toggle("lg:-translate-x-full");
                
                // Geser Main Content & Footer agar memenuhi layar
                if (mainContent.classList.contains("lg:ml-64")) {
                    mainContent.classList.remove("lg:ml-64");
                    footer.classList.remove("lg:ml-64");
                } else {
                    mainContent.classList.add("lg:ml-64");
                    footer.classList.add("lg:ml-64");
                }

            } else {
                // LOGIKA MOBILE:
                // Sidebar default: -translate-x-full (Hidden)
                // Kita toggle agar translate hilang (jadi visible)
                if (sidebar.classList.contains("-translate-x-full")) {
                    sidebar.classList.remove("-translate-x-full");
                    overlay.classList.remove("hidden"); // Tampilkan overlay gelap
                } else {
                    sidebar.classList.add("-translate-x-full");
                    overlay.classList.add("hidden"); // Sembunyikan overlay
                }
            }
        }

        // Tutup sidebar otomatis jika layar di-resize dari desktop ke mobile
        window.addEventListener('resize', () => {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("sidebar-overlay");
            
            if (window.innerWidth < 1024) {
                // Pastikan sidebar tertutup saat resize ke mobile
                if (!sidebar.classList.contains("-translate-x-full")) {
                    sidebar.classList.add("-translate-x-full");
                    overlay.classList.add("hidden");
                }
            } else {
                // Pastikan overlay hilang di desktop
                overlay.classList.add("hidden");
            }
        });
    </script>

</body>
</html>