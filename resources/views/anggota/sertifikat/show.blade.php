<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Sertifikat - ConnecTIK</title>
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
                        <a class="nav-link" href="{{ route('anggota.profile') }}">
                            <i class="fas fa-user me-1"></i>Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('anggota.sertifikat.index') }}">
                            <i class="fas fa-certificate me-1"></i>Sertifikat Saya
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
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-certificate me-2"></i>Detail Sertifikat
                            </h4>
                            <div>
                                <a href="{{ route('anggota.sertifikat.edit', $sertifikat->id) }}" class="btn btn-light btn-sm me-2">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <form action="{{ route('anggota.sertifikat.destroy', $sertifikat->id) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus sertifikat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-check me-2"></i>Judul Kegiatan
                                    </div>
                                    <div class="info-value">{{ $sertifikat->riwayatKegiatan->judul }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar me-2"></i>Tanggal Kegiatan
                                    </div>
                                    <div class="info-value">{{ $sertifikat->riwayatKegiatan->tanggal_kegiatan_formatted }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-tag me-2"></i>Jenis Kegiatan
                                    </div>
                                    <div class="info-value">{{ $sertifikat->riwayatKegiatan->jenis_kegiatan }}</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-hashtag me-2"></i>Nomor Sertifikat
                                    </div>
                                    <div class="info-value">{{ $sertifikat->nomor_sertifikat ?? '-' }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-alt me-2"></i>Tanggal Terbit
                                    </div>
                                    <div class="info-value">{{ $sertifikat->tanggal_terbit_formatted }}</div>
                                </div>
                                
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-building me-2"></i>Penyelenggara
                                    </div>
                                    <div class="info-value">{{ $sertifikat->penyelenggara }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="info-item mt-3">
                            <div class="info-label">
                                <i class="fas fa-file me-2"></i>File Sertifikat
                            </div>
                            <div class="info-value">
                                @if($sertifikat->file_sertifikat)
                                    <a href="{{ route('anggota.sertifikat.download', $sertifikat->id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download me-1"></i>Download File
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada file</span>
                                @endif
                            </div>
                        </div>
                        
                        @if($sertifikat->keterangan)
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-sticky-note me-2"></i>Keterangan
                            </div>
                            <div class="info-value">{{ $sertifikat->keterangan }}</div>
                        </div>
                        @endif

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-clock me-2"></i>Ditambahkan
                            </div>
                            <div class="info-value">{{ $sertifikat->created_at->format('d/m/Y H:i') }}</div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('anggota.sertifikat.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
