<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Kegiatan - ConnecTIK Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        .btn-secondary {
            border-radius: 10px;
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
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .kegiatan-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    @include('admin.layouts.navbar')

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Kegiatan Header -->
        <div class="kegiatan-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">{{ $riwayatKegiatan->judul }}</h2>
                    <p class="mb-1">
                        <i class="fas fa-calendar me-2"></i>{{ $riwayatKegiatan->tanggal_kegiatan_formatted }}
                        <i class="fas fa-clock ms-3 me-2"></i>{{ $riwayatKegiatan->waktu_mulai }} - {{ $riwayatKegiatan->waktu_selesai }}
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>{{ $riwayatKegiatan->lokasi }}
                        <i class="fas fa-building ms-3 me-2"></i>{{ $riwayatKegiatan->penyelenggara }}
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('riwayat-kegiatan.show', $riwayatKegiatan->id) }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-clipboard-check me-2"></i>Daftar Absensi Kegiatan
                            </h4>
                            <span class="badge bg-primary">{{ $stats['total_peserta'] }} Peserta</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Statistics -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <h3>{{ $stats['total_peserta'] }}</h3>
                                    <p><i class="fas fa-clipboard-list me-2"></i>Total Peserta</p>
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
                                        <th>Anggota</th>
                                        <th>Status Kehadiran</th>
                                        <th>Waktu Absen</th>
                                        <th>Keterangan</th>
                                        <th>Bukti Kehadiran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($absensiKegiatans as $index => $absensi)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($absensi->anggota->foto)
                                                        <img src="{{ asset('storage/anggotas/' . $absensi->anggota->foto) }}" 
                                                             alt="{{ $absensi->anggota->nama }}" 
                                                             class="avatar me-2">
                                                    @else
                                                        <div class="avatar bg-secondary d-flex align-items-center justify-content-center me-2">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <strong>{{ $absensi->anggota->nama }}</strong>
                                                        <br><small class="text-muted">{{ $absensi->anggota->email }}</small>
                                                        <br><small class="text-muted">{{ $absensi->anggota->jabatan }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge {{ $absensi->status_kehadiran == 'Hadir' ? 'bg-success' : ($absensi->status_kehadiran == 'Izin' ? 'bg-warning' : ($absensi->status_kehadiran == 'Sakit' ? 'bg-info' : 'bg-danger')) }}">
                                                    {{ $absensi->status_kehadiran }}
                                                </span>
                                            </td>
                                            <td>{{ $absensi->waktu_absen_formatted }}</td>
                                            <td>
                                                @if($absensi->keterangan)
                                                    {{ Str::limit($absensi->keterangan, 30) }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($absensi->bukti_kehadiran)
                                                    <a href="{{ asset('storage/absensi-kegiatan/' . $absensi->bukti_kehadiran) }}" 
                                                       target="_blank" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-download me-1"></i>Download
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('admin.absensi.show', $absensi->id) }}" 
                                                       class="btn btn-info btn-sm" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.absensi.anggota', $absensi->anggota_id) }}" 
                                                       class="btn btn-primary btn-sm" title="Riwayat Anggota">
                                                        <i class="fas fa-user"></i>
                                                    </a>
                                                    <form action="{{ route('admin.absensi.destroy', $absensi->id) }}" 
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
                                <h5 class="text-muted">Belum ada absensi untuk kegiatan ini</h5>
                                <p class="text-muted">Anggota belum melakukan absensi untuk kegiatan ini.</p>
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
