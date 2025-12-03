<div class="w-full lg:w-64 bg-white rounded-xl shadow-lg p-6 h-fit sticky top-8">

    <div class="mb-6 pb-4 border-b border-gray-200">
        <h2 class="text-xl font-bold text-emerald-700">{{ Auth::user()->username }}</h2>
        <p class="text-sm text-gray-500">Pelamar</p>
    </div>

    <nav class="space-y-2">

        @php
            $currentRoute = Route::currentRouteName();
            $activeClass =
                'flex items-center p-3 text-sm font-medium rounded-lg transition-colors bg-emerald-100 text-emerald-700 hover:bg-emerald-200';
            $inactiveClass =
                'flex items-center p-3 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100 transition-colors';
        @endphp

        <a href="{{ route('pelamar.dashboard') }}"
            class="{{ $currentRoute === 'pelamar.dashboard' ? $activeClass : $inactiveClass }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2l-7-7-7 7m16 2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('pelamar.lowongan') }}"
            class="{{ $currentRoute === 'pelamar.lowongan' ? $activeClass : $inactiveClass }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 13.255A23.58 23.58 0 0112 15c-3.18 0-6.233-.62-9-1.745M16 8V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2m12 0h2a2 2 0 012 2v4m-2-4h-2m2 0h-2">
                </path>
            </svg>
            Lowongan
        </a>

        <a href="{{ route('pelamar.history') }}"
            class="{{ $currentRoute === 'pelamar.history' ? $activeClass : $inactiveClass }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            History Lamaran
        </a>

        <a href="{{ route('pelamar.datadiry') }}"
            class="{{ $currentRoute === 'pelamar.datadiry' ? $activeClass : $inactiveClass }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Data Diri
        </a>
    </nav>

    <div class="mt-8 pt-4 border-t border-gray-200">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full text-red-500 hover:bg-red-50 p-3 rounded-lg font-medium flex items-center transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Keluar (Logout)
            </button>
        </form>
    </div>
</div>
