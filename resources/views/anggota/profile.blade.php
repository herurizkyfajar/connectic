<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Anggota - ConnecTIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar { background:#fff; border-bottom:1px solid #e5e7eb; }
        .navbar .container-fluid { display:grid; grid-template-columns:1fr auto 1fr; align-items:center; }
        .navbar .navbar-brand { color:#1877F2; font-weight:700; justify-self:start; }
        .nav-center { justify-self:center; }
        .nav-right { justify-self:end; }
        .nav-center .nav-icon { width:60px; height:44px; display:flex; align-items:center; justify-content:center; border-radius:8px; color:#5f676b; text-decoration:none; }
        .nav-center .nav-icon:hover { background:#f0f2f5; color:#1c1e21; }
        .nav-center .nav-icon.active { box-shadow: inset 0 -3px 0 #1877F2; color:#1877F2; }
        .nav-right .nav-circle { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:#f0f2f5; color:#1c1e21; text-decoration:none; }
        .nav-right .nav-circle:hover { background:#e9ecef; }
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
        .profile-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
        .badge-keaktifan {
            font-size: 1rem;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        .badge-keaktifan:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
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
                <a class="nav-icon" href="{{ route('anggota.kegiatan.calendar') }}" title="Kalender Kegiatan"><i class="fas fa-calendar-days"></i></a>
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

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-user me-2"></i>Profil Anggota
                            </h4>
                            <a href="{{ route('anggota.edit-profile') }}" class="btn btn-light">
                                <i class="fas fa-edit me-2"></i>Edit Profil
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($anggota->foto)
                                    <img src="{{ asset('storage/anggotas/' . $anggota->foto) }}" 
                                         alt="{{ $anggota->nama }}" class="profile-image mb-3">
                                @else
                                    <div class="profile-image bg-secondary d-flex align-items-center justify-content-center mb-3 mx-auto">
                                        <i class="fas fa-user fa-4x text-white"></i>
                                    </div>
                                @endif
                                
                                <h3 class="mb-1">{{ $anggota->nama }}</h3>
                                <p class="text-muted mb-2">{{ $anggota->pekerjaan ?? 'Tidak ada pekerjaan' }}</p>
                                
                                <span class="badge {{ $anggota->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                    <i class="fas fa-circle me-1"></i>{{ $anggota->status }}
                                </span>
                                
                                <!-- Kategori Keaktifan -->
                                <div class="mt-3">
                                    <span class="badge bg-{{ $badgeKeaktifan }} badge-keaktifan" 
                                          title="Kehadiran Kegiatan: {{ $kehadiranKegiatan }} | Kehadiran Meeting: {{ $kehadiranMeeting }} | Skor: {{ $skor }} (1 tahun terakhir)">
                                        <i class="fas {{ $iconKeaktifan }} me-2"></i>{{ $kategoriKeaktifan }}
                                    </span>
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            {{ $skor }} kehadiran (1 tahun)
                                        </small>
                                    </div>
                                </div>

                                <!-- Barcode Profil Publik -->
                                <div class="mt-4 pt-3 border-top">
                                    <h6 class="text-muted mb-3">ID Card Digital</h6>
                                    <div id="qrcode" class="d-flex justify-content-center bg-white p-2 border rounded mx-auto" style="width: fit-content;"></div>
                                    <div class="mt-2 small text-muted">Scan untuk profil publik</div>
                                    <div class="d-flex gap-2 justify-content-center mt-3">
                                        <button onclick="downloadQRCode()" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-download me-1"></i>Download
                                        </button>
                                        <a href="{{ route('anggota.profil', $anggota->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-1"></i>Lihat Profil
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-envelope me-2"></i>Email
                                            </div>
                                            <div class="info-value">{{ $anggota->email }}</div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-phone me-2"></i>Telepon
                                            </div>
                                            <div class="info-value">{{ $anggota->telepon }}</div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-calendar me-2"></i>Tanggal Lahir
                                            </div>
                                            <div class="info-value">
                                                {{ $anggota->tanggal_lahir_formatted }} 
                                                <small class="text-muted">({{ $anggota->umur }} tahun)</small>
                                            </div>
                                        </div>
                                        
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-venus-mars me-2"></i>Jenis Kelamin
                                            </div>
                                            <div class="info-value">{{ $anggota->jenis_kelamin }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-network-wired me-2"></i>Aktif di
                                            </div>
                                            <div class="info-value">
                                                @php
                                                    $aktifDi = is_array($anggota->aktif_di) ? $anggota->aktif_di : [];
                                                    $labelMap = ['nasional' => 'Nasional', 'wilayah' => 'Wilayah', 'cabang' => 'Cabang', 'komisariat' => 'Komisariat'];
                                                @endphp
                                                @if(!empty($aktifDi))
                                                    @foreach($aktifDi as $val)
                                                        <span class="badge bg-info me-1">{{ $labelMap[$val] ?? ucfirst($val) }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-map-marker-alt me-2"></i>Alamat
                                            </div>
                                            <div class="info-value">{{ $anggota->alamat }}</div>
                                        </div>
                                        
                                        @if($anggota->pekerjaan)
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-briefcase me-2"></i>Pekerjaan
                                            </div>
                                            <div class="info-value">{{ $anggota->pekerjaan }}</div>
                                        </div>
                                        @endif
                                        
                                        @if($anggota->jabatan)
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-user-tie me-2"></i>Jabatan
                                            </div>
                                            <div class="info-value">
                                                <span class="badge bg-info">{{ $anggota->jabatan }}</span>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="info-item">
                                            <div class="info-label">
                                                <i class="fas fa-clock me-2"></i>Terdaftar
                                            </div>
                                            <div class="info-value">{{ $anggota->created_at->format('d/m/Y H:i') }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($anggota->keterangan)
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-sticky-note me-2"></i>Keterangan
                                    </div>
                                    <div class="info-value">{{ $anggota->keterangan }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Sertifikat -->
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-certificate me-2"></i>Riwayat Sertifikat
                            </h4>
                            <a href="{{ route('anggota.sertifikat.index') }}" class="btn btn-light">
                                <i class="fas fa-list me-2"></i>Kelola Sertifikat
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($sertifikats->isEmpty())
                            <div class="text-center py-4">
                                <i class="fas fa-certificate fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada sertifikat yang diterima</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kegiatan</th>
                                            <th>Nomor Sertifikat</th>
                                            <th>Tanggal Terbit</th>
                                            <th>Penyelenggara</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sertifikats as $index => $sertifikat)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div><strong>{{ $sertifikat->riwayatKegiatan->judul }}</strong></div>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        {{ $sertifikat->riwayatKegiatan->tanggal_kegiatan_formatted }}
                                                    </small>
                                                </td>
                                                <td>
                                                    @if($sertifikat->nomor_sertifikat)
                                                        <code>{{ $sertifikat->nomor_sertifikat }}</code>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ $sertifikat->tanggal_terbit_formatted }}</td>
                                                <td>{{ $sertifikat->penyelenggara }}</td>
                                                <td>
                                                    @if($sertifikat->file_sertifikat)
                                                        <a href="{{ route('anggota.sertifikat.download', $sertifikat->id) }}" 
                                                           class="btn btn-sm btn-primary"
                                                           title="Download File">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-3">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Total Sertifikat:</strong> {{ $sertifikats->count() }} sertifikat
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Riwayat Kegiatan -->
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-history me-2"></i>Riwayat Kegiatan Terakhir
                            </h4>
                            <a href="{{ route('riwayat-kegiatan.index') }}" class="btn btn-light">
                                <i class="fas fa-list me-2"></i>Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($riwayatKegiatans->isEmpty())
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada riwayat kegiatan</p>
                                <a href="{{ route('riwayat-kegiatan.index') }}" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>Lihat Kegiatan Tersedia
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kegiatan</th>
                                            <th>Tanggal</th>
                                            <th>Lokasi</th>
                                            <th>Status</th>
                                            <th>Jenis</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($riwayatKegiatans as $index => $kegiatan)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div><strong>{{ $kegiatan->judul }}</strong></div>
                                                    <small class="text-muted">{{ Str::limit($kegiatan->deskripsi, 50) }}</small>
                                                </td>
                                                <td>
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $kegiatan->tanggal_kegiatan_formatted }}
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $kegiatan->waktu_mulai }} - {{ $kegiatan->waktu_selesai }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    {{ $kegiatan->lokasi }}
                                                </td>
                                                <td>
                                                    <span class="badge {{ $kegiatan->status == 'Terlaksana' ? 'bg-success' : ($kegiatan->status == 'Dibatalkan' ? 'bg-danger' : 'bg-warning') }}">
                                                        {{ $kegiatan->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $kegiatan->jenis_kegiatan }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Total Kegiatan Diikuti:</strong> {{ $riwayatKegiatans->count() }} kegiatan (10 terakhir)
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: "{{ route('anggota.profil', $anggota->id) }}",
            width: 128,
            height: 128,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });

        function downloadQRCode() {
            // Tunggu sebentar untuk memastikan QR code sudah di-render
            setTimeout(function() {
                var qrContainer = document.getElementById("qrcode");
                var img = qrContainer.getElementsByTagName("img")[0];
                
                // Jika img belum ada (karena qrcode.js menggunakan canvas dulu), coba ambil canvas
                if (!img) {
                    var canvas = qrContainer.getElementsByTagName("canvas")[0];
                    if (canvas) {
                        var image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
                        var link = document.createElement('a');
                        link.download = "QRCode-{{ $anggota->nama }}.png";
                        link.href = image;
                        link.click();
                    }
                } else {
                    // Jika sudah ada img tag (biasanya qrcode.js mengganti canvas dengan img)
                    var link = document.createElement('a');
                    link.download = "QRCode-{{ $anggota->nama }}.png";
                    link.href = img.src;
                    link.click();
                }
            }, 100);
        }
    </script>
</body>
</html>
