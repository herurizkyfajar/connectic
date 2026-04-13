@extends('admin.layouts.app')

@section('title', 'Detail Data Keuangan')

@section('styles')
<style>
    .detail-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        position: relative;
    }

    .detail-header.jenis-masuk {
        background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    }

    .detail-header.jenis-keluar {
        background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
    }

    .detail-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(30px, -30px);
    }

    .detail-header h4 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        position: relative;
        z-index: 1;
    }

    .detail-header .subtitle {
        opacity: 0.9;
        font-size: 14px;
        margin: 5px 0 0 0;
        position: relative;
        z-index: 1;
    }

    .detail-body {
        padding: 25px;
    }

    .info-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid #1976d2;
    }

    .info-section h6 {
        color: #1976d2;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: #495057;
    }

    .info-value {
        font-weight: 600;
        color: #212529;
    }

    .amount-display {
        font-size: 32px;
        font-weight: 700;
        text-align: center;
        padding: 20px;
        border-radius: 8px;
        margin: 20px 0;
        color: white;
    }

    .amount-masuk {
        background: linear-gradient(135deg, #28a745, #20c997);
    }

    .amount-keluar {
        background: linear-gradient(135deg, #dc3545, #fd7e14);
    }

    .file-display {
        background: #e3f2fd;
        border: 1px solid #2196f3;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        margin-top: 15px;
    }

    .file-icon {
        font-size: 48px;
        color: #1976d2;
        margin-bottom: 15px;
    }

    .btn-action {
        border-radius: 25px;
        padding: 10px 25px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .badge-custom {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .activity-timeline {
        position: relative;
        padding-left: 30px;
    }

    .activity-timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .activity-item {
        position: relative;
        padding-bottom: 20px;
    }

    .activity-item::before {
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

    .activity-time {
        font-size: 12px;
        color: #6c757d;
        font-weight: 500;
    }

    .activity-text {
        font-size: 14px;
        color: #495057;
        margin-top: 4px;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .detail-header {
            padding: 20px;
        }

        .detail-header h4 {
            font-size: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">📄 Detail Data Keuangan</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.keuangan.index') }}">Keuangan</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.keuangan.edit', $keuangan->id) }}" class="btn btn-warning btn-action">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('admin.keuangan.index') }}" class="btn btn-secondary btn-action">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Main Detail Card -->
    <div class="detail-card">
        <div class="detail-header jenis-{{ $keuangan->jenis }}">
            <h4>
                <i class="fas fa-{{ $keuangan->jenis == 'masuk' ? 'arrow-up' : 'arrow-down' }} me-2"></i>
                {{ ucfirst($keuangan->jenis) }} - {{ $keuangan->kategori }}
            </h4>
            <div class="subtitle">
                <i class="fas fa-calendar me-1"></i>
                {{ $keuangan->tanggal->format('l, d F Y') }}
                •
                <i class="fas fa-clock ms-2 me-1"></i>
                {{ $keuangan->tanggal->format('H:i') }}
            </div>
        </div>

        <div class="detail-body">
            <!-- Amount Display -->
            <div class="amount-display {{ $keuangan->jenis == 'masuk' ? 'amount-masuk' : 'amount-keluar' }}">
                <i class="fas fa-{{ $keuangan->jenis == 'masuk' ? 'arrow-up' : 'arrow-down' }} me-2"></i>
                {{ $keuangan->formatted_jumlah }}
            </div>

            <!-- Basic Information -->
            <div class="info-section">
                <h6><i class="fas fa-info-circle"></i> Informasi Dasar</h6>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">ID Transaksi:</span>
                        <span class="info-value">#{{ $keuangan->id }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jenis:</span>
                        <span class="badge badge-custom bg-{{ $keuangan->jenis == 'masuk' ? 'success' : 'danger' }}">
                            <i class="fas fa-{{ $keuangan->jenis == 'masuk' ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                            {{ ucfirst($keuangan->jenis) }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kategori:</span>
                        <span class="info-value">{{ $keuangan->kategori }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tanggal:</span>
                        <span class="info-value">{{ $keuangan->tanggal->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($keuangan->keterangan)
                <div class="info-section">
                    <h6><i class="fas fa-sticky-note"></i> Keterangan</h6>
                    <p class="mb-0">{{ $keuangan->keterangan }}</p>
                </div>
            @endif

            <!-- Source/Recipient Information -->
            @if($keuangan->jenis == 'masuk' && $keuangan->sumber)
                <div class="info-section">
                    <h6><i class="fas fa-donate"></i> Informasi Sumber</h6>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Sumber Dana:</span>
                            <span class="info-value">{{ $keuangan->sumber }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if($keuangan->jenis == 'keluar' && $keuangan->penerima)
                <div class="info-section">
                    <h6><i class="fas fa-hand-holding-usd"></i> Informasi Penerima</h6>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Penerima Dana:</span>
                            <span class="info-value">{{ $keuangan->penerima }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- File Attachment -->
            @if($keuangan->bukti)
                <div class="info-section">
                    <h6><i class="fas fa-paperclip"></i> Bukti Transaksi</h6>
                    <div class="file-display">
                        <div class="file-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="fw-bold">{{ basename($keuangan->bukti) }}</div>
                        <div class="text-muted small mb-3">File bukti transaksi</div>
                        <a href="{{ $keuangan->bukti_url }}" target="_blank" class="btn btn-primary btn-action">
                            <i class="fas fa-eye me-1"></i> Lihat Bukti
                        </a>
                        <a href="{{ $keuangan->bukti_url }}" download class="btn btn-success btn-action ms-2">
                            <i class="fas fa-download me-1"></i> Download
                        </a>
                    </div>
                </div>
            @endif

            <!-- Activity Timeline -->
            <div class="info-section">
                <h6><i class="fas fa-history"></i> Riwayat Aktivitas</h6>
                <div class="activity-timeline">
                    <div class="activity-item">
                        <div class="activity-time">{{ $keuangan->created_at->format('d/m/Y H:i') }}</div>
                        <div class="activity-text">
                            <i class="fas fa-plus-circle text-success me-1"></i>
                            Data transaksi dibuat
                        </div>
                    </div>
                    @if($keuangan->updated_at != $keuangan->created_at)
                        <div class="activity-item">
                            <div class="activity-time">{{ $keuangan->updated_at->format('d/m/Y H:i') }}</div>
                            <div class="activity-text">
                                <i class="fas fa-edit text-warning me-1"></i>
                                Data transaksi diperbarui
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-4">
                <a href="{{ route('admin.keuangan.edit', $keuangan->id) }}" class="btn btn-warning btn-action me-3">
                    <i class="fas fa-edit me-2"></i>Edit Data
                </a>
                <a href="{{ route('admin.keuangan.report') }}?start_date={{ $keuangan->tanggal->format('Y-m-d') }}&end_date={{ $keuangan->tanggal->format('Y-m-d') }}" class="btn btn-info btn-action me-3">
                    <i class="fas fa-chart-bar me-2"></i>Lihat Laporan
                </a>
                <a href="{{ route('admin.keuangan.index') }}" class="btn btn-secondary btn-action">
                    <i class="fas fa-list me-2"></i>Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add some interactive features
    document.addEventListener('DOMContentLoaded', function() {
        // Animate amount display on load
        const amountDisplay = document.querySelector('.amount-display');
        if (amountDisplay) {
            amountDisplay.style.transform = 'scale(0.95)';
            amountDisplay.style.opacity = '0';

            setTimeout(() => {
                amountDisplay.style.transition = 'all 0.5s ease';
                amountDisplay.style.transform = 'scale(1)';
                amountDisplay.style.opacity = '1';
            }, 100);
        }

        // Add hover effects to info sections
        document.querySelectorAll('.info-section').forEach(section => {
            section.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 6px 25px rgba(0,0,0,0.15)';
                this.style.transition = 'all 0.3s ease';
            });

            section.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    });
</script>
@endsection
