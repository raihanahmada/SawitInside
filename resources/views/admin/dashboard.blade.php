{{-- resources/views/Admin/dashboard.blade.php --}}
@extends('layouts.admin.app')

@section('title', 'Ringkasan Sistem')
@section('admin_page_title', 'Dashboard Admin') {{-- Judul yang akan muncul di dalam konten --}}

@section('admin_content')
{{-- KONTEN ANDA DISINI --}}
<h2 class="text-xl font-semibold text-gray-700 mb-4">Metrik Utama (Action Required)</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
    {{-- Kartu Aksi 1: Pemilik Menunggu Verifikasi --}}
    <div class="bg-red-500 text-white p-6 rounded-xl shadow-lg transform hover:scale-[1.02] transition duration-300 cursor-pointer">
        {{-- ... Kode Kartu ... --}}
        <div class="flex justify-between items-center">
            <p class="text-sm font-medium opacity-80">Pemilik Menunggu Verif</p>
            <i class="fas fa-exclamation-triangle text-3xl"></i>
        </div>
        <p class="text-4xl font-extrabold mt-2">{{ $metrics['pending_owners'] }}</p>
        <a href="{{ route('admin.owner_pending') }}" class="text-xs mt-2 block font-light underline opacity-90">Tinjau Sekarang &rarr;</a>
    </div>

    {{-- Kartu Aksi 2: Lowongan Butuh Konfirmasi --}}
    <div class="bg-yellow-500 text-white p-6 rounded-xl shadow-lg transform hover:scale-[1.02] transition duration-300 cursor-pointer">
        <div class="flex justify-between items-center">
            <p class="text-sm font-medium opacity-80">Lowongan Butuh Konfirmasi</p>
            <i class="fas fa-clipboard-list text-3xl"></i>
        </div>
        <p class="text-4xl font-extrabold mt-2">{{ $metrics['pending_vacancies'] }}</p>
        <a href="{{ route('admin.lowongan_pending') }}" class="text-xs mt-2 block font-light underline opacity-90">Verifikasi &rarr;</a>
    </div>

    {{-- Kartu Informasi 3: Total Pelamar --}}
    <div class="bg-blue-500 text-white p-6 rounded-xl shadow-lg transform hover:scale-[1.02] transition duration-300">
        <div class="flex justify-between items-center">
            <p class="text-sm font-medium opacity-80">Total Pelamar Terdaftar</p>
            <i class="fas fa-users text-3xl"></i>
        </div>
        <p class="text-4xl font-extrabold mt-2">{{ $metrics['total_applicants'] }}</p>
    </div>

    {{-- Kartu Informasi 4: Lowongan Aktif --}}
    <div class="bg-green-500 text-white p-6 rounded-xl shadow-lg transform hover:scale-[1.02] transition duration-300">
        <div class="flex justify-between items-center">
            <p class="text-sm font-medium opacity-80">Lowongan Aktif</p>
            <i class="fas fa-briefcase text-3xl"></i>
        </div>
        <p class="text-4xl font-extrabold mt-2">{{ $metrics['active_vacancies'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- COLUMN 1 & 2: GRAFIK KPI --}}
    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg">
        <h3 class="text-xl font-semibold mb-4 text-gray-700">Tren Keberhasilan Penempatan Kerja (Tahun {{ date('Y') }})</h3>
        <canvas id="successChart"></canvas>
    </div>

    {{-- COLUMN 3: RINGKASAN TAMBAHAN --}}
    <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-lg space-y-4">
        <h3 class="text-xl font-semibold mb-4 text-gray-700">Ringkasan Tambahan</h3>

        <div class="p-3 border-l-4 border-teal-500 bg-teal-50 rounded">
            <p class="text-sm font-medium text-teal-700">Total Penempatan Sukses</p>
            <p class="text-2xl font-bold text-teal-600">{{ $metrics['total_success_hires'] }}</p>
        </div>

        <div class="p-3 border-l-4 border-indigo-500 bg-indigo-50 rounded">
            <p class="text-sm font-medium text-indigo-700">Pemilik Kebun Terverifikasi</p>
            <p class="text-2xl font-bold text-indigo-600">{{ $metrics['approved_owners'] }}</p>
        </div>
    </div>
</div>

<script>
    // --- Logika Grafik (Chart.js) ---
    const ctx = document.getElementById('successChart').getContext('2d');

    // Siapkan data dari PHP
    const trendData = @json($success_trend);

    // Proses data untuk Chart.js
    const labels = trendData.map(item => 'Bulan ' + item.month);
    const totals = trendData.map(item => item.total);

    const successChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pekerja Diterima',
                data: totals,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Pekerja'
                    }
                }
            }
        }
    });
</script>
@endsection
