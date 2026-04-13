<div class="sidebar">
    <div class="sidebar-header">
        <h5>ConnecTIK</h5>
    </div>
    
    <div class="profile-section">
        <div class="profile-avatar">
            <i class="fas fa-user-shield"></i>
        </div>
        <div>
            <strong>{{ Auth::guard('admin')->user()->name }}</strong>
            <div class="profile-email">{{ Auth::guard('admin')->user()->email }}</div>
        </div>
    </div>

    <div class="sidebar-nav">
        @php
            $user = Auth::guard('admin')->user();
            $role = optional($user)->role;
            $isPembina = $role === 'pembina';
            $isNasional = $role === 'admin_nasional';
            $isWilayah = $role === 'admin_wilayah';
            $isCabang = $role === 'admin_cabang';

            $anggotaCount = \App\Models\Anggota::count();
            $kegiatanCount = \App\Models\RiwayatKegiatan::count();
            
            if ($isCabang) {
                $anggotaCount = \App\Models\Anggota::where('parent_id_cabang', $user->id)->count();
                $kegiatanCount = \App\Models\RiwayatKegiatan::where('parent_id_cabang', $user->id)->count();
            } elseif ($isWilayah) {
                 $anggotaCount = \App\Models\Anggota::where('parent_id', $user->id)->count();
                 $kegiatanCount = \App\Models\RiwayatKegiatan::where('parent_id', $user->id)->count();
            }
        @endphp
        <div class="nav-section-title">Main Navigation</div>

        @if($isNasional)
            {{-- Menu khusus Admin Nasional --}}
            <a href="{{ route('admin.nasional.dashboard') }}" class="{{ request()->routeIs('admin.nasional.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.wilayah.index') }}" class="{{ request()->routeIs('admin.wilayah.*') ? 'active' : '' }}">
                <i class="fas fa-map-marked-alt"></i>
                <span>Kelola Wilayah</span>
            </a>
            <a href="{{ route('riwayat-kegiatan.index') }}" class="{{ request()->routeIs('riwayat-kegiatan.index') || request()->routeIs('riwayat-kegiatan.create') || request()->routeIs('riwayat-kegiatan.edit') || request()->routeIs('riwayat-kegiatan.show') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                <span>Kegiatan</span>
            </a>
            <a href="{{ route('riwayat-kegiatan.calendar') }}" class="{{ request()->routeIs('riwayat-kegiatan.calendar') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Kalender Kegiatan</span>
            </a>
            <a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Anggota</span>
            </a>
            <a href="{{ route('admin.lms.index') }}" class="{{ request()->routeIs('admin.lms.*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i>
                <span>LMS</span>
            </a>
            <a href="{{ route('admin.analisis-keaktifan') }}" class="{{ request()->routeIs('admin.analisis-keaktifan') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Analisis Keaktifan</span>
            </a>
            <a href="{{ route('admin.tentang.penjelasan') }}" class="{{ request()->routeIs('admin.tentang.penjelasan') ? 'active' : '' }}">
                <i class="fas fa-info-circle"></i>
                <span>Tentang RTIK</span>
            </a>
            <a href="{{ route('admin.tentang.struktur') }}" class="{{ request()->routeIs('admin.tentang.struktur') ? 'active' : '' }}">
                <i class="fas fa-sitemap"></i>
                <span>Struktur Organisasi</span>
            </a>
            <a href="{{ route('admin.nasional.account') }}" class="{{ request()->routeIs('admin.nasional.account') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i>
                <span>Kelola Akun</span>
            </a>
        @elseif($isWilayah)
            {{-- Menu khusus Admin Wilayah --}}
            <a href="{{ route('admin.wilayah.dashboard') }}" class="{{ request()->routeIs('admin.wilayah.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.wilayah.index') }}" class="{{ request()->routeIs('admin.wilayah.index') || request()->routeIs('admin.wilayah.create') || request()->routeIs('admin.wilayah.edit') || request()->routeIs('admin.wilayah.show') ? 'active' : '' }}">
                <i class="fas fa-map-marked-alt"></i>
                <span>Kelola Wilayah</span>
            </a>
            <a href="{{ route('riwayat-kegiatan.index') }}" class="{{ request()->routeIs('riwayat-kegiatan.index') || request()->routeIs('riwayat-kegiatan.create') || request()->routeIs('riwayat-kegiatan.edit') || request()->routeIs('riwayat-kegiatan.show') ? 'active' : '' }}">
                <i class="fas fa-list"></i>
                <span>Kegiatan</span>
            </a>
            <a href="{{ route('riwayat-kegiatan.calendar') }}" class="{{ request()->routeIs('riwayat-kegiatan.calendar') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Kalender Kegiatan</span>
            </a>
            <a href="{{ route('admin.analisis-keaktifan') }}" class="{{ request()->routeIs('admin.analisis-keaktifan') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Analisis Keaktifan</span>
            </a>
            <a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Kelola Anggota</span>
            </a>
            <a href="{{ route('admin.meeting-notes.index') }}" class="{{ request()->routeIs('admin.meeting-notes.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>Meeting Notes</span>
            </a>
            <a href="{{ route('pengajuan.index') }}" class="{{ request()->routeIs('pengajuan.*') ? 'active' : '' }}">
                <i class="fas fa-file-contract"></i>
                <span>Pengajuan</span>
            </a>
            <a href="{{ route('admin.keuangan.index') }}" class="{{ request()->routeIs('admin.keuangan.*') ? 'active' : '' }}">
                <i class="fas fa-wallet"></i>
                <span>Keuangan</span>
            </a>
            <a href="{{ route('admin.account.index') }}" class="{{ request()->routeIs('admin.account.*') ? 'active' : '' }}">
                <i class="fas fa-user-cog"></i>
                <span>Kelola Akun</span>
            </a>
        @else
            {{-- Menu Default Admin & Pembina --}}
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Anggota</span>
                <span class="badge">{{ $anggotaCount }}</span>
            </a>
            <a href="{{ route('riwayat-kegiatan.index') }}" class="{{ request()->routeIs('riwayat-kegiatan.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                <span>Kegiatan</span>
                <span class="badge">{{ $kegiatanCount }}</span>
            </a>
            @unless($isPembina)
                <a href="{{ route('admin.absensi.index') }}" class="{{ request()->routeIs('admin.absensi.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Absensi</span>
                </a>
                @if(Auth::guard('admin')->user()->role !== 'admin_cabang')
                    <a href="{{ route('admin.sertifikat.index') }}" class="{{ request()->routeIs('admin.sertifikat.*') ? 'active' : '' }}">
                        <i class="fas fa-certificate"></i>
                        <span>Sertifikat</span>
                    </a>
                @endif
                <a href="{{ route('admin.meeting-notes.index') }}" class="{{ request()->routeIs('admin.meeting-notes.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Meeting Notes</span>
                </a>
                <a href="{{ route('pengajuan.index') }}" class="{{ request()->routeIs('pengajuan.*') ? 'active' : '' }}">
                    <i class="fas fa-file-contract"></i>
                    <span>Pengajuan</span>
                </a>
                <a href="{{ route('admin.lms.index') }}" class="{{ request()->routeIs('admin.lms.*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap"></i>
                    <span>LMS</span>
                </a>
                <a href="{{ route('admin.keuangan.index') }}" class="{{ request()->routeIs('admin.keuangan.*') ? 'active' : '' }}">
                    <i class="fas fa-wallet"></i>
                    <span>Keuangan</span>
                </a>
            @endunless
            <a href="{{ route('admin.analisis-keaktifan') }}" class="{{ request()->routeIs('admin.analisis-keaktifan') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Analisis Keaktifan</span>
            </a>
            @unless($isPembina)
                <a href="{{ route('anggota-access.index') }}" class="{{ request()->routeIs('anggota-access.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i>
                    <span>Akses Anggota</span>
                </a>
                @if(Auth::guard('admin')->user()->role !== 'admin_cabang')
                    <a href="{{ route('admin.tentang.penjelasan') }}" class="{{ request()->routeIs('admin.tentang.*') ? 'active' : '' }}">
                        <i class="fas fa-info-circle"></i>
                        <span>Tentang RTIK</span>
                    </a>
                @endif
            @endunless
            <a href="{{ route('admin.absensi.ranking') }}" class="{{ request()->routeIs('admin.absensi.ranking') || request()->routeIs('admin.meeting-notes.ranking') ? 'active' : '' }}">
                <i class="fas fa-trophy"></i>
                <span>Ranking</span>
            </a>
        @endif
    </div>

    <div style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.1); margin-top: 20px;">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100" style="text-transform: none;">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </button>
        </form>
    </div>
</div>
