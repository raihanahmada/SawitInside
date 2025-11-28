@extends('layouts.app') {{-- Menggunakan layout utama untuk header, footer, dan HTML dasar --}}

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="flex flex-col lg:flex-row gap-8">

        @include('layouts.pelamar.sidebar')

        <div class="flex-1">
            {{-- Slot tempat konten spesifik halaman akan dimasukkan --}}
            @yield('dashboard_content')
        </div>
    </div>

</div>
@endsection
