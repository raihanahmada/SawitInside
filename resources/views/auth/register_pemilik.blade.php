@extends('layouts.app')

@section('title', 'Daftar Sebagai Pemilik')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full bg-white rounded-xl shadow-2xl border-t-4 border-emerald-600 p-8 transform transition-all hover:scale-[1.01]">

        {{-- ALERT ERROR --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 animate-pulse">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <strong>Periksa kembali data Anda:</strong>
                </div>
                <ul class="list-disc list-inside text-sm pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- HEADER --}}
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-emerald-800 tracking-tight">Daftar Akun Pemilik</h2>
            <p class="mt-2 text-sm text-gray-500">
                Role: <span class="font-bold text-emerald-600 bg-emerald-100 px-2 py-1 rounded">Pemilik Kebun</span>
            </p>
        </div>

        <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            {{-- 1. FOTO PROFIL (Dengan Preview) --}}
            <div class="flex flex-col items-center">
                <div class="relative group cursor-pointer w-32 h-32 mb-4">
                    <img id="previewFoto" src="https://ui-avatars.com/api/?name=P&background=d1fae5&color=059669"
                         class="w-32 h-32 rounded-full object-cover border-4 border-emerald-100 shadow-lg transition-transform group-hover:scale-105">

                    <div class="absolute inset-0 bg-black bg-opacity-40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <input type="file" name="foto_profil" id="foto_profil" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                </div>
                <label class="text-sm font-medium text-gray-600">Foto Profil (Wajib)</label>
            </div>

            {{-- 2. GRID INFO AKUN --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm" placeholder="user123">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">No. WhatsApp</label>
                    <input type="number" name="kontak" value="{{ old('kontak') }}" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm" placeholder="08123456789">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm" placeholder="contoh@email.com">
            </div>

            {{-- 3. PASSWORD --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="password" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Ulangi Password</label>
                    <input type="password" name="password_confirmation" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm">
                </div>
            </div>

            <hr class="border-gray-200 my-4">
            <h3 class="text-lg font-bold text-emerald-800">Data Perkebunan</h3>

            {{-- 4. INFO KEBUN --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Luas Kebun (m²)</label>
                    <input type="number" name="luas_kebun" value="{{ old('luas_kebun') }}" required min="1"
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm" placeholder="5000">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Lokasi / Daerah</label>
                    <input type="text" name="lokasi_kebun" value="{{ old('lokasi_kebun') }}" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm" placeholder="Kecamatan X, Riau">
                </div>
            </div>

            {{-- 5. UPLOAD BUKTI KEPEMILIKAN (Drag & Drop) --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Bukti Kepemilikan (Dokumen)</label>
                <div id="uploadBox" class="w-full p-6 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 text-center cursor-pointer hover:bg-emerald-50 hover:border-emerald-500 transition duration-300 group">
                    <div class="flex flex-col items-center justify-center space-y-2">
                        <div class="p-3 bg-white rounded-full shadow-sm group-hover:shadow-md transition">
                            <svg class="w-8 h-8 text-gray-400 group-hover:text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </div>
                        <div class="text-sm text-gray-600">
                            <span id="fileName" class="font-medium text-emerald-600 hover:text-emerald-500">Klik untuk upload</span> atau seret file ke sini
                        </div>
                        <p class="text-xs text-gray-400">PNG, JPG, JPEG (Maks. 2MB)</p>
                    </div>
                    <input type="file" name="foto_dokumen" id="foto_dokumen" accept="image/*" class="hidden" required>
                </div>
            </div>

            {{-- TOMBOL SUBMIT --}}
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition transform hover:-translate-y-0.5">
                Daftar Sekarang
            </button>

            <p class="text-center text-sm text-gray-600 mt-4">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-medium text-emerald-600 hover:text-emerald-500 hover:underline">Login disini</a>
            </p>
        </form>
    </div>
</div>

{{-- SCRIPT JAVASCRIPT --}}
<script>
    // 1. Preview Foto Profil
    const fotoInput = document.getElementById('foto_profil');
    const imgPreview = document.getElementById('previewFoto');

    fotoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // 2. Drag & Drop Foto Dokumen
    const uploadBox = document.getElementById('uploadBox');
    const docInput = document.getElementById('foto_dokumen');
    const fileName = document.getElementById('fileName');

    // Klik Box -> Trigger Input
    uploadBox.addEventListener('click', () => docInput.click());

    // File Dipilih -> Ganti Teks
    docInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            fileName.textContent = "File Terpilih: " + this.files[0].name;
            uploadBox.classList.add('border-emerald-500', 'bg-emerald-50');
        }
    });

    // Efek Drag Over
    uploadBox.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadBox.classList.add('border-emerald-500', 'bg-emerald-100');
    });

    // Efek Drag Leave
    uploadBox.addEventListener('dragleave', () => {
        uploadBox.classList.remove('border-emerald-500', 'bg-emerald-100');
    });

    // Efek Drop
    uploadBox.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadBox.classList.remove('border-emerald-500', 'bg-emerald-100');

        if (e.dataTransfer.files.length > 0) {
            docInput.files = e.dataTransfer.files;
            // Trigger change event manual agar nama file update
            const event = new Event('change');
            docInput.dispatchEvent(event);
        }
    });
</script>
@endsection
