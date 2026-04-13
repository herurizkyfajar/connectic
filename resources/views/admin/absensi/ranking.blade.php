@extends('admin.layouts.app')

@section('title', 'Ranking Keaktifan')

@section('page-title', 'RANKING ANGGOTA PALING AKTIF')

@section('styles')
<style>
    /* Dashboard cards container - horizontal scrolling */
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

    /* Grid layout for horizontal cards */
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        grid-template-rows: 1fr;
        gap: 12px;
        grid-auto-flow: column;
        width: 100%;
        height: max-content;
    }

    /* Force horizontal layout - no wrapping */
    .dashboard-cards .dashboard-card {
        height: 120px;
        grid-column: span 1;
        grid-row: span 1;
        flex-shrink: 0;
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
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
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    .dashboard-card.primary {
        border-left-color: #2196F3;
        background: linear-gradient(135deg, #e3f2fd 0%, #f8fbff 100%);
    }

    .dashboard-card.success {
        border-left-color: #4caf50;
        background: linear-gradient(135deg, #e8f5e8 0%, #f8fdf8 100%);
    }

    .dashboard-card.info {
        border-left-color: #00bcd4;
        background: linear-gradient(135deg, #e0f7fa 0%, #f8fdff 100%);
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

    .dashboard-card.primary .card-icon { 
        background: linear-gradient(135deg, #1976d2, #2196f3); 
    }
    
    .dashboard-card.success .card-icon { 
        background: linear-gradient(135deg, #4caf50, #66bb6a); 
    }
    
    .dashboard-card.info .card-icon { 
        background: linear-gradient(135deg, #00bcd4, #4dd0e1); 
    }

    .dashboard-card h3 {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 8px 0 4px 0;
        color: #212121;
    }

    .dashboard-card p {
        margin: 0;
        color: #757575;
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .dashboard-cards {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .dashboard-cards {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .dashboard-cards .dashboard-card {
            height: 110px;
        }

        .dashboard-card h3 {
            font-size: 1.5rem;
        }

        .dashboard-card p {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 576px) {
        .dashboard-cards {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .dashboard-cards .dashboard-card {
            height: 100px;
        }

        .dashboard-card h3 {
            font-size: 1.25rem;
        }

        .card-icon {
            width: 38px;
            height: 38px;
            font-size: 18px;
            margin-bottom: 8px;
        }
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
    
    /* Progress Bar */
    .progress {
        height: 30px;
        border-radius: 15px;
        background-color: #f0f0f0;
        overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    }
    .progress-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
        transition: width 0.6s ease;
        border-radius: 15px;
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
    
    /* Three Dots */
    .page-item .page-link:contains('...') {
        border: none;
        background: transparent;
        box-shadow: none;
        cursor: default;
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
    <!-- Statistics Cards - Horizontal Scrolling -->
    <div class="dashboard-cards-container">
        <div class="dashboard-cards">
            <div class="dashboard-card primary">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>{{ $totalAnggota }}</h3>
                <p>Total Anggota</p>
            </div>
            <div class="dashboard-card success">
                <div class="card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>{{ $totalHadir }}</h3>
                <p>Total Kehadiran</p>
            </div>
            <div class="dashboard-card info">
                <div class="card-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3>{{ $totalKegiatan }}</h3>
                <p>Total Kegiatan</p>
            </div>
        </div>
    </div>

    <!-- Ranking Table -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-trophy me-2"></i>Ranking Keaktifan Anggota
                </h5>
                <div>
                    <span class="badge bg-primary">
                        <i class="fas fa-calendar me-1"></i>Total: {{ $rankings->total() }} Anggota
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($rankings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">Ranking</th>
                                <th>Anggota</th>
                                <th class="text-center">Jumlah Kehadiran</th>
                                <th class="text-center">Tingkat Kehadiran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rankings as $index => $ranking)
                                @php
                                    $rankNumber = ($rankings->currentPage() - 1) * $rankings->perPage() + $index + 1;
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
                                            @if($ranking->foto)
                                                <img src="{{ asset('storage/anggotas/' . $ranking->foto) }}" 
                                                     alt="{{ $ranking->nama }}" class="avatar me-3">
                                            @else
                                                <div class="avatar bg-secondary d-flex align-items-center justify-content-center me-3">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <strong>{{ $ranking->nama }}</strong>
                                                <br><small class="text-muted">{{ $ranking->email }}</small>
                                                @if($ranking->jabatan)
                                                    <br><span class="badge bg-info">{{ $ranking->jabatan }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="badge bg-success" style="font-size: 1.1rem; padding: 10px 20px;">
                                                <i class="fas fa-check-circle me-1"></i>{{ $ranking->jumlah_hadir }}
                                            </span>
                                            <small class="text-muted mt-1">kegiatan</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $persentase = $totalKegiatan > 0 ? round(($ranking->jumlah_hadir / $totalKegiatan) * 100, 1) : 0;
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
                                    <td class="text-center">
                                        <a href="{{ route('anggota.show', $ranking->id) }}" 
                                           class="btn btn-sm btn-primary" title="Lihat Profil">
                                            <i class="fas fa-eye"></i>
                                        </a>
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
                        <span>Menampilkan <strong>{{ $rankings->firstItem() }}</strong> - <strong>{{ $rankings->lastItem() }}</strong> dari <strong>{{ $rankings->total() }}</strong> anggota</span>
                    </div>
                    <nav aria-label="Pagination Navigation">
                        {{ $rankings->links() }}
                    </nav>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data kehadiran</h5>
                    <p class="text-muted">Data ranking akan muncul setelah ada kegiatan yang dilaksanakan</p>
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
                    <li>Ranking dihitung berdasarkan jumlah kehadiran anggota pada semua kegiatan</li>
                    <li>Hanya kehadiran dengan status <strong>"Hadir"</strong> yang dihitung</li>
                    <li>Anggota dengan kehadiran terbanyak mendapat ranking tertinggi</li>
                    <li>🏆 Top 3 mendapat highlight khusus dengan badge emas, perak, dan perunggu</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
