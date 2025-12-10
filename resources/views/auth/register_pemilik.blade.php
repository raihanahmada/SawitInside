@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto p-8 bg-white rounded-xl shadow-2xl my-10 border-t-4 border-emerald-600">

    {{-- ALERT ERROR --}}
    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-300 text-red-700">
            <strong>Periksa kembali data yang kamu isi:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2 class="text-2xl font-bold text-emerald-800 mb-6 text-center">Daftar Akun Pemilik</h2>
    <p class="text-center text-gray-500 mb-8">Role:
        <span class="font-semibold text-emerald-600">Pemilik</span>
    </p>

    <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <input type="hidden" name="role" value="{{ $role }}">

        <!-- FOTO PROFIL -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>

            <!-- PREVIEW -->
            <div class="flex justify-center mb-3">
                <img id="previewFoto"
                     src="https://via.placeholder.com/120?text=Foto"
                     class="w-28 h-28 rounded-full object-cover border shadow bg-gray-100">
            </div>

            <!-- INPUT FOTO PROFIL -->
            <input 
                type="file" 
                name="foto_profil" 
                id="foto_profil" 
                accept="image/*"
                required
                class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm 
                       focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <!-- Username -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" required
                class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <!-- Kontak -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Kontak (WhatsApp)</label>
            <input type="text" name="kontak" value="{{ old('kontak') }}" required
                class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                placeholder="Contoh: 628123456XXXX">
        </div>

        <!-- Password -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required
                    class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Konfirmasi</label>
                <input type="password" name="password_confirmation" required
                    class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
            </div>
        </div>

        <!-- Luas Kebun -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Luas Kebun (m²)</label>
            <input type="number" name="luas_kebun" value="{{ old('luas_kebun') }}" required
                class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <!-- Lokasi Kebun -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Daerah</label>
            <input type="text" name="lokasi_kebun" value="{{ old('lokasi_kebun') }}" required
                class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
        </div>

        <!-- FOTO DOKUMEN -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Foto Bukti Kepemilikan
            </label>

            <div id="uploadBox"
                class="w-full p-6 border-2 border-dashed border-gray-300 rounded-lg text-center cursor-pointer 
                       hover:border-emerald-500 transition">

                <div class="flex flex-col items-center">
                    <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7h2l2-3h10l2 3h2v12H3V7z" />
                    </svg>

                    <p id="fileName" class="text-gray-600">Klik atau seret file ke sini</p>
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG</p>
                </div>

                <input type="file" name="foto_dokumen" id="foto_dokumen" accept="image/*" class="hidden" required>
            </div>
        </div>

        <button type="submit"
            class="w-full py-3 px-4 rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 transition duration-150">
            Daftar Sebagai Pemilik
        </button>
    </form>
</div>

{{-- SCRIPT PREVIEW FOTO PROFIL --}}
<script>
    document.getElementById("foto_profil").addEventListener("change", function(event) {
        const imgPreview = document.getElementById("previewFoto");
        const file = event.target.files[0];
        if (file) {
            imgPreview.src = URL.createObjectURL(file);
        }
    });
</script>

{{-- SCRIPT DRAG n DROP DOKUMEN --}}
<script>
    const uploadBox = document.getElementById("uploadBox");
    const fileInput = document.getElementById("foto_dokumen");
    const fileName = document.getElementById("fileName");

    uploadBox.addEventListener("click", () => fileInput.click());

    fileInput.addEventListener("change", () => {
        if (fileInput.files.length > 0) {
            fileName.textContent = "File dipilih: " + fileInput.files[0].name;
        }
    });

    uploadBox.addEventListener("dragover", (e) => {
        e.preventDefault();
        uploadBox.classList.add("border-emerald-500");
    });

    uploadBox.addEventListener("dragleave", () => {
        uploadBox.classList.remove("border-emerald-500");
    });

    uploadBox.addEventListener("drop", (e) => {
        e.preventDefault();
        fileInput.files = e.dataTransfer.files;
        fileInput.dispatchEvent(new Event('change'));
        uploadBox.classList.remove("border-emerald-500");
    });
</script>
@endsection
