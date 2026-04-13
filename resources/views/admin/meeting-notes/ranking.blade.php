@extends('admin.layouts.app')

@section('title', 'Ranking Meeting Attendance')

@section('page-title', 'RANKING PESERTA MEETING PALING AKTIF')

@section('styles')
<style>
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border-left: 4px solid;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    .stat-card.primary {
        border-left-color: #2196F3;
    }
    .stat-card.primary .stat-icon {
        background: linear-gradient(135deg, #2196F3 0%, #64B5F6 100%);
    }
    .stat-card.success {
        border-left-color: #4caf50;
    }
    .stat-card.success .stat-icon {
        background: linear-gradient(135deg, #4caf50 0%, #81c784 100%);
    }
    .stat-card.warning {
        border-left-color: #ff9800;
    }
    .stat-card.warning .stat-icon {
        background: linear-gradient(135deg, #ff9800 0%, #ffb74d 100%);
    }
    .stat-card .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        margin-bottom: 1rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .stat-card h3 {
        font-size: 2.5rem;
        font-weight: 600;
        margin: 0;
        color: #212121;
    }
    .stat-card p {
        margin: 0;
        color: #757575;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    /* Ranking Badge */
    .badge-rank {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
        position: relative;
        transition: all 0.3s ease;
    }
    .badge-rank:hover {
        transform: scale(1.1) rotate(5deg);
    }
    
    /* Trophy Icons for Top 3 */
    .rank-1 {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #000;
        box-shadow: 0 4px 15px rgba(255, 215, 0, 0.6);
        border: 3px solid #fff;
    }
    .rank-1::before {
        content: "🏆";
        position: absolute;
        top: -15px;
        right: -10px;
        font-size: 1.5rem;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }
    .rank-2 {
        background: linear-gradient(135deg, #c0c0c0 0%, #e8e8e8 100%);
        color: #000;
        box-shadow: 0 4px 15px rgba(192, 192, 192, 0.6);
        border: 3px solid #fff;
    }
    .rank-2::before {
        content: "🥈";
        position: absolute;
        top: -15px;
        right: -10px;
        font-size: 1.3rem;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }
    .rank-3 {
        background: linear-gradient(135deg, #cd7f32 0%, #f4a460 100%);
        color: #fff;
        box-shadow: 0 4px 15px rgba(205, 127, 50, 0.6);
        border: 3px solid #fff;
    }
    .rank-3::before {
        content: "🥉";
        position: absolute;
        top: -15px;
        right: -10px;
        font-size: 1.3rem;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }
    .rank-other {
        background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
        color: #757575;
        border: 2px solid #e0e0e0;
    }
    
    /* Avatar */
    .avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e0e0e0;
        transition: all 0.3s ease;
    }
    .top-performer .avatar {
        border-color: #ffd700;
    }
    
    /* Table Styling */
    .table thead th {
        background: linear-gradient(135deg, #2196F3 0%, #64B5F6 100%);
        color: white;
        border: none;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        padding: 1rem;
    }
    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    /* Top Performer Highlight */
    .top-performer {
        background: linear-gradient(90deg, rgba(255, 215, 0, 0.05) 0%, rgba(255, 255, 255, 0) 100%);
        border-left: 5px solid #ffd700;
        position: relative;
    }
    .top-performer::after {
        content: "⭐";
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 2rem;
        opacity: 0.1;
    }
    
    /* Card */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .card-header {
        background: linear-gradient(135deg, #2196F3 0%, #64B5F6 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        border: none;
        padding: 1.5rem;
    }
    
    /* Pagination */
    .pagination {
        margin: 0;
        gap: 10px;
    }
    .page-item {
        margin: 0;
    }
    .page-item .page-link {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        color: #424242;
        font-weight: 600;
        min-width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: white;
        margin: 0;
        font-size: 1.05rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }
    
    /* Arrow Buttons Styling */
    .page-item:first-child .page-link,
    .page-item:last-child .page-link {
        padding: 0;
        border-radius: 12px;
        min-width: 48px;
        background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
        border: 2px solid #bdbdbd;
    }
    .page-item:first-child .page-link i,
    .page-item:last-child .page-link i {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }
    .page-item:first-child:not(.disabled) .page-link:hover,
    .page-item:last-child:not(.disabled) .page-link:hover {
        background: linear-gradient(135deg, #2196F3 0%, #64B5F6 100%);
        border-color: #2196F3;
        color: white;
        box-shadow: 0 4px 12px rgba(33, 150, 243, 0.4);
    }
    .page-item:first-child:not(.disabled) .page-link:hover i {
        transform: translateX(-3px);
    }
    .page-item:last-child:not(.disabled) .page-link:hover i {
        transform: translateX(3px);
    }
    
    /* Active Page Number */
    .page-item.active .page-link {
        background: linear-gradient(135deg, #2196F3 0%, #64B5F6 100%);
        border-color: #2196F3;
        color: white;
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.5);
        transform: scale(1.1);
        z-index: 2;
        font-weight: 700;
    }
    
    /* Hover State for Numbers */
    .page-item:not(.active):not(.disabled):not(:first-child):not(:last-child) .page-link:hover {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-color: #2196F3;
        color: #2196F3;
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 6px 16px rgba(33, 150, 243, 0.35);
        text-decoration: none;
    }
    .page-item.active .page-link:hover {
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
        color: white;
        transform: scale(1.12);
        box-shadow: 0 6px 20px rgba(33, 150, 243, 0.6);
    }
    
    /* Disabled State */
    .page-item.disabled .page-link {
        background: linear-gradient(135deg, #fafafa 0%, #f0f0f0 100%);
        border-color: #e0e0e0;
        color: #bdbdbd;
        cursor: not-allowed;
        opacity: 0.5;
        box-shadow: none;
    }
    .page-item.disabled .page-link:hover {
        transform: none;
        box-shadow: none;
        background: linear-gradient(135deg, #fafafa 0%, #f0f0f0 100%);
        border-color: #e0e0e0;
        color: #bdbdbd;
    }
    
    /* Pagination Info Styling */
    .pagination-info {
        background: white;
        padding: 12px 20px;
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        color: #616161;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .pagination-info i {
        color: #2196F3;
        font-size: 1.1rem;
    }
    
    /* Badge */
    .badge {
        padding: 6px 12px;
        font-weight: 500;
        border-radius: 6px;
    }
    
    /* Info Alert */
    .alert-info {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border: none;
        border-left: 4px solid #2196F3;
        border-radius: 8px;
        color: #1976d2;
    }
    
    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .table tbody tr {
        animation: fadeInUp 0.5s ease-out;
    }
</style>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stat-card primary text-center">
                <div class="stat-icon mx-auto">
                    <i class="fas fa-users"></i>
                </div>
                <h3>{{ $totalAnggota }}</h3>
                <p>Total Peserta Meeting</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card success text-center">
                <div class="stat-icon mx-auto">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>{{ $totalAttendance }}</h3>
                <p>Total Kehadiran</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card warning text-center">
                <div class="stat-icon mx-auto">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3>{{ $totalMeetings }}</h3>
                <p>Total Meeting</p>
            </div>
        </div>
    </div>

    <!-- Ranking Table -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-trophy me-2"></i>Ranking Peserta Meeting Paling Aktif
                </h5>
                <div>
                    <span class="badge bg-primary">
                        <i class="fas fa-users me-1"></i>Total: {{ $ranking->total() }} Peserta
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($ranking->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">Ranking</th>
                                <th>Peserta</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center">Jumlah Kehadiran</th>
                                <th class="text-center">Tingkat Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ranking as $index => $attendance)
                                @php
                                    $rankNumber = ($ranking->currentPage() - 1) * $ranking->perPage() + $index + 1;
                                    $rankClass = '';
                                    if($rankNumber == 1) $rankClass = 'rank-1';
                                    elseif($rankNumber == 2) $rankClass = 'rank-2';
                                    elseif($rankNumber == 3) $rankClass = 'rank-3';
                                    else $rankClass = 'rank-other';
                                @endphp
                                <tr class="{{ $rankNumber <= 3 ? 'top-performer' : '' }}">
                                    <td class="text-center">
                                        <span class="badge-rank {{ $rankClass }}">{{ $rankNumber }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($attendance['foto'])
                                                <img src="{{ asset('storage/anggotas/' . $attendance['foto']) }}" 
                                                     alt="{{ $attendance['nama'] }}" class="avatar me-3">
                                            @else
                                                <div class="avatar bg-secondary d-flex align-items-center justify-content-center me-3">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $attendance['nama'] }}</strong>
                                                <br><small class="text-muted">{{ $attendance['email'] }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($attendance['jabatan'])
                                            <span class="badge bg-info">{{ $attendance['jabatan'] }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="badge bg-success" style="font-size: 1.1rem; padding: 10px 20px;">
                                                <i class="fas fa-check-circle me-1"></i>{{ $attendance['count'] }}
                                            </span>
                                            <small class="text-muted mt-1">meeting</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $persentase = $totalMeetings > 0 ? round(($attendance['count'] / $totalMeetings) * 100, 1) : 0;
                                            $badgeColor = $persentase >= 80 ? 'success' : ($persentase >= 50 ? 'warning' : 'danger');
                                        @endphp
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar bg-{{ $badgeColor }}" 
                                                 style="width: {{ $persentase }}%"
                                                 role="progressbar">
                                                <strong>{{ $persentase }}%</strong>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
                    <div class="pagination-info">
                        <i class="fas fa-info-circle"></i>
                        <span>Menampilkan <strong>{{ $ranking->firstItem() }}</strong> - <strong>{{ $ranking->lastItem() }}</strong> dari <strong>{{ $ranking->total() }}</strong> peserta</span>
                    </div>
                    <nav aria-label="Pagination Navigation">
                        {{ $ranking->links() }}
                    </nav>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data meeting</h5>
                    <p class="text-muted">Data ranking akan muncul setelah ada meeting yang dilaksanakan</p>
                    <a href="{{ route('admin.meeting-notes.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-2"></i>Tambah Meeting Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Info Box -->
    <div class="alert alert-info mt-4">
        <div class="d-flex align-items-start">
            <div class="me-3">
                <i class="fas fa-info-circle" style="font-size: 1.5rem;"></i>
            </div>
            <div>
                <h6 class="mb-2"><strong>📊 Cara Perhitungan Ranking:</strong></h6>
                <ul class="mb-0" style="padding-left: 1.2rem;">
                    <li>Ranking dihitung berdasarkan jumlah kehadiran peserta pada semua meeting</li>
                    <li>Data diambil dari field <strong>"Attendance"</strong> di setiap meeting note</li>
                    <li>Peserta dengan kehadiran terbanyak mendapat ranking tertinggi</li>
                    <li>🏆 Top 3 mendapat highlight khusus dengan badge emas, perak, dan perunggu</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
