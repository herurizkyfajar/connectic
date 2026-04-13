<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - ConnecTIK</title>
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
            padding: 12px 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .current-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ddd;
        }
    </style>
</head>
<body>
    <nav class="navbar sticky-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a class="navbar-brand" href="{{ route('anggota.beranda') }}">ConnecTIK Anggota</a>
            <div class="nav-center d-flex align-items-center gap-1">
                <a class="nav-icon" href="{{ route('anggota.beranda') }}"><i class="fas fa-home"></i></a>
                <a class="nav-icon" href="{{ route('anggota.beranda') }}#anggota-rtik"><i class="fas fa-users"></i></a>
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
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-edit me-2"></i>Edit Profil
                            </h4>
                            <a href="{{ route('anggota.profile') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('anggota.update-profile') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" 
                                               class="form-control @error('nama') is-invalid @enderror" 
                                               id="nama" 
                                               name="nama" 
                                               value="{{ old('nama', $anggota->nama) }}" 
                                               required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email"
                                               value="{{ old('email', $anggota->email) }}" 
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Pastikan email aktif dan belum digunakan anggota lain
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="telepon" class="form-label">Telepon</label>
                                        <input type="text" 
                                               class="form-control @error('telepon') is-invalid @enderror" 
                                               id="telepon" 
                                               name="telepon" 
                                               value="{{ old('telepon', $anggota->telepon) }}" 
                                               required>
                                        @error('telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                                  id="alamat" 
                                                  name="alamat" 
                                                  rows="3" 
                                                  required>{{ old('alamat', $anggota->alamat) }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" 
                                               class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                               id="tanggal_lahir" 
                                               name="tanggal_lahir" 
                                               value="{{ old('tanggal_lahir', $anggota->tanggal_lahir->format('Y-m-d')) }}" 
                                               required>
                                        @error('tanggal_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                                id="jenis_kelamin" 
                                                name="jenis_kelamin" 
                                                required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('jenis_kelamin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                        <input type="text" 
                                               class="form-control @error('pekerjaan') is-invalid @enderror" 
                                               id="pekerjaan" 
                                               name="pekerjaan" 
                                               value="{{ old('pekerjaan', $anggota->pekerjaan) }}">
                                        @error('pekerjaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan</label>
                                        <select class="form-select @error('jabatan') is-invalid @enderror" 
                                                id="jabatan" 
                                                name="jabatan">
                                            <option value="">Pilih Jabatan</option>
                                            <option value="Ketua umum" {{ old('jabatan', $anggota->jabatan) == 'Ketua umum' ? 'selected' : '' }}>Ketua umum</option>
                                            <option value="Wakil ketua" {{ old('jabatan', $anggota->jabatan) == 'Wakil ketua' ? 'selected' : '' }}>Wakil ketua</option>
                                            <option value="Sekretaris" {{ old('jabatan', $anggota->jabatan) == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                                            <option value="Bendahara" {{ old('jabatan', $anggota->jabatan) == 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                                            <option value="Bidang kesekretariatan" {{ old('jabatan', $anggota->jabatan) == 'Bidang kesekretariatan' ? 'selected' : '' }}>Bidang kesekretariatan</option>
                                            <option value="Bidang kemitraan dan legal" {{ old('jabatan', $anggota->jabatan) == 'Bidang kemitraan dan legal' ? 'selected' : '' }}>Bidang kemitraan dan legal</option>
                                            <option value="Bidang program dan aptika" {{ old('jabatan', $anggota->jabatan) == 'Bidang program dan aptika' ? 'selected' : '' }}>Bidang program dan aptika</option>
                                            <option value="Bidang penelitian dan pengembangan sumber daya manusia" {{ old('jabatan', $anggota->jabatan) == 'Bidang penelitian dan pengembangan sumber daya manusia' ? 'selected' : '' }}>Bidang penelitian dan pengembangan sumber daya manusia</option>
                                            <option value="Bidang komunikasi publik" {{ old('jabatan', $anggota->jabatan) == 'Bidang komunikasi publik' ? 'selected' : '' }}>Bidang komunikasi publik</option>
                                        </select>
                                        @error('jabatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="foto" class="form-label">Foto Profil</label>
                                        <input type="file" 
                                               class="form-control @error('foto') is-invalid @enderror" 
                                               id="foto" 
                                               name="foto" 
                                               accept="image/*">
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                                        
                                        @if($anggota->foto)
                                        <div class="mt-2">
                                            <label class="form-label">Foto Saat Ini:</label>
                                            <br>
                                            <img src="{{ asset('storage/anggotas/' . $anggota->foto) }}" 
                                                 alt="{{ $anggota->nama }}" 
                                                 class="current-photo">
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                                  id="keterangan" 
                                                  name="keterangan" 
                                                  rows="3">{{ old('keterangan', $anggota->keterangan) }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <h5 class="mb-3">
                                <i class="fas fa-lock me-2"></i>Ubah Password
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <input type="password" 
                                               class="form-control" 
                                               id="password_confirmation" 
                                               name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                            <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                            
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('anggota.profile') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
