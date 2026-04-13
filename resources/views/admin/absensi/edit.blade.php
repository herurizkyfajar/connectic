@extends('admin.layouts.app')

@section('title', 'Edit Absensi')

@section('page-title', 'EDIT ABSENSI')

@section('styles')
<style>
    .form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .form-section {
        padding: 1.5rem;
        border-bottom: 1px solid #eee;
    }
    .form-section:last-child {
        border-bottom: none;
    }
    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2196F3;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #2196F3;
    }
    .form-label {
        font-weight: 500;
        color: #424242;
        margin-bottom: 0.5rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #2196F3;
        box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
    }
    .btn-primary {
        background: linear-gradient(135deg, #2196F3 0%, #64B5F6 100%);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
    }
    .text-muted {
        font-size: 0.875rem;
    }
</style>
@endsection

@section('content')
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading"><i class="fas fa-exclamation-circle me-2"></i>Validation Error!</h5>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-card">
                <form method="POST" action="{{ route('admin.absensi.update', $absensiKegiatan->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Anggota & Kegiatan Section -->
                    <div class="form-section">
                        <h5 class="form-section-title">
                            <i class="fas fa-user me-2"></i>Informasi Anggota & Kegiatan
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="anggota_id" class="form-label">Anggota <span class="text-danger">*</span></label>
                                <select class="form-select @error('anggota_id') is-invalid @enderror" 
                                        id="anggota_id" 
                                        name="anggota_id" 
                                        required>
                                    <option value="">Pilih Anggota</option>
                                    @foreach($anggotas as $anggota)
                                        <option value="{{ $anggota->id }}" {{ old('anggota_id', $absensiKegiatan->anggota_id) == $anggota->id ? 'selected' : '' }}>
                                            {{ $anggota->nama }} - {{ $anggota->email }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('anggota_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="riwayat_kegiatan_id" class="form-label">Kegiatan <span class="text-danger">*</span></label>
                                <select class="form-select @error('riwayat_kegiatan_id') is-invalid @enderror" 
                                        id="riwayat_kegiatan_id" 
                                        name="riwayat_kegiatan_id" 
                                        required>
                                    <option value="">Pilih Kegiatan</option>
                                    @foreach($riwayatKegiatans as $kegiatan)
                                        <option value="{{ $kegiatan->id }}" {{ old('riwayat_kegiatan_id', $absensiKegiatan->riwayat_kegiatan_id) == $kegiatan->id ? 'selected' : '' }}>
                                            {{ $kegiatan->judul }} - {{ $kegiatan->tanggal_kegiatan_formatted }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('riwayat_kegiatan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status & Peran Section -->
                    <div class="form-section">
                        <h5 class="form-section-title">
                            <i class="fas fa-clipboard-check me-2"></i>Status & Peran
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="status_kehadiran" class="form-label">Status Kehadiran <span class="text-danger">*</span></label>
                                <select class="form-select @error('status_kehadiran') is-invalid @enderror" 
                                        id="status_kehadiran" 
                                        name="status_kehadiran" 
                                        required>
                                    <option value="">Pilih Status</option>
                                    <option value="Hadir" {{ old('status_kehadiran', $absensiKegiatan->status_kehadiran) == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="Tidak Hadir" {{ old('status_kehadiran', $absensiKegiatan->status_kehadiran) == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                    <option value="Izin" {{ old('status_kehadiran', $absensiKegiatan->status_kehadiran) == 'Izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="Sakit" {{ old('status_kehadiran', $absensiKegiatan->status_kehadiran) == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                </select>
                                @error('status_kehadiran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="ikut_serta_sebagai" class="form-label">Ikut Serta Sebagai <span class="text-danger">*</span></label>
                                <select class="form-select @error('ikut_serta_sebagai') is-invalid @enderror" 
                                        id="ikut_serta_sebagai" 
                                        name="ikut_serta_sebagai" 
                                        required>
                                    <option value="">Pilih Peran</option>
                                    <option value="Peserta" {{ old('ikut_serta_sebagai', $absensiKegiatan->ikut_serta_sebagai) == 'Peserta' ? 'selected' : '' }}>Peserta</option>
                                    <option value="Panitia" {{ old('ikut_serta_sebagai', $absensiKegiatan->ikut_serta_sebagai) == 'Panitia' ? 'selected' : '' }}>Panitia</option>
                                    <option value="Narasumber" {{ old('ikut_serta_sebagai', $absensiKegiatan->ikut_serta_sebagai) == 'Narasumber' ? 'selected' : '' }}>Narasumber</option>
                                    <option value="Lainnya" {{ old('ikut_serta_sebagai', $absensiKegiatan->ikut_serta_sebagai) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('ikut_serta_sebagai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3" id="lainnya_container" style="display: {{ old('ikut_serta_sebagai', $absensiKegiatan->ikut_serta_sebagai) == 'Lainnya' ? 'block' : 'none' }};">
                                <label for="ikut_serta_lainnya" class="form-label">Sebutkan Peran Lainnya <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('ikut_serta_lainnya') is-invalid @enderror" 
                                       id="ikut_serta_lainnya" 
                                       name="ikut_serta_lainnya" 
                                       value="{{ old('ikut_serta_lainnya', $absensiKegiatan->ikut_serta_lainnya) }}"
                                       placeholder="Misal: Moderator, Dokumentasi, dll">
                                @error('ikut_serta_lainnya')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Detail Absensi Section -->
                    <div class="form-section">
                        <h5 class="form-section-title">
                            <i class="fas fa-info-circle me-2"></i>Detail Absensi
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="waktu_absen" class="form-label">Waktu Absen <span class="text-danger">*</span></label>
                                <input type="datetime-local" 
                                       class="form-control @error('waktu_absen') is-invalid @enderror" 
                                       id="waktu_absen" 
                                       name="waktu_absen" 
                                       value="{{ old('waktu_absen', $absensiKegiatan->waktu_absen ? \Carbon\Carbon::parse($absensiKegiatan->waktu_absen)->format('Y-m-d\TH:i') : '') }}"
                                       required>
                                @error('waktu_absen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="metode_absensi" class="form-label">Metode Absensi</label>
                                <input type="text" 
                                       class="form-control @error('metode_absensi') is-invalid @enderror" 
                                       id="metode_absensi" 
                                       name="metode_absensi" 
                                       value="{{ old('metode_absensi', $absensiKegiatan->metode_absensi) }}"
                                       placeholder="Misal: QR Code, Manual, dll">
                                @error('metode_absensi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="lokasi_absensi" class="form-label">Lokasi Absensi</label>
                                <input type="text" 
                                       class="form-control @error('lokasi_absensi') is-invalid @enderror" 
                                       id="lokasi_absensi" 
                                       name="lokasi_absensi" 
                                       value="{{ old('lokasi_absensi', $absensiKegiatan->lokasi_absensi) }}"
                                       placeholder="Lokasi saat absen">
                                @error('lokasi_absensi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-8 mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                          id="keterangan" 
                                          name="keterangan" 
                                          rows="3" 
                                          placeholder="Tambahkan keterangan jika diperlukan...">{{ old('keterangan', $absensiKegiatan->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="bukti_kehadiran" class="form-label">Bukti Kehadiran</label>
                                <input type="file" 
                                       class="form-control @error('bukti_kehadiran') is-invalid @enderror" 
                                       id="bukti_kehadiran" 
                                       name="bukti_kehadiran" 
                                       accept=".jpg,.jpeg,.png,.pdf">
                                <small class="text-muted">
                                    Format: JPG, JPEG, PNG, PDF (Max: 2MB)
                                    @if($absensiKegiatan->bukti_kehadiran)
                                        <br><strong>File saat ini:</strong> {{ $absensiKegiatan->bukti_kehadiran }}
                                    @endif
                                </small>
                                @error('bukti_kehadiran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="form-section">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.absensi.show', $absensiKegiatan->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Absensi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Toggle Ikut Serta Lainnya field
    const ikutSertaSelect = document.getElementById('ikut_serta_sebagai');
    const lainnyaContainer = document.getElementById('lainnya_container');
    const lainnyaInput = document.getElementById('ikut_serta_lainnya');

    ikutSertaSelect.addEventListener('change', function() {
        if (this.value === 'Lainnya') {
            lainnyaContainer.style.display = 'block';
            lainnyaInput.required = true;
        } else {
            lainnyaContainer.style.display = 'none';
            lainnyaInput.required = false;
            lainnyaInput.value = '';
        }
    });

    // Set required on page load if Lainnya is selected
    if (ikutSertaSelect.value === 'Lainnya') {
        lainnyaInput.required = true;
    }
</script>
@endsection

