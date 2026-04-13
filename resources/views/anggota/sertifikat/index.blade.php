<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Saya - ConnecTIK</title>
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
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .action-buttons .btn {
            padding: 5px 10px;
            font-size: 0.8rem;
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

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-certificate me-2"></i>Sertifikat Saya
                    </h4>
                    <a href="{{ route('anggota.sertifikat.create') }}" class="btn btn-light">
                        <i class="fas fa-plus me-2"></i>Tambah Sertifikat
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($sertifikats->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-certificate fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada sertifikat</h5>
                        <p class="text-muted">Tambahkan sertifikat pertama Anda</p>
                        <a href="{{ route('anggota.sertifikat.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Sertifikat
                        </a>
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sertifikats as $index => $sertifikat)
                                    <tr>
                                        <td>{{ $sertifikats->firstItem() + $index }}</td>
                                        <td>
                                            <div><strong>{{ $sertifikat->riwayatKegiatan->judul }}</strong></div>
                                            <small class="text-muted">{{ $sertifikat->riwayatKegiatan->tanggal_kegiatan_formatted }}</small>
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
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Download File">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('anggota.sertifikat.show', $sertifikat->id) }}" 
                                                   class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('anggota.sertifikat.edit', $sertifikat->id) }}" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('anggota.sertifikat.destroy', $sertifikat->id) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Yakin ingin menghapus sertifikat ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
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

                    <div class="d-flex justify-content-center mt-3">
                        {{ $sertifikats->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
