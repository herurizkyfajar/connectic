<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Anggota - ConnecTIK Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background:#fff; border-bottom:1px solid #e5e7eb; }
        .navbar .navbar-brand { color:#1877F2; font-weight:700; }
        .profile-card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); }
        .profile-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0 !important; border: none; }
        .avatar { width:96px; height:96px; border-radius:50%; overflow:hidden; background:#eee; display:flex; align-items:center; justify-content:center; }
        .avatar img { width:100%; height:100%; object-fit:cover; display:block; }
        .badge-role { font-size: .85rem; }
    </style>
</head>
<body>
    <nav class="navbar sticky-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a class="navbar-brand" href="{{ route('anggota.beranda') }}">ConnecTIK Anggota</a>
            <div class="nav-right d-flex align-items-center gap-2">
                <a class="btn btn-light" href="{{ route('anggota.anggota-list') }}"><i class="fas fa-users me-1"></i>Daftar Anggota</a>
                <form method="POST" action="{{ route('anggota.logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-sign-out-alt"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card profile-card">
            <div class="card-header profile-header">
                <h4 class="mb-0"><i class="fas fa-id-badge me-2"></i>Profil Anggota</h4>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="avatar">
                        @if($anggota->foto)
                            <img src="{{ asset('storage/anggotas/' . $anggota->foto) }}" alt="{{ $anggota->nama }}">
                        @else
                            <i class="fas fa-user text-secondary"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="h5 mb-1">{{ $anggota->nama }}</div>
                        <div class="text-muted">{{ $anggota->jabatan ?? '-' }}</div>
                        <div>
                            <span class="badge bg-primary badge-role">{{ $anggota->status }}</span>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="text-muted small">Email</div>
                            <div class="fw-semibold">{{ $anggota->email }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Telepon</div>
                            <div class="fw-semibold">{{ $anggota->telepon }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Jenis Kelamin</div>
                            <div class="fw-semibold">{{ $anggota->jenis_kelamin }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Tanggal Lahir</div>
                            <div class="fw-semibold">{{ optional($anggota->tanggal_lahir)->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="text-muted small">Pekerjaan</div>
                            <div class="fw-semibold">{{ $anggota->pekerjaan ?? '-' }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Alamat</div>
                            <div class="fw-semibold">{{ $anggota->alamat }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Keterangan</div>
                            <div class="fw-semibold">{{ $anggota->keterangan ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header"><i class="fas fa-clipboard-check me-2"></i>Riwayat Kegiatan Diikuti</div>
                    <div class="card-body">
                        @if(isset($riwayatKegiatans) && $riwayatKegiatans->count())
                            <ul class="list-group list-group-flush">
                                @foreach($riwayatKegiatans as $rk)
                                    <li class="list-group-item p-2">
                                        <div class="fw-semibold">{{ $rk->judul }}</div>
                                        <div class="text-muted small">{{ $rk->lokasi }} • {{ optional($rk->tanggal_kegiatan)->format('d/m/Y') }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-muted">Belum ada riwayat kegiatan.</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header"><i class="fas fa-handshake me-2"></i>Meeting yang Diikuti</div>
                    <div class="card-body">
                        @if(isset($meetings) && $meetings->count())
                            <ul class="list-group list-group-flush">
                                @foreach($meetings as $m)
                                    <li class="list-group-item p-2">
                                        <div class="fw-semibold">{{ $m->project_name }}</div>
                                        <div class="text-muted small">{{ $m->topic }} • {{ optional($m->meeting_date)->format('d/m/Y') }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-muted">Belum ada meeting diikuti.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
