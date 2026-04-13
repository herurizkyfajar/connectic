@extends('admin.layouts.app')

@section('title', 'Tambah Sertifikat')

@section('page-title', 'TAMBAH SERTIFIKAT ANGGOTA')

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
            <form action="{{ route('admin.sertifikat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Data Anggota & Kegiatan -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-user-check"></i>
                        <h5>Anggota & Kegiatan</h5>
                    </div>
                    
                    <div class="mb-3">
                        <label for="anggota_id" class="form-label">
                            <i class="fas fa-user"></i>
                            Nama Anggota<span class="required">*</span>
                        </label>
                        <select class="form-select select2 @error('anggota_id') is-invalid @enderror" 
                                id="anggota_id" name="anggota_id" required>
                            <option value="">Pilih Anggota</option>
                            @foreach($anggotas as $anggota)
                                <option value="{{ $anggota->id }}" {{ (old('anggota_id', request('anggota_id')) == $anggota->id) ? 'selected' : '' }}>
                                    {{ $anggota->nama }} - {{ $anggota->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('anggota_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kegiatan_search" class="form-label">
                            <i class="fas fa-calendar-alt"></i>
                            Cari Kegiatan<span class="required">*</span>
                        </label>
                        <select class="form-select select2 @error('riwayat_kegiatan_id') is-invalid @enderror" 
                                id="kegiatan_search" name="riwayat_kegiatan_id" required>
                            <option value="">Ketik untuk mencari kegiatan...</option>
                        </select>
                        @error('riwayat_kegiatan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Ketik minimal 2 karakter untuk mencari kegiatan</small>
                    </div>

                    <div id="kegiatan_info" class="alert alert-info d-none mb-3">
                        <h6><i class="fas fa-info-circle me-2"></i>Informasi Kegiatan:</h6>
                        <div id="kegiatan_details"></div>
                    </div>
                </div>

                <!-- Informasi Sertifikat -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-certificate"></i>
                        <h5>Informasi Sertifikat</h5>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nomor_sertifikat" class="form-label">
                                <i class="fas fa-hashtag"></i>
                                Nomor Sertifikat
                            </label>
                            <input type="text" class="form-control @error('nomor_sertifikat') is-invalid @enderror" 
                                   id="nomor_sertifikat" name="nomor_sertifikat" value="{{ old('nomor_sertifikat') }}"
                                   placeholder="Masukkan nomor sertifikat (opsional)">
                            @error('nomor_sertifikat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_terbit" class="form-label">
                                <i class="fas fa-calendar-check"></i>
                                Tanggal Terbit<span class="required">*</span>
                            </label>
                            <input type="date" class="form-control @error('tanggal_terbit') is-invalid @enderror" 
                                   id="tanggal_terbit" name="tanggal_terbit" value="{{ old('tanggal_terbit') }}" required>
                            @error('tanggal_terbit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="penyelenggara" class="form-label">
                            <i class="fas fa-building"></i>
                            Penyelenggara<span class="required">*</span>
                        </label>
                        <input type="text" class="form-control @error('penyelenggara') is-invalid @enderror" 
                               id="penyelenggara" name="penyelenggara" value="{{ old('penyelenggara') }}"
                               placeholder="Masukkan nama penyelenggara" required>
                        @error('penyelenggara')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">
                            <i class="fas fa-sticky-note"></i>
                            Keterangan
                        </label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" name="keterangan" rows="3" 
                                  placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- File Upload -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-file-upload"></i>
                        <h5>Upload File Sertifikat</h5>
                    </div>
                    
                    <div class="mb-3">
                        <label for="file_sertifikat" class="form-label">
                            <i class="fas fa-file-pdf"></i>
                            File Sertifikat
                        </label>
                        <input type="file" class="form-control @error('file_sertifikat') is-invalid @enderror" 
                               id="file_sertifikat" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Format: PDF, JPG, PNG. Maksimal 2MB</small>
                        @error('file_sertifikat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; background: #fafafa; border-radius: 8px;">
                    <a href="{{ route('admin.sertifikat.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Sertifikat
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for anggota
        $('#anggota_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih Anggota',
            allowClear: true
        });

        // Initialize Select2 for kegiatan with AJAX
        $('#kegiatan_search').select2({
            theme: 'bootstrap-5',
            placeholder: 'Ketik untuk mencari kegiatan...',
            allowClear: true,
            minimumInputLength: 2,
            ajax: {
                url: '{{ route("sertifikat.search-kegiatan") }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.id,
                                text: item.judul + ' (' + item.tanggal_kegiatan_formatted + ')',
                                data: item
                            };
                        })
                    };
                },
                cache: true
            }
        });

        // When kegiatan selected, show details
        $('#kegiatan_search').on('select2:select', function(e) {
            var data = e.params.data.data;
            var details = `
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Tanggal:</strong> ${data.tanggal_kegiatan_formatted}</p>
                        <p class="mb-1"><strong>Lokasi:</strong> ${data.lokasi}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Jenis:</strong> <span class="badge bg-info">${data.jenis_kegiatan}</span></p>
                        <p class="mb-1"><strong>Penyelenggara:</strong> ${data.penyelenggara}</p>
                    </div>
                </div>
            `;
            $('#kegiatan_details').html(details);
            $('#kegiatan_info').removeClass('d-none');
            
            // Auto-fill penyelenggara if empty
            if($('#penyelenggara').val() == '') {
                $('#penyelenggara').val(data.penyelenggara);
            }
        });

        // When kegiatan cleared
        $('#kegiatan_search').on('select2:clear', function() {
            $('#kegiatan_info').addClass('d-none');
        });
    });
</script>
@endsection
