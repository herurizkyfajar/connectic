<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Absensi Kegiatan - ConnecTIK</title>
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
        .info-item {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        .info-value {
            color: #666;
        }
        .badge {
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 0.9rem;
        }
        .status-card {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 1rem;
            border-radius: 15px;
            margin-bottom: 1rem;
        }
        .status-card.tidak-hadir {
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        }
        .status-card.izin {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        }
        .status-card.sakit {
            background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
        }
        .bukti-preview {
            max-width: 100%;
            max-height: 300px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('anggota.profile') }}">
                <i class="fas fa-users me-2"></i>
                ConnecTIK - Portal Anggota
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('anggota.beranda') }}">
                            <i class="fas fa-house me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('anggota.profile') }}">
                            <i class="fas fa-user me-1"></i>Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('riwayat-kegiatan.index') }}">
                            <i class="fas fa-calendar-days me-1"></i>Riwayat Kegiatan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('absensi-kegiatan.index') }}">
                            <i class="fas fa-clipboard-check me-1"></i>Absensi Kegiatan
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarTentang" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-info-circle me-1"></i>Tentang RTIK
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarTentang">
                            <li><a class="dropdown-item" href="{{ route('anggota.tentang.penjelasan') }}">
                                <i class="fas fa-book-open me-2"></i>Penjelasan RTIK
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('anggota.tentang.struktur') }}">
                                <i class="fas fa-sitemap me-2"></i>Struktur Organisasi
                            </a></li>
                            <li><a class="dropdown-item" href="https://drive.google.com/drive/folders/1tEeSl8Bc3BJ2k0YRgIcfT3IFTb9uSCD_?usp=sharing" target="_blank" rel="noopener">
                                <i class="fas fa-folder-open me-2"></i>SK
                            </a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('anggota.edit-profile') }}">
                            <i class="fas fa-edit me-1"></i>Edit Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('anggota.logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm ms-2">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-clipboard-check me-2"></i>Detail Absensi Kegiatan
                            </h4>
                            <a href="{{ route('absensi-kegiatan.index') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="mb-3">{{ $absensiKegiatan->riwayatKegiatan->judul }}</h3>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-calendar me-2"></i>Tanggal Kegiatan
                                            </div>
                                            <div class="info-value">{{ $absensiKegiatan->riwayatKegiatan->tanggal_kegiatan_formatted }}</div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-clock me-2"></i>Waktu Kegiatan
                                            </div>
                                            <div class="info-value">
                                                {{ $absensiKegiatan->riwayatKegiatan->waktu_mulai }} - {{ $absensiKegiatan->riwayatKegiatan->waktu_selesai }}
                                                <br><small class="text-muted">Durasi: {{ $absensiKegiatan->riwayatKegiatan->durasi }}</small>
                                            </div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-map-marker-alt me-2"></i>Lokasi
                                            </div>
                                            <div class="info-value">{{ $absensiKegiatan->riwayatKegiatan->lokasi }}</div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-building me-2"></i>Penyelenggara
                                            </div>
                                            <div class="info-value">{{ $absensiKegiatan->riwayatKegiatan->penyelenggara }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-clipboard-check me-2"></i>Status Kehadiran
                                            </div>
                                            <div class="info-value">
                                                <span class="badge {{ $absensiKegiatan->status_kehadiran == 'Hadir' ? 'bg-success' : ($absensiKegiatan->status_kehadiran == 'Izin' ? 'bg-warning' : ($absensiKegiatan->status_kehadiran == 'Sakit' ? 'bg-info' : 'bg-danger')) }}">
                                                    {{ $absensiKegiatan->status_kehadiran }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-user-tag me-2"></i>Ikut Serta Sebagai
                                            </div>
                                            <div class="info-value">
                                                <span class="badge bg-primary">
                                                    @if($absensiKegiatan->ikut_serta_sebagai == 'Lainnya' && $absensiKegiatan->ikut_serta_lainnya)
                                                        {{ $absensiKegiatan->ikut_serta_lainnya }}
                                                    @else
                                                        {{ $absensiKegiatan->ikut_serta_sebagai }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-clock me-2"></i>Waktu Absen
                                            </div>
                                            <div class="info-value">{{ $absensiKegiatan->waktu_absen_formatted }}</div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-tag me-2"></i>Jenis Kegiatan
                                            </div>
                                            <div class="info-value">
                                                <span class="badge bg-info">{{ $absensiKegiatan->riwayatKegiatan->jenis_kegiatan }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-calendar-plus me-2"></i>Dibuat
                                            </div>
                                            <div class="info-value">{{ $absensiKegiatan->created_at->format('d/m/Y H:i') }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-align-left me-2"></i>Deskripsi Kegiatan
                                    </div>
                                    <div class="info-value">{{ $absensiKegiatan->riwayatKegiatan->deskripsi }}</div>
                                </div>
                                
                                @if($absensiKegiatan->keterangan)
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-sticky-note me-2"></i>Keterangan Absensi
                                    </div>
                                    <div class="info-value">{{ $absensiKegiatan->keterangan }}</div>
                                </div>
                                @endif
                                
                                @if($absensiKegiatan->bukti_kehadiran)
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-file me-2"></i>Bukti Kehadiran
                                    </div>
                                    <div class="info-value">
                                        <div class="d-flex align-items-center gap-3">
                                            <a href="{{ asset('storage/absensi-kegiatan/' . $absensiKegiatan->bukti_kehadiran) }}" 
                                               target="_blank" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                            <small class="text-muted">{{ $absensiKegiatan->bukti_kehadiran }}</small>
                                        </div>
                                        
                                        @if(in_array(pathinfo($absensiKegiatan->bukti_kehadiran, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                        <div class="mt-3">
                                            <img src="{{ asset('storage/absensi-kegiatan/' . $absensiKegiatan->bukti_kehadiran) }}" 
                                                 alt="Bukti Kehadiran" 
                                                 class="bukti-preview">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Status Card -->
                <div class="status-card {{ $absensiKegiatan->status_kehadiran == 'Hadir' ? '' : ($absensiKegiatan->status_kehadiran == 'Izin' ? 'izin' : ($absensiKegiatan->status_kehadiran == 'Sakit' ? 'sakit' : 'tidak-hadir')) }}">
                    <h5 class="mb-2">
                        <i class="fas fa-info-circle me-2"></i>Status Kehadiran
                    </h5>
                    <p class="mb-0">
                        @if($absensiKegiatan->status_kehadiran == 'Hadir')
                            <i class="fas fa-check-circle me-2"></i>Anda hadir dalam kegiatan ini
                        @elseif($absensiKegiatan->status_kehadiran == 'Izin')
                            <i class="fas fa-user-clock me-2"></i>Anda mengajukan izin untuk kegiatan ini
                        @elseif($absensiKegiatan->status_kehadiran == 'Sakit')
                            <i class="fas fa-user-injured me-2"></i>Anda tidak dapat hadir karena sakit
                        @else
                            <i class="fas fa-times-circle me-2"></i>Anda tidak hadir dalam kegiatan ini
                        @endif
                    </p>
                </div>
                
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-cogs me-2"></i>Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('absensi-kegiatan.edit', $absensiKegiatan->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Absensi
                            </a>
                            
                            <form action="{{ route('absensi-kegiatan.destroy', $absensiKegiatan->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger w-100"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus absensi ini?')">
                                    <i class="fas fa-trash me-2"></i>Hapus Absensi
                                </button>
                            </form>
                            
                            <a href="{{ route('absensi-kegiatan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-list me-2"></i>Daftar Absensi
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Activity Info -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2"></i>Informasi Absensi
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar-plus me-2"></i>Dibuat
                            </div>
                            <div class="info-value">{{ $absensiKegiatan->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-edit me-2"></i>Terakhir Diupdate
                            </div>
                            <div class="info-value">{{ $absensiKegiatan->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-clock me-2"></i>Waktu Absen
                            </div>
                            <div class="info-value">{{ $absensiKegiatan->waktu_absen_formatted }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
