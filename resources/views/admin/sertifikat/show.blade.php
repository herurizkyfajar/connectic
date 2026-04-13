@extends('admin.layouts.app')

@section('title', 'Detail Sertifikat')

@section('page-title', 'DETAIL SERTIFIKAT ANGGOTA')

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
        width: 180px;
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
    
    .certificate-box {
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
        color: white;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    .certificate-box i {
        font-size: 4rem;
        opacity: 0.9;
        margin-bottom: 1rem;
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="info-card">
                <div class="section-header">
                    <i class="fas fa-certificate"></i>
                    <h5>Informasi Sertifikat</h5>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-user"></i>Nama Anggota</div>
                    <div class="info-value">
                        <strong>{{ $sertifikat->anggota->nama }}</strong>
                        <br><small class="text-muted">{{ $sertifikat->anggota->email }}</small>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-calendar-alt"></i>Kegiatan</div>
                    <div class="info-value">
                        <strong>{{ $sertifikat->riwayatKegiatan->judul }}</strong>
                        <br><small class="text-muted">{{ $sertifikat->riwayatKegiatan->tanggal_kegiatan_formatted }}</small>
                    </div>
                </div>
                
                @if($sertifikat->nomor_sertifikat)
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-hashtag"></i>Nomor Sertifikat</div>
                    <div class="info-value"><code>{{ $sertifikat->nomor_sertifikat }}</code></div>
                </div>
                @endif
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-calendar-check"></i>Tanggal Terbit</div>
                    <div class="info-value">{{ $sertifikat->tanggal_terbit_formatted }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-building"></i>Penyelenggara</div>
                    <div class="info-value">{{ $sertifikat->penyelenggara }}</div>
                </div>
                
                @if($sertifikat->keterangan)
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-sticky-note"></i>Keterangan</div>
                    <div class="info-value">{{ $sertifikat->keterangan }}</div>
                </div>
                @endif
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-history"></i>Dibuat</div>
                    <div class="info-value">{{ $sertifikat->created_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-edit"></i>Diupdate</div>
                    <div class="info-value">{{ $sertifikat->updated_at->format('d/m/Y H:i') }}</div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.sertifikat.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.sertifikat.edit', $sertifikat->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <form action="{{ route('admin.sertifikat.destroy', $sertifikat->id) }}" 
                          method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus sertifikat ini?')">
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
            <div class="certificate-box">
                <i class="fas fa-award"></i>
                <h5>File Sertifikat</h5>
                @if($sertifikat->file_sertifikat)
                    <p class="mb-3"><i class="fas fa-file-pdf me-2"></i>{{ basename($sertifikat->file_sertifikat) }}</p>
                    <a href="{{ route('admin.sertifikat.download', $sertifikat->id) }}" 
                       class="btn btn-light">
                        <i class="fas fa-download me-2"></i>Download File
                    </a>
                @else
                    <p class="mb-0"><i class="fas fa-exclamation-circle me-2"></i>Belum ada file sertifikat</p>
                @endif
            </div>
            
            <div class="info-card">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i>
                    <h5>Informasi Tambahan</h5>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-user-tie"></i>Jabatan</div>
                    <div class="info-value">
                        @if($sertifikat->anggota->jabatan)
                            <span class="badge bg-info">{{ $sertifikat->anggota->jabatan }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-tags"></i>Jenis Kegiatan</div>
                    <div class="info-value">
                        <span class="badge bg-info">{{ $sertifikat->riwayatKegiatan->jenis_kegiatan }}</span>
                    </div>
                </div>
                
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('anggota.show', $sertifikat->anggota_id) }}" 
                       class="btn btn-primary flex-fill">
                        <i class="fas fa-user me-1"></i>Profil
                    </a>
                    <a href="{{ route('riwayat-kegiatan.show', $sertifikat->riwayat_kegiatan_id) }}" 
                       class="btn btn-primary flex-fill">
                        <i class="fas fa-calendar me-1"></i>Kegiatan
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
