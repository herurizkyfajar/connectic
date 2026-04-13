@extends('admin.layouts.app')

@section('title', 'Edit Tentang RTIK')

@section('page-title', 'EDIT TENTANG RTIK')

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
</style>
@endsection

@section('content')
<form action="{{ route('admin.tentang.update') }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Intro Card -->
    <div class="content-box">
        <h5 class="mb-3">Pendahuluan</h5>
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="content[intro_title]" class="form-control" value="{{ $data['intro_title'] ?? 'Ruang Teknologi Informasi dan Komunikasi' }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Sub Judul</label>
            <input type="text" name="content[intro_subtitle]" class="form-control" value="{{ $data['intro_subtitle'] ?? 'Kabupaten Buton Tengah' }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="content[intro_desc]" class="form-control" rows="3">{{ $data['intro_desc'] ?? 'RTIK (Ruang Teknologi Informasi dan Komunikasi) Kabupaten Buton Tengah adalah organisasi yang berfokus pada pengembangan dan pemanfaatan teknologi informasi dan komunikasi untuk kemajuan daerah.' }}</textarea>
        </div>
    </div>

    <!-- Visi -->
    <h3 class="section-title"><i class="fas fa-eye me-2"></i>Visi</h3>
    <div class="content-box">
        <textarea name="content[visi]" class="form-control" rows="3">{{ $data['visi'] ?? '"Mewujudkan Kabupaten Buton Tengah yang maju dan sejahtera melalui pemanfaatan teknologi informasi dan komunikasi yang optimal"' }}</textarea>
    </div>

    <!-- Misi -->
    <h3 class="section-title"><i class="fas fa-bullseye me-2"></i>Misi</h3>
    <div class="content-box">
        <div id="misi-container">
            @php
                $misis = $data['misi'] ?? [
                    'Meningkatkan literasi digital masyarakat Kabupaten Buton Tengah',
                    'Mengembangkan infrastruktur teknologi informasi dan komunikasi yang merata',
                    'Mendorong inovasi berbasis teknologi untuk peningkatan pelayanan publik',
                    'Memfasilitasi kolaborasi antar stakeholder dalam pengembangan TIK',
                    'Menciptakan ekosistem digital yang mendukung pertumbuhan ekonomi lokal'
                ];
            @endphp
            @foreach($misis as $index => $misi)
            <div class="input-group mb-2">
                <input type="text" name="content[misi][]" class="form-control" value="{{ $misi }}">
                <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">Hapus</button>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addMisi()">+ Tambah Misi</button>
    </div>

    <!-- Tujuan -->
    <h3 class="section-title"><i class="fas fa-flag-checkered me-2"></i>Tujuan</h3>
    <div class="content-box">
        <div id="tujuan-container">
            @php
                $tujuans = $data['tujuan'] ?? [
                    'Meningkatkan kompetensi SDM dalam bidang teknologi informasi dan komunikasi',
                    'Menyediakan akses internet yang merata di seluruh wilayah kabupaten',
                    'Mengembangkan aplikasi dan sistem informasi untuk mendukung pemerintahan digital',
                    'Membangun kemitraan strategis dengan berbagai pihak untuk pengembangan TIK',
                    'Mendorong transformasi digital dalam berbagai sektor kehidupan masyarakat'
                ];
            @endphp
            @foreach($tujuans as $index => $tujuan)
            <div class="input-group mb-2">
                <input type="text" name="content[tujuan][]" class="form-control" value="{{ $tujuan }}">
                <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">Hapus</button>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addTujuan()">+ Tambah Tujuan</button>
    </div>

    <!-- Bidang Kegiatan -->
    <h3 class="section-title"><i class="fas fa-tasks me-2"></i>Bidang Kegiatan</h3>
    <div id="bidang-container">
        @php
            $bidangs = $data['bidang_kegiatan'] ?? [
                ['title' => 'Pelatihan & Edukasi', 'desc' => 'Menyelenggarakan berbagai program pelatihan dan workshop untuk meningkatkan kemampuan masyarakat dalam bidang TIK.', 'icon' => 'fas fa-graduation-cap'],
                ['title' => 'Pengembangan Aplikasi', 'desc' => 'Mengembangkan berbagai aplikasi dan sistem informasi untuk mendukung pelayanan publik dan administrasi pemerintahan.', 'icon' => 'fas fa-code'],
                ['title' => 'Infrastruktur TIK', 'desc' => 'Membangun dan mengembangkan infrastruktur teknologi informasi yang handal dan merata di seluruh wilayah.', 'icon' => 'fas fa-network-wired'],
                ['title' => 'Kolaborasi & Kemitraan', 'desc' => 'Menjalin kerjasama dengan berbagai pihak untuk mengoptimalkan pemanfaatan TIK di Kabupaten Buton Tengah.', 'icon' => 'fas fa-handshake']
            ];
        @endphp
        @foreach($bidangs as $index => $bidang)
        <div class="content-box mb-3 bidang-item">
            <div class="d-flex justify-content-between mb-2">
                <h6>Bidang {{ $index + 1 }}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.bidang-item').remove()">Hapus</button>
            </div>
            <div class="mb-2">
                <label class="form-label">Judul</label>
                <input type="text" name="content[bidang_kegiatan][{{ $index }}][title]" class="form-control" value="{{ $bidang['title'] }}">
            </div>
            <div class="mb-2">
                <label class="form-label">Deskripsi</label>
                <textarea name="content[bidang_kegiatan][{{ $index }}][desc]" class="form-control" rows="2">{{ $bidang['desc'] }}</textarea>
            </div>
            <div class="mb-2">
                <label class="form-label">Icon (FontAwesome Class)</label>
                <input type="text" name="content[bidang_kegiatan][{{ $index }}][icon]" class="form-control" value="{{ $bidang['icon'] }}">
            </div>
        </div>
        @endforeach
    </div>
    <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addBidang()">+ Tambah Bidang</button>

    <div class="mt-4 mb-5">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
        <a href="{{ route('admin.tentang.penjelasan') }}" class="btn btn-secondary">Batal</a>
    </div>
</form>

<script>
    function addMisi() {
        const container = document.getElementById('misi-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" name="content[misi][]" class="form-control" placeholder="Misi baru">
            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">Hapus</button>
        `;
        container.appendChild(div);
    }

    function addTujuan() {
        const container = document.getElementById('tujuan-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" name="content[tujuan][]" class="form-control" placeholder="Tujuan baru">
            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">Hapus</button>
        `;
        container.appendChild(div);
    }

    let bidangIndex = {{ count($bidangs) }};
    function addBidang() {
        const container = document.getElementById('bidang-container');
        const div = document.createElement('div');
        div.className = 'content-box mb-3 bidang-item';
        div.innerHTML = `
            <div class="d-flex justify-content-between mb-2">
                <h6>Bidang Baru</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('.bidang-item').remove()">Hapus</button>
            </div>
            <div class="mb-2">
                <label class="form-label">Judul</label>
                <input type="text" name="content[bidang_kegiatan][${bidangIndex}][title]" class="form-control">
            </div>
            <div class="mb-2">
                <label class="form-label">Deskripsi</label>
                <textarea name="content[bidang_kegiatan][${bidangIndex}][desc]" class="form-control" rows="2"></textarea>
            </div>
            <div class="mb-2">
                <label class="form-label">Icon (FontAwesome Class)</label>
                <input type="text" name="content[bidang_kegiatan][${bidangIndex}][icon]" class="form-control" value="fas fa-circle">
            </div>
        `;
        container.appendChild(div);
        bidangIndex++;
    }
</script>
@endsection
