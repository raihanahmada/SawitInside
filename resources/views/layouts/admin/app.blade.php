@extends('layouts.app') {{-- ATAU layouts.app --}}

@section('content')
<div class="flex min-h-screen pt-4"> {{-- Margin top agar tidak menempel di header --}}

    <!-- SIDEBAR (Komponen yang di-include) -->
    @include('layouts.admin.sidebar')

    <!-- KONTEN UTAMA -->
    <div class="flex-1 flex flex-col overflow-hidden pl-6 pr-4">

        <!-- Slot untuk konten spesifik halaman (Dashboard, Verifikasi, dll.) -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto">

            <!-- Judul Halaman Di Sini -->
            <h1 class="text-3xl font-bold text-gray-800 mb-6">@yield('admin_page_title')</h1>

            @yield('admin_content')
        </main>

    </div>
</div>
@endsection
