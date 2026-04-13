@extends('admin.layouts.app')

@section('title', 'Struktur Organisasi')

@section('page-title', 'STRUKTUR ORGANISASI RTIK')

@section('styles')
<style>
    .struktur-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s, box-shadow 0.3s;
        border-left: 5px solid;
    }
    
    .struktur-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
    .jabatan-badge {
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-block;
        margin-bottom: 0.5rem;
    }
    
    .ketua-card { border-left-color: #dc3545; }
    .wakil-card { border-left-color: #fd7e14; }
    .sekretaris-card { border-left-color: #20c997; }
    .bendahara-card { border-left-color: #0dcaf0; }
    .bidang-card { border-left-color: #6f42c1; }
</style>
@endsection

@section('content')
    @php
        $user = Auth::guard('admin')->user();
        $isNasional = $user && $user->role === 'admin_nasional';
    @endphp

    @if($isNasional)
    <div class="mb-3 text-end">
        <a href="{{ route('admin.tentang.struktur.edit') }}" class="btn btn-primary"><i class="fas fa-edit me-2"></i>Edit Struktur</a>
    </div>
    @endif

    <!-- Ketua Umum -->
    <h3 class="mb-3"><i class="fas fa-user-tie me-2"></i>Pimpinan</h3>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="struktur-card ketua-card">
                <span class="jabatan-badge" style="background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);">Ketua Umum</span>
                <h5 class="mt-2 mb-1">{{ $struktur['ketua_umum']['nama'] ?? '-' }}</h5>
                <p class="text-muted mb-0"><i class="fas fa-envelope me-2"></i>{{ $struktur['ketua_umum']['email'] ?? '-' }}</p>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="struktur-card wakil-card">
                <span class="jabatan-badge" style="background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%);">Wakil Ketua</span>
                <h5 class="mt-2 mb-1">{{ $struktur['wakil_ketua']['nama'] ?? '-' }}</h5>
                <p class="text-muted mb-0"><i class="fas fa-envelope me-2"></i>{{ $struktur['wakil_ketua']['email'] ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Sekretaris & Bendahara -->
    <h3 class="mb-3 mt-4"><i class="fas fa-users me-2"></i>Sekretariat & Keuangan</h3>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="struktur-card sekretaris-card">
                <span class="jabatan-badge" style="background: linear-gradient(135deg, #20c997 0%, #0d6efd 100%);">Sekretaris</span>
                <h5 class="mt-2 mb-1">{{ $struktur['sekretaris']['nama'] ?? '-' }}</h5>
                <p class="text-muted mb-0"><i class="fas fa-envelope me-2"></i>{{ $struktur['sekretaris']['email'] ?? '-' }}</p>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="struktur-card bendahara-card">
                <span class="jabatan-badge" style="background: linear-gradient(135deg, #0dcaf0 0%, #17a2b8 100%);">Bendahara</span>
                <h5 class="mt-2 mb-1">{{ $struktur['bendahara']['nama'] ?? '-' }}</h5>
                <p class="text-muted mb-0"><i class="fas fa-envelope me-2"></i>{{ $struktur['bendahara']['email'] ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Bidang-Bidang -->
    <h3 class="mb-3 mt-4"><i class="fas fa-sitemap me-2"></i>Bidang-Bidang</h3>
    <div class="row">
        @foreach(['kesekretariatan', 'kemitraan_legal', 'program_aptika', 'penelitian_sdm', 'komunikasi_publik'] as $bidang)
            @if(isset($struktur[$bidang]) && count($struktur[$bidang]) > 0)
            <div class="col-md-6 mb-3">
                <div class="struktur-card bidang-card">
                    <span class="jabatan-badge">
                        @if($bidang == 'kesekretariatan') Bidang Kesekretariatan
                        @elseif($bidang == 'kemitraan_legal') Bidang Kemitraan & Legal
                        @elseif($bidang == 'program_aptika') Bidang Program & Aptika
                        @elseif($bidang == 'penelitian_sdm') Bidang Penelitian & Pengembangan SDM
                        @else Bidang Komunikasi Publik
                        @endif
                    </span>
                    @foreach($struktur[$bidang] as $anggota)
                        <h6 class="mt-2 mb-1">{{ $anggota['nama'] }}</h6>
                        <p class="text-muted mb-2"><i class="fas fa-envelope me-2"></i>{{ $anggota['email'] }}</p>
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
    </div>

    <!-- Info -->
    <div class="alert alert-info mt-4">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Catatan:</strong> Struktur organisasi ini diperbarui secara otomatis berdasarkan data jabatan anggota yang terdaftar dalam sistem.
    </div>
@endsection
