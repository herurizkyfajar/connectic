<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Kegiatan - ConnecTIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background:#fff;
            border-bottom:1px solid #e5e7eb;
        }
        .navbar .container-fluid { display:grid; grid-template-columns:1fr auto 1fr; align-items:center; }
        .navbar .navbar-brand {
            color:#1877F2;
            font-weight:700;
            justify-self:start;
        }
        .nav-center { justify-self:center; }
        .nav-right { justify-self:end; }
        .nav-center .nav-icon {
            width:60px;
            height:44px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:8px;
            color:#5f676b;
            text-decoration:none;
        }
        .nav-center .nav-icon:hover {
            background:#f0f2f5;
            color:#1c1e21;
        }
        .nav-center .nav-icon.active {
            box-shadow: inset 0 -3px 0 #1877F2;
            color:#1877F2;
        }
        .nav-right .nav-circle {
            width:36px;
            height:36px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#f0f2f5;
            color:#1c1e21;
            text-decoration:none;
        }
        .nav-right .nav-circle:hover {
            background:#e9ecef;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-success {
            border-radius: 10px;
        }
        .btn-warning {
            border-radius: 10px;
        }
        .btn-danger {
            border-radius: 10px;
        }
        .btn-info {
            border-radius: 10px;
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        .stats-card.success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        .stats-card.warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        }
        .stats-card.danger {
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        }
        .stats-card.info {
            background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            font-weight: 600;
        }
        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }
        .badge {
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 0.9rem;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .action-buttons .btn {
            padding: 5px 10px;
            font-size: 0.8rem;
        }
        .kegiatan-card {
            border-left: 4px solid #667eea;
            margin-bottom: 1rem;
        }
        .kegiatan-card.hadir {
            border-left-color: #28a745;
        }
        .kegiatan-card.tidak-hadir {
            border-left-color: #dc3545;
        }
        .kegiatan-card.izin {
            border-left-color: #ffc107;
        }
        .kegiatan-card.sakit {
            border-left-color: #17a2b8;
        }
    </style>
</head>
<body>
    <nav class="navbar sticky-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a class="navbar-brand" href="{{ route('anggota.beranda') }}">ConnecTIK Anggota</a>
            <div class="nav-center d-flex align-items-center gap-1">
                <a class="nav-icon" href="{{ route('anggota.beranda') }}"><i class="fas fa-home"></i></a>
                <a class="nav-icon" href="{{ route('anggota.anggota-list') }}" title="Daftar Anggota"><i class="fas fa-users"></i></a>
                <a class="nav-icon" href="{{ route('anggota.academy') }}" title="Academy"><i class="fas fa-graduation-cap"></i></a>
            </div>
            <div class="nav-right d-flex align-items-center gap-2">
                <form method="POST" action="{{ route('anggota.logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn p-0 nav-circle" title="Logout"><i class="fas fa-sign-out-alt"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-clipboard-check me-2"></i>Absensi Kegiatan
                            </h4>
                            <a href="{{ route('absensi-kegiatan.create') }}" class="btn btn-light">
                                <i class="fas fa-plus me-2"></i>Tambah Absensi
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Statistics -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <h3>{{ $stats['total'] }}</h3>
                                    <p><i class="fas fa-clipboard-list me-2"></i>Total Absensi</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card success">
                                    <h3>{{ $stats['hadir'] }}</h3>
                                    <p><i class="fas fa-check-circle me-2"></i>Hadir</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card warning">
                                    <h3>{{ $stats['izin'] }}</h3>
                                    <p><i class="fas fa-user-clock me-2"></i>Izin</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card danger">
                                    <h3>{{ $stats['tidak_hadir'] }}</h3>
                                    <p><i class="fas fa-times-circle me-2"></i>Tidak Hadir</p>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kegiatan</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Waktu Absen</th>
                                        <th>Status</th>
                                        <th>Peran</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($absensiKegiatans as $index => $absensi)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $absensi->riwayatKegiatan->judul }}</strong>
                                                <br><small class="text-muted">{{ $absensi->riwayatKegiatan->lokasi }}</small>
                                            </td>
                                            <td>{{ $absensi->riwayatKegiatan->tanggal_kegiatan_formatted }}</td>
                                            <td>{{ $absensi->waktu_absen_formatted }}</td>
                                            <td>
                                                <span class="badge {{ $absensi->status_kehadiran == 'Hadir' ? 'bg-success' : ($absensi->status_kehadiran == 'Izin' ? 'bg-warning' : ($absensi->status_kehadiran == 'Sakit' ? 'bg-info' : 'bg-danger')) }}">
                                                    {{ $absensi->status_kehadiran }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    @if($absensi->ikut_serta_sebagai == 'Lainnya' && $absensi->ikut_serta_lainnya)
                                                        {{ $absensi->ikut_serta_lainnya }}
                                                    @else
                                                        {{ $absensi->ikut_serta_sebagai ?? 'Peserta' }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                @if($absensi->keterangan)
                                                    {{ Str::limit($absensi->keterangan, 30) }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('absensi-kegiatan.show', $absensi->id) }}" 
                                                       class="btn btn-info btn-sm" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('absensi-kegiatan.edit', $absensi->id) }}" 
                                                       class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('absensi-kegiatan.destroy', $absensi->id) }}" 
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus absensi ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($absensiKegiatans->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-clipboard-times fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada absensi kegiatan</h5>
                                <p class="text-muted">Klik tombol "Tambah Absensi" untuk mencatat kehadiran kegiatan pertama.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
