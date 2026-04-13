<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-shield-alt me-2"></i>
            <span class="fw-bold">ConnecTIK</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('anggota.*') || request()->routeIs('anggota-access.*') ? 'active' : '' }}" href="#" id="navbarAnggota" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-users me-1"></i>Anggota
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarAnggota">
                        <li><a class="dropdown-item" href="{{ route('anggota.index') }}">
                            <i class="fas fa-list me-2"></i>Data Anggota
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('anggota.create') }}">
                            <i class="fas fa-user-plus me-2"></i>Tambah Anggota
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('anggota-access.index') }}">
                            <i class="fas fa-user-shield me-2"></i>Kelola Akses
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('riwayat-kegiatan.*') ? 'active' : '' }}" href="#" id="navbarKegiatan" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-calendar-alt me-1"></i>Kegiatan
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarKegiatan">
                        <li><a class="dropdown-item" href="{{ route('riwayat-kegiatan.index') }}">
                            <i class="fas fa-history me-2"></i>Riwayat Kegiatan
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('riwayat-kegiatan.create') }}">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Kegiatan
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.absensi.*') ? 'active' : '' }}" href="#" id="navbarAbsensi" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-clipboard-check me-1"></i>Absensi
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarAbsensi">
                        <li><a class="dropdown-item" href="{{ route('admin.absensi.index') }}">
                            <i class="fas fa-list-alt me-2"></i>Riwayat Absensi
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.absensi.ranking') }}">
                            <i class="fas fa-trophy me-2"></i>Ranking Kehadiran
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.tentang.*') ? 'active' : '' }}" href="#" id="navbarTentang" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-info-circle me-1"></i>Tentang RTIK
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarTentang">
                        <li><a class="dropdown-item" href="{{ route('admin.tentang.penjelasan') }}">
                            <i class="fas fa-book-open me-2"></i>Penjelasan RTIK
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.tentang.struktur') }}">
                            <i class="fas fa-sitemap me-2"></i>Struktur Organisasi
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.meeting-notes.*') ? 'active' : '' }}" href="#" id="navbarMeetingNotes" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-file-alt me-1"></i>Meeting Notes
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarMeetingNotes">
                        <li><a class="dropdown-item" href="{{ route('admin.meeting-notes.index') }}">
                            <i class="fas fa-list me-2"></i>Daftar Meeting
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.meeting-notes.create') }}">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Meeting Note
                        </a></li>
                    </ul>
                </li>
                @php($isPembina = optional(Auth::guard('admin')->user())->role === 'pembina')
                @unless($isPembina)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.lms.*') ? 'active' : '' }}" href="#" id="navbarLms" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-graduation-cap me-1"></i>LMS
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarLms">
                        <li><a class="dropdown-item" href="{{ route('admin.lms.index') }}">
                            <i class="fas fa-list me-2"></i>Daftar Konten
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.lms.create') }}">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Konten
                        </a></li>
                    </ul>
                </li>
                @endunless
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.sertifikat.*') ? 'active' : '' }}" href="#" id="navbarSertifikat" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-certificate me-1"></i>Sertifikat
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarSertifikat">
                        <li><a class="dropdown-item" href="{{ route('admin.sertifikat.index') }}">
                            <i class="fas fa-list me-2"></i>Daftar Sertifikat
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.sertifikat.create') }}">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Sertifikat
                        </a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarProfile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>{{ Auth::guard('admin')->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarProfile">
                        <li><h6 class="dropdown-header">
                            <i class="fas fa-shield-alt me-2"></i>Administrator
                        </h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        padding: 0.8rem 0;
    }
    .navbar-brand {
        font-weight: 600;
        font-size: 1.3rem;
        transition: all 0.3s ease;
    }
    .navbar-brand:hover {
        transform: scale(1.05);
    }
    .nav-link {
        padding: 0.5rem 1rem !important;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin: 0 0.2rem;
    }
    .nav-link:hover {
        background-color: rgba(255,255,255,0.1);
        transform: translateY(-2px);
    }
    .nav-link.active {
        background-color: rgba(255,255,255,0.2);
        font-weight: 600;
    }
    .dropdown-menu {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        margin-top: 0.5rem;
    }
    .dropdown-item {
        padding: 0.6rem 1.2rem;
        transition: all 0.3s ease;
        border-radius: 6px;
        margin: 0.2rem 0.5rem;
    }
    .dropdown-item:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateX(5px);
    }
    .dropdown-header {
        font-weight: 600;
        color: #667eea;
        padding: 0.8rem 1.2rem;
    }
    .navbar-toggler {
        border: 2px solid rgba(255,255,255,0.5);
        padding: 0.5rem 0.75rem;
    }
    .navbar-toggler:focus {
        box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.3);
    }
</style>

