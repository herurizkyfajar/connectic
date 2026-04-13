@extends('admin.layouts.app')

@section('title', 'Tentang RTIK')

@section('page-title', 'TENTANG RTIK KABUPATEN BUTON TENGAH')

@section('styles')
<style>
    .content-box {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        border-left: 4px solid #1976d2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .section-title {
        color: #1976d2;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 3px solid #1976d2;
    }
    
    .icon-box {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    
    .list-custom {
        list-style: none;
        padding: 0;
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
        color: #1976d2;
        font-weight: bold;
        font-size: 1.2rem;
    }
</style>
@endsection

@section('content')
    @php
        $data = $pageContent ? $pageContent->content : [];
        $user = Auth::guard('admin')->user();
        $isNasional = $user && $user->role === 'admin_nasional';
    @endphp

    @if($isNasional)
    <div class="mb-3 text-end">
        <a href="{{ route('admin.tentang.edit') }}" class="btn btn-primary"><i class="fas fa-edit me-2"></i>Edit Konten</a>
    </div>
    @endif

    <!-- Intro Card -->
    <div class="content-box">
        <div class="d-flex align-items-center mb-3">
            <div class="icon-box">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <h4 class="mb-0">{{ $data['intro_title'] ?? 'Ruang Teknologi Informasi dan Komunikasi' }}</h4>
                <p class="text-muted mb-0">{{ $data['intro_subtitle'] ?? 'Kabupaten Buton Tengah' }}</p>
            </div>
        </div>
        <p class="lead">
            {{ $data['intro_desc'] ?? 'RTIK (Ruang Teknologi Informasi dan Komunikasi) Kabupaten Buton Tengah adalah organisasi yang berfokus pada pengembangan dan pemanfaatan teknologi informasi dan komunikasi untuk kemajuan daerah.' }}
        </p>
    </div>

    <!-- Visi -->
    <h3 class="section-title"><i class="fas fa-eye me-2"></i>Visi</h3>
    <div class="content-box">
        <p class="mb-0 fw-bold text-center" style="font-size: 1.1rem; color: #424242;">
            {{ $data['visi'] ?? '"Mewujudkan Kabupaten Buton Tengah yang maju dan sejahtera melalui pemanfaatan teknologi informasi dan komunikasi yang optimal"' }}
        </p>
    </div>

    <!-- Misi -->
    <h3 class="section-title"><i class="fas fa-bullseye me-2"></i>Misi</h3>
    <div class="content-box">
        <ul class="list-custom">
            @php
                $misis = $data['misi'] ?? [
                    'Meningkatkan literasi digital masyarakat Kabupaten Buton Tengah',
                    'Mengembangkan infrastruktur teknologi informasi dan komunikasi yang merata',
                    'Mendorong inovasi berbasis teknologi untuk peningkatan pelayanan publik',
                    'Memfasilitasi kolaborasi antar stakeholder dalam pengembangan TIK',
                    'Menciptakan ekosistem digital yang mendukung pertumbuhan ekonomi lokal'
                ];
            @endphp
            @foreach($misis as $misi)
                <li>{{ $misi }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Tujuan -->
    <h3 class="section-title"><i class="fas fa-flag-checkered me-2"></i>Tujuan</h3>
    <div class="content-box">
        <ul class="list-custom">
            @php
                $tujuans = $data['tujuan'] ?? [
                    'Meningkatkan kompetensi SDM dalam bidang teknologi informasi dan komunikasi',
                    'Menyediakan akses internet yang merata di seluruh wilayah kabupaten',
                    'Mengembangkan aplikasi dan sistem informasi untuk mendukung pemerintahan digital',
                    'Membangun kemitraan strategis dengan berbagai pihak untuk pengembangan TIK',
                    'Mendorong transformasi digital dalam berbagai sektor kehidupan masyarakat'
                ];
            @endphp
            @foreach($tujuans as $tujuan)
                <li>{{ $tujuan }}</li>
            @endforeach
        </ul>
    </div>

    <!-- Bidang Kegiatan -->
    <h3 class="section-title"><i class="fas fa-tasks me-2"></i>Bidang Kegiatan</h3>
    <div class="row">
        @php
            $bidangs = $data['bidang_kegiatan'] ?? [
                ['title' => 'Pelatihan & Edukasi', 'desc' => 'Menyelenggarakan berbagai program pelatihan dan workshop untuk meningkatkan kemampuan masyarakat dalam bidang TIK.', 'icon' => 'fas fa-graduation-cap'],
                ['title' => 'Pengembangan Aplikasi', 'desc' => 'Mengembangkan berbagai aplikasi dan sistem informasi untuk mendukung pelayanan publik dan administrasi pemerintahan.', 'icon' => 'fas fa-code'],
                ['title' => 'Infrastruktur TIK', 'desc' => 'Membangun dan mengembangkan infrastruktur teknologi informasi yang handal dan merata di seluruh wilayah.', 'icon' => 'fas fa-network-wired'],
                ['title' => 'Kolaborasi & Kemitraan', 'desc' => 'Menjalin kerjasama dengan berbagai pihak untuk mengoptimalkan pemanfaatan TIK di Kabupaten Buton Tengah.', 'icon' => 'fas fa-handshake']
            ];
        @endphp
        @foreach($bidangs as $bidang)
        <div class="col-md-6 mb-3">
            <div class="content-box">
                <h5 class="mb-3"><i class="{{ $bidang['icon'] ?? 'fas fa-circle' }} text-primary me-2"></i>{{ $bidang['title'] }}</h5>
                <p class="mb-0">{{ $bidang['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Info -->
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Informasi:</strong> Untuk bergabung atau mendapatkan informasi lebih lanjut tentang RTIK Kabupaten Buton Tengah, 
        silakan hubungi admin atau kunjungi kantor kami.
    </div>
@endsection
