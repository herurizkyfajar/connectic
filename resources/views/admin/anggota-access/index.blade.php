@extends('admin.layouts.app')

@section('title', 'Kelola Akses Anggota')

@section('page-title', 'KELOLA AKSES ANGGOTA')

@section('styles')
<style>
    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border-left: 4px solid;
        text-align: center;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    .stat-card.primary { border-left-color: #1976d2; }
    .stat-card.success { border-left-color: #4caf50; }
    .stat-card.danger { border-left-color: #f44336; }
    .stat-card h3 {
        font-size: 2rem;
        font-weight: 600;
        margin: 0;
        color: #212121;
    }
    .stat-card p {
        margin: 0;
        color: #757575;
        font-size: 0.875rem;
    }
    .table tbody tr:hover { background-color: #f8f9fa; }
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

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stat-card primary">
                <h3>{{ $totalAnggota }}</h3>
                <p><i class="fas fa-users me-2"></i>Total Anggota</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card success">
                <h3>{{ $totalWithAccess }}</h3>
                <p><i class="fas fa-check-circle me-2"></i>Memiliki Akses</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card danger">
                <h3>{{ $totalWithoutAccess }}</h3>
                <p><i class="fas fa-times-circle me-2"></i>Belum Memiliki Akses</p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-key me-2"></i>Daftar Anggota & Status Akses
            </h5>
        </div>
        <div class="card-body">
            @if($anggotas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Status Akses</th>
                                <th class="text-center">Kelas Dibaca</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anggotas as $index => $anggota)
                                <tr>
                                    <td>{{ $anggotas->firstItem() + $index }}</td>
                                    <td><strong>{{ $anggota->nama }}</strong></td>
                                    <td>{{ $anggota->email }}</td>
                                    <td>
                                        @if($anggota->jabatan)
                                            <span class="badge bg-info">{{ $anggota->jabatan }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $anggota->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $anggota->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($anggota->status == 'Aktif')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle"></i> Tidak Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php($readCount = \Illuminate\Support\Facades\DB::table('lms_reads')->where('anggota_id', $anggota->id)->count())
                                        <span class="badge bg-info">{{ $readCount }} kelas</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('anggota.show', $anggota->id) }}" 
                                           class="btn btn-sm btn-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('anggota-access.toggle-status', $anggota->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @if($anggota->status == 'Aktif')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        title="Nonaktifkan Akses"
                                                        onclick="return confirm('Yakin ingin menonaktifkan akses anggota ini?')">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @else
                                                <button type="submit" 
                                                        class="btn btn-sm btn-success" 
                                                        title="Aktifkan Akses"
                                                        onclick="return confirm('Yakin ingin mengaktifkan akses anggota ini?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </form>
                                        <button type="button" 
                                                class="btn btn-sm btn-warning" 
                                                title="Reset Password"
                                                onclick="resetPassword({{ $anggota->id }}, '{{ $anggota->nama }}')">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $anggotas->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data anggota</h5>
                </div>
            @endif
        </div>
    </div>

    <div class="alert alert-info mt-4">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Info:</strong> Anggota yang memiliki akses dapat login ke sistem dan mengakses fitur-fitur yang tersedia untuk anggota.
    </div>

    <!-- Hidden form for reset password -->
    <form id="resetPasswordForm" method="POST" style="display: none;">
        @csrf
    </form>
@endsection

@section('scripts')
<script>
    function resetPassword(anggotaId, anggotaNama) {
        if (confirm(`Yakin ingin mereset password untuk ${anggotaNama}?\nPassword akan direset ke: password123`)) {
            const form = document.getElementById('resetPasswordForm');
            form.action = `/admin/anggota-access/reset-password/${anggotaId}`;
            form.submit();
        }
    }
</script>
@endsection
