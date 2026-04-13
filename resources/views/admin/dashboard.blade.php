@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('styles')
    <style>
    /* Dashboard specific styles */
    .dashboard-cards-container {
        overflow-x: auto;
        overflow-y: hidden;
        margin: 50px 0 50px 0 !important;
        padding: 20px 0 30px 0 !important;
        scrollbar-width: thin;
        scrollbar-color: #ccc transparent;
    }

    .dashboard-cards-container::-webkit-scrollbar {
        height: 8px;
    }

    .dashboard-cards-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .dashboard-cards-container::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    .dashboard-cards-container::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        grid-template-rows: 1fr;
        gap: 12px;
        grid-auto-flow: column;
        width: max-content;
        min-width: 100%;
    }

    /* Force horizontal layout - no wrapping */
    .dashboard-cards .dashboard-card {
        grid-column: span 1;
        grid-row: span 1;
        flex-shrink: 0;
    }

    .dashboard-card {
            background: white;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
        min-height: 120px;
            display: flex;
        flex-direction: column;
            justify-content: center;
            width: 100%;
        max-width: 100%;
        flex-shrink: 0;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    .dashboard-card.primary {
        border-left-color: #1976d2;
        background: linear-gradient(135deg, #e3f2fd 0%, #f8fbff 100%);
    }

    .dashboard-card.success {
        border-left-color: #4caf50;
        background: linear-gradient(135deg, #e8f5e8 0%, #f8fdf8 100%);
    }

    .dashboard-card.warning {
        border-left-color: #ff9800;
        background: linear-gradient(135deg, #fff3e0 0%, #fffbf8 100%);
    }

    .dashboard-card.info {
        border-left-color: #2196f3;
        background: linear-gradient(135deg, #e1f5fe 0%, #f8fbff 100%);
    }

    .dashboard-card.danger {
        border-left-color: #f44336;
        background: linear-gradient(135deg, #ffebee 0%, #fef8f8 100%);
    }

    .dashboard-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
            width: 80px;
            height: 80px;
        background: rgba(255,255,255,0.1);
            border-radius: 50%;
        transform: translate(20px, -20px);
    }

    .card-icon {
        width: 42px;
        height: 42px;
        border-radius: 8px;
            display: flex;
            align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }

    .dashboard-card.primary .card-icon { background: linear-gradient(135deg, #1976d2, #2196f3); }
    .dashboard-card.success .card-icon { background: linear-gradient(135deg, #4caf50, #66bb6a); }
    .dashboard-card.warning .card-icon { background: linear-gradient(135deg, #ff9800, #ffb74d); }
    .dashboard-card.info .card-icon { background: linear-gradient(135deg, #2196f3, #42a5f5); }
    .dashboard-card.danger .card-icon { background: linear-gradient(135deg, #f44336, #ef5350); }

    .dashboard-card.danger {
        border-left-color: #f44336;
        background: linear-gradient(135deg, #ffebee 0%, #fef8f8 100%);
    }

    .card-title {
        font-size: 10px;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
            letter-spacing: 0.5px;
        margin-bottom: 6px;
        position: relative;
        z-index: 1;
        line-height: 1.2;
    }

    .card-value {
            font-size: 24px;
        font-weight: 700;
        color: #333;
        margin: 0;
        position: relative;
        z-index: 1;
        line-height: 1.1;
    }

    .card-subtitle {
        font-size: 9px;
        color: #888;
        margin-top: 3px;
        position: relative;
        z-index: 1;
        line-height: 1.2;
    }

    .quick-actions {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .quick-actions h5 {
        color: #1976d2;
            font-weight: 600;
        margin-bottom: 20px;
            display: flex;
            align-items: center;
        gap: 10px;
    }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .action-item {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
            display: flex;
            align-items: center;
        gap: 12px;
    }

    .action-item:hover {
        background: #1976d2;
        color: white;
        border-color: #1976d2;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);
        text-decoration: none;
    }

    .action-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #1976d2;
            color: white;
            display: flex;
            align-items: center;
        justify-content: center;
            font-size: 18px;
        transition: all 0.3s ease;
    }

    .action-item:hover .action-icon {
        background: white;
        color: #1976d2;
    }

    .activity-timeline {
            background: white;
        border-radius: 12px;
            padding: 25px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .activity-timeline h5 {
        color: #1976d2;
        font-weight: 600;
        margin-bottom: 20px;
            display: flex;
            align-items: center;
        gap: 10px;
        }

    .timeline {
            position: relative;
        padding-left: 30px;
        }

    .timeline::before {
            content: '';
            position: absolute;
        left: 15px;
            top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
            position: relative;
        padding-bottom: 20px;
        }

    .timeline-item::before {
            content: '';
            position: absolute;
        left: -22px;
        top: 8px;
        width: 12px;
        height: 12px;
            border-radius: 50%;
        background: #1976d2;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #e9ecef;
    }

    .timeline-time {
            font-size: 12px;
        color: #888;
            font-weight: 500;
    }

    .timeline-text {
            font-size: 14px;
        color: #333;
        margin-top: 4px;
        line-height: 1.4;
    }

    .timeline-link {
        color: #1976d2;
        text-decoration: none;
    }

    .timeline-link:hover {
        text-decoration: underline;
    }

    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
        }

    .status-active {
        background: #e8f5e8;
        color: #4caf50;
    }

    .status-pending {
        background: #fff3e0;
        color: #ff9800;
    }

    .ranking-card {
            background: white;
        border-radius: 12px;
            padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
    }

    .ranking-card h5 {
        color: #1976d2;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ranking-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
        position: relative;
    }

    .ranking-item:last-child {
        border-bottom: none;
    }

    .ranking-number {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1976d2, #2196f3);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
            font-size: 14px;
                margin-right: 15px;
            }

    .ranking-info {
        flex: 1;
    }

    .ranking-name {
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .activity-ranking .ranking-name {
        color: #2e7d32;
    }

    .meeting-ranking .ranking-name {
        color: #7b1fa2;
    }

    .activity-ranking .ranking-name a {
        color: #2e7d32;
    }

    .activity-ranking .ranking-name a:hover {
        color: #4caf50;
    }

    .meeting-ranking .ranking-name a {
        color: #7b1fa2;
    }

    .meeting-ranking .ranking-name a:hover {
        color: #9c27b0;
    }

    .ranking-stats {
        font-size: 12px;
        color: #666;
        margin-top: 2px;
    }

    .activity-ranking .ranking-stats {
        color: #2e7d32;
    }

    .meeting-ranking .ranking-stats {
        color: #7b1fa2;
    }

    .ranking-badge {
        background: #f8f9fa;
        color: #495057;
        padding: 4px 8px;
            border-radius: 12px;
                font-size: 11px;
            font-weight: 500;
        border: 1px solid #dee2e6;
    }

    .activity-ranking .ranking-badge {
        background: #e8f5e8;
        color: #4caf50;
        border: 1px solid #c3e6c3;
    }

    .meeting-ranking .ranking-badge {
        background: #f3e5f5;
        color: #9c27b0;
        border: 1px solid #e1bee7;
    }

    .notification-card {
        background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
        color: white;
        border-radius: 12px;
                padding: 20px;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }

    .notification-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(20px, -20px);
    }

    .notification-icon {
                width: 50px;
                height: 50px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .notification-title {
                font-size: 18px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .notification-text {
                font-size: 14px;
        opacity: 0.9;
        margin-bottom: 15px;
    }

    .notification-count {
        background: rgba(255,255,255,0.3);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .meeting-ranking {
        background: white;
        border: 2px solid #9c27b0;
        border-radius: 12px;
    }

    .meeting-ranking h5 {
        color: #9c27b0;
    }

    .meeting-ranking .ranking-number {
        background: linear-gradient(135deg, #9c27b0, #673ab7);
    }

    .activity-ranking {
        background: white;
        border: 2px solid #4caf50;
        border-radius: 12px;
    }

    .activity-ranking h5 {
        color: #4caf50;
    }

    .activity-ranking .ranking-number {
        background: linear-gradient(135deg, #4caf50, #388e3c);
    }

    .absensi-alert {
        background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        animation: pulse 2s infinite;
    }

    .activity-ranking .btn-outline-primary {
        color: #4caf50;
        border-color: #4caf50;
    }

    .activity-ranking .btn-outline-primary:hover {
        background: #4caf50;
        border-color: #4caf50;
    }

    .meeting-ranking .btn-outline-secondary {
        color: #9c27b0;
        border-color: #9c27b0;
    }

    .meeting-ranking .btn-outline-secondary:hover {
        background: #9c27b0;
        border-color: #9c27b0;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(244, 67, 54, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(244, 67, 54, 0); }
        100% { box-shadow: 0 0 0 0 rgba(244, 67, 54, 0); }
    }

    /* Maintain horizontal layout at all screen sizes */
    @media (max-width: 1400px) {
        .dashboard-cards {
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 10px;
        }

        .dashboard-card {
            padding: 14px;
            min-height: 110px;
        }

        .card-value {
            font-size: 22px;
        }

        .card-title {
            font-size: 9px;
        }

        .card-icon {
            width: 40px;
            height: 40px;
            font-size: 18px;
            margin-bottom: 8px;
        }
    }

    @media (max-width: 1200px) {
        .dashboard-cards {
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 8px;
        }

        .dashboard-card {
            padding: 12px;
            min-height: 100px;
        }

        .card-value {
            font-size: 20px;
        }

        .card-title {
            font-size: 8px;
            margin-bottom: 4px;
        }

        .card-subtitle {
            font-size: 8px;
            margin-top: 2px;
        }

        .card-icon {
            width: 36px;
            height: 36px;
            font-size: 16px;
            margin-bottom: 6px;
        }
    }

    @media (max-width: 992px) {
        .dashboard-cards {
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 6px;
        }

        .dashboard-card {
            padding: 10px;
            min-height: 90px;
        }

        .card-value {
            font-size: 18px;
        }

        .card-title {
            font-size: 7px;
        }

        .card-icon {
            width: 32px;
            height: 32px;
            font-size: 14px;
            margin-bottom: 4px;
        }
    }

    @media (max-width: 768px) {
        /* Ubah layout menjadi grid 2 kolom dan hilangkan horizontal scroll */
        .dashboard-cards-container {
            overflow-x: visible;
            padding: 12px 0 20px 0 !important;
        }

        .dashboard-cards {
            width: 100%;
            grid-auto-flow: row;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .action-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-card {
            padding: 12px;
            min-height: 110px;
        }

        .card-value {
            font-size: 20px;
        }

        .card-title {
            font-size: 8px;
            margin-bottom: 4px;
        }

        .card-subtitle {
            font-size: 8px;
            margin-top: 2px;
        }

        .card-icon {
            width: 36px;
            height: 36px;
            font-size: 16px;
            margin-bottom: 6px;
        }

        .ranking-item {
            padding: 10px 0;
        }

        .ranking-number {
            width: 25px;
            height: 25px;
            font-size: 12px;
            margin-right: 10px;
        }
    }

    @media (max-width: 576px) {
        /* Stack 1 kolom untuk layar sangat kecil */
        .dashboard-cards-container {
            overflow-x: visible;
        }

        .dashboard-cards {
            width: 100%;
            grid-auto-flow: row;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .dashboard-card {
            padding: 12px;
            min-height: 110px;
        }

        .card-value {
            font-size: 20px;
        }

        .card-title {
            font-size: 8px;
        }

        .card-icon {
            width: 34px;
            height: 34px;
            font-size: 16px;
            margin-bottom: 6px;
        }
    }
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
            <h4 class="mb-1">🏠 Dashboard Admin</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>
        <div class="text-muted">
            <i class="fas fa-calendar me-1"></i>
            {{ now()->format('l, d F Y') }}
            </div>
        </div>

    <!-- Dashboard Cards -->
    <div class="dashboard-cards-container">
        <div class="dashboard-cards">
        <!-- Total Anggota -->
        <div class="dashboard-card info">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-title">Total Anggota</div>
            <div class="card-value">{{ $anggotaCount }}</div>
            <div class="card-subtitle">Anggota terdaftar</div>
        </div>

        <!-- Total Kegiatan -->
        <div class="dashboard-card primary">
            <div class="card-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="card-title">Total Kegiatan</div>
            <div class="card-value">{{ $kegiatanCount }}</div>
            <div class="card-subtitle">Kegiatan yang telah dibuat</div>
        </div>

        <!-- Total Absensi -->
        <div class="dashboard-card success">
            <div class="card-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="card-title">Total Absensi</div>
            <div class="card-value">{{ $absensiCount }}</div>
            <div class="card-subtitle">Data absensi yang tercatat</div>
        </div>

        <!-- Total Sertifikat -->
        <div class="dashboard-card warning">
            <div class="card-icon">
                <i class="fas fa-certificate"></i>
            </div>
            <div class="card-title">Total Sertifikat</div>
            <div class="card-value">{{ $sertifikatCount }}</div>
            <div class="card-subtitle">Sertifikat yang diterbitkan</div>
        </div>

        <!-- Total Keuangan Masuk -->
        <div class="dashboard-card success">
            <div class="card-icon">
                <i class="fas fa-arrow-up"></i>
                                    </div>
            <div class="card-title">Pemasukan Bulan Ini</div>
            <div class="card-value">
                @php
                    $totalMasuk = \App\Models\Keuangan::masuk()
                        ->whereYear('tanggal', now()->year)
                        ->whereMonth('tanggal', now()->month)
                        ->sum('jumlah');
                @endphp
                Rp {{ number_format($totalMasuk, 0, ',', '.') }}
                                </div>
            <div class="card-subtitle">Total pemasukan bulan ini</div>
                            </div>

        <!-- Total Keuangan Keluar -->
        <div class="dashboard-card danger">
            <div class="card-icon">
                <i class="fas fa-arrow-down"></i>
        </div>
            <div class="card-title">Pengeluaran Bulan Ini</div>
            <div class="card-value">
                @php
                    $totalKeluar = \App\Models\Keuangan::keluar()
                        ->whereYear('tanggal', now()->year)
                        ->whereMonth('tanggal', now()->month)
                        ->sum('jumlah');
                @endphp
                Rp {{ number_format($totalKeluar, 0, ',', '.') }}
            </div>
            <div class="card-subtitle">Total pengeluaran bulan ini</div>
            </div>
            </div>
                                    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h5><i class="fas fa-bolt"></i> Quick Actions</h5>
        <div class="action-grid">
            <a href="{{ route('anggota.index') }}" class="action-item">
                <div class="action-icon">
                <i class="fas fa-users"></i>
                                </div>
                <div>
                    <div class="fw-bold">Kelola Anggota</div>
                    <div class="text-muted small">Tambah, edit, hapus anggota</div>
                            </div>
            </a>

            <a href="{{ route('riwayat-kegiatan.index') }}" class="action-item">
                <div class="action-icon">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <div>
                    <div class="fw-bold">Buat Kegiatan</div>
                    <div class="text-muted small">Jadwalkan kegiatan baru</div>
                </div>
            </a>

            <a href="{{ route('admin.absensi.index') }}" class="action-item">
                <div class="action-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div>
                    <div class="fw-bold">Kelola Absensi</div>
                    <div class="text-muted small">Lihat dan edit absensi</div>
                                    </div>
            </a>

            <a href="{{ route('admin.sertifikat.index') }}" class="action-item">
                <div class="action-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <div>
                    <div class="fw-bold">Kelola Sertifikat</div>
                    <div class="text-muted small">Buat dan kelola sertifikat</div>
                            </div>
            </a>

            <a href="{{ route('admin.keuangan.index') }}" class="action-item">
                <div class="action-icon">
                    <i class="fas fa-wallet"></i>
                        </div>
                <div>
                    <div class="fw-bold">Kelola Keuangan</div>
                    <div class="text-muted small">Input dan laporan keuangan</div>
                    </div>
            </a>

            <a href="{{ route('admin.meeting-notes.index') }}" class="action-item">
                <div class="action-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <div class="fw-bold">Meeting Notes</div>
                    <div class="text-muted small">Catatan rapat dan agenda</div>
                </div>
            </a>
            </div>
        </div>

    <!-- Notifications & Alerts -->
    @php
        // Check for recent absensi updates (last 24 hours)
        $recentAbsensi = \App\Models\AbsensiKegiatan::where('waktu_absen', '>=', now()->subDay())
            ->orderBy('waktu_absen', 'desc')
            ->count();

        // Check for pending absensi (need confirmation)
        $pendingAbsensi = \App\Models\AbsensiKegiatan::whereIn('status_kehadiran', ['Izin', 'Sakit'])
            ->where('waktu_absen', '>=', now()->subDays(3))
            ->count();
    @endphp

    @if($recentAbsensi > 0 || $pendingAbsensi > 0)
        <div class="row">
            @if($recentAbsensi > 0)
            <div class="col-lg-6">
                    <div class="notification-card absensi-alert">
                        <div class="notification-icon">
                <i class="fas fa-bell"></i>
                        </div>
                        <div class="notification-title">
                            <i class="fas fa-clipboard-check me-2"></i>Update Absensi Terbaru
                                    </div>
                        <div class="notification-text">
                            Ada {{ $recentAbsensi }} absensi baru yang perlu ditinjau dalam 24 jam terakhir.
                                </div>
                        <div class="notification-count">
                            {{ $recentAbsensi }} Update
                </div>
                        <a href="{{ route('admin.absensi.index') }}" class="btn btn-light btn-sm mt-2">
                            <i class="fas fa-eye me-1"></i>Lihat Absensi
                        </a>
                            </div>
                        </div>
            @endif

            @if($pendingAbsensi > 0)
                <div class="col-lg-6">
                    <div class="notification-card" style="background: linear-gradient(135deg, #ff5722 0%, #e64a19 100%);">
                        <div class="notification-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                </div>
                        <div class="notification-title">
                            <i class="fas fa-clock me-2"></i>Perlu Konfirmasi
                </div>
                        <div class="notification-text">
                            Ada {{ $pendingAbsensi }} permohonan izin/sakit yang menunggu konfirmasi admin.
            </div>
                        <div class="notification-count">
                            {{ $pendingAbsensi }} Pending
        </div>
                        <a href="{{ route('admin.absensi.index') }}?status=Izin,Sakit" class="btn btn-light btn-sm mt-2">
                            <i class="fas fa-check me-1"></i>Konfirmasi
                        </a>
                            </div>
                        </div>
            @endif
                </div>
    @endif

    <!-- Analisis Keaktifan Anggota -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm mb-4" style="border-left: 4px solid #2196f3;">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        📊 Analisis Keaktifan Anggota
                    </h5>
                    <a href="{{ route('admin.analisis-keaktifan') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-chart-bar me-1"></i>
                        Lihat Detail
                    </a>
                </div>
                <div class="card-body">
                    <!-- Summary Stats -->
                    <div class="row mb-4">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="analisis-stat-card" style="background: linear-gradient(135deg, #e3f2fd 0%, #f8fbff 100%); border-left: 4px solid #2196f3; padding: 20px; border-radius: 12px;">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #2196f3, #64b5f6); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-calendar-check text-white" style="font-size: 24px;"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Aktif Kegiatan (30 Hari)</div>
                                        <div class="h4 mb-0 fw-bold">{{ $analisisKeaktifan['anggota_aktif_kegiatan'] }}</div>
                                        <div class="small text-success">
                                            <i class="fas fa-arrow-up me-1"></i>
                                            {{ $analisisKeaktifan['tingkat_keaktifan_kegiatan'] }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="analisis-stat-card" style="background: linear-gradient(135deg, #f3e5f5 0%, #faf8fb 100%); border-left: 4px solid #9c27b0; padding: 20px; border-radius: 12px;">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #9c27b0, #ba68c8); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-users text-white" style="font-size: 24px;"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Aktif Meeting (30 Hari)</div>
                                        <div class="h4 mb-0 fw-bold">{{ $analisisKeaktifan['anggota_aktif_meeting'] }}</div>
                                        <div class="small text-success">
                                            <i class="fas fa-arrow-up me-1"></i>
                                            {{ $analisisKeaktifan['tingkat_keaktifan_meeting'] }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="analisis-stat-card" style="background: linear-gradient(135deg, #fff3e0 0%, #fffbf8 100%); border-left: 4px solid #ff9800; padding: 20px; border-radius: 12px;">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #ff9800, #ffb74d); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-certificate text-white" style="font-size: 24px;"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Anggota Bersertifikat</div>
                                        <div class="h4 mb-0 fw-bold">{{ $analisisKeaktifan['anggota_dengan_sertifikat'] }}</div>
                                        <div class="small text-warning">
                                            <i class="fas fa-award me-1"></i>
                                            {{ $analisisKeaktifan['tingkat_sertifikasi'] }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="analisis-stat-card" style="background: linear-gradient(135deg, #e8f5e8 0%, #f8fdf8 100%); border-left: 4px solid #4caf50; padding: 20px; border-radius: 12px;">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #4caf50, #81c784); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user-check text-white" style="font-size: 24px;"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small">Total Anggota Aktif</div>
                                        <div class="h4 mb-0 fw-bold">{{ $analisisKeaktifan['total_anggota'] }}</div>
                                        <div class="small text-muted">
                                            <i class="fas fa-users me-1"></i>
                                            Anggota Terdaftar
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori Keaktifan -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="mb-3 fw-bold">
                                <i class="fas fa-layer-group me-2"></i>
                                Kategori Keaktifan (30 Hari Terakhir)
                            </h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="kategori-card" style="background: linear-gradient(135deg, #e8f5e9, #f1f8e9); border: 2px solid #4caf50; border-radius: 12px; padding: 20px; text-align: center;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #4caf50, #66bb6a); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-star text-white" style="font-size: 28px;"></i>
                                </div>
                                <div class="h2 mb-1 fw-bold text-success">{{ $analisisKeaktifan['kategori']['sangat_aktif'] }}</div>
                                <div class="fw-bold text-success mb-1">Sangat Aktif</div>
                                <div class="small text-muted">≥ 5 kehadiran</div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="kategori-card" style="background: linear-gradient(135deg, #e1f5fe, #e0f7fa); border: 2px solid #2196f3; border-radius: 12px; padding: 20px; text-align: center;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #2196f3, #42a5f5); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-thumbs-up text-white" style="font-size: 28px;"></i>
                                </div>
                                <div class="h2 mb-1 fw-bold text-info">{{ $analisisKeaktifan['kategori']['aktif'] }}</div>
                                <div class="fw-bold text-info mb-1">Aktif</div>
                                <div class="small text-muted">3-4 kehadiran</div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="kategori-card" style="background: linear-gradient(135deg, #fff3e0, #fff8e1); border: 2px solid #ff9800; border-radius: 12px; padding: 20px; text-align: center;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #ff9800, #ffa726); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-exclamation-triangle text-white" style="font-size: 28px;"></i>
                                </div>
                                <div class="h2 mb-1 fw-bold text-warning">{{ $analisisKeaktifan['kategori']['kurang_aktif'] }}</div>
                                <div class="fw-bold text-warning mb-1">Kurang Aktif</div>
                                <div class="small text-muted">1-2 kehadiran</div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="kategori-card" style="background: linear-gradient(135deg, #ffebee, #fce4ec); border: 2px solid #f44336; border-radius: 12px; padding: 20px; text-align: center;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #f44336, #ef5350); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-times-circle text-white" style="font-size: 28px;"></i>
                                </div>
                                <div class="h2 mb-1 fw-bold text-danger">{{ $analisisKeaktifan['kategori']['tidak_aktif'] }}</div>
                                <div class="fw-bold text-danger mb-1">Tidak Aktif</div>
                                <div class="small text-muted">0 kehadiran</div>
                            </div>
                        </div>
                    </div>

                    <!-- Info Footer -->
                    <div class="alert alert-info mb-0 mt-3" style="border-left: 4px solid #2196f3;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle me-3" style="font-size: 24px;"></i>
                            <div>
                                <strong>Catatan:</strong> Data analisis berdasarkan kehadiran kegiatan dan meeting dalam 30 hari terakhir. 
                                Klik <strong>"Lihat Detail"</strong> untuk melihat rincian lengkap per anggota.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ranking Section -->
        <div class="row">
        <!-- Anggota Terbanyak Ikut Kegiatan -->
            <div class="col-lg-6">
            <div class="ranking-card activity-ranking">
                <h5><i class="fas fa-trophy"></i> 🏆 Anggota Teraktif Kegiatan</h5>
                @php
                    $topKegiatanAnggota = \App\Models\Anggota::withCount([
                                                'absensiKegiatans as hadir_count' => function ($q) {
                                                    $q->where('status_kehadiran', 'Hadir');
                                                },
                        'absensiKegiatans as total_count'
                            ])->orderByDesc('hadir_count')->limit(5)->get();
                                        @endphp

                @forelse($topKegiatanAnggota as $index => $anggota)
                    <div class="ranking-item">
                        <div class="ranking-number">{{ $index + 1 }}</div>
                        <div class="ranking-info">
                            <div class="ranking-name">
                                <a href="{{ route('anggota.show', $anggota->id) }}" class="text-decoration-none">
                                    {{ $anggota->nama }}
                                </a>
                                    </div>
                            <div class="ranking-stats">
                                {{ $anggota->hadir_count }} hadir dari {{ $anggota->total_count }} kegiatan
                                <span class="ranking-badge">
                                    {{ $anggota->total_count > 0 ? round(($anggota->hadir_count / $anggota->total_count) * 100) : 0 }}% kehadiran
                                </span>
                                </div>
                        </div>
                    </div>
                                        @empty
                    <div class="ranking-item">
                        <div class="ranking-info">
                            <div class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Belum ada data kegiatan
                            </div>
                        </div>
                    </div>
                                        @endforelse

                <div class="text-center mt-3">
                    <a href="{{ route('admin.absensi.ranking') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-chart-bar me-1"></i>Lihat Ranking Lengkap
                    </a>
                                </div>
                            </div>
                        </div>

        <!-- Anggota Terbanyak Ikut Meeting -->
            <div class="col-lg-6">
            <div class="ranking-card meeting-ranking">
                <h5><i class="fas fa-users"></i> 🏆 Anggota Teraktif Meeting</h5>
                @php
                    // Get meeting attendance data
                                    $meetings = \App\Models\MeetingNote::whereNotNull('attendance')
                                                   ->where('attendance', '!=', '')
                                                   ->get();
                                    
                    $meetingAttendanceCount = [];
                                    
                                    foreach ($meetings as $meeting) {
                                        $attendees = array_map('trim', explode(',', $meeting->attendance));
                                        
                                        foreach ($attendees as $attendee) {
                                            if (!empty($attendee)) {
                                if (!isset($meetingAttendanceCount[$attendee])) {
                                    $meetingAttendanceCount[$attendee] = 0;
                                }
                                $meetingAttendanceCount[$attendee]++;
                            }
                        }
                    }

                    arsort($meetingAttendanceCount);
                    $topMeetingAttendees = array_slice($meetingAttendanceCount, 0, 5, true);
                                @endphp

                                @forelse($topMeetingAttendees as $name => $count)
                                    @php
                                        $anggota = \App\Models\Anggota::where('nama', $name)->first();
                                    @endphp
                    <div class="ranking-item">
                        <div class="ranking-number">{{ $loop->index + 1 }}</div>
                        <div class="ranking-info">
                            <div class="ranking-name">
                                            @if($anggota)
                                    <a href="{{ route('anggota.show', $anggota->id) }}" class="text-decoration-none">
                                        {{ $name }}
                                                </a>
                                                                @else
                                    {{ $name }}
                                                                @endif
                            </div>
                            <div class="ranking-stats">
                                {{ $count }} meeting dihadiri
                                <span class="ranking-badge">
                                    {{ $meetings->count() > 0 ? round(($count / $meetings->count()) * 100) : 0 }}% partisipasi
                                                                </span>
                            </div>
                        </div>
                    </div>
                                @empty
                    <div class="ranking-item">
                        <div class="ranking-info">
                            <div class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Belum ada data meeting
                            </div>
                        </div>
                    </div>
                                @endforelse

                <div class="text-center mt-3">
                    <a href="{{ route('admin.meeting-notes.ranking') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-chart-bar me-1"></i>Lihat Ranking Lengkap
                    </a>
                                    </div>
                                </div>
                            </div>
                        </div>

    <!-- Recent Activities Summary -->
        <div class="row">
        <div class="col-lg-6">
            <div class="activity-timeline">
                <h5><i class="fas fa-clock"></i> Aktivitas Absensi Hari Ini</h5>
                <div class="timeline">
                    @php
                        $todayActivities = \App\Models\AbsensiKegiatan::with(['anggota', 'riwayatKegiatan'])
                            ->whereDate('waktu_absen', today())
                                            ->orderBy('waktu_absen', 'desc')
                            ->limit(5)
                                            ->get();
                                    @endphp

                    @forelse($todayActivities as $activity)
                        <div class="timeline-item">
                            <div class="timeline-time">{{ $activity->waktu_absen->format('H:i') }}</div>
                            <div class="timeline-text">
                                <strong>{{ $activity->anggota->nama }}</strong>
                                <span class="status-indicator {{ $activity->status_kehadiran == 'Hadir' ? 'status-active' : 'status-pending' }}">
                                    <i class="fas fa-{{ $activity->status_kehadiran == 'Hadir' ? 'check' : 'clock' }}"></i>
                                    {{ $activity->status_kehadiran }}
                                </span>
                                                    <br>
                                                    <small class="text-muted">
                                    {{ Str::limit($activity->riwayatKegiatan->judul, 25) }}
                                                    </small>
                                                                </div>
                        </div>
                    @empty
                        <div class="timeline-item">
                            <div class="timeline-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Belum ada aktivitas hari ini
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="activity-timeline">
                <h5><i class="fas fa-calendar-week"></i> Kegiatan Minggu Ini</h5>
                <div class="timeline">
                    @php
                        $weekActivities = \App\Models\RiwayatKegiatan::whereBetween('tanggal_kegiatan', [
                                now()->startOfWeek(),
                                now()->endOfWeek()
                            ])
                            ->orderBy('tanggal_kegiatan', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp

                    @forelse($weekActivities as $activity)
                        <div class="timeline-item">
                            <div class="timeline-time">{{ $activity->tanggal_kegiatan->format('d/m') }}</div>
                            <div class="timeline-text">
                                <strong>{{ $activity->judul }}</strong>
                                <span class="status-indicator status-active">
                                    <i class="fas fa-calendar"></i>
                                    {{ $activity->tanggal_kegiatan->format('l') }}
                                                    </span>
                                <br>
                                <small class="text-muted">
                                    {{ $activity->waktu_mulai }} - {{ $activity->waktu_selesai }}
                                                </small>
                            </div>
                        </div>
                                                    @empty
                        <div class="timeline-item">
                            <div class="timeline-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Tidak ada kegiatan minggu ini
                                        </div>
                        </div>
                    @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
