@extends('layouts.app')

@section('content')
{{-- Konten ini sekarang akan mengisi lebar 100% karena logika di layouts/app.blade.php --}}

<div class="flex min-h-screen">

    @include('layouts.admin.sidebar')

    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Slot untuk konten spesifik halaman --}}
        <main class="flex-1 overflow-y-auto bg-gray-100">

            {{-- Header Judul Konten --}}
            <header class="bg-white shadow p-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-700">@yield('admin_page_title', 'Verifikasi Pemilik Kebun')</h1>
            </header>

            <div class="px-6 pb-6"> {{-- Tambahkan padding di sini --}}
                @yield('admin_content')
            </div>

        </main>

    </div>
</div>
@endsection
