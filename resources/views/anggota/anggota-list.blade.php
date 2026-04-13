<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota - ConnecTIK Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background:#fff; border-bottom:1px solid #e5e7eb; }
        .navbar .navbar-brand { color:#1877F2; font-weight:700; }
        .nav-center .nav-icon { width:60px; height:44px; display:flex; align-items:center; justify-content:center; border-radius:8px; color:#5f676b; text-decoration:none; }
        .nav-center .nav-icon:hover { background:#f0f2f5; color:#1c1e21; }
        .nav-center .nav-icon.active { box-shadow: inset 0 -3px 0 #1877F2; color:#1877F2; }
        .nav-right .nav-circle { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:#f0f2f5; color:#1c1e21; text-decoration:none; }
        .nav-right .nav-circle:hover { background:#e9ecef; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); }
        .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0 !important; border: none; }
        .filter-row { gap: 8px; }
        .avatar { width:48px; height:48px; border-radius:50%; background:#eee; display:flex; align-items:center; justify-content:center; overflow:hidden; }
        .avatar img { width:100%; height:100%; object-fit:cover; display:block; }
        .anggota-item { background:#fff; border-radius:12px; padding:10px; border:1px solid #e9ecef; }
    </style>
</head>
<body>
    <nav class="navbar sticky-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a class="navbar-brand" href="{{ route('anggota.beranda') }}">ConnecTIK Anggota</a>
            <div class="nav-center d-flex align-items-center gap-1">
                <a class="nav-icon" href="{{ route('anggota.beranda') }}"><i class="fas fa-home"></i></a>
                <a class="nav-icon active" href="{{ route('anggota.anggota-list') }}" title="Daftar Anggota"><i class="fas fa-users"></i></a>
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
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-users me-2"></i>Daftar Anggota</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('anggota.anggota-list') }}" class="mb-3">
                    <div class="row filter-row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                                <input type="text" name="nama" class="form-control" placeholder="Cari nama..." value="{{ request('nama') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user-tie"></i></span>
                                <select name="jabatan" class="form-select">
                                    <option value="">Semua Jabatan</option>
                                    @foreach($jabatanOptions as $j)
                                        <option value="{{ $j }}" {{ request('jabatan') == $j ? 'selected' : '' }}>{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i>Filter</button>
                        </div>
                    </div>
                </form>

                @if($anggotas->count())
                <div class="row g-2">
                    @foreach($anggotas as $a)
                    <div class="col-lg-6">
                        <a href="{{ route('anggota.profil', $a->id) }}" class="text-decoration-none">
                            <div class="anggota-item d-flex align-items-center gap-2">
                                <div class="avatar">
                                    @if($a->foto)
                                        <img src="{{ asset('storage/anggotas/' . $a->foto) }}" alt="{{ $a->nama }}">
                                    @else
                                        <i class="fas fa-user text-secondary"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $a->nama }}</div>
                                    <div class="text-muted small">{{ $a->jabatan ?? '-' }}</div>
                                </div>
                                <div>
                                    <span class="badge bg-primary">Aktif</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-end mt-3">
                    {{ $anggotas->links() }}
                </div>
                @else
                <div class="text-center py-4 text-muted"><i class="fas fa-users-slash me-2"></i>Tidak ada anggota yang cocok.</div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
