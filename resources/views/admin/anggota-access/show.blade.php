@extends('admin.layouts.app')

@section('title', 'Detail Akses Anggota')

@section('page-title', 'DETAIL AKSES ANGGOTA')

@section('styles')
<style>
    .info-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .section-header {
        display: flex;
        align-items: center;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #e0e0e0;
    }
    
    .section-header i {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
    
    .info-row {
        display: flex;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f5f5f5;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 500;
        color: #616161;
        width: 200px;
        flex-shrink: 0;
    }
    
    .info-label i {
        color: #1976d2;
        margin-right: 8px;
    }
    
    .info-value {
        color: #212121;
        flex-grow: 1;
    }
    
    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #1976d2;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .navbar { background:#fff; border-bottom:1px solid #e5e7eb; }
    .navbar .navbar-brand { color:#1877F2; font-weight:700; }
    .nav-center .nav-icon { width:60px; height:44px; display:flex; align-items:center; justify-content:center; border-radius:8px; color:#5f676b; text-decoration:none; }
    .nav-center .nav-icon:hover { background:#f0f2f5; color:#1c1e21; }
    .nav-center .nav-icon.active { box-shadow: inset 0 -3px 0 #1877F2; color:#1877F2; }
    .nav-right .nav-circle { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:#f0f2f5; color:#1c1e21; text-decoration:none; }
    .nav-right .nav-circle:hover { background:#e9ecef; }
</style>
@endsection

@section('header')
<nav class="navbar sticky-top">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <a class="navbar-brand" href="{{ route('anggota.beranda') }}">ConnecTIK Anggota</a>
        <div class="nav-center d-flex align-items-center gap-1">
            <a class="nav-icon" href="{{ route('anggota.beranda') }}"><i class="fas fa-home"></i></a>
            <a class="nav-icon" href="{{ route('anggota.index') }}"><i class="fas fa-users"></i></a>
        </div>
        <div class="nav-right d-flex align-items-center gap-2">
            <form method="POST" action="{{ route('admin.logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn p-0 nav-circle" title="Logout"><i class="fas fa-sign-out-alt"></i></button>
            </form>
        </div>
    </div>
</nav>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <div class="info-card text-center">
                @if($anggota->foto)
                    <img src="{{ asset('storage/anggotas/' . $anggota->foto) }}" 
                         alt="{{ $anggota->nama }}" class="profile-image mb-3">
                @else
                    <div class="profile-image bg-secondary d-inline-flex align-items-center justify-content-center mb-3">
                        <i class="fas fa-user fa-4x text-white"></i>
                    </div>
                @endif
                <h4 class="mb-1">{{ $anggota->nama }}</h4>
                <p class="text-muted mb-2">{{ $anggota->email }}</p>
                @if($anggota->jabatan)
                    <span class="badge bg-info">{{ $anggota->jabatan }}</span>
                @endif
            </div>

            <div class="info-card">
                <div class="section-header">
                    <i class="fas fa-key"></i>
                    <h6 class="mb-0">Status Akses</h6>
                </div>
                
                @if($anggota->has_access)
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Akses Aktif</strong>
                        <p class="mb-0 mt-2 small">Anggota ini dapat login dan mengakses sistem</p>
                    </div>
                    <form action="{{ route('admin.anggota-access.revoke', $anggota->id) }}" 
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menonaktifkan akses anggota ini?')">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-ban me-2"></i>Nonaktifkan Akses
                        </button>
                    </form>
                @else
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle me-2"></i>
                        <strong>Akses Tidak Aktif</strong>
                        <p class="mb-0 mt-2 small">Anggota ini tidak dapat login ke sistem</p>
                    </div>
                    <form action="{{ route('admin.anggota-access.grant', $anggota->id) }}" 
                          method="POST"
                          onsubmit="return confirm('Yakin ingin mengaktifkan akses anggota ini?')">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check me-2"></i>Aktifkan Akses
                        </button>
                    </form>
                @endif
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="info-card">
                <div class="section-header">
                    <i class="fas fa-user"></i>
                    <h5>Informasi Anggota</h5>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-id-card"></i>Nama Lengkap</div>
                    <div class="info-value"><strong>{{ $anggota->nama }}</strong></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-envelope"></i>Email</div>
                    <div class="info-value">{{ $anggota->email }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-phone"></i>Telepon</div>
                    <div class="info-value">{{ $anggota->telepon }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-calendar"></i>Tanggal Lahir</div>
                    <div class="info-value">{{ $anggota->tanggal_lahir_formatted }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-venus-mars"></i>Jenis Kelamin</div>
                    <div class="info-value">{{ $anggota->jenis_kelamin }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-briefcase"></i>Pekerjaan</div>
                    <div class="info-value">{{ $anggota->pekerjaan ?? '-' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-user-tie"></i>Jabatan</div>
                    <div class="info-value">
                        @if($anggota->jabatan)
                            <span class="badge bg-info">{{ $anggota->jabatan }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-toggle-on"></i>Status</div>
                    <div class="info-value">
                        <span class="badge {{ $anggota->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                            {{ $anggota->status }}
                        </span>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-map-marker-alt"></i>Alamat</div>
                    <div class="info-value">{{ $anggota->alamat }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-history"></i>Terdaftar Sejak</div>
                    <div class="info-value">{{ $anggota->created_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.anggota-access.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('anggota.show', $anggota->id) }}" class="btn btn-primary">
                        <i class="fas fa-eye me-2"></i>Lihat Profil Lengkap
                    </a>
                </div>
            </div>

            <div class="info-card">
                <div class="section-header">
                    <i class="fas fa-book-reader"></i>
                    <h5>Kelas yang Sudah Dibaca</h5>
                </div>
                @php($totalReads = isset($lmsReads) ? $lmsReads->count() : 0)
                <p class="text-muted">Total: <strong>{{ $totalReads }}</strong> kelas</p>
                @if($totalReads > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($lmsReads as $read)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $read->title }}</strong>
                                    <div class="text-muted small">Dibaca {{ \Carbon\Carbon::parse($read->read_at)->format('d/m/Y H:i') }}</div>
                                </div>
                                <a href="{{ route('anggota.academy.show', $read->slug) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-muted">Belum ada kelas yang dibaca.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
