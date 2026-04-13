<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ConnecTIK Anggota')</title>
    <link rel="icon" href="{{ asset('images/rtik.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background:#fff; border-bottom:1px solid #e5e7eb; }
        .navbar .navbar-brand { color:#1877F2; font-weight:700; }
        .navbar .nav-link { color:#1c1e21; }
        .navbar .container-fluid { display:grid; grid-template-columns:1fr auto 1fr; align-items:center; }
        .navbar .navbar-brand { justify-self:start; }
        .navbar .nav-center { justify-self:center; }
        .navbar .nav-right { justify-self:end; }
        .nav-center .nav-icon { width:60px; height:44px; display:flex; align-items:center; justify-content:center; border-radius:8px; color:#5f676b; text-decoration:none; }
        .nav-center .nav-icon:hover { background:#f0f2f5; color:#1c1e21; }
        .nav-center .nav-icon.active { box-shadow: inset 0 -3px 0 #1877F2; color:#1877F2; }
        .nav-right .nav-circle { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:#f0f2f5; color:#1c1e21; text-decoration:none; }
        .nav-right .nav-circle:hover { background:#e9ecef; }
        .card { border: none; border-radius: 15px; box-shadow: none; --bs-card-bg: transparent; --bs-card-spacer-y: 0; background-color: transparent; }
        .card-body { padding: 0 !important; }
        .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0 !important; border: none; }
        .section-title { font-weight: 700; }
        .list-group-item { border: none; }
        .list-group, .list-group-item { --bs-list-group-bg: transparent; background-color: transparent; }
        
        @media (min-width: 992px) {
            html, body { height: 100%; overflow: hidden; }
            .page-content { height: calc(100vh - 64px); display: flex; flex-direction: column; overflow: hidden; padding-top: 16px; }
            .grid-row { flex: 1 1 auto; display: flex; overflow: hidden; }
            .grid-col { height: 100%; overflow-y: auto; padding-bottom: 50px; box-sizing: border-box; scrollbar-gutter: stable; -ms-overflow-style: none; scrollbar-width: none; }
            .grid-col::-webkit-scrollbar { width: 0; height: 0; }
            .grid-col::after { content: ""; display: block; height: 50px; }
            .grid-col > .card:last-child { margin-bottom: 50px; }
        }
        
        @yield('styles')
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar sticky-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a class="navbar-brand" href="{{ route('anggota.beranda') }}">ConnecTIK Anggota</a>
            <div class="nav-center d-flex align-items-center gap-1">
                <a class="nav-icon nav-home {{ Route::is('anggota.beranda') ? 'active' : '' }}" href="{{ route('anggota.beranda') }}"><i class="fas fa-home"></i></a>
                <a class="nav-icon nav-users {{ Route::is('anggota.anggota-list') ? 'active' : '' }}" href="{{ route('anggota.anggota-list') }}" title="Daftar Anggota"><i class="fas fa-users"></i></a>
                <a class="nav-icon nav-academy {{ Route::is('anggota.academy') ? 'active' : '' }}" href="{{ route('anggota.academy') }}" title="Academy"><i class="fas fa-graduation-cap"></i></a>
                <a class="nav-icon nav-calendar {{ Route::is('anggota.kegiatan.*') ? 'active' : '' }}" href="{{ route('anggota.kegiatan.calendar') }}" title="Kalender Kegiatan"><i class="fas fa-calendar-days"></i></a>
            </div>
            
            <div class="nav-right d-flex align-items-center gap-2">
                <form method="POST" action="{{ route('anggota.logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn p-0 nav-circle"><i class="fas fa-sign-out-alt"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container page-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
