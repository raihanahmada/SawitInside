<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sawit Inside - @yield('title', 'Dashboard')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2d572c;
            --secondary-color: #ffcc00;
            --light-green: #4a7c4a;
            --bg-light: #f8f9fa;
            --text-dark: #333;
            --text-light: #666;
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
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            background-color: var(--primary-color);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-header .logo {
            font-size: 26px;
            font-weight: 800;
            color: white;
            text-decoration: none;
        }

        .sidebar-header .logo span {
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
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--light-green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            color: white;
            overflow: hidden;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info h5 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-info p {
            font-size: 13px;
            opacity: 0.8;
            margin-bottom: 0;
        }

        .nav-menu {
            padding: 20px 0;
        }

        .nav-item {
            margin: 5px 15px;
            border-radius: 8px;
            overflow: hidden;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-link.active {
            background-color: var(--light-green);
            color: white;
            border-left: 4px solid var(--secondary-color);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 18px;
        }

        .logout-btn {
            margin-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 20px;
            background-color: var(--bg-light);
            transition: all 0.3s ease;
        }

        /* Header */
        .page-header {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .page-title h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .page-title p {
            color: var(--text-light);
            margin-bottom: 0;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #eee;
            padding: 20px 25px;
            border-radius: 10px 10px 0 0 !important;
        }

        .card-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0;
        }

        .card-body {
            padding: 25px;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 25px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--light-green);
            border-color: var(--light-green);
        }

        .btn-success {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: #333;
            font-weight: 500;
        }

        .btn-success:hover {
            background-color: #e6b800;
            border-color: #e6b800;
            color: #333;
        }

        /* Table */
        .table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-color: #eee;
        }

        /* Badges */
        .badge {
            padding: 8px 15px;
            font-weight: 500;
            border-radius: 20px;
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Forms */
        .form-control, .form-select {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(45, 87, 44, 0.25);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            color: var(--text-light);
            font-size: 14px;
            border-top: 1px solid #eee;
            margin-top: 30px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .sidebar {
                width: 0;
                transform: translateX(-100%);
            }

            .sidebar.active {
                width: 260px;
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .toggle-sidebar {
                display: block !important;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 20px;
            }

            .card-body {
                padding: 20px;
            }

            .main-content {
                padding: 15px;
            }
        }

        /* Toggle Sidebar Button */
        .toggle-sidebar {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 999;
            background-color: var(--primary-color);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--light-green);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Toggle Sidebar Button (Mobile) -->
    <button class="toggle-sidebar" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Logo -->
        <div class="sidebar-header">
            <a href="{{ route('pelamar.dashboard') }}" class="logo">
                Sawit<span>Inside</span>
            </a>
        </div>

        <!-- User Profile -->
        <div class="user-profile">
            <div class="user-avatar">
                @if(auth()->check() && auth()->user()->foto)
                    <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Foto Profil">
                @else
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                @endif
            </div>
            <div class="user-info">
                <h5>{{ auth()->user()->name ?? 'Pengguna' }}</h5>
                <p>Pelamar</p>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="nav-menu">
            <div class="nav-item">
                <a href="{{ route('pelamar.dashboard') }}" class="nav-link {{ request()->routeIs('pelamar.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('pelamar.lowongan') }}" class="nav-link {{ request()->routeIs('pelamar.lowongan') ? 'active' : '' }}">
                    <i class="fas fa-search"></i> Cari Lowongan
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('pelamar.history') }}" class="nav-link {{ request()->routeIs('pelamar.history') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> History Lamaran
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('pelamar.datadiri') }}" class="nav-link {{ request()->routeIs('pelamar.datadiri') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> Data Diri
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('pelamar.profil') }}" class="nav-link {{ request()->routeIs('pelamar.profil') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>
            </div>

            <!-- Logout -->
            <div class="nav-item logout-btn">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link" style="background: none; border: none; width: 100%; text-align: left;">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Copyright -->
        <div style="padding: 20px; text-align: center; font-size: 12px; opacity: 0.7;">
            &copy; {{ date('Y') }} SawitInside
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title">
                <h2>@yield('page-title', 'Dashboard')</h2>
                <p>@yield('page-subtitle', 'Selamat datang di dashboard SawitInside')</p>
            </div>

            @hasSection('header-action')
            <div class="header-action">
                @yield('header-action')
            </div>
            @endif
        </div>

        <!-- Page Content -->
        <div class="fade-in">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} SawitInside - Sistem Manajemen Lowongan Sawit</p>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Toggle Sidebar for Mobile
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggleSidebar');

            if (window.innerWidth <= 992 &&
                !sidebar.contains(event.target) &&
                !toggleBtn.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Set active nav item based on current URL
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });

            // Auto-hide sidebar on mobile after navigation
            if (window.innerWidth <= 992) {
                document.getElementById('sidebar').classList.remove('active');
            }
        });

        // Auto-dismiss alerts
        setTimeout(function() {
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
