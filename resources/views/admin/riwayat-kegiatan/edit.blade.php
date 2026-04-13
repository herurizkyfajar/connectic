@extends('admin.layouts.app')

@section('title', 'Edit Kegiatan')

@section('page-title', 'EDIT KEGIATAN')

@section('styles')
<style>
    .form-section {
        background: white;
        border-radius: 8px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .section-title {
        display: flex;
        align-items: center;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #e0e0e0;
    }
    
    .section-title i {
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
    
    .form-label {
        font-weight: 500;
        color: #424242;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }
    
    .form-label i {
        margin-right: 8px;
        color: #1976d2;
    }
    
    .form-label .required {
        color: #f44336;
        margin-left: 4px;
    }
</style>
@endsection

@section('content')
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Terdapat kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form method="POST" action="{{ route('riwayat-kegiatan.update', $riwayatKegiatan->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Informasi Kegiatan -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-info-circle"></i>
                        <h5>Informasi Kegiatan</h5>
                    </div>
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">
                            <i class="fas fa-heading"></i>
                            Judul Kegiatan<span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" name="judul" value="{{ old('judul', $riwayatKegiatan->judul) }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">
                            <i class="fas fa-align-left"></i>
                            Deskripsi<span class="required">*</span>
                        </label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $riwayatKegiatan->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kegiatan" class="form-label">
                                <i class="fas fa-tags"></i>
                                Jenis Kegiatan<span class="required">*</span>
                            </label>
                            <select class="form-select @error('jenis_kegiatan') is-invalid @enderror" 
                                    id="jenis_kegiatan" name="jenis_kegiatan" required>
                                <option value="">Pilih Jenis</option>
                                <option value="Rapat" {{ old('jenis_kegiatan', $riwayatKegiatan->jenis_kegiatan) == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                                <option value="Pelatihan" {{ old('jenis_kegiatan', $riwayatKegiatan->jenis_kegiatan) == 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                <option value="Seminar" {{ old('jenis_kegiatan', $riwayatKegiatan->jenis_kegiatan) == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                                <option value="Workshop" {{ old('jenis_kegiatan', $riwayatKegiatan->jenis_kegiatan) == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                                <option value="Sosialisasi" {{ old('jenis_kegiatan', $riwayatKegiatan->jenis_kegiatan) == 'Sosialisasi' ? 'selected' : '' }}>Sosialisasi</option>
                                <option value="Pertemuan" {{ old('jenis_kegiatan', $riwayatKegiatan->jenis_kegiatan) == 'Pertemuan' ? 'selected' : '' }}>Pertemuan</option>
                                <option value="Kegiatan Lainnya" {{ old('jenis_kegiatan', $riwayatKegiatan->jenis_kegiatan) == 'Kegiatan Lainnya' ? 'selected' : '' }}>Kegiatan Lainnya</option>
                            </select>
                            @error('jenis_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">
                                <i class="fas fa-toggle-on"></i>
                                Status<span class="required">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Terlaksana" {{ old('status', $riwayatKegiatan->status) == 'Terlaksana' ? 'selected' : '' }}>Terlaksana</option>
                                <option value="Akan Datang" {{ old('status', $riwayatKegiatan->status) == 'Akan Datang' ? 'selected' : '' }}>Akan Datang</option>
                                <option value="Dibatalkan" {{ old('status', $riwayatKegiatan->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                <option value="Ditunda" {{ old('status', $riwayatKegiatan->status) == 'Ditunda' ? 'selected' : '' }}>Ditunda</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Waktu & Lokasi -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-calendar-alt"></i>
                        <h5>Waktu & Lokasi</h5>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="tanggal_kegiatan" class="form-label">
                                <i class="fas fa-calendar"></i>
                                Tanggal<span class="required">*</span>
                            </label>
                            <input type="date" class="form-control @error('tanggal_kegiatan') is-invalid @enderror" 
                                   id="tanggal_kegiatan" name="tanggal_kegiatan" 
                                   value="{{ old('tanggal_kegiatan', $riwayatKegiatan->tanggal_kegiatan->format('Y-m-d')) }}" required>
                            @error('tanggal_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="waktu_mulai" class="form-label">
                                <i class="fas fa-clock"></i>
                                Waktu Mulai<span class="required">*</span>
                            </label>
                            <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                   id="waktu_mulai" name="waktu_mulai" 
                                   value="{{ old('waktu_mulai', $riwayatKegiatan->waktu_mulai) }}" required>
                            @error('waktu_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="waktu_selesai" class="form-label">
                                <i class="fas fa-clock"></i>
                                Waktu Selesai<span class="required">*</span>
                            </label>
                            <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                   id="waktu_selesai" name="waktu_selesai" 
                                   value="{{ old('waktu_selesai', $riwayatKegiatan->waktu_selesai) }}" required>
                            @error('waktu_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Lokasi<span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                               id="lokasi" name="lokasi" value="{{ old('lokasi', $riwayatKegiatan->lokasi) }}" required>
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Penyelenggara & Dokumentasi -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-users"></i>
                        <h5>Penyelenggara & Dokumentasi</h5>
                    </div>
                    
                    <div class="mb-3">
                        <label for="penyelenggara" class="form-label">
                            <i class="fas fa-building"></i>
                            Penyelenggara<span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('penyelenggara') is-invalid @enderror" 
                               id="penyelenggara" name="penyelenggara" 
                               value="{{ old('penyelenggara', $riwayatKegiatan->penyelenggara) }}" required>
                        @error('penyelenggara')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="dokumentasi" class="form-label">
                            <i class="fas fa-file-upload"></i>
                            File Dokumentasi Baru
                        </label>
                        <input type="file" class="form-control @error('dokumentasi') is-invalid @enderror" 
                               id="dokumentasi" name="dokumentasi" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="form-text text-muted">Format: PDF, DOC, DOCX, JPG, PNG. Maksimal 10MB. Kosongkan jika tidak ingin mengubah</small>
                        @if($riwayatKegiatan->dokumentasi)
                            <div class="mt-2">
                                <small class="text-muted">File saat ini: {{ basename($riwayatKegiatan->dokumentasi) }}</small>
                            </div>
                        @endif
                        @error('dokumentasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">
                            <i class="fas fa-sticky-note"></i>
                            Catatan
                        </label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                  id="catatan" name="catatan" rows="3">{{ old('catatan', $riwayatKegiatan->catatan) }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Relasi Admin -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-link"></i>
                        <h5>Relasi Admin</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Admin Provinsi (parent_id)</label>
                            <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                <option value="">Gunakan admin login</option>
                                @foreach($adminWilayahs as $a)
                                    <option value="{{ $a->id }}" {{ old('parent_id', $riwayatKegiatan->parent_id) == $a->id ? 'selected' : '' }}>
                                        {{ $a->name }} ({{ $a->username }} - {{ $a->role }})
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Admin Cabang (parent_id_cabang)</label>
                            <select name="parent_id_cabang" class="form-select @error('parent_id_cabang') is-invalid @enderror">
                                <option value="">Tidak Ada</option>
                                @foreach($adminCabangs as $a)
                                    <option value="{{ $a->id }}" {{ old('parent_id_cabang', $riwayatKegiatan->parent_id_cabang) == $a->id ? 'selected' : '' }}>
                                        {{ $a->name }} ({{ $a->username }} - {{ $a->role }})
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id_cabang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; background: #fafafa; border-radius: 8px;">
                    <a href="{{ route('riwayat-kegiatan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Kegiatan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
