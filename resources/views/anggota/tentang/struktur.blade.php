<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi RTIK - ConnecTIK</title>
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
        .struktur-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            border-left: 5px solid #667eea;
        }
        .struktur-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
        }
        .jabatan-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 0.5rem;
        }
        .ketua-card {
            border-left: 5px solid #dc3545;
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.05) 0%, rgba(255, 255, 255, 1) 100%);
        }
        .wakil-card {
            border-left: 5px solid #fd7e14;
            background: linear-gradient(135deg, rgba(253, 126, 20, 0.05) 0%, rgba(255, 255, 255, 1) 100%);
        }
        .sekretaris-card {
            border-left: 5px solid #20c997;
            background: linear-gradient(135deg, rgba(32, 201, 151, 0.05) 0%, rgba(255, 255, 255, 1) 100%);
        }
        .bendahara-card {
            border-left: 5px solid #0dcaf0;
            background: linear-gradient(135deg, rgba(13, 202, 240, 0.05) 0%, rgba(255, 255, 255, 1) 100%);
        }
        .photo-container {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid #f8f9fa;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            margin: 0 auto 1rem;
        }
        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .anggota-info {
            text-align: center;
        }
        .anggota-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.3rem;
        }
        .anggota-contact {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0.2rem 0;
        }
        .section-title {
            color: #667eea;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #667eea;
            text-transform: uppercase;
        }
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
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
                    <i class="fas fa-sitemap me-2"></i>Struktur Organisasi RTIK
                </h4>
            </div>
            <div class="card-body">
                @if($pengurus->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-users-slash"></i>
                        <h4>Belum Ada Data Pengurus</h4>
                        <p>Data struktur organisasi belum tersedia.</p>
                    </div>
                @else
                    <!-- Ketua Umum -->
                    @php
                        $ketua = $pengurus->where('jabatan', 'Ketua umum')->first();
                    @endphp
                    @if($ketua)
                        <h3 class="section-title">
                            <i class="fas fa-crown me-2"></i>Pimpinan Tertinggi
                        </h3>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="struktur-card ketua-card">
                                    <div class="photo-container">
                                        @if($ketua->foto)
                                            <img src="{{ asset('storage/anggotas/' . $ketua->foto) }}" alt="{{ $ketua->nama }}">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($ketua->nama) }}&size=120&background=667eea&color=fff" alt="{{ $ketua->nama }}">
                                        @endif
                                    </div>
                                    <div class="anggota-info">
                                        <div class="jabatan-badge bg-danger">
                                            <i class="fas fa-crown me-2"></i>{{ $ketua->jabatan }}
                                        </div>
                                        <h4 class="anggota-name">{{ $ketua->nama }}</h4>
                                        @if($ketua->email)
                                            <p class="anggota-contact">
                                                <i class="fas fa-envelope me-2"></i>{{ $ketua->email }}
                                            </p>
                                        @endif
                                        @if($ketua->telepon)
                                            <p class="anggota-contact">
                                                <i class="fas fa-phone me-2"></i>{{ $ketua->telepon }}
                                            </p>
                                        @endif
                                        @if($ketua->pekerjaan)
                                            <p class="anggota-contact">
                                                <i class="fas fa-briefcase me-2"></i>{{ $ketua->pekerjaan }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Wakil Ketua -->
                    @php
                        $wakil = $pengurus->where('jabatan', 'Wakil ketua');
                    @endphp
                    @if($wakil->count() > 0)
                        <h3 class="section-title">
                            <i class="fas fa-user-tie me-2"></i>Wakil Pimpinan
                        </h3>
                        <div class="row justify-content-center">
                            @foreach($wakil as $w)
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="struktur-card wakil-card">
                                        <div class="photo-container">
                                            @if($w->foto)
                                                <img src="{{ asset('storage/anggotas/' . $w->foto) }}" alt="{{ $w->nama }}">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($w->nama) }}&size=120&background=fd7e14&color=fff" alt="{{ $w->nama }}">
                                            @endif
                                        </div>
                                        <div class="anggota-info">
                                            <div class="jabatan-badge" style="background: linear-gradient(135deg, #fd7e14 0%, #f97316 100%);">
                                                <i class="fas fa-user-tie me-2"></i>{{ $w->jabatan }}
                                            </div>
                                            <h4 class="anggota-name">{{ $w->nama }}</h4>
                                            @if($w->email)
                                                <p class="anggota-contact">
                                                    <i class="fas fa-envelope me-2"></i>{{ $w->email }}
                                                </p>
                                            @endif
                                            @if($w->telepon)
                                                <p class="anggota-contact">
                                                    <i class="fas fa-phone me-2"></i>{{ $w->telepon }}
                                                </p>
                                            @endif
                                            @if($w->pekerjaan)
                                                <p class="anggota-contact">
                                                    <i class="fas fa-briefcase me-2"></i>{{ $w->pekerjaan }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Sekretaris & Bendahara -->
                    @php
                        $sekretaris = $pengurus->where('jabatan', 'Sekretaris');
                        $bendahara = $pengurus->where('jabatan', 'Bendahara');
                    @endphp
                    @if($sekretaris->count() > 0 || $bendahara->count() > 0)
                        <h3 class="section-title">
                            <i class="fas fa-users-cog me-2"></i>Sekretariat & Keuangan
                        </h3>
                        <div class="row">
                            @foreach($sekretaris as $s)
                                <div class="col-md-6 mb-3">
                                    <div class="struktur-card sekretaris-card">
                                        <div class="photo-container">
                                            @if($s->foto)
                                                <img src="{{ asset('storage/anggotas/' . $s->foto) }}" alt="{{ $s->nama }}">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($s->nama) }}&size=120&background=20c997&color=fff" alt="{{ $s->nama }}">
                                            @endif
                                        </div>
                                        <div class="anggota-info">
                                            <div class="jabatan-badge" style="background: linear-gradient(135deg, #20c997 0%, #0dcaf0 100%);">
                                                <i class="fas fa-file-alt me-2"></i>{{ $s->jabatan }}
                                            </div>
                                            <h4 class="anggota-name">{{ $s->nama }}</h4>
                                            @if($s->email)
                                                <p class="anggota-contact">
                                                    <i class="fas fa-envelope me-2"></i>{{ $s->email }}
                                                </p>
                                            @endif
                                            @if($s->telepon)
                                                <p class="anggota-contact">
                                                    <i class="fas fa-phone me-2"></i>{{ $s->telepon }}
                                                </p>
                                            @endif
                                            @if($s->pekerjaan)
                                                <p class="anggota-contact">
                                                    <i class="fas fa-briefcase me-2"></i>{{ $s->pekerjaan }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @foreach($bendahara as $b)
                                <div class="col-md-6 mb-3">
                                    <div class="struktur-card bendahara-card">
                                        <div class="photo-container">
                                            @if($b->foto)
                                                <img src="{{ asset('storage/anggotas/' . $b->foto) }}" alt="{{ $b->nama }}">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($b->nama) }}&size=120&background=0dcaf0&color=fff" alt="{{ $b->nama }}">
                                            @endif
                                        </div>
                                        <div class="anggota-info">
                                            <div class="jabatan-badge" style="background: linear-gradient(135deg, #0dcaf0 0%, #3b82f6 100%);">
                                                <i class="fas fa-wallet me-2"></i>{{ $b->jabatan }}
                                            </div>
                                            <h4 class="anggota-name">{{ $b->nama }}</h4>
                                            @if($b->email)
                                                <p class="anggota-contact">
                                                    <i class="fas fa-envelope me-2"></i>{{ $b->email }}
                                                </p>
                                            @endif
                                            @if($b->telepon)
                                                <p class="anggota-contact">
                                                    <i class="fas fa-phone me-2"></i>{{ $b->telepon }}
                                                </p>
                                            @endif
                                            @if($b->pekerjaan)
                                                <p class="anggota-contact">
                                                    <i class="fas fa-briefcase me-2"></i>{{ $b->pekerjaan }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Bidang-Bidang -->
                    @php
                        $bidangList = [
                            'Bidang kesekretariatan' => ['icon' => 'clipboard-list', 'color' => '#6366f1'],
                            'Bidang kemitraan dan legal' => ['icon' => 'handshake', 'color' => '#8b5cf6'],
                            'Bidang program dan aptika' => ['icon' => 'laptop-code', 'color' => '#ec4899'],
                            'Bidang penelitian dan pengembangan sumber daya manusia' => ['icon' => 'user-graduate', 'color' => '#10b981'],
                            'Bidang komunikasi publik' => ['icon' => 'bullhorn', 'color' => '#f59e0b']
                        ];
                    @endphp
                    @foreach($bidangList as $namaBidang => $info)
                        @php
                            $bidang = $pengurus->where('jabatan', $namaBidang);
                        @endphp
                        @if($bidang->count() > 0)
                            <h3 class="section-title">
                                <i class="fas fa-{{ $info['icon'] }} me-2"></i>{{ ucwords($namaBidang) }}
                            </h3>
                            <div class="row">
                                @foreach($bidang as $b)
                                    <div class="col-md-4 mb-3">
                                        <div class="struktur-card" style="border-left-color: {{ $info['color'] }}">
                                            <div class="photo-container">
                                                @if($b->foto)
                                                    <img src="{{ asset('storage/anggotas/' . $b->foto) }}" alt="{{ $b->nama }}">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($b->nama) }}&size=120&background={{ ltrim($info['color'], '#') }}&color=fff" alt="{{ $b->nama }}">
                                                @endif
                                            </div>
                                            <div class="anggota-info">
                                                <div class="jabatan-badge" style="background: {{ $info['color'] }};">
                                                    <i class="fas fa-{{ $info['icon'] }} me-2"></i>{{ ucwords($namaBidang) }}
                                                </div>
                                                <h5 class="anggota-name">{{ $b->nama }}</h5>
                                                @if($b->email)
                                                    <p class="anggota-contact">
                                                        <i class="fas fa-envelope me-2"></i>{{ $b->email }}
                                                    </p>
                                                @endif
                                                @if($b->telepon)
                                                    <p class="anggota-contact">
                                                        <i class="fas fa-phone me-2"></i>{{ $b->telepon }}
                                                    </p>
                                                @endif
                                                @if($b->pekerjaan)
                                                    <p class="anggota-contact">
                                                        <i class="fas fa-briefcase me-2"></i>{{ $b->pekerjaan }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endif

                <div class="mt-4 text-center">
                    <a href="{{ route('anggota.tentang.penjelasan') }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Penjelasan
                    </a>
                    <a href="{{ route('anggota.profile') }}" class="btn btn-primary">
                        <i class="fas fa-user me-2"></i>Kembali ke Profil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
