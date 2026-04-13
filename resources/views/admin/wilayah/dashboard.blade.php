@extends('admin.layouts.app')

@section('title', 'Dashboard Wilayah')
@section('page-title', 'DASHBOARD WILAYAH')

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
        grid-template-columns: repeat(3, minmax(0, 1fr));
        grid-template-rows: 1fr;
        gap: 20px;
        grid-auto-flow: column;
        width: 100%;
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
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        min-height: 140px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        width: 100%;
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

    .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
    }

    .dashboard-card.primary .card-icon { background: linear-gradient(135deg, #1976d2, #2196f3); }
    .dashboard-card.success .card-icon { background: linear-gradient(135deg, #4caf50, #66bb6a); }
    .dashboard-card.warning .card-icon { background: linear-gradient(135deg, #ff9800, #ffb74d); }

    .card-title {
        font-size: 14px;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }

    .card-value {
        font-size: 32px;
        font-weight: 700;
        color: #333;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .card-subtitle {
        font-size: 12px;
        color: #888;
        margin-top: 5px;
        position: relative;
        z-index: 1;
    }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="dashboard-cards-container">
        <div class="dashboard-cards">
            <!-- Card Wilayah Cabang -->
            <div class="dashboard-card primary">
                <div class="card-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="card-title">Wilayah Cabang</div>
                <div class="card-value">{{ $jumlahWilayahCabang }}</div>
                <div class="card-subtitle">Cabang di bawah wilayah ini</div>
            </div>

            <!-- Card Anggota -->
            <div class="dashboard-card success">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-title">Total Anggota</div>
                <div class="card-value">{{ $jumlahAnggota }}</div>
                <div class="card-subtitle">Anggota terdaftar</div>
            </div>

            <!-- Card Kegiatan -->
            <div class="dashboard-card warning">
                <div class="card-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="card-title">Total Kegiatan</div>
                <div class="card-value">{{ $jumlahKegiatan }}</div>
                <div class="card-subtitle">Riwayat kegiatan</div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">10 Kegiatan Akan Datang</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kegiatanAkanDatang as $kegiatan)
                                    <tr>
                                        <td>{{ $kegiatan->tanggal_kegiatan->format('d-m-Y') }}</td>
                                        <td>{{ $kegiatan->judul }}</td>
                                        <td>{{ $kegiatan->lokasi }}</td>
                                        <td><span class="badge bg-info">{{ $kegiatan->status }}</span></td>
                                        <td>
                                            <a href="{{ route('riwayat-kegiatan.show', $kegiatan->id) }}" class="btn btn-primary btn-sm" title="Lihat">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada kegiatan akan datang.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">10 Pengajuan Pending Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Judul Pengajuan</th>
                                    <th>Status</th>
                                    <th>Berkas</th>
                                    <th>Kelola</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuans as $item)
                                    <tr>
                                        <td>{{ $item->tanggal_pengajuan->format('d-m-Y') }}</td>
                                        <td>{{ $item->judul_pengajuan }}</td>
                                        <td>
                                            @if($item->status == 'Pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($item->status == 'Disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($item->status == 'Ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->link_berkas)
                                                <a href="{{ $item->link_berkas }}" target="_blank" class="btn btn-info btn-sm">
                                                    <i class="fas fa-link"></i> Lihat
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('pengajuan.show', $item->id) }}" class="btn btn-primary btn-sm" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('pengajuan.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data pengajuan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
