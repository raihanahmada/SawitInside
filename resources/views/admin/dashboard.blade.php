{{-- resources/views/Admin/dashboard.blade.php --}}
@extends('layouts.admin.app')

@section('title', 'Ringkasan Sistem')
@section('admin_page_title')
    <div class="flex flex-col">
        <span class="text-sm font-normal text-gray-500">Overview Harian</span>
        <span class="text-2xl font-bold text-gray-800">Dashboard Admin</span>
    </div>
@endsection

@section('admin_content')
{{-- 🗓️ Header Tanggal --}}
<div class="flex justify-between items-end mb-8" data-aos="fade-down">
    <div>
        <h2 class="text-lg font-medium text-gray-600">Selamat Datang kembali, Administrator! 👋</h2>
        <p class="text-sm text-gray-400">Berikut adalah laporan aktivitas sistem per hari ini, <strong>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</strong>.</p>
    </div>
    {{-- Tombol Refresh (Opsional) --}}
    <button onclick="window.location.reload();" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center transition">
        <i class="fas fa-sync-alt mr-2"></i> Refresh Data
    </button>
</div>

{{-- ⚡ STATISTIK UTAMA (Cards) --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    {{-- Kartu 1: Pemilik Menunggu (Action Needed) --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden group" data-aos="fade-up" data-aos-delay="0">
        <div class="absolute right-0 top-0 h-full w-1 bg-red-500"></div>
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-red-500 uppercase tracking-wide mb-1">Perlu Verifikasi</p>
                <h3 class="text-gray-500 text-sm font-medium">Pemilik Kebun Baru</h3>
                <p class="text-4xl font-extrabold text-gray-800 mt-2 group-hover:text-red-600 transition">{{ $metrics['pending_owners'] }}</p>
            </div>
            <div class="p-3 bg-red-50 rounded-lg text-red-500 group-hover:bg-red-500 group-hover:text-white transition duration-300">
                <i class="fas fa-user-clock text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.owner_pending') }}" class="text-xs font-semibold text-red-500 hover:text-red-700 flex items-center">
                Proses Sekarang <i class="fas fa-arrow-right ml-2 text-[10px]"></i>
            </a>
        </div>
    </div>

    {{-- Kartu 2: Lowongan Pending (Action Needed) --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-amber-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden group" data-aos="fade-up" data-aos-delay="100">
        <div class="absolute right-0 top-0 h-full w-1 bg-amber-500"></div>
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-amber-500 uppercase tracking-wide mb-1">Menunggu Review</p>
                <h3 class="text-gray-500 text-sm font-medium">Lowongan Kerja</h3>
                <p class="text-4xl font-extrabold text-gray-800 mt-2 group-hover:text-amber-600 transition">{{ $metrics['pending_vacancies'] }}</p>
            </div>
            <div class="p-3 bg-amber-50 rounded-lg text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition duration-300">
                <i class="fas fa-file-contract text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.lowongan_pending') }}" class="text-xs font-semibold text-amber-500 hover:text-amber-700 flex items-center">
                Tinjau Lowongan <i class="fas fa-arrow-right ml-2 text-[10px]"></i>
            </a>
        </div>
    </div>

    {{-- Kartu 3: Total Pelamar (Data) --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden group" data-aos="fade-up" data-aos-delay="200">
        <div class="absolute right-0 top-0 h-full w-1 bg-blue-500"></div>
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-blue-500 uppercase tracking-wide mb-1">Database</p>
                <h3 class="text-gray-500 text-sm font-medium">Total Pelamar</h3>
                <p class="text-4xl font-extrabold text-gray-800 mt-2">{{ $metrics['total_applicants'] }}</p>
            </div>
            <div class="p-3 bg-blue-50 rounded-lg text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition duration-300">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
            <span>Terdaftar aktif</span>
            <i class="fas fa-check-circle text-blue-400"></i>
        </div>
    </div>

    {{-- Kartu 4: Lowongan Aktif (Data) --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden group" data-aos="fade-up" data-aos-delay="300">
        <div class="absolute right-0 top-0 h-full w-1 bg-emerald-500"></div>
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-bold text-emerald-500 uppercase tracking-wide mb-1">Marketplace</p>
                <h3 class="text-gray-500 text-sm font-medium">Lowongan Live</h3>
                <p class="text-4xl font-extrabold text-gray-800 mt-2">{{ $metrics['active_vacancies'] }}</p>
            </div>
            <div class="p-3 bg-emerald-50 rounded-lg text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition duration-300">
                <i class="fas fa-briefcase text-xl"></i>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
            <span>Sedang tayang</span>
            <i class="fas fa-signal text-emerald-400"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- 📈 COLUMN 1 & 2: GRAFIK KPI (Lebih Cantik) --}}
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100" data-aos="fade-right" data-aos-delay="400">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Tren Penempatan Kerja</h3>
                <p class="text-xs text-gray-400">Statistik penerimaan pekerja tahun {{ date('Y') }}</p>
            </div>
            <div class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-xs font-bold">
                <i class="fas fa-chart-bar mr-1"></i> Monthly
            </div>
        </div>
        <div class="relative h-72 w-full">
            <canvas id="successChart"></canvas>
        </div>
    </div>

    {{-- 📊 COLUMN 3: RINGKASAN EKSEKUTIF --}}
    <div class="lg:col-span-1 space-y-6">

        {{-- Stat Card: Total Sukses --}}
        <div class="bg-gradient-to-br from-teal-500 to-emerald-600 rounded-2xl p-6 text-white shadow-lg transform hover:scale-[1.02] transition" data-aos="fade-left" data-aos-delay="500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-emerald-100 text-sm font-medium mb-1">Total Penempatan Sukses</p>
                    <h4 class="text-4xl font-extrabold">{{ $metrics['total_success_hires'] }}</h4>
                    <p class="text-xs text-emerald-200 mt-2">Pekerja telah diterima bekerja.</p>
                </div>
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <i class="fas fa-handshake text-2xl text-white"></i>
                </div>
            </div>
        </div>

        {{-- Stat Card: Pemilik Resmi --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-indigo-100" data-aos="fade-left" data-aos-delay="600">
            <div class="flex items-center space-x-4">
                <div class="bg-indigo-100 text-indigo-600 p-4 rounded-xl">
                    <i class="fas fa-building text-2xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Pemilik Kebun Resmi</p>
                    <h4 class="text-2xl font-bold text-gray-800">{{ $metrics['approved_owners'] }}</h4>
                </div>
            </div>

        </div>

         {{-- Mini Info --}}
         <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 text-center" data-aos="fade-up" data-aos-delay="700">
            <p class="text-xs text-gray-400">Sistem berjalan normal</p>
            <p class="text-xs text-gray-500 mt-1"><i class="fas fa-clock text-green-500 mr-1"></i> Server Time: {{ date('H:i:s') }}</p>
         </div>

    </div>
</div>

{{-- SCRIPT GRAPH --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('successChart').getContext('2d');
        const trendData = @json($success_trend);

        // Buat Gradient untuk batang grafik
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.8)'); // Emerald-500
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0.1)'); // Emerald-100

        const labels = trendData.map(item => item.month_name ?? 'Bulan ' + item.month); // Asumsi controller kirim nama bulan, jika tidak pakai angka
        const totals = trendData.map(item => item.total);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pekerja Diterima',
                    data: totals,
                    backgroundColor: gradient,
                    borderColor: '#10b981',
                    borderWidth: 1,
                    borderRadius: 6, // Membulatkan sudut batang
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legend default agar lebih bersih
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#f9fafb',
                        bodyColor: '#f9fafb',
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            font: { family: "'Inter', sans-serif" },
                            color: '#9ca3af'
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: "'Inter', sans-serif" },
                            color: '#6b7280'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
