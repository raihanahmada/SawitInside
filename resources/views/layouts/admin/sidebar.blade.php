<div class="w-72 bg-gray-900 text-white p-6 min-h-full flex flex-col space-y-4 shadow-2xl">
    <h2 class="text-2xl font-bold border-b border-gray-700 pb-4 text-emerald-400">ADMIN PANEL</h2>

    <nav class="space-y-2 flex-grow">
        @php
            $currentRoute = Route::currentRouteName();
            $activeClass = 'bg-emerald-600 text-white';
            // Ubah inactiveClass agar lebih konsisten
            $inactiveClass = 'hover:bg-gray-700 text-gray-300';
        @endphp

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center p-3 rounded-lg transition-colors
                   {{ $currentRoute === 'admin.dashboard' ? $activeClass : $inactiveClass }}">
            <i class="fas fa-home mr-3"></i> Dashboard
        </a>

        <div class="pt-4 space-y-2">
            <p class="text-xs font-semibold uppercase text-gray-400">VERIFIKASI & KONFIRMASI</p>

            <a href="{{ route('admin.lowongan_pending') }}"
               class="flex items-center p-3 rounded-lg transition-colors {{ $currentRoute === 'admin.lowongan_pending' ? $activeClass : $inactiveClass }}">
                <i class="fas fa-clipboard-check mr-3"></i> Lowongan Butuh Konfirmasi
            </a>

            <a href="{{ route('admin.owner_pending') }}"
               class="flex items-center p-3 rounded-lg transition-colors {{ $currentRoute === 'admin.owner_pending' ? $activeClass : $inactiveClass }}">
                <i class="fas fa-user-clock mr-3"></i> Pemilik Menunggu Verif
            </a>
        </div>

        <div class="pt-4 space-y-2">
            <p class="text-xs font-semibold uppercase text-gray-400">MANAJEMEN DATA</p>

            <a href="{{ route('admin.owner_verified') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 text-gray-300">
                <i class="fas fa-building mr-3"></i> Data Pemilik (Terverif)
            </a>
            <a href="{{ route('admin.applicants') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 text-gray-300">
                <i class="fas fa-users mr-3"></i> Data Pelamar
            </a>
            <a href="{{ route('admin.vacancies_active') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 text-gray-300">
                <i class="fas fa-briefcase mr-3"></i> Lowongan Aktif
            </a>
        </div>

        <div class="pt-4 space-y-2">
            <p class="text-xs font-semibold uppercase text-gray-400">SISTEM</p>
            <a href="{{ route('admin.settings') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 text-gray-300">
                <i class="fas fa-cog mr-3"></i> Setting Views Web
            </a>
        </div>
    </nav>

    <form action="{{ route('logout') }}" method="POST" class="mt-auto">
        @csrf
        <button type="submit" class="w-full text-red-400 hover:bg-gray-700 p-3 rounded-lg font-medium flex items-center justify-center transition-colors">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </button>
    </form>
</div>
