@extends('layouts.admin.app')

@section('title', 'Pengaturan Tampilan Web')
@section('admin_page_title', 'Pengaturan Global Website')

@section('admin_content')

{{-- Container Utama --}}
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Header & Alert --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Konfigurasi Website</h2>
            <p class="text-sm text-gray-500">Kelola identitas visual, konten utama, dan parameter sistem.</p>
        </div>

        @if (session('success'))
        <div x-data="{ show: true }" x-show="show" class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Berhasil!</span> {{ session('success') }}
            </div>
            <button @click="show = false" type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        @endif
    </div>

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- KOLOM KIRI: Aset Visual (Logo & Hero) --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Card Logo --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-image text-emerald-500"></i> Identitas Visual
                        </h3>
                    </div>
                    <div class="p-5 space-y-6">
                        {{-- Logo Input --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo Website</label>

                            {{-- Preview Area --}}
                            <div class="mb-3 p-4 bg-gray-100 border border-dashed border-gray-300 rounded-lg flex justify-center items-center min-h-[100px]">
                                @if(isset($settings['logo_path']) && $settings['logo_path'])
                                    <img src="{{ asset($settings['logo_path']) }}" alt="Current Logo" class="max-h-16 object-contain">
                                @else
                                    <span class="text-gray-400 text-xs">Belum ada logo</span>
                                @endif
                            </div>

                            <input type="file" name="logo_path" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-xs file:font-semibold
                                file:bg-emerald-50 file:text-emerald-700
                                hover:file:bg-emerald-100 transition
                            "/>
                            @error('logo_path') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <hr class="border-gray-100">

                        {{-- Hero Image Input --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Background Hero Utama</label>

                            {{-- Preview Area --}}
                            <div class="mb-3 relative group overflow-hidden rounded-lg h-32 bg-gray-200">
                                @if(isset($settings['hero_image_path']) && $settings['hero_image_path'])
                                    <img src="{{ asset($settings['hero_image_path']) }}" alt="Hero Bg" class="w-full h-full object-cover">
                                    <a href="{{ asset($settings['hero_image_path']) }}" target="_blank" class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-white text-xs font-medium">
                                        Lihat Full Size
                                    </a>
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400 text-xs">No Image</div>
                                @endif
                            </div>

                            <input type="file" name="hero_image_path" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-xs file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100 transition
                            "/>
                            <p class="mt-1 text-xs text-gray-400">Rekomendasi: 1920x1080px (JPG/WEBP)</p>
                            @error('hero_image_path') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Card System Limit --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-cogs text-gray-500"></i> Konfigurasi Sistem
                        </h3>
                    </div>
                    <div class="p-5">
                        <label for="lowongan_limit" class="block text-sm font-medium text-gray-700 mb-1">Limit Lowongan Unggulan</label>
                        <div class="flex items-center gap-3">
                            <input type="number" name="lowongan_limit" id="lowongan_limit" min="1" max="12"
                                value="{{ $settings['lowongan_limit'] ?? old('lowongan_limit', 3) }}"
                                class="block w-20 text-center border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                            >
                            <span class="text-xs text-gray-500">Item ditampilkan</span>
                        </div>
                        @error('lowongan_limit') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: Konten Teks --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Card Hero Text --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-heading text-blue-500"></i> Konten Halaman Utama (Hero)
                        </h3>
                    </div>
                    <div class="p-6 space-y-5">

                        {{-- Tagline --}}
                        <div>
                            <label for="hero_tagline" class="block text-sm font-medium text-gray-700 mb-1">Hero Tagline <span class="text-red-500">*</span></label>
                            <input type="text" name="hero_tagline" id="hero_tagline"
                                value="{{ $settings['hero_tagline'] ?? old('hero_tagline') }}"
                                class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm py-2.5"
                                placeholder="Contoh: Kelola Pekerja Sawit Anda dengan Mudah"
                            >
                            <p class="mt-1 text-xs text-gray-400">Judul besar paling atas di halaman beranda.</p>
                            @error('hero_tagline') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Subtitle --}}
                        <div>
                            <label for="hero_subtitle" class="block text-sm font-medium text-gray-700 mb-1">Hero Subtitle</label>
                            <textarea name="hero_subtitle" id="hero_subtitle" rows="3"
                                class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                                placeholder="Deskripsi singkat di bawah judul..."
                            >{{ $settings['hero_subtitle'] ?? old('hero_subtitle') }}</textarea>
                            @error('hero_subtitle') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </div>

                {{-- Card Testimonial --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-quote-left text-orange-400"></i> Quote Halaman Registrasi
                        </h3>
                    </div>
                    <div class="p-6 space-y-5 relative">

                        {{-- Dekorasi Visual Quote --}}
                        <div class="absolute top-5 right-5 text-gray-100">
                            <i class="fas fa-quote-right text-6xl"></i>
                        </div>

                        {{-- Quote Content --}}
                        <div class="relative z-10">
                            <label for="mitra_quote" class="block text-sm font-medium text-gray-700 mb-1">Isi Quote</label>
                            <textarea name="mitra_quote" id="mitra_quote" rows="3"
                                class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm bg-yellow-50/30"
                                placeholder="Tulis testimoni motivasi di sini..."
                            >{{ $settings['mitra_quote'] ?? old('mitra_quote') }}</textarea>
                            @error('mitra_quote') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Quote Author --}}
                        <div class="relative z-10 w-2/3">
                            <label for="mitra_quote_author" class="block text-sm font-medium text-gray-700 mb-1">Penulis Quote</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">-</span>
                                </div>
                                <input type="text" name="mitra_quote_author" id="mitra_quote_author"
                                    value="{{ $settings['mitra_quote_author'] ?? old('mitra_quote_author') }}"
                                    class="focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-7 sm:text-sm border-gray-300 rounded-lg"
                                    placeholder="Nama Penulis, Jabatan"
                                >
                            </div>
                            @error('mitra_quote_author') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- Sticky Action Bar --}}
        <div class="sticky bottom-4 mt-8 bg-white/90 backdrop-blur-md p-4 rounded-xl shadow-lg border border-gray-200 flex items-center justify-between z-20">
            <div class="text-sm text-gray-500 pl-2">
                <span class="hidden md:inline">Pastikan semua data sudah benar sebelum menyimpan.</span>
            </div>
            <div class="flex gap-3">
                <button type="reset" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition text-sm">
                    Reset
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium shadow-md shadow-emerald-200 hover:shadow-lg transition transform active:scale-95 text-sm flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </div>

    </form>
</div>

@endsection
