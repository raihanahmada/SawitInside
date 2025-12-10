@extends('layouts.pemilik.app')

@section('title', 'Edit Lowongan — SAWIT INSIDE')

@section('pemilik_content')
<!-- 1. CSS CUSTOM UNTUK MODAL JAM (EMERALD THEME) -->
<style>
    /* Styling ClockPicker Modal - Hijau */
    .clockpicker-popover {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        z-index: 9999 !important;
        box-shadow: 0 0 0 100vmax rgba(0,0,0,0.5), 0 10px 25px rgba(0,0,0,0.2) !important;
        border-radius: 12px;
        border: none;
    }
    .clockpicker-popover .arrow { display: none !important; }
    .clockpicker-popover .popover-title {
        background-color: #059669 !important; /* Emerald-600 */
        color: white !important;
        font-weight: bold; border-radius: 12px 12px 0 0;
    }
    .clockpicker-canvas line { stroke: #059669 !important; }
    .clockpicker-canvas-bearing, .clockpicker-canvas-fg { fill: #059669 !important; }
    .clockpicker-canvas-bg { fill: #d1fae5 !important; } /* Emerald-100 */
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css">

<!-- 2. LOGIKA PHP: Parsing Data dari Database ke Form -->
@php
    // A. Parse Jam Kerja ("08:00 - 16:00 WIB" -> Masuk: 08:00, Pulang: 16:00)
    $jam_masuk_value = '';
    $jam_pulang_value = '';
    
    if ($lowongan->jam_kerja) {
        if (strpos($lowongan->jam_kerja, ' - ') !== false) {
            $parts = explode(' - ', $lowongan->jam_kerja);
            $jam_masuk_value = trim($parts[0]);
            $jam_pulang_value = isset($parts[1]) ? trim(str_replace(' WIB', '', $parts[1])) : '';
        } elseif (strpos($lowongan->jam_kerja, ' s/d ') !== false) {
            $parts = explode(' s/d ', $lowongan->jam_kerja);
            $jam_masuk_value = trim($parts[0]);
        }
    }

    // B. Parse Upah ("Borongan: Rp 200.000 / Kg" -> Jenis: Borongan, Nilai: 200000)
    $jenis_upah_value = '';
    $nilai_manual_value = '';

    if ($lowongan->upah) {
        if (strpos($lowongan->upah, ':') !== false) {
            $parts = explode(':', $lowongan->upah);
            $jenis_upah_value = strtolower(trim($parts[0])); // borongan/harian
            // Ambil angka saja dari string
            $nilai_manual_value = preg_replace('/[^0-9]/', '', $parts[1]);
        } else {
            // Jika format lama atau cuma teks
            $jenis_upah_value = 'manual'; 
        }
    }
@endphp

<div class="max-w-4xl mx-auto p-8 bg-white rounded-xl shadow-2xl my-10 border-t-4 border-emerald-600">
    
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-emerald-800">Edit Data Lowongan</h2>
        <p class="text-gray-500 text-sm mt-1">Perbarui detail pekerjaan, upah, dan lokasi.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
            <h3 class="text-sm font-medium text-red-800">Mohon perbaiki kesalahan berikut:</h3>
            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pemilik.lowongan.update', $lowongan->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- BAGIAN 1: INFORMASI PEKERJAAN -->
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Dasar</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Lowongan</label>
                    <input type="text" name="judul" value="{{ old('judul', $lowongan->judul) }}" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi Kerja</label>
                    <input type="text" name="lokasi_kerja" value="{{ old('lokasi_kerja', $lowongan->lokasi_kerja) }}" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>
        </div>

        <!-- BAGIAN 2: DETAIL GAJI & WAKTU -->
        <div class="bg-emerald-50 p-6 rounded-lg border border-emerald-200">
            <h3 class="text-lg font-semibold text-emerald-800 mb-4 border-b border-emerald-200 pb-2">Detail & Penawaran</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Sistem Upah -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Sistem Upah</label>
                    <div class="space-y-3">
                        <select id="jenis_upah" name="jenis_upah" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">-- Pilih Sistem --</option>
                            <option value="borongan" {{ (old('jenis_upah', $jenis_upah_value) == 'borongan') ? 'selected' : '' }}>Borongan (Per Kg/Tandan)</option>
                            <option value="harian" {{ (old('jenis_upah', $jenis_upah_value) == 'harian') ? 'selected' : '' }}>Per Hari</option>
                            <option value="bulanan" {{ (old('jenis_upah', $jenis_upah_value) == 'bulanan') ? 'selected' : '' }}>Per Bulan</option>
                            <option value="manual" {{ (old('jenis_upah', $jenis_upah_value) == 'manual') ? 'selected' : '' }}>Lainnya / Manual</option>
                        </select>

                        <!-- Pilihan Nominal (Dinamis via JS) -->
                        <div id="nilai_wrapper" class="hidden">
                            <select id="nilai_upah" name="nilai_upah" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"></select>
                        </div>

                        <!-- Input Manual -->
                        <div id="manual_wrapper" class="hidden relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">Rp</span>
                            <input type="number" id="nilai_manual" name="nilai_manual" 
                                value="{{ old('nilai_manual', $nilai_manual_value) }}"
                                class="w-full pl-10 p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" placeholder="0">
                        </div>
                    </div>
                </div>

                <!-- Jam Kerja (MODAL PICKER) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Kerja</label>
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <!-- JAM MASUK -->
                        <div>
                            <label class="text-xs text-gray-500 mb-1 block">Masuk</label>
                            <div class="relative clockpicker">
                                <!-- NAME="JAM_MASUK" AGAR DIBACA CONTROLLER -->
                                <input type="text" id="jam_masuk" name="jam_masuk" 
                                    class="w-full p-2 border border-gray-300 rounded-lg bg-white cursor-pointer"
                                    readonly placeholder="Pilih..." 
                                    value="{{ old('jam_masuk', $jam_masuk_value) }}">
                            </div>
                        </div>
                        <!-- JAM PULANG -->
                        <div>
                            <label class="text-xs text-gray-500 mb-1 block">Pulang</label>
                            <div class="relative clockpicker">
                                <!-- NAME="JAM_PULANG" AGAR DIBACA CONTROLLER -->
                                <input type="text" id="jam_pulang" name="jam_pulang"
                                    class="w-full p-2 border border-gray-300 rounded-lg bg-white cursor-pointer"
                                    readonly placeholder="Pilih..." 
                                    value="{{ old('jam_pulang', $jam_pulang_value) }}">
                            </div>
                        </div>
                    </div>
                    <!-- Display Only -->
                    <input type="text" id="jam_kerja_display" readonly value="{{ $lowongan->jam_kerja }}" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 text-sm">
                </div>

                <!-- Jumlah & Batas -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Kebutuhan</label>
                    <input type="number" name="jumlah_kebutuhan" value="{{ old('jumlah_kebutuhan', $lowongan->jumlah_kebutuhan) }}" required min="1" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Batas Akhir Lamaran</label>
                    <input type="date" name="batas_pelamar" value="{{ old('batas_pelamar', $lowongan->batas_pelamar) }}" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
            <button type="submit" class="flex-1 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition duration-200">
                Simpan Perubahan
            </button>
            <a href="{{ route('pemilik.lowongan.index') }}" class="flex-none py-3 px-6 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition duration-200">Batal</a>
        </div>
    </form>
</div>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.js"></script>

<script>
    // 1. Script ClockPicker Modal
    $('.clockpicker input').clockpicker({
        donetext: 'SIMPAN',
        autoclose: true,
        vibrate: true,
        afterDone: function() { updateJamDisplay(); }
    });

    function updateJamDisplay() {
        const m = $('#jam_masuk').val();
        const p = $('#jam_pulang').val();
        if(m && p) $('#jam_kerja_display').val(m + ' - ' + p + ' WIB');
        else if(m) $('#jam_kerja_display').val(m + ' - Selesai');
    }

    // 2. Script Logic Upah (Sama dengan Create)
    const presets = {
        borongan: [150000, 200000, 250000, 300000],
        harian: [80000, 100000, 120000, 150000],
        bulanan: [2500000, 3000000, 3500000, 4000000]
    };

    const jenisEl = document.getElementById('jenis_upah');
    const nilaiWrapper = document.getElementById('nilai_wrapper');
    const nilaiSelect = document.getElementById('nilai_upah');
    const manualWrapper = document.getElementById('manual_wrapper');
    const manualInput = document.getElementById('nilai_manual');

    // Fungsi Render Opsi
    function renderOptions(val) {
        nilaiSelect.innerHTML = '';
        if (!val || val === 'manual') {
            nilaiWrapper.classList.add('hidden');
            manualWrapper.classList.toggle('hidden', val !== 'manual');
            return;
        }

        const optDefault = document.createElement('option');
        optDefault.text = '-- Pilih Nominal --';
        nilaiSelect.add(optDefault);

        if(presets[val]) {
            presets[val].forEach(rp => {
                const opt = document.createElement('option');
                opt.value = rp;
                opt.text = 'Rp ' + rp.toLocaleString('id-ID');
                nilaiSelect.add(opt);
            });
        }

        const optCustom = document.createElement('option');
        optCustom.value = 'custom';
        optCustom.text = 'Input Manual...';
        nilaiSelect.add(optCustom);

        nilaiWrapper.classList.remove('hidden');
    }

    // Event Listener
    if(jenisEl){
        jenisEl.addEventListener('change', function() {
            renderOptions(this.value);
            // Reset manual saat ganti jenis
            manualWrapper.classList.add('hidden');
        });

        nilaiSelect.addEventListener('change', function() {
            if(this.value === 'custom') manualWrapper.classList.remove('hidden');
            else {
                manualWrapper.classList.add('hidden');
                manualInput.value = this.value; // Isi hidden value jika preset dipilih
            }
        });

        // INIT SAAT LOAD (Agar data lama terisi benar)
        const oldJenis = "{{ old('jenis_upah', $jenis_upah_value) }}";
        const oldNilai = "{{ old('nilai_manual', $nilai_manual_value) }}";

        if(oldJenis && oldJenis !== 'manual') {
            renderOptions(oldJenis);
            
            // Cek apakah nilai lama ada di preset
            let found = false;
            if(presets[oldJenis] && oldNilai) {
                if(presets[oldJenis].includes(parseInt(oldNilai))) {
                    nilaiSelect.value = oldNilai;
                    found = true;
                }
            }
            
            if(!found && oldNilai) {
                nilaiSelect.value = 'custom';
                manualWrapper.classList.remove('hidden');
            }
        } else if (oldJenis === 'manual') {
            manualWrapper.classList.remove('hidden');
        }
    }
</script>
@endsection