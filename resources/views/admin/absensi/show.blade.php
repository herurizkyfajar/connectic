@extends('admin.layouts.app')

@section('title', 'Detail Absensi')

@section('page-title', 'DETAIL ABSENSI KEGIATAN')

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
    
    .avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #1976d2;
    }
</style>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="info-card">
                <div class="section-header">
                    <i class="fas fa-user-check"></i>
                    <h5>Informasi Absensi</h5>
                </div>
                
                <!-- Anggota Info -->
                <div class="text-center mb-4">
                    @if($absensiKegiatan->anggota->foto)
                        <img src="{{ asset('storage/anggotas/' . $absensiKegiatan->anggota->foto) }}" 
                             alt="{{ $absensiKegiatan->anggota->nama }}" class="avatar mb-3">
                    @else
                        <div class="avatar bg-secondary d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="fas fa-user fa-2x text-white"></i>
                        </div>
                    @endif
                    <h4 class="mb-1">{{ $absensiKegiatan->anggota->nama }}</h4>
                    <p class="text-muted">{{ $absensiKegiatan->anggota->email }}</p>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-calendar"></i>Kegiatan</div>
                    <div class="info-value">
                        <strong>{{ $absensiKegiatan->riwayatKegiatan->judul }}</strong>
                        <br><small class="text-muted">{{ $absensiKegiatan->riwayatKegiatan->tanggal_kegiatan_formatted }}</small>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-user-tag"></i>Ikut Serta Sebagai</div>
                    <div class="info-value">
                        <span class="badge bg-info">
                            {{ $absensiKegiatan->ikut_serta_sebagai == 'Lainnya' ? $absensiKegiatan->ikut_serta_lainnya : $absensiKegiatan->ikut_serta_sebagai }}
                        </span>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-toggle-on"></i>Status Kehadiran</div>
                    <div class="info-value">
                        <span class="badge {{ $absensiKegiatan->status_kehadiran == 'Hadir' ? 'bg-success' : ($absensiKegiatan->status_kehadiran == 'Tidak Hadir' ? 'bg-danger' : 'bg-warning') }}">
                            {{ $absensiKegiatan->status_kehadiran }}
                        </span>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-clock"></i>Waktu Absen</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($absensiKegiatan->waktu_absen)->format('d/m/Y H:i:s') }}</div>
                </div>
                
                @if($absensiKegiatan->metode_absensi)
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-fingerprint"></i>Metode Absensi</div>
                    <div class="info-value">{{ $absensiKegiatan->metode_absensi }}</div>
                </div>
                @endif
                
                @if($absensiKegiatan->lokasi_absensi)
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-map-marker-alt"></i>Lokasi Absensi</div>
                    <div class="info-value">{{ $absensiKegiatan->lokasi_absensi }}</div>
                </div>
                @endif
                
                @if($absensiKegiatan->keterangan)
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-sticky-note"></i>Keterangan</div>
                    <div class="info-value">{{ $absensiKegiatan->keterangan }}</div>
                </div>
                @endif
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-history"></i>Dibuat</div>
                    <div class="info-value">{{ $absensiKegiatan->created_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-edit"></i>Diupdate</div>
                    <div class="info-value">{{ $absensiKegiatan->updated_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('riwayat-kegiatan.show', $absensiKegiatan->riwayat_kegiatan_id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Kegiatan
                    </a>
                    <a href="{{ route('admin.absensi.edit', $absensiKegiatan->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <form action="{{ route('admin.absensi.destroy', $absensiKegiatan->id) }}" 
                          method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus absensi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="info-card">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i>
                    <h5>Informasi Anggota</h5>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-phone"></i>Telepon</div>
                    <div class="info-value">{{ $absensiKegiatan->anggota->telepon }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-briefcase"></i>Pekerjaan</div>
                    <div class="info-value">{{ $absensiKegiatan->anggota->pekerjaan ?? '-' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-user-tie"></i>Jabatan</div>
                    <div class="info-value">
                        @if($absensiKegiatan->anggota->jabatan)
                            <span class="badge bg-info">{{ $absensiKegiatan->anggota->jabatan }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                </div>
                
                <div class="mt-3">
                    <a href="{{ route('anggota.show', $absensiKegiatan->anggota_id) }}" class="btn btn-primary w-100">
                        <i class="fas fa-user me-2"></i>Lihat Profil Lengkap
                    </a>
                </div>
            </div>
            
            <div class="info-card">
                <div class="section-header">
                    <i class="fas fa-calendar-check"></i>
                    <h5>Informasi Kegiatan</h5>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-tags"></i>Jenis</div>
                    <div class="info-value">
                        <span class="badge bg-info">{{ $absensiKegiatan->riwayatKegiatan->jenis_kegiatan }}</span>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-building"></i>Penyelenggara</div>
                    <div class="info-value">{{ $absensiKegiatan->riwayatKegiatan->penyelenggara }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-map-marker-alt"></i>Lokasi</div>
                    <div class="info-value">{{ $absensiKegiatan->riwayatKegiatan->lokasi }}</div>
                </div>
                
                <div class="mt-3">
                    <a href="{{ route('riwayat-kegiatan.show', $absensiKegiatan->riwayat_kegiatan_id) }}" class="btn btn-primary w-100">
                        <i class="fas fa-eye me-2"></i>Lihat Detail Kegiatan
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
