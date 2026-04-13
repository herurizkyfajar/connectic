<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kegiatan RTIK</title>
    <link rel="icon" href="{{ asset('images/rtik.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, #4f46e5 0%, #1e40af 100%);
        }

        .navbar-brand-logo {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: linear-gradient(135deg, #1e5bb8 0%, #4a90e2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            overflow: hidden;
        }

        .navbar-brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .page-header {
            padding: 2.5rem 0 1.5rem;
            background: radial-gradient(circle at top left, #4f46e5 0, #1e40af 35%, #020617 100%);
            color: #ffffff;
        }

        .page-header-title {
            font-size: 1.9rem;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .activity-card {
            border-radius: 1.1rem;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.07);
            background-color: #ffffff;
        }

        .activity-card .card-body {
            padding: 1.1rem 1.25rem 0.9rem;
        }

        .activity-card .card-footer {
            padding: 0.85rem 1.25rem 1.1rem;
            background-color: transparent;
            border-top: none;
        }

        .activity-title {
            font-size: 1rem;
            font-weight: 600;
        }

        .pagination-wrapper {
            border-top: 1px solid #e5e7eb;
            margin-top: 1.5rem;
            padding-top: 1.2rem;
        }

        .app-footer {
            background-color: #020617;
            color: #ffffff;
            padding: 2.5rem 0 1.75rem;
        }

        .app-footer .footer-link {
            color: #ffffff;
            text-decoration: none;
        }

        .app-footer .footer-link:hover {
            color: #ffffff;
            opacity: 0.85;
        }

        .app-footer .text-muted {
            color: #ffffff !important;
        }

        .footer-pill {
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.7);
            font-size: 0.75rem;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a href="{{ route('landing') }}" class="navbar-brand d-flex align-items-center">
                <div class="navbar-brand-logo me-2">
                    @if(file_exists(public_path('images/rtik.png')))
                        <img src="{{ asset('images/rtik.png') }}" alt="Logo RTIK">
                    @else
                        <i class="fas fa-shield-alt"></i>
                    @endif
                </div>
                <div class="d-flex flex-column">
                    <span class="fw-bold">ConnecTIK</span>
                    <small class="text-white-50 d-none d-sm-block">Daftar Kegiatan RTIK</small>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPublic" aria-controls="navbarPublic" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarPublic">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('landing') }}">Beranda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="page-header">
        <div class="container">
            <h1 class="page-header-title mb-2">Daftar Kegiatan Terlaksana</h1>
            <p class="mb-0 text-white-50">
                Menampilkan kegiatan RTIK yang berstatus terlaksana dengan dokumentasi singkat.
            </p>
        </div>
    </header>

    <main class="py-4">
        <div class="container">
            @if($kegiatans->count() === 0)
                <div class="text-center text-muted py-5">
                    <i class="fas fa-calendar-times fa-2x mb-3"></i>
                    <p class="mb-0">Belum ada kegiatan terlaksana yang tercatat.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($kegiatans as $kegiatan)
                        <div class="col-md-4">
                            <div class="card activity-card h-100 border-0">
                                @php
                                    $featuredImageUrl = null;
                                    if ($kegiatan->dokumentasi) {
                                        $filename = basename($kegiatan->dokumentasi);
                                        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                        if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                                            $featuredImageUrl = route('riwayat-kegiatan.image', $kegiatan->id);
                                        }
                                    }
                                @endphp
                                @if($featuredImageUrl)
                                    <img src="{{ $featuredImageUrl }}" alt="Dokumentasi {{ $kegiatan->judul }}" class="w-100" style="height: 180px; object-fit: cover; border-top-left-radius: 1.1rem; border-top-right-radius: 1.1rem;">
                                @endif
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="small text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ optional($kegiatan->tanggal_kegiatan)->format('d/m/Y') }}
                                        </div>
                                        @if($kegiatan->status)
                                            @php
                                                $badgeClass = 'bg-secondary';
                                                if ($kegiatan->status === 'Terlaksana') {
                                                    $badgeClass = 'bg-success';
                                                } elseif ($kegiatan->status === 'Dibatalkan') {
                                                    $badgeClass = 'bg-danger';
                                                } elseif ($kegiatan->status === 'Ditunda' || $kegiatan->status === 'Akan Datang') {
                                                    $badgeClass = 'bg-warning text-dark';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ $kegiatan->status }}
                                            </span>
                                        @endif
                                    </div>
                                    <h2 class="activity-title mb-1">
                                        {{ $kegiatan->judul }}
                                    </h2>
                                    <p class="card-text text-muted mb-2">
                                        {{ \Illuminate\Support\Str::limit($kegiatan->deskripsi, 100) }}
                                    </p>
                                    @if($kegiatan->penyelenggara)
                                        <div class="small text-muted">
                                            <i class="fas fa-building me-1"></i>
                                            {{ $kegiatan->penyelenggara }}
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center">
                                    <span class="small text-muted">
                                        {{ $kegiatan->waktu_mulai ? $kegiatan->waktu_mulai->format('H:i') : '-' }}
                                        @if($kegiatan->waktu_selesai)
                                            - {{ $kegiatan->waktu_selesai->format('H:i') }}
                                        @endif
                                    </span>
                                    <a href="{{ route('public.kegiatan.show', $kegiatan->id) }}" class="btn btn-sm btn-outline-primary">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination-wrapper d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4">
                    <div class="small text-muted">
                        Menampilkan
                        <strong>{{ $kegiatans->firstItem() }}</strong>
                        -
                        <strong>{{ $kegiatans->lastItem() }}</strong>
                        dari
                        <strong>{{ $kegiatans->total() }}</strong>
                        kegiatan terlaksana
                    </div>
                    <nav aria-label="Navigasi halaman kegiatan">
                        {{ $kegiatans->onEachSide(1)->links() }}
                    </nav>
                </div>
            @endif
        </div>
    </main>

    <footer class="app-footer">
        <div class="container">
            <div class="row gy-3">
                <div class="col-md-5">
                    <div class="d-flex align-items-center mb-2">
                        <div class="navbar-brand-logo me-2">
                            @if(file_exists(public_path('images/rtik.png')))
                                <img src="{{ asset('images/rtik.png') }}" alt="Logo RTIK">
                            @else
                                <i class="fas fa-shield-alt"></i>
                            @endif
                        </div>
                        <div class="d-flex flex-column">
                            <span class="fw-semibold">ConnecTIK</span>
                            <small class="text-muted">Sistem Manajemen RTIK Terintegrasi</small>
                        </div>
                    </div>
                    <p class="text-muted small mb-0">
                        Platform terpusat untuk mengelola anggota, wilayah, dan kegiatan Relawan TIK Indonesia,
                        dari tingkat nasional hingga komisariat.
                    </p>
                </div>
                <div class="col-6 col-md-3">
                    <h6 class="fw-semibold mb-2">Navigasi</h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-1">
                            <a href="{{ route('landing') }}" class="footer-link">Beranda</a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('login') }}" class="footer-link">Login Admin</a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('anggota.login') }}" class="footer-link">Login Anggota</a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('public.kegiatan.index') }}" class="footer-link">Kegiatan</a>
                        </li>
                    </ul>
                </div>
                <div class="col-6 col-md-4">
                    <h6 class="fw-semibold mb-2">Informasi</h6>
                    <ul class="list-unstyled small mb-2">
                        <li class="mb-1">Relawan TIK Indonesia</li>
                        <li class="mb-1">Manajemen data anggota dan kegiatan.</li>
                    </ul>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="footer-pill">
                            <i class="fas fa-shield-alt me-1"></i>Terpusat
                        </span>
                        <span class="footer-pill">
                            <i class="fas fa-cloud me-1"></i>Online
                        </span>
                    </div>
                </div>
            </div>
            <div class="border-top border-secondary mt-3 pt-3 d-flex justify-content-between small text-muted flex-column flex-md-row">
                <span>© {{ date('Y') }} ConnecTIK. Semua hak dilindungi.</span>
                <span>Relawan TIK Indonesia</span>
                <span>Aplikasi ini dibuat oleh <strong>FURTIK</strong></span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
