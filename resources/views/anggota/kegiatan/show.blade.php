@extends('anggota.layout')

@section('title', 'Detail Kegiatan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card bg-white shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0 fw-bold">{{ $kegiatan->judul }}</h4>
                    <span class="badge bg-{{ $kegiatan->status == 'Terlaksana' ? 'success' : ($kegiatan->status == 'Dibatalkan' ? 'danger' : 'warning') }} fs-6">
                        {{ $kegiatan->status }}
                    </span>
                </div>

                <div class="mb-4">
                    @if($kegiatan->dokumentasi)
                        <img src="{{ asset('storage/riwayat-kegiatan/' . basename($kegiatan->dokumentasi)) }}" class="img-fluid rounded w-100 mb-3" alt="Dokumentasi" style="max-height: 400px; object-fit: cover;">
                    @endif
                    <div class="p-3 bg-light rounded">
                        <p class="mb-0 text-secondary">{{ $kegiatan->deskripsi }}</p>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 border rounded">
                            <i class="fas fa-calendar fa-2x me-3 text-primary"></i>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Tanggal</small>
                                <strong class="fs-5">{{ $kegiatan->tanggal_kegiatan->translatedFormat('d F Y') }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 border rounded">
                            <i class="fas fa-clock fa-2x me-3 text-primary"></i>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Waktu</small>
                                <strong class="fs-5">{{ $kegiatan->waktu_mulai->format('H:i') }} - {{ $kegiatan->waktu_selesai->format('H:i') }} WIB</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 border rounded">
                            <i class="fas fa-map-marker-alt fa-2x me-3 text-primary"></i>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Lokasi</small>
                                <strong class="fs-5">{{ $kegiatan->lokasi }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 border rounded">
                            <i class="fas fa-user-tie fa-2x me-3 text-primary"></i>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.75rem;">Penyelenggara</small>
                                <strong class="fs-5">{{ $kegiatan->penyelenggara }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between border-top pt-3">
                    <a href="{{ route('anggota.kegiatan.calendar') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Kalender
                    </a>
                    <a href="{{ route('docs.app.docx') }}" class="btn btn-primary">
                        <i class="fas fa-file-word me-1"></i> Buka Dokumentasi (.docx)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
