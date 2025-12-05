@extends('layouts.pelamar')

@section('title', 'Cari Lowongan')

@section('content')
<div class="main-content">
    <!-- Header Halaman -->
    <div class="page-header">
        <div class="page-title">
            <h2>Cari Lowongan</h2>
            <p>Temukan lowongan pekerjaan yang sesuai dengan kemampuan Anda</p>
        </div>
    </div>

    <!-- Form Pencarian -->
    <div class="search-section">
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Judul, lokasi, atau deskripsi...">
            <button class="search-btn">Cari</button>
        </div>

        <div class="filter-section">
            <select class="filter-dropdown">
                <option>Status Lowongan</option>
                <option>Aktif</option>
                <option>Tutup</option>
            </select>

            <select class="filter-dropdown">
                <option>Urutkan</option>
                <option>Terbaru</option>
                <option>Gaji Tertinggi</option>
                <option>Lokasi Terdekat</option>
            </select>
        </div>
    </div>

    <!-- Tab Status -->
    <div class="status-tabs">
        <div class="status-tab active">Lowongan Aktif</div>
        <div class="status-tab">Menunggu ACC</div>
        <div class="status-tab">Lowongan Selesai</div>
    </div>

    <!-- Daftar Lowongan -->
    <div class="card">
        <div class="card-title">Lowongan Tersedia</div>

        <div class="lowongan-container">
            <!-- Lowongan 1 -->
            <div class="lowongan-card">
                <div class="lowongan-title">Pemanen Sawit Berpengalaman</div>
                <div class="lowongan-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Kalimantan Barat</span>
                    <span><i class="fas fa-money-bill-wave"></i> Rp 4,5 - 5,5 juta</span>
                </div>
                <div class="lowongan-desc">
                    Dicari pemanen sawit berpengalaman minimal 2 tahun. Mampu memanen 100-150 pohon per hari. Fasilitas: mess, transportasi, asuransi.
                </div>
                <button class="apply-btn">Lamar Sekarang</button>
            </div>

            <!-- Lowongan 2 -->
            <div class="lowongan-card">
                <div class="lowongan-title">Mandor Kebun Sawit</div>
                <div class="lowongan-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Riau</span>
                    <span><i class="fas fa-money-bill-wave"></i> Rp 5 - 6 juta</span>
                </div>
                <div class="lowongan-desc">
                    Bertanggung jawab mengawasi 20-30 pemanen. Minimal pengalaman 3 tahun sebagai pemanen atau 1 tahun sebagai mandor.
                </div>
                <button class="apply-btn">Lamar Sekarang</button>
            </div>

            <!-- Lowongan 3 -->
            <div class="lowongan-card">
                <div class="lowongan-title">Operator Alat Berat Perkebunan</div>
                <div class="lowongan-meta">
                    <span><i class="fas fa-map-marker-alt"></i> Sumatera Selatan</span>
                    <span><i class="fas fa-money-bill-wave"></i> Rp 5 - 6,5 juta</span>
                </div>
                <div class="lowongan-desc">
                    Mengoperasikan excavator, bulldozer untuk pembukaan lahan. Memiliki sertifikasi operator alat berat. Pengalaman minimal 2 tahun.
                </div>
                <button class="apply-btn">Lamar Sekarang</button>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Lowongan -->
<script>
    // Tab status lowongan
    document.querySelectorAll('.status-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.status-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Tombol lamar
    document.querySelectorAll('.apply-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            alert('Lamaran berhasil dikirim!');
        });
    });

    // Set active menu di sidebar
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.nav-item').forEach(item => {
            item.classList.remove('active');
        });
        document.querySelector('.nav-item[data-page="lowongan"]').classList.add('active');
    });
</script>

<style>
    /* CSS khusus untuk halaman lowongan */
    .search-section {
        margin-bottom: 30px;
    }

    .search-box {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .search-input {
        flex: 1;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    .search-btn {
        background-color: #2d572c;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 12px 25px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .search-btn:hover {
        background-color: #3a6b39;
    }

    .filter-section {
        display: flex;
        gap: 15px;
    }

    .filter-dropdown {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: white;
        color: #333;
    }

    .status-tabs {
        display: flex;
        background-color: #f0f0f0;
        border-radius: 8px;
        padding: 5px;
        margin-bottom: 25px;
    }

    .status-tab {
        flex: 1;
        text-align: center;
        padding: 12px;
        cursor: pointer;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .status-tab.active {
        background-color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        color: #2d572c;
    }

    .lowongan-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .lowongan-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        border-left: 4px solid #2d572c;
        transition: transform 0.3s;
    }

    .lowongan-card:hover {
        transform: translateY(-5px);
    }

    .lowongan-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #2d572c;
    }

    .lowongan-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        font-size: 14px;
        color: #666;
    }

    .lowongan-meta i {
        margin-right: 5px;
    }

    .lowongan-desc {
        color: #555;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .apply-btn {
        background-color: #2d572c;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-weight: 500;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s;
    }

    .apply-btn:hover {
        background-color: #3a6b39;
    }
</style>
@endsection
