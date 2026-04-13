@extends('admin.layouts.app')

@section('title', 'Riwayat Kegiatan')

@section('page-title', 'RIWAYAT KEGIATAN')

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
        grid-template-columns: repeat(4, minmax(0, 1fr));
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

    .dashboard-card.warning {
        border-left-color: #ff9800;
        background: linear-gradient(135deg, #fff3e0 0%, #fffbf8 100%);
    }

    .dashboard-card.danger {
        border-left-color: #f44336;
        background: linear-gradient(135deg, #ffebee 0%, #fef8f8 100%);
    }

    .dashboard-card.info {
        border-left-color: #17a2b8;
        background: linear-gradient(135deg, #e0f7fa 0%, #e0f2f1 100%);
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
    
    .dashboard-card.warning .card-icon { 
        background: linear-gradient(135deg, #ff9800, #ffb74d); 
    }
    
    .dashboard-card.danger .card-icon { 
        background: linear-gradient(135deg, #f44336, #ef5350); 
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
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .dashboard-cards {
            grid-template-columns: repeat(4, minmax(0, 1fr));
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
            grid-template-columns: repeat(4, minmax(0, 1fr));
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
    
    /* Kegiatan Card */
    .kegiatan-card {
        border-left: 4px solid #2196F3;
        margin-bottom: 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .kegiatan-card:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .kegiatan-card.terlaksana {
        border-left-color: #4caf50;
    }
    .kegiatan-card.dibatalkan {
        border-left-color: #f44336;
    }
    .kegiatan-card.ditunda {
        border-left-color: #ff9800;
    }
    .kegiatan-card.akan.datang {
        border-left-color: #17a2b8;
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
    .page-item.active .page-link {
        background: linear-gradient(135deg, #2196F3 0%, #64B5F6 100%);
        border-color: #2196F3;
        color: white;
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.5);
        transform: scale(1.1);
        z-index: 2;
        font-weight: 700;
    }
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
    
    /* Pagination Info */
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
</style>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics - Horizontal Scrolling -->
    <div class="dashboard-cards-container">
        <div class="dashboard-cards">
            <div class="dashboard-card primary">
                <div class="card-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <h3>{{ $stats['total'] }}</h3>
                <p>Total Kegiatan</p>
            </div>
            <div class="dashboard-card info">
                <div class="card-icon">
                    <i class="fas fa-hourglass-start"></i>
                </div>
                <h3>{{ $stats['akan_datang'] }}</h3>
                <p>Akan Datang</p>
            </div>
            <div class="dashboard-card success">
                <div class="card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>{{ $stats['terlaksana'] }}</h3>
                <p>Terlaksana</p>
            </div>
            <div class="dashboard-card warning">
                <div class="card-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>{{ $stats['ditunda'] }}</h3>
                <p>Ditunda</p>
            </div>
            <div class="dashboard-card danger">
                <div class="card-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <h3>{{ $stats['dibatalkan'] }}</h3>
                <p>Dibatalkan</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Riwayat Kegiatan
                </h5>
                <a href="{{ route('riwayat-kegiatan.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-2"></i>Tambah Kegiatan
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($kegiatans->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada kegiatan</h5>
                    <p class="text-muted">Mulai tambahkan kegiatan pertama Anda</p>
                    <a href="{{ route('riwayat-kegiatan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Kegiatan
                    </a>
                </div>
            @else
                @foreach($kegiatans as $kegiatan)
                    <div class="card kegiatan-card {{ strtolower($kegiatan->status) }}">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="mb-2">{{ $kegiatan->judul }}</h5>
                                    <p class="text-muted mb-2">{{ Str::limit($kegiatan->deskripsi, 150) }}</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-info">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $kegiatan->tanggal_kegiatan_formatted }}
                                        </span>
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $kegiatan->waktu_mulai }} - {{ $kegiatan->waktu_selesai }}
                                        </span>
                                        <span class="badge bg-dark">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ $kegiatan->lokasi }}
                                        </span>
                                        <span class="badge {{ $kegiatan->status == 'Terlaksana' ? 'bg-success' : ($kegiatan->status == 'Dibatalkan' ? 'bg-danger' : ($kegiatan->status == 'Akan Datang' ? 'bg-info' : 'bg-warning')) }}">
                                            {{ $kegiatan->status }}
                                        </span>
                                        <span class="badge bg-primary">
                                            {{ $kegiatan->jenis_kegiatan }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end mt-3 mt-md-0">
                                    <div class="d-flex justify-content-end gap-2 flex-wrap">
                                        <a href="{{ route('riwayat-kegiatan.show', $kegiatan->id) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('riwayat-kegiatan.edit', $kegiatan->id) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('riwayat-kegiatan.destroy', $kegiatan->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                    <div class="pagination-info mb-2 mb-md-0">
                        <i class="fas fa-info-circle"></i>
                        <span>Menampilkan <strong>{{ $kegiatans->firstItem() ?? 0 }}</strong> - <strong>{{ $kegiatans->lastItem() ?? 0 }}</strong> dari <strong>{{ $kegiatans->total() }}</strong> kegiatan</span>
                    </div>
                    <nav aria-label="Pagination">
                        {{ $kegiatans->links() }}
                    </nav>
                </div>
            @endif
        </div>
    </div>
@endsection
