@extends('layouts.pelamar')

@section('title', 'History Lamaran')

@section('content')
<div class="main-content">
    <!-- Header Halaman -->
    <div class="page-header">
        <div class="page-title">
            <h2>History Lamaran</h2>
            <p>Riwayat lamaran yang telah Anda ajukan</p>
        </div>
    </div>

    <!-- Statistik -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-number">0</div>
            <div class="stat-label">Total Lamaran</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">0</div>
            <div class="stat-label">Menunggu</div>
        </div>

        <div class="stat-card">
            <div class="stat-number">0</div>
            <div class="stat-label">Diterima</div>
        </div>
    </div>

    <!-- Daftar History -->
    <div class="card">
        <div class="card-title">Daftar Lamaran</div>

        <!-- Tampilan kosong -->
        <div class="empty-state" id="empty-history">
            <div class="empty-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <h3>Belum ada riwayat lamaran</h3>
            <p>Anda belum pernah mengajukan lamaran pekerjaan. Temukan lowongan yang sesuai dengan keahlian Anda dan ajukan lamaran sekarang.</p>
            <a href="{{ route('pelamar.lowongan') }}" class="empty-action">Cari lowongan sekarang →</a>
        </div>

        <!-- Daftar history (akan ditampilkan jika ada data) -->
        <div class="history-section" id="history-list" style="display: none;">
            <!-- Item history akan ditampilkan di sini -->
        </div>
    </div>
</div>

<!-- Script untuk History -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set active menu di sidebar
        document.querySelectorAll('.nav-item').forEach(item => {
            item.classList.remove('active');
        });
        document.querySelector('.nav-item[data-page="history"]').classList.add('active');

        // Contoh data history (bisa diambil dari database)
        const historyData = [
            {
                id: 1,
                title: "Pemanen Sawit Berpengalaman",
                location: "Kalimantan Barat",
                date: "12 Maret 2023",
                status: "menunggu"
            },
            {
                id: 2,
                title: "Mandor Kebun Sawit",
                location: "Riau",
                date: "5 Februari 2023",
                status: "diterima"
            }
        ];

        // Jika ada data history, tampilkan
        if (historyData.length > 0) {
            document.getElementById('empty-history').style.display = 'none';
            document.getElementById('history-list').style.display = 'block';

            const historyList = document.getElementById('history-list');
            historyList.innerHTML = '';

            historyData.forEach(item => {
                let statusClass = '';
                let statusText = '';

                switch(item.status) {
                    case 'menunggu':
                        statusClass = 'status-menunggu';
                        statusText = 'Menunggu';
                        break;
                    case 'diterima':
                        statusClass = 'status-diterima';
                        statusText = 'Diterima';
                        break;
                    case 'ditolak':
                        statusClass = 'status-ditolak';
                        statusText = 'Ditolak';
                        break;
                }

                historyList.innerHTML += `
                    <div class="history-item">
                        <div class="history-info">
                            <h4>${item.title}</h4>
                            <div class="history-meta">
                                <span><i class="fas fa-map-marker-alt"></i> ${item.location}</span>
                                <span><i class="fas fa-calendar"></i> ${item.date}</span>
                            </div>
                        </div>
                        <div class="history-status ${statusClass}">${statusText}</div>
                    </div>
                `;
            });
        }
    });
</script>

<style>
    /* CSS khusus untuk halaman history */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        text-align: center;
    }

    .stat-number {
        font-size: 36px;
        font-weight: 700;
        color: #2d572c;
        margin-bottom: 5px;
    }

    .stat-label {
        color: #666;
        font-size: 14px;
    }

    .history-section {
        margin-top: 20px;
    }

    .history-item {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-left: 4px solid #2d572c;
    }

    .history-info h4 {
        font-size: 18px;
        color: #2d572c;
        margin-bottom: 8px;
    }

    .history-meta {
        display: flex;
        gap: 15px;
        color: #666;
        font-size: 14px;
    }

    .history-status {
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .status-menunggu {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-diterima {
        background-color: #d4edda;
        color: #155724;
    }

    .status-ditolak {
        background-color: #f8d7da;
        color: #721c24;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #666;
    }

    .empty-icon {
        font-size: 60px;
        color: #ddd;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 22px;
        margin-bottom: 10px;
        color: #555;
    }

    .empty-state p {
        margin-bottom: 25px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .empty-action {
        display: inline-block;
        background-color: #2d572c;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 12px 25px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s;
        text-decoration: none;
    }

    .empty-action:hover {
        background-color: #3a6b39;
        color: white;
        text-decoration: none;
    }
</style>
@endsection
