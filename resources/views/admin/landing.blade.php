<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConnecTIK - Sistem Manajemen RTIK Terintegrasi</title>
    <link rel="icon" href="{{ asset('images/rtik.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background-color: #f3f4f6;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            padding-top: 72px;
        }

        .navbar-brand-logo {
            width: 40px;
            height: 40px;
            border-radius: 12px;
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

        .hero {
            padding: 4rem 0 3rem;
            background: radial-gradient(circle at top left, #4f46e5 0, #1e40af 35%, #020617 100%);
            color: #ffffff;
        }

        .hero-title {
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        @media (min-width: 992px) {
            .hero-title {
                font-size: 3rem;
            }
        }

        .hero-subtitle {
            font-size: 1rem;
            opacity: 0.9;
        }

        .hero-slide {
            min-height: 260px;
            border-radius: 20px;
            padding: 2rem;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.85), rgba(37, 99, 235, 0.85));
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.7);
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            background-color: rgba(15, 23, 42, 0.85);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .hero .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background-color: rgba(255, 255, 255, 0.6);
        }

        .hero .carousel-indicators .active {
            background-color: #ffffff;
        }

        .stats-section {
            padding: 3rem 0;
        }

        .stat-card {
            background-color: #ffffff;
            border-radius: 1.1rem;
            padding: 1.25rem 1.4rem;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.07);
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            height: 100%;
        }

        .stat-icon {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .stat-value {
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: -0.03em;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #6b7280;
        }

        .latest-section {
            padding: 3rem 0 3.5rem;
        }

        .activity-card {
            border-radius: 1.1rem;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.07);
        }

        .activity-card .card-body {
            padding: 1.25rem 1.4rem 1rem;
        }

        .activity-card .card-footer {
            padding: 0.85rem 1.4rem 1.1rem;
        }

        .activity-title {
            font-size: 1rem;
            font-weight: 600;
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
    @php
        $dashboardUrl = null;
        if (Illuminate\Support\Facades\Auth::guard('admin')->check()) {
            $adminUser = Illuminate\Support\Facades\Auth::guard('admin')->user();
            if ($adminUser->role === 'admin_nasional') {
                $dashboardUrl = route('admin.nasional.dashboard');
            } elseif ($adminUser->role === 'admin_wilayah') {
                $dashboardUrl = route('admin.wilayah.dashboard');
            } else {
                $dashboardUrl = route('admin.dashboard');
            }
        } elseif (Illuminate\Support\Facades\Auth::guard('anggota')->check()) {
            $dashboardUrl = route('anggota.beranda');
        }
    @endphp

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
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
                    <small class="text-muted d-none d-sm-block">Sistem Manajemen RTIK Terintegrasi</small>
                </div>
            </a>
            <div class="ms-auto">
                @if($dashboardUrl)
                    <a href="{{ $dashboardUrl }}" class="btn btn-primary">
                        <i class="fas fa-gauge-high me-2"></i>Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <main>
        <section class="hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <p class="mb-2 text-indigo-100 text-uppercase small fw-semibold">
                            Relawan TIK Indonesia
                        </p>
                        <h1 class="hero-title mb-3">
                            Kelola anggota dan kegiatan RTIK lebih terstruktur
                        </h1>
                        <p class="hero-subtitle mb-4">
                            ConnecTIK membantu mengelola data anggota, wilayah, dan riwayat kegiatan
                            secara terpusat, sehingga koordinasi nasional hingga komisariat menjadi lebih mudah.
                        </p>

                    </div>
                    <div class="col-lg-6">
                        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="hero-slide d-flex flex-column justify-content-center">
                                        <div class="hero-badge mb-3">
                                            <i class="fas fa-users me-2"></i>Komunitas RTIK
                                        </div>
                                        <h2 class="h4 mb-2">Monitoring kegiatan nasional dan daerah</h2>
                                        <p class="mb-0 opacity-75">
                                            Pantau aktivitas relawan di seluruh provinsi, kabupaten/kota, dan komisariat dalam satu sistem.
                                        </p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="hero-slide d-flex flex-column justify-content-center">
                                        <div class="hero-badge mb-3">
                                            <i class="fas fa-chart-line me-2"></i>Analisis Data
                                        </div>
                                        <h2 class="h4 mb-2">Statistik keanggotaan real-time</h2>
                                        <p class="mb-0 opacity-75">
                                            Lihat jumlah anggota, sebaran wilayah, dan tren kegiatan untuk pengambilan keputusan yang lebih baik.
                                        </p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="hero-slide d-flex flex-column justify-content-center">
                                        <div class="hero-badge mb-3">
                                            <i class="fas fa-calendar-check me-2"></i>Dokumentasi Kegiatan
                                        </div>
                                        <h2 class="h4 mb-2">Riwayat kegiatan terarsip rapi</h2>
                                        <p class="mb-0 opacity-75">
                                            Simpan detail kegiatan, status, dan dokumentasi sehingga mudah ditelusuri kapan saja.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        <section class="stats-section">
            <div class="container">
                <div class="text-center mb-4">
                    <h2 class="h4 fw-bold mb-2">Statistik Organisasi</h2>
                    <p class="text-muted mb-0">
                        Gambaran singkat ekosistem anggota dan kegiatan Relawan TIK di sistem ini.
                    </p>
                </div>
                <div class="row g-3 g-md-4 justify-content-center">
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="stat-label">Anggota</span>
                                <span class="stat-icon bg-primary-subtle text-primary">
                                    <i class="fas fa-users"></i>
                                </span>
                            </div>
                            <div class="stat-value">
                                {{ number_format($anggotaCount) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="stat-label">Provinsi</span>
                                <span class="stat-icon bg-success-subtle text-success">
                                    <i class="fas fa-map-marked-alt"></i>
                                </span>
                            </div>
                            <div class="stat-value">
                                {{ number_format($provinsiCount) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="stat-label">Cabang/Kota</span>
                                <span class="stat-icon bg-warning-subtle text-warning">
                                    <i class="fas fa-city"></i>
                                </span>
                            </div>
                            <div class="stat-value">
                                {{ number_format($cabangCount) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="stat-label">Komisariat</span>
                                <span class="stat-icon bg-info-subtle text-info">
                                    <i class="fas fa-network-wired"></i>
                                </span>
                            </div>
                            <div class="stat-value">
                                {{ number_format($komisariatCount) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="stat-label">Kegiatan</span>
                                <span class="stat-icon bg-danger-subtle text-danger">
                                    <i class="fas fa-calendar-check"></i>
                                </span>
                            </div>
                            <div class="stat-value">
                                {{ number_format($kegiatanCount) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="latest-section">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="h4 fw-bold mb-1">Kegiatan Terbaru</h2>
                        <p class="text-muted mb-0">
                            Tiga kegiatan terakhir yang tercatat dalam Sistem Manajemen RTIK.
                        </p>
                    </div>
                    <div class="mt-2 mt-md-0 d-none d-md-inline-flex">
                        <a href="{{ route('public.kegiatan.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat semua kegiatan
                        </a>
                    </div>
                </div>
                <div class="row g-4">
                    @forelse($latestKegiatans as $kegiatan)
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
                                    <h3 class="activity-title mb-1">
                                        {{ $kegiatan->judul }}
                                    </h3>
                                    <p class="card-text text-muted mb-2">
                                        {{ \Illuminate\Support\Str::limit($kegiatan->deskripsi, 80) }}
                                    </p>
                                    @if($kegiatan->penyelenggara)
                                        <div class="small text-muted">
                                            <i class="fas fa-building me-1"></i>
                                            {{ $kegiatan->penyelenggara }}
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <a href="{{ route('public.kegiatan.show', $kegiatan->id) }}" class="btn btn-sm btn-outline-primary">
                                        Detail Kegiatan
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center text-muted py-4">
                                Belum ada kegiatan yang tercatat di sistem.
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="mt-3 d-md-none text-center">
                    <a href="{{ route('public.kegiatan.index') }}" class="btn btn-outline-primary btn-sm">
                        Lihat semua kegiatan
                    </a>
                </div>
            </div>
        </section>
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
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
