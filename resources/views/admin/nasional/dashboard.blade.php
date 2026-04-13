@extends('admin.layouts.app')

@section('title', 'Dashboard Admin Nasional')

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
        grid-template-columns: repeat(5, minmax(220px, 1fr)); /* Adjusted for 5 cards */
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
    
    .meeting-ranking .btn-outline-secondary {
        color: #9c27b0;
        border-color: #9c27b0;
    }

    .meeting-ranking .btn-outline-secondary:hover {
        background: #9c27b0;
        border-color: #9c27b0;
        color: white;
    }
    
    .ranking-stats {
        font-size: 12px;
        color: #666;
        margin-top: 2px;
    }
    
    .meeting-ranking .ranking-stats {
        color: #7b1fa2;
    }
    
    .meeting-ranking .ranking-badge {
        background: #f3e5f5;
        color: #9c27b0;
        border: 1px solid #e1bee7;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
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
    }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">🏠 Dashboard Admin Nasional</h4>
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
                <div class="card-value">{{ \App\Models\Anggota::count() }}</div>
                <div class="card-subtitle">Anggota terdaftar</div>
            </div>

            <!-- Total Provinsi Terdaftar -->
            <div class="dashboard-card primary">
                <div class="card-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <div class="card-title">Total Provinsi</div>
                <div class="card-value">{{ \App\Models\Wilayah::where('tipe', 'provinsi')->count() }}</div>
                <div class="card-subtitle">Provinsi terdaftar</div>
            </div>

            <!-- Total Kota/Kabupaten Terdaftar -->
            <div class="dashboard-card info">
                <div class="card-icon">
                    <i class="fas fa-city"></i>
                </div>
                <div class="card-title">Total Kota/Kab</div>
                <div class="card-value">{{ \App\Models\Wilayah::where('tipe', 'cabang')->count() }}</div>
                <div class="card-subtitle">Kota/Kabupaten terdaftar</div>
            </div>
            
            <!-- Total LMS -->
            <div class="dashboard-card warning">
                <div class="card-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="card-title">Total LMS</div>
                <div class="card-value">{{ \App\Models\Lms::count() }}</div>
                <div class="card-subtitle">Materi pembelajaran</div>
            </div>
            
            <!-- Keaktifan -->
            <div class="dashboard-card success">
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="card-title">Keaktifan</div>
                <div class="card-value">{{ $analisisKeaktifan['active_percentage'] }}%</div>
                <div class="card-subtitle">Persentase anggota aktif</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Top 5 Meeting Attendance -->
        <div class="col-md-6 mb-4">
            <div class="ranking-card meeting-ranking h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-video me-2"></i>
                        Top 5 Kehadiran Meeting
                    </h5>
                    <a href="{{ route('admin.absensi.ranking') }}" class="btn btn-sm btn-outline-secondary">
                        Lihat Semua
                    </a>
                </div>

                <div class="ranking-list">
                    @forelse($topMeetingAttendance as $name => $count)
                        <div class="ranking-item">
                            <div class="ranking-number">{{ $loop->iteration }}</div>
                            <div class="ranking-info">
                                <div class="ranking-name">{{ $name }}</div>
                                <div class="ranking-stats">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Hadir {{ $count }} kali meeting
                                </div>
                            </div>
                            <div class="ranking-badge">
                                Top {{ $loop->iteration }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-info-circle mb-2" style="font-size: 24px;"></i>
                            <p class="mb-0">Belum ada data kehadiran meeting</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Analisis Keaktifan Summary -->
        <div class="col-md-6 mb-4">
            <div class="ranking-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Ringkasan Keaktifan
                    </h5>
                    <a href="{{ route('admin.analisis-keaktifan') }}" class="btn btn-sm btn-outline-primary">
                        Detail Analisis
                    </a>
                </div>
                
                <div class="p-3">
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span>Total Anggota</span>
                        <span class="fw-bold">{{ $analisisKeaktifan['total'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span class="text-success">Anggota Aktif</span>
                        <span class="fw-bold text-success">{{ $analisisKeaktifan['active'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                        <span class="text-muted">Anggota Tidak Aktif</span>
                        <span class="fw-bold text-muted">{{ $analisisKeaktifan['inactive'] }}</span>
                    </div>
                    
                    <div class="mt-4">
                        <label class="small text-muted mb-1">Tingkat Keaktifan</label>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                style="width: {{ $analisisKeaktifan['active_percentage'] }}%" 
                                aria-valuenow="{{ $analisisKeaktifan['active_percentage'] }}" 
                                aria-valuemin="0" aria-valuemax="100">
                                {{ $analisisKeaktifan['active_percentage'] }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
