<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item->title }} - Academy</title>
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
        .cover { width: 100%; max-height: 300px; object-fit: cover; border-radius: 8px; }
        .content { line-height: 1.8; }
        .badge { border-radius: 10px; }
    </style>
</head>
<body>
    <nav class="navbar sticky-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a class="navbar-brand" href="{{ route('anggota.beranda') }}">ConnecTIK Anggota</a>
            <div class="nav-center d-flex align-items-center gap-1">
                <a class="nav-icon" href="{{ route('anggota.beranda') }}"><i class="fas fa-home"></i></a>
                <a class="nav-icon" href="{{ route('anggota.anggota-list') }}" title="Daftar Anggota"><i class="fas fa-users"></i></a>
                <a class="nav-icon active" href="{{ route('anggota.academy') }}"><i class="fas fa-graduation-cap"></i></a>
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
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>{{ $item->title }}</h4>
                <div>
                    @if($item->category)
                        <span class="badge bg-light text-dark me-1"><i class="fas fa-tags me-1"></i>{{ $item->category }}</span>
                    @endif
                    @if($item->level)
                        <span class="badge bg-info text-dark"><i class="fas fa-signal me-1"></i>{{ $item->level }}</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($item->cover)
                    <img class="cover mb-3" src="{{ asset('storage/lms/' . $item->cover) }}" alt="{{ $item->title }}">
                @endif
                @if($item->description)
                    <p class="text-muted">{{ $item->description }}</p>
                @endif
                <div class="content">
                    {!! \App\Support\HtmlSanitizer::clean($item->content) !!}
                </div>

                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <div class="text-muted small">Diperbarui {{ $item->updated_at->format('d/m/Y H:i') }}</div>
                    @if(!empty($hasRead) && $hasRead)
                        <button class="btn btn-success" disabled>
                            <i class="fas fa-check me-1"></i>Sudah membaca
                        </button>
                    @else
                        <form method="POST" action="{{ route('anggota.academy.read', $item->slug) }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-book-reader me-1"></i>Tandai sudah membaca
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
