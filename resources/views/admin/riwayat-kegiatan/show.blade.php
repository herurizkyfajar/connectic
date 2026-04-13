@extends('admin.layouts.app')

@section('title', 'Detail Kegiatan')

@section('page-title', 'DETAIL KEGIATAN')

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
    
    .stat-box {
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
        color: white;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .stat-box h3 {
        font-size: 2.5rem;
        margin: 0;
        font-weight: 600;
    }
    
    .stat-box p {
        margin: 0;
        opacity: 0.9;
    }
    
    .avatar-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
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
        <!-- Left Column: Detail Kegiatan -->
        <div class="col-lg-8">
            <div class="info-card">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i>
                    <h5>Detail Kegiatan</h5>
                </div>
                
                <h3 class="mb-4">{{ $riwayatKegiatan->judul }}</h3>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-calendar"></i>Tanggal</div>
                    <div class="info-value">{{ $riwayatKegiatan->tanggal_kegiatan_formatted }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-clock"></i>Waktu</div>
                    <div class="info-value">
                        {{ $riwayatKegiatan->waktu_mulai }} - {{ $riwayatKegiatan->waktu_selesai }}
                        <small class="text-muted ms-2">({{ $riwayatKegiatan->durasi }})</small>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-map-marker-alt"></i>Lokasi</div>
                    <div class="info-value">{{ $riwayatKegiatan->lokasi }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-tags"></i>Jenis Kegiatan</div>
                    <div class="info-value">
                        <span class="badge bg-info">{{ $riwayatKegiatan->jenis_kegiatan }}</span>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-building"></i>Penyelenggara</div>
                    <div class="info-value">{{ $riwayatKegiatan->penyelenggara }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-toggle-on"></i>Status</div>
                    <div class="info-value">
                        <span class="badge {{ $riwayatKegiatan->status == 'Terlaksana' ? 'bg-success' : ($riwayatKegiatan->status == 'Dibatalkan' ? 'bg-danger' : 'bg-warning') }}">
                            {{ $riwayatKegiatan->status }}
                        </span>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-align-left"></i>Deskripsi</div>
                    <div class="info-value">{{ $riwayatKegiatan->deskripsi }}</div>
                </div>
                
                @if($riwayatKegiatan->catatan)
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-sticky-note"></i>Catatan</div>
                    <div class="info-value">{{ $riwayatKegiatan->catatan }}</div>
                </div>
                @endif
                
                @if($riwayatKegiatan->dokumentasi)
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-file"></i>Dokumentasi</div>
                    <div class="info-value">
                        <a href="{{ route('riwayat-kegiatan.download', $riwayatKegiatan->id) }}" 
                           class="btn btn-sm btn-primary">
                            <i class="fas fa-download me-1"></i>Download File
                        </a>
                    </div>
                </div>
                @endif
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('riwayat-kegiatan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('riwayat-kegiatan.edit', $riwayatKegiatan->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <form action="{{ route('riwayat-kegiatan.destroy', $riwayatKegiatan->id) }}" 
                          method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Daftar Peserta -->
            <div class="info-card">
                <div class="section-header">
                    <i class="fas fa-users"></i>
                    <h5>Daftar Peserta ({{ $totalPeserta }})</h5>
                </div>
                
                @if($pesertaKegiatan->isEmpty())
                    <div class="text-center py-4">
                        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada peserta terdaftar untuk kegiatan ini</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Status Kehadiran</th>
                                    <th>Waktu Absen</th>
                                    <th>Peran</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pesertaKegiatan as $index => $absensi)
                                    <tr>
                                        <td>{{ $pesertaKegiatan->firstItem() + $index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($absensi->anggota->foto)
                                                    <img src="{{ asset('storage/anggotas/' . $absensi->anggota->foto) }}" 
                                                         alt="{{ $absensi->anggota->nama }}"
                                                         class="avatar-sm me-2">
                                                @else
                                                    <div class="avatar-sm bg-secondary d-flex align-items-center justify-content-center me-2">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <strong>{{ $absensi->anggota->nama }}</strong>
                                                    <br><small class="text-muted">{{ $absensi->anggota->email }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $absensi->status_kehadiran == 'Hadir' ? 'bg-success' : ($absensi->status_kehadiran == 'Tidak Hadir' ? 'bg-danger' : 'bg-warning') }}">
                                                {{ $absensi->status_kehadiran }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ \Carbon\Carbon::parse($absensi->waktu_absen)->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $absensi->ikut_serta_sebagai == 'Lainnya' ? $absensi->ikut_serta_lainnya : $absensi->ikut_serta_sebagai }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.absensi.show', $absensi->id) }}" 
                                               class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $pesertaKegiatan->links() }}
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Right Column: Stats & Actions -->
        <div class="col-lg-4">
            <div class="stat-box">
                <h3>{{ $totalPeserta }}</h3>
                <p><i class="fas fa-users me-2"></i>Total Peserta</p>
            </div>
            
            <div class="info-card">
                <h6 class="mb-3"><i class="fas fa-chart-pie me-2"></i>Statistik Kehadiran</h6>
                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span><i class="fas fa-check-circle text-success me-1"></i>Hadir</span>
                        <strong>{{ $jumlahHadir }} orang</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ $totalPeserta > 0 ? ($jumlahHadir/$totalPeserta)*100 : 0 }}%"></div>
                    </div>
                </div>
                
                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span><i class="fas fa-times-circle text-danger me-1"></i>Tidak Hadir</span>
                        <strong>{{ $jumlahTidakHadir }} orang</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger" style="width: {{ $totalPeserta > 0 ? ($jumlahTidakHadir/$totalPeserta)*100 : 0 }}%"></div>
                    </div>
                </div>
                
                <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span><i class="fas fa-exclamation-circle text-warning me-1"></i>Izin/Sakit</span>
                        <strong>{{ $jumlahIzin + $jumlahSakit }} orang</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: {{ $totalPeserta > 0 ? (($jumlahIzin + $jumlahSakit)/$totalPeserta)*100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="info-card">
                <h6 class="mb-3"><i class="fas fa-clock me-2"></i>Informasi Waktu</h6>
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-plus-circle"></i>Dibuat</div>
                    <div class="info-value">
                        <small>{{ $riwayatKegiatan->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label"><i class="fas fa-edit"></i>Diupdate</div>
                    <div class="info-value">
                        <small>{{ $riwayatKegiatan->updated_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
