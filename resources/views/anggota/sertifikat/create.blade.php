<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Sertifikat - ConnecTIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('anggota.profile') }}">
                <i class="fas fa-users me-2"></i>
                ConnecTIK - Portal Anggota
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('anggota.profile') }}">
                            <i class="fas fa-user me-1"></i>Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('anggota.sertifikat.index') }}">
                            <i class="fas fa-certificate me-1"></i>Sertifikat Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('anggota.logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm ms-2">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-certificate me-2"></i>Tambah Sertifikat
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('anggota.sertifikat.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="kegiatan_search" class="form-label">Cari Kegiatan <span class="text-danger">*</span></label>
                                <select class="form-select @error('riwayat_kegiatan_id') is-invalid @enderror" 
                                        id="kegiatan_search" name="riwayat_kegiatan_id" required>
                                    <option value="">Ketik untuk mencari kegiatan...</option>
                                </select>
                                @error('riwayat_kegiatan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Ketik minimal 2 karakter untuk mencari kegiatan</small>
                            </div>

                            <div id="kegiatan_info" class="alert alert-info d-none mb-3">
                                <h6>Informasi Kegiatan:</h6>
                                <div id="kegiatan_details"></div>
                            </div>

                            <div class="mb-3">
                                <label for="nomor_sertifikat" class="form-label">Nomor Sertifikat</label>
                                <input type="text" 
                                       class="form-control @error('nomor_sertifikat') is-invalid @enderror" 
                                       id="nomor_sertifikat" 
                                       name="nomor_sertifikat" 
                                       value="{{ old('nomor_sertifikat') }}"
                                       placeholder="Masukkan nomor sertifikat (opsional)">
                                @error('nomor_sertifikat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_terbit" class="form-label">Tanggal Terbit <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('tanggal_terbit') is-invalid @enderror" 
                                       id="tanggal_terbit" 
                                       name="tanggal_terbit" 
                                       value="{{ old('tanggal_terbit') }}" 
                                       required>
                                @error('tanggal_terbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="penyelenggara" class="form-label">Penyelenggara <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('penyelenggara') is-invalid @enderror" 
                                       id="penyelenggara" 
                                       name="penyelenggara" 
                                       value="{{ old('penyelenggara') }}"
                                       placeholder="Masukkan nama penyelenggara" 
                                       required>
                                @error('penyelenggara')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                          id="keterangan" 
                                          name="keterangan" 
                                          rows="3" 
                                          placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="file_sertifikat" class="form-label">File Sertifikat</label>
                                <input type="file" 
                                       class="form-control @error('file_sertifikat') is-invalid @enderror" 
                                       id="file_sertifikat" 
                                       name="file_sertifikat"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                @error('file_sertifikat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: PDF, JPG, JPEG, PNG. Maksimal 5MB</small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('anggota.sertifikat.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Select2 for Kegiatan with AJAX
            $('#kegiatan_search').select2({
                theme: 'bootstrap-5',
                placeholder: 'Ketik untuk mencari kegiatan...',
                allowClear: true,
                minimumInputLength: 2,
                ajax: {
                    url: '{{ route("anggota.sertifikat.search-kegiatan") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.judul,
                                    data: item
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            // Show kegiatan details when selected
            $('#kegiatan_search').on('select2:select', function (e) {
                var data = e.params.data.data;
                var details = `
                    <p class="mb-1"><strong>Judul:</strong> ${data.judul}</p>
                    <p class="mb-1"><strong>Tanggal:</strong> ${new Date(data.tanggal_kegiatan).toLocaleDateString('id-ID')}</p>
                    <p class="mb-1"><strong>Jenis:</strong> ${data.jenis_kegiatan}</p>
                    <p class="mb-0"><strong>Penyelenggara:</strong> ${data.penyelenggara}</p>
                `;
                $('#kegiatan_details').html(details);
                $('#kegiatan_info').removeClass('d-none');
                
                // Auto-fill penyelenggara if empty
                if ($('#penyelenggara').val() === '') {
                    $('#penyelenggara').val(data.penyelenggara);
                }
            });

            // Hide kegiatan details when cleared
            $('#kegiatan_search').on('select2:clear', function (e) {
                $('#kegiatan_info').addClass('d-none');
            });
        });
    </script>
</body>
</html>

