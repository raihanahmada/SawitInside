@extends('layouts.pelamar')

@section('title', 'History Lamaran')
@section('page-title', 'History Lamaran')
@section('page-subtitle', 'Riwayat lamaran yang telah Anda ajukan')

@section('content')
<div class="container-fluid">
    <!-- Stats Section -->
    <div class="history-stats">
        <div class="history-stat-card">
            <div class="stat-number">0</div>
            <div class="stat-label">Total Lamaran</div>
        </div>

        <div class="history-stat-card">
            <div class="stat-number">0</div>
            <div class="stat-label">Menunggu</div>
        </div>

        <div class="history-stat-card">
            <div class="stat-number">0</div>
            <div class="stat-label">Diterima</div>
        </div>
    </div>

    <!-- History List Section -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Daftar Lamaran</h5>
        </div>
        <div class="card-body">
            <!-- Empty State -->
            <div class="empty-history">
                <div class="empty-history-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h4>Belum ada riwayat lamaran</h4>
                <p>Anda belum pernah melakukan lamaran pekerjaan. Temukan lowongan yang sesuai untuk Anda!</p>
                <a href="{{ route('pelamar.lowongan') }}" class="btn btn-primary">
                    <i class="fas fa-search me-2"></i>Cari Lowongan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Contoh data untuk demo (jika ingin menampilkan data contoh)
        const historyData = [
            {
                id: 1,
                title: "Pemanen Sawit Berpengalaman",
                company: "PT. Sawit Maju Jaya",
                date: "12 Maret 2023",
                status: "menunggu"
            },
            {
                id: 2,
                title: "Mandor Kebun Sawit",
                company: "PT. Kebun Sawit Makmur",
                date: "5 Februari 2023",
                status: "diterima"
            }
        ];

        // Jika ingin menampilkan data demo, hapus komentar di bawah ini
        /*
        if (historyData.length > 0) {
            // Sembunyikan empty state
            document.querySelector('.empty-history').style.display = 'none';

            // Buat container untuk history list
            const historyList = document.createElement('div');
            historyList.className = 'history-list';

            // Tambahkan setiap item
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

                const historyItem = document.createElement('div');
                historyItem.className = 'history-item';
                historyItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="history-job-title">${item.title}</div>
                            <div class="history-company">${item.company}</div>
                            <div class="history-date">Dilamar pada: ${item.date}</div>
                        </div>
                        <div>
                            <span class="history-status ${statusClass}">${statusText}</span>
                        </div>
                    </div>
                `;

                historyList.appendChild(historyItem);
            });

            // Tambahkan history list ke card body
            document.querySelector('.card-body').appendChild(historyList);
        }
        */
    });
</script>
@endsection
