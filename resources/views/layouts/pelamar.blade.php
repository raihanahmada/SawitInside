<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sawit Inside - @yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            /* Palette Emerald Green */
            --primary-color: #059669; /* Emerald 600 */
            --primary-dark: #047857;  /* Emerald 700 */
            --secondary-color: #fbbf24; /* Amber 400 */
            --light-green: #d1fae5;   /* Emerald 100 */
            --bg-light: #f3f4f6;      /* Gray 100 */
            --text-dark: #1f2937;     /* Gray 800 */
            --text-light: #6b7280;    /* Gray 500 */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            background-color: var(--primary-color);
            background-image: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            /* Flexbox untuk merapikan logo */
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 80px;
        }

        /* Wrapper Logo agar rapi */
        .logo-wrapper img {
            max-height: 45px; /* Batasi tinggi logo */
            width: auto;
            object-fit: contain;
            display: block;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 800;
            color: white;
            text-decoration: none;
            letter-spacing: 1px;
        }

        .logo-text span {
            color: var(--secondary-color);
        }

        .user-profile {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            color: white;
            overflow: hidden;
            border: 2px solid rgba(255, 255, 255, 0.3);
            flex-shrink: 0; /* Agar avatar tidak gepeng */
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            overflow: hidden;
        }

        .user-info h5 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: white;
        }

        .user-info p {
            font-size: 12px;
            opacity: 0.8;
            margin-bottom: 0;
            color: rgba(255, 255, 255, 0.9);
        }

        .nav-menu {
            padding: 20px 10px;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
            border-radius: 8px;
            font-size: 15px;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .nav-link i {
            width: 24px;
            text-align: center;
            font-size: 16px;
        }

        .logout-wrapper {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-left: 10px;
            padding-right: 10px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 30px;
            transition: all 0.3s ease;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: var(--text-light);
            font-size: 13px;
            margin-top: 40px;
        }

        /* Toggle Button */
        .toggle-sidebar {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background-color: white;
            color: var(--primary-color);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            align-items: center;
            justify-content: center;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
                padding-top: 70px;
            }

            .toggle-sidebar {
                display: flex;
            }
        }
    </style>

    @yield('styles')
</head>

<body>

    <button class="toggle-sidebar" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{route('pelamar.dashboard')}}" class="text-decoration-none">
                {{-- LOGO WRAPPER (Agar Rapi) --}}
                <div class="logo-wrapper">
                    @php
                        $logoPath = $global_settings['logo_path'] ?? null;
                    @endphp

                    @if ($logoPath)
                        <img src="{{ asset($logoPath) }}" alt="Logo Sawit Inside">
                    @else
                        {{-- Fallback Teks Logo --}}
                        <div class="logo-text">
                            Sawit<span>Inside</span> 🌴
                        </div>
                    @endif
                </div>
            </a>
        </div>

        <div class="user-profile">
            <div class="user-avatar">
                {{-- 1. Cek Google Avatar --}}
                @if (Auth::user()->google_avatar)
                    <img src="{{ Auth::user()->google_avatar }}" alt="Google Avatar" referrerpolicy="no-referrer">

                {{-- 2. Cek Foto Upload Manual --}}
                @elseif(Auth::user()->pelamar_profil && Auth::user()->pelamar_profil->foto)
                    <img src="{{ asset('storage/' . Auth::user()->pelamar_profil->foto) }}" alt="Foto Profil">

                {{-- 3. Fallback Inisial --}}
                @else
                    @php
                        $displayName = Auth::user()->pelamar_profil->nama ?? Auth::user()->username;
                    @endphp
                    <span>{{ strtoupper(substr($displayName, 0, 1)) }}</span>
                @endif
            </div>

            <div class="user-info">
                {{-- Tampilkan Nama Asli jika ada, kalau tidak Username --}}
                <h5 title="{{ Auth::user()->pelamar_profil->nama ?? Auth::user()->username }}">
                    {{ \Illuminate\Support\Str::limit(Auth::user()->pelamar_profil->nama ?? Auth::user()->username, 18) }}
                </h5>
                <p>Pelamar</p>
            </div>
        </div>

        <div class="nav-menu">
            <div class="nav-item">
                <a href="{{ route('pelamar.dashboard') }}"
                    class="nav-link {{ request()->routeIs('pelamar.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('pelamar.lowongan') }}"
                    class="nav-link {{ request()->routeIs('pelamar.lowongan*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase"></i> Lowongan Kerja
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('pelamar.history') }}"
                    class="nav-link {{ request()->routeIs('pelamar.history') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> Riwayat Lamaran
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('pelamar.datadiri') }}"
                    class="nav-link {{ request()->routeIs('pelamar.profile*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i> Profil Saya
                </a>
            </div>

            <div class="logout-wrapper">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="nav-link w-100 text-start border-0 bg-transparent text-white-50 hover:text-white">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="main-content">
        @yield('content')

        <div class="footer">
            &copy; {{ date('Y') }} Sawit Inside. Platform Manajemen Tenaga Kerja Perkebunan.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 992) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    @yield('scripts')
</body>
</html>
