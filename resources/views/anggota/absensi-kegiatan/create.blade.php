<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Absensi Kegiatan - ConnecTIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background:#fff;
            border-bottom:1px solid #e5e7eb;
        }
        .navbar .container-fluid { display:grid; grid-template-columns:1fr auto 1fr; align-items:center; }
        .navbar .navbar-brand {
            color:#1877F2;
            font-weight:700;
            justify-self:start;
        }
        .nav-center { justify-self:center; }
        .nav-right { justify-self:end; }
        .nav-center .nav-icon {
            width:60px;
            height:44px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:8px;
            color:#5f676b;
            text-decoration:none;
        }
        .nav-center .nav-icon:hover {
            background:#f0f2f5;
            color:#1c1e21;
        }
        .nav-center .nav-icon.active {
            box-shadow: inset 0 -3px 0 #1877F2;
            color:#1877F2;
        }
        .nav-right .nav-circle {
            width:36px;
            height:36px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#f0f2f5;
            color:#1c1e21;
            text-decoration:none;
        }
        .nav-right .nav-circle:hover {
            background:#e9ecef;
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
        .btn-secondary {
            border-radius: 10px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .form-label {
            font-weight: 600;
            color: #333;
        }
        .autocomplete-container {
            position: relative;
        }
        .autocomplete-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 300px;
            overflow-y: auto;
            display: none;
        }
        .autocomplete-item {
            padding: 12px 15px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        .autocomplete-item:hover {
            background-color: #f8f9fa;
        }
        .autocomplete-item:last-child {
            border-bottom: none;
        }
        .kegiatan-info {
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>
    <nav class="navbar sticky-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a class="navbar-brand" href="{{ route('anggota.beranda') }}">ConnecTIK Anggota</a>
            <div class="nav-center d-flex align-items-center gap-1">
                <a class="nav-icon" href="{{ route('anggota.beranda') }}"><i class="fas fa-home"></i></a>
                <a class="nav-icon" href="{{ route('anggota.anggota-list') }}" title="Daftar Anggota"><i class="fas fa-users"></i></a>
                <a class="nav-icon" href="{{ route('anggota.academy') }}" title="Academy"><i class="fas fa-graduation-cap"></i></a>
                <a class="nav-icon" href="{{ route('anggota.kegiatan.calendar') }}" title="Kalender Kegiatan"><i class="fas fa-calendar-days"></i></a>
            </div>
            <div class="nav-right d-flex align-items-center gap-2">
                <form method="POST" action="{{ route('anggota.logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn p-0 nav-circle" title="Logout"><i class="fas fa-sign-out-alt"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-plus me-2"></i>Tambah Absensi Kegiatan
                            </h4>
                            <a href="{{ route('absensi-kegiatan.index') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('absensi-kegiatan.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="kegiatan_search" class="form-label">Cari Kegiatan</label>
                                    <div class="autocomplete-container">
                                        <input type="text" 
                                               class="form-control @error('riwayat_kegiatan_id') is-invalid @enderror" 
                                               id="kegiatan_search" 
                                               placeholder="Ketik nama kegiatan, lokasi, atau penyelenggara..."
                                               autocomplete="off">
                                        <div class="autocomplete-dropdown" id="kegiatan_dropdown"></div>
                                        <input type="hidden" 
                                               name="riwayat_kegiatan_id" 
                                               id="riwayat_kegiatan_id" 
                                               value="{{ old('riwayat_kegiatan_id') }}">
                                    </div>
                                    <div class="form-text">Mulai mengetik untuk mencari kegiatan yang tersedia</div>
                                    @error('riwayat_kegiatan_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="status_kehadiran" class="form-label">Status Kehadiran</label>
                                    <select class="form-select @error('status_kehadiran') is-invalid @enderror" 
                                            id="status_kehadiran" 
                                            name="status_kehadiran" 
                                            required>
                                        <option value="">Pilih Status</option>
                                        <option value="Hadir" {{ old('status_kehadiran') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                        <option value="Tidak Hadir" {{ old('status_kehadiran') == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                        <option value="Izin" {{ old('status_kehadiran') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="Sakit" {{ old('status_kehadiran') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                    </select>
                                    @error('status_kehadiran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="ikut_serta_sebagai" class="form-label">Ikut Serta Sebagai <span class="text-danger">*</span></label>
                                    <select class="form-select @error('ikut_serta_sebagai') is-invalid @enderror" 
                                            id="ikut_serta_sebagai" 
                                            name="ikut_serta_sebagai" 
                                            required>
                                        <option value="">Pilih Peran</option>
                                        <option value="Peserta" {{ old('ikut_serta_sebagai') == 'Peserta' ? 'selected' : '' }}>Peserta</option>
                                        <option value="Panitia" {{ old('ikut_serta_sebagai') == 'Panitia' ? 'selected' : '' }}>Panitia</option>
                                        <option value="Narasumber" {{ old('ikut_serta_sebagai') == 'Narasumber' ? 'selected' : '' }}>Narasumber</option>
                                        <option value="Lainnya" {{ old('ikut_serta_sebagai') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('ikut_serta_sebagai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3" id="lainnya_container" style="display: none;">
                                    <label for="ikut_serta_lainnya" class="form-label">Sebutkan Peran Lainnya <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('ikut_serta_lainnya') is-invalid @enderror" 
                                           id="ikut_serta_lainnya" 
                                           name="ikut_serta_lainnya" 
                                           value="{{ old('ikut_serta_lainnya') }}"
                                           placeholder="Misal: Moderator, Dokumentasi, dll">
                                    @error('ikut_serta_lainnya')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="bukti_kehadiran" class="form-label">Bukti Kehadiran</label>
                                    <input type="file" 
                                           class="form-control @error('bukti_kehadiran') is-invalid @enderror" 
                                           id="bukti_kehadiran" 
                                           name="bukti_kehadiran" 
                                           accept=".jpg,.jpeg,.png,.pdf">
                                    <div class="form-text">Format: JPG, JPEG, PNG, PDF (Max: 5MB)</div>
                                    @error('bukti_kehadiran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                              id="keterangan" 
                                              name="keterangan" 
                                              rows="3" 
                                              placeholder="Tambahkan keterangan jika diperlukan...">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('absensi-kegiatan.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Absensi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Ikut Serta Lainnya field
        const ikutSertaSelect = document.getElementById('ikut_serta_sebagai');
        const lainnyaContainer = document.getElementById('lainnya_container');
        const lainnyaInput = document.getElementById('ikut_serta_lainnya');

        // Check on page load (for validation errors)
        if (ikutSertaSelect.value === 'Lainnya') {
            lainnyaContainer.style.display = 'block';
            lainnyaInput.required = true;
        }

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

        // Autocomplete kegiatan
        let searchTimeout;
        const searchInput = document.getElementById('kegiatan_search');
        const dropdown = document.getElementById('kegiatan_dropdown');
        const hiddenInput = document.getElementById('riwayat_kegiatan_id');

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            if (query.length < 2) {
                dropdown.style.display = 'none';
                hiddenInput.value = '';
                return;
            }

            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchKegiatan(query);
            }, 300);
        });

        function searchKegiatan(query) {
            fetch(`{{ route('absensi-kegiatan.search') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    displayResults(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function displayResults(kegiatans) {
            if (kegiatans.length === 0) {
                dropdown.innerHTML = '<div class="autocomplete-item text-muted">Tidak ada kegiatan ditemukan</div>';
            } else {
                dropdown.innerHTML = kegiatans.map(kegiatan => `
                    <div class="autocomplete-item" data-id="${kegiatan.id}">
                        <div class="fw-bold">${kegiatan.judul}</div>
                        <div class="kegiatan-info">
                            <i class="fas fa-calendar me-1"></i>${kegiatan.tanggal_kegiatan}
                            <i class="fas fa-map-marker-alt ms-2 me-1"></i>${kegiatan.lokasi}
                            <br><i class="fas fa-building me-1"></i>${kegiatan.penyelenggara}
                        </div>
                    </div>
                `).join('');
            }
            dropdown.style.display = 'block';
        }

        dropdown.addEventListener('click', function(e) {
            const item = e.target.closest('.autocomplete-item');
            if (item) {
                const id = item.dataset.id;
                const title = item.querySelector('.fw-bold').textContent;
                
                hiddenInput.value = id;
                searchInput.value = title;
                dropdown.style.display = 'none';
            }
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.autocomplete-container')) {
                dropdown.style.display = 'none';
            }
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!hiddenInput.value) {
                e.preventDefault();
                alert('Pilih kegiatan terlebih dahulu!');
                searchInput.focus();
            }
        });
    </script>
</body>
</html>
