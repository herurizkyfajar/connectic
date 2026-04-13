<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjelasan RTIK - ConnecTIK</title>
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
        .navbar-brand {
            font-weight: 700;
        }
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
        }
        .btn-outline-light {
            border-radius: 8px;
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
        .section-title {
            color: #667eea;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #667eea;
        }
        .content-box {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #667eea;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .icon-box {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-right: 1rem;
        }
        .list-custom li {
            margin-bottom: 0.8rem;
            padding-left: 1.5rem;
            position: relative;
        }
        .list-custom li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #667eea;
            font-weight: bold;
            font-size: 1.2rem;
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
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-book-open me-2"></i>Penjelasan RTIK
                </h4>
            </div>
            <div class="card-body">
                <!-- Pengertian -->
                <div class="content-box">
                    <div class="d-flex align-items-start">
                        <div class="icon-box">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div>
                            <h3 class="section-title mb-3">Apa itu RTIK?</h3>
                            <p class="lead">
                                <strong>RTIK (Relawan Teknologi Informasi dan Komunikasi)</strong> adalah organisasi yang terdiri dari para relawan yang memiliki kepedulian dan keahlian di bidang Teknologi Informasi dan Komunikasi (TIK).
                            </p>
                            <p>
                                RTIK berkomitmen untuk meningkatkan literasi digital, memberikan bantuan teknis, dan mendukung transformasi digital di berbagai sektor masyarakat. Melalui berbagai program dan kegiatan, RTIK berupaya menjembatani kesenjangan digital dan memberdayakan masyarakat melalui teknologi.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Visi -->
                <div class="content-box">
                    <div class="d-flex align-items-start">
                        <div class="icon-box">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="section-title mb-3">Visi</h3>
                            <p class="fs-5">
                                "Menjadi organisasi relawan TIK yang profesional, inovatif, dan terdepan dalam mendukung transformasi digital Indonesia yang inklusif dan berkelanjutan."
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Misi -->
                <div class="content-box">
                    <div class="d-flex align-items-start">
                        <div class="icon-box">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="section-title mb-3">Misi</h3>
                            <ul class="list-custom list-unstyled">
                                <li>Meningkatkan literasi digital masyarakat melalui program edukasi dan pelatihan berkelanjutan</li>
                                <li>Memberikan dukungan teknis dan konsultasi TIK kepada pemerintah, organisasi, dan masyarakat</li>
                                <li>Mengembangkan solusi teknologi yang inovatif untuk menyelesaikan permasalahan sosial</li>
                                <li>Membangun ekosistem kolaborasi antara pemangku kepentingan di bidang TIK</li>
                                <li>Mendorong pemanfaatan teknologi untuk pembangunan berkelanjutan</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Program Utama -->
                <div class="content-box">
                    <div class="d-flex align-items-start">
                        <div class="icon-box">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="section-title mb-3">Program Utama</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <h5><i class="fas fa-graduation-cap text-primary me-2"></i>Literasi Digital</h5>
                                        <p class="mb-0">Workshop, pelatihan, dan sosialisasi untuk meningkatkan kemampuan digital masyarakat</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <h5><i class="fas fa-hands-helping text-success me-2"></i>Bantuan Teknis</h5>
                                        <p class="mb-0">Memberikan dukungan teknis TIK untuk pemerintahan dan organisasi</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <h5><i class="fas fa-lightbulb text-warning me-2"></i>Inovasi Teknologi</h5>
                                        <p class="mb-0">Mengembangkan solusi digital untuk menyelesaikan permasalahan sosial</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <h5><i class="fas fa-network-wired text-info me-2"></i>Kolaborasi</h5>
                                        <p class="mb-0">Membangun kerjasama dengan berbagai pihak untuk kemajuan TIK</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nilai-Nilai -->
                <div class="content-box">
                    <div class="d-flex align-items-start">
                        <div class="icon-box">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="section-title mb-3">Nilai-Nilai Organisasi</h3>
                            <div class="row text-center">
                                <div class="col-md-3 mb-3">
                                    <div class="p-3">
                                        <div class="fs-1 text-primary mb-2">
                                            <i class="fas fa-handshake"></i>
                                        </div>
                                        <h5>Integritas</h5>
                                        <p class="small text-muted mb-0">Bertindak jujur dan bertanggung jawab</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="p-3">
                                        <div class="fs-1 text-success mb-2">
                                            <i class="fas fa-rocket"></i>
                                        </div>
                                        <h5>Inovasi</h5>
                                        <p class="small text-muted mb-0">Selalu mencari solusi kreatif</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="p-3">
                                        <div class="fs-1 text-warning mb-2">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <h5>Kolaborasi</h5>
                                        <p class="small text-muted mb-0">Bekerja sama untuk hasil terbaik</p>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="p-3">
                                        <div class="fs-1 text-info mb-2">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <h5>Profesional</h5>
                                        <p class="small text-muted mb-0">Bekerja dengan standar tinggi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('anggota.tentang.struktur') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-sitemap me-2"></i>Lihat Struktur Organisasi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
