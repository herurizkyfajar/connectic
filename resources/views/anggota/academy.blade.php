<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academy - ConnecTIK Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
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
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); }
        .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0 !important; border: none; }
        .course-card { position: relative; border: 1px solid #e9ecef; border-radius: 12px; overflow: hidden; background: #fff; }
        .course-cover { width: 100%; height: 140px; object-fit: cover; background:#f0f2f5; }
        .course-body { padding: 12px; }
        .course-title { font-weight: 600; margin-bottom: 4px; }
        .badge { border-radius: 10px; }
        .badge-read { position: absolute; top: 8px; right: 8px; }
        .grid { display: grid; grid-template-columns: repeat(1, 1fr); gap: 12px; }
        @media (min-width: 576px) { .grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 992px) { .grid { grid-template-columns: repeat(3, 1fr); } }
    </style>
    </head>
<body>
    <nav class="navbar sticky-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a class="navbar-brand" href="{{ route('anggota.beranda') }}">ConnecTIK Anggota</a>
            <div class="nav-center d-flex align-items-center gap-1">
                <a class="nav-icon" href="{{ route('anggota.beranda') }}"><i class="fas fa-home"></i></a>
                <a class="nav-icon" href="{{ route('anggota.anggota-list') }}" title="Daftar Anggota"><i class="fas fa-users"></i></a>
                <a class="nav-icon active" href="{{ route('anggota.academy') }}" title="Academy"><i class="fas fa-graduation-cap"></i></a>
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
                <h4 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Academy</h4>
            </div>
            <div class="card-body">
                @if(isset($items) && $items->count())
                    <div class="grid">
                        @foreach($items as $item)
                            <div class="course-card">
                                @if(!empty($readIds) && in_array($item->id, $readIds))
                                    <span class="badge bg-success badge-read"><i class="fas fa-check me-1"></i>Sudah dibaca</span>
                                @endif
                                @if($item->cover)
                                    <img class="course-cover" src="{{ asset('storage/lms/' . $item->cover) }}" alt="{{ $item->title }}">
                                @else
                                    <div class="course-cover d-flex align-items-center justify-content-center text-muted">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                @endif
                                <div class="course-body">
                                    <div class="course-title">{{ $item->title }}</div>
                                    <div class="mb-2">
                                        @if($item->category)
                                            <span class="badge bg-light text-dark me-1"><i class="fas fa-tags me-1"></i>{{ $item->category }}</span>
                                        @endif
                                        @if($item->level)
                                            <span class="badge bg-info text-dark"><i class="fas fa-signal me-1"></i>{{ $item->level }}</span>
                                        @endif
                                    </div>
                                    <div class="text-muted small mb-2">Diperbarui {{ $item->updated_at->format('d/m/Y') }}</div>
                                    <a href="{{ route('anggota.academy.show', $item->slug) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Lihat Kelas
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">{{ $items->links() }}</div>
                @else
                    <div class="text-muted">Belum ada kelas tersedia.</div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
