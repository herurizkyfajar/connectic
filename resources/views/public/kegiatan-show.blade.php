<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kegiatan - {{ $riwayatKegiatan->judul }}</title>
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

        .badge-status {
            font-size: 0.8rem;
            padding: 0.3rem 0.7rem;
            border-radius: 999px;
        }

        .card-detail {
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(15,23,42,0.08);
            border: none;
        }

        .info-label {
            font-weight: 500;
            color: #6b7280;
            min-width: 120px;
        }

        .info-value {
            color: #111827;
        }

        .footer-text {
            font-size: 0.85rem;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('landing') }}">
                <div class="navbar-brand-logo me-2">
                    @if(file_exists(public_path('images/rtik.png')))
                        <img src="{{ asset('images/rtik.png') }}" alt="Logo RTIK">
                    @else
                        <i class="fas fa-shield-alt"></i>
                    @endif
                </div>
                <span class="fw-semibold">ConnecTIK</span>
            </a>
        </div>
    </nav>

    <main style="padding-top: 80px;">
        <section class="page-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <p class="mb-2 text-sm text-indigo-200 text-uppercase fw-semibold" style="letter-spacing: .18em; font-size: 0.75rem;">
                            Detail Kegiatan RTIK
                        </p>
                        <h1 class="h3 fw-bold mb-2">
                            {{ $riwayatKegiatan->judul }}
                        </h1>
                        <div class="d-flex flex-wrap align-items-center gap-2 text-sm">
                            <span class="badge-status bg-light text-dark">
                                <i class="fas fa-calendar-day me-1"></i>
                                {{ $riwayatKegiatan->tanggal_kegiatan_formatted }}
                            </span>
                            <span class="badge-status bg-light text-dark">
                                <i class="fas fa-clock me-1"></i>
                                {{ $riwayatKegiatan->waktu_mulai }} - {{ $riwayatKegiatan->waktu_selesai }}
                            </span>
                            <span class="badge-status {{ $riwayatKegiatan->status === 'Terlaksana' ? 'bg-success text-white' : ($riwayatKegiatan->status === 'Dibatalkan' ? 'bg-danger text-white' : 'bg-warning text-dark') }}">
                                {{ $riwayatKegiatan->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-4 py-md-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <div class="card card-detail">
                            <div class="card-body p-4 p-md-5">
                                @php
                                    $featuredImageUrl = null;
                                    if ($riwayatKegiatan->dokumentasi) {
                                        $filename = basename($riwayatKegiatan->dokumentasi);
                                        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                        if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                                            $featuredImageUrl = route('riwayat-kegiatan.image', $riwayatKegiatan->id);
                                        }
                                    }
                                @endphp

                                @if($featuredImageUrl)
                                    <div class="mb-4">
                                        <img src="{{ $featuredImageUrl }}" alt="Dokumentasi {{ $riwayatKegiatan->judul }}" class="w-100 rounded" style="max-height: 320px; object-fit: cover;">
                                    </div>
                                @endif

                                <h2 class="h5 fw-bold mb-3">Deskripsi Kegiatan</h2>
                                <p class="mb-4" style="white-space: pre-line;">
                                    {{ $riwayatKegiatan->deskripsi }}
                                </p>

                                @if($riwayatKegiatan->catatan)
                                    <h3 class="h6 fw-semibold mb-2">Catatan Tambahan</h3>
                                    <p class="mb-0" style="white-space: pre-line;">
                                        {{ $riwayatKegiatan->catatan }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card card-detail mb-3">
                            <div class="card-body p-4">
                                <h2 class="h6 fw-bold mb-3">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>Informasi Kegiatan
                                </h2>
                                <div class="mb-2 d-flex">
                                    <div class="info-label">
                                        <i class="fas fa-map-marker-alt me-1 text-danger"></i>Lokasi
                                    </div>
                                    <div class="info-value">
                                        {{ $riwayatKegiatan->lokasi }}
                                    </div>
                                </div>
                                <div class="mb-2 d-flex">
                                    <div class="info-label">
                                        <i class="fas fa-tags me-1 text-secondary"></i>Jenis
                                    </div>
                                    <div class="info-value">
                                        <span class="badge bg-info text-dark">
                                            {{ $riwayatKegiatan->jenis_kegiatan }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-2 d-flex">
                                    <div class="info-label">
                                        <i class="fas fa-building me-1 text-indigo"></i>Penyelenggara
                                    </div>
                                    <div class="info-value">
                                        {{ $riwayatKegiatan->penyelenggara }}
                                    </div>
                                </div>
                                <div class="mb-2 d-flex">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-plus me-1 text-success"></i>Dibuat
                                    </div>
                                    <div class="info-value">
                                        {{ $riwayatKegiatan->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <div class="mb-0 d-flex">
                                    <div class="info-label">
                                        <i class="fas fa-edit me-1 text-warning"></i>Diupdate
                                    </div>
                                    <div class="info-value">
                                        {{ $riwayatKegiatan->updated_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($riwayatKegiatan->dokumentasi)
                            <div class="card card-detail mb-3">
                                <div class="card-body p-4">
                                    <h2 class="h6 fw-bold mb-2">
                                        <i class="fas fa-folder-open me-2 text-primary"></i>Dokumentasi
                                    </h2>
                                    <p class="mb-2 small text-muted">
                                        Dokumentasi kegiatan tersimpan di sistem dan dapat diakses oleh admin.
                                    </p>
                                    @if($featuredImageUrl)
                                        <p class="mb-0 small">
                                            Gambar di atas merupakan ringkasan dokumentasi kegiatan ini.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="d-grid">
                            <a href="{{ route('landing') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-3 border-top bg-white mt-auto">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <p class="mb-0 footer-text">
                &copy; {{ date('Y') }} ConnecTIK - Sistem Manajemen RTIK Terintegrasi.
            </p>
            <a href="{{ route('landing') }}" class="footer-text text-decoration-none">
                Kembali ke Beranda
            </a>
            <span class="footer-text">Aplikasi ini dibuat oleh <strong>FURTIK</strong></span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
