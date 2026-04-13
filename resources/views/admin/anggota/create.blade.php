@extends('admin.layouts.app')

@section('title', 'Tambah Anggota')

@section('page-title', 'TAMBAH ANGGOTA BARU')

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
    
    .preview-container {
        margin-top: 1rem;
        padding: 1rem;
        background: #fafafa;
        border-radius: 8px;
        text-align: center;
    }
    
    .preview-image {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Terdapat kesalahan pada form:</strong>
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
            <form action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Data Pribadi -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-user"></i>
                        <h5>Data Pribadi</h5>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">
                                <i class="fas fa-user-circle"></i>
                                Nama Lengkap<span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" name="nama" value="{{ old('nama') }}" required
                                   placeholder="Masukkan nama lengkap">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i>
                                Email<span class="required">*</span>
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="nama@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label">
                                <i class="fas fa-phone"></i>
                                Nomor Telepon<span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                   id="telepon" name="telepon" value="{{ old('telepon') }}" required
                                   placeholder="08xxxxxxxxxx">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_lahir" class="form-label">
                                <i class="fas fa-calendar"></i>
                                Tanggal Lahir<span class="required">*</span>
                            </label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                   id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">
                                <i class="fas fa-venus-mars"></i>
                                Jenis Kelamin<span class="required">*</span>
                            </label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                    id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
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
                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }} selected>Aktif</option>
                                <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Alamat Lengkap<span class="required">*</span>
                        </label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3" required
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Keamanan -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-lock"></i>
                        <h5>Keamanan Akun</h5>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-key"></i>
                                Password<span class="required">*</span>
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required placeholder="Minimal 8 karakter">
                            <small class="form-text text-muted">Minimal 8 karakter</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-check-circle"></i>
                                Konfirmasi Password<span class="required">*</span>
                            </label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required
                                   placeholder="Ulangi password">
                            <small class="form-text text-muted">Ulangi password yang sama</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-layer-group"></i>
                            Aktif di
                        </label>
                        @php
                            $aktifOptions = ['nasional' => 'Nasional', 'wilayah' => 'Wilayah', 'cabang' => 'Cabang', 'komisariat' => 'Komisariat'];
                            $aktifSelected = (array) old('aktif_di', []);
                        @endphp
                        <div class="row">
                            @foreach($aktifOptions as $value => $label)
                                <div class="col-md-3 col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="aktif_di[]" id="aktif_{{ $value }}" value="{{ $value }}" {{ in_array($value, $aktifSelected) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aktif_{{ $value }}">{{ $label }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('aktif_di.*')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Pekerjaan -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-briefcase"></i>
                        <h5>Informasi Pekerjaan & Jabatan</h5>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pekerjaan" class="form-label">
                                <i class="fas fa-building"></i>
                                Pekerjaan
                            </label>
                            <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" 
                                   id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}"
                                   placeholder="Masukkan pekerjaan (opsional)">
                            @error('pekerjaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jabatan" class="form-label">
                                <i class="fas fa-user-tie"></i>
                                Jabatan di Organisasi
                            </label>
                            <select class="form-select @error('jabatan') is-invalid @enderror" 
                                    id="jabatan" name="jabatan">
                                <option value="">Pilih Jabatan (Opsional)</option>
                                <option value="Ketua umum" {{ old('jabatan') == 'Ketua umum' ? 'selected' : '' }}>Ketua umum</option>
                                <option value="Wakil ketua" {{ old('jabatan') == 'Wakil ketua' ? 'selected' : '' }}>Wakil ketua</option>
                                <option value="Sekretaris" {{ old('jabatan') == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                                <option value="Bendahara" {{ old('jabatan') == 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                                <option value="Bidang kesekretariatan" {{ old('jabatan') == 'Bidang kesekretariatan' ? 'selected' : '' }}>Bidang kesekretariatan</option>
                                <option value="Bidang kemitraan dan legal" {{ old('jabatan') == 'Bidang kemitraan dan legal' ? 'selected' : '' }}>Bidang kemitraan dan legal</option>
                                <option value="Bidang program dan aptika" {{ old('jabatan') == 'Bidang program dan aptika' ? 'selected' : '' }}>Bidang program dan aptika</option>
                                <option value="Bidang penelitian dan pengembangan sumber daya manusia" {{ old('jabatan') == 'Bidang penelitian dan pengembangan sumber daya manusia' ? 'selected' : '' }}>Bidang penelitian dan pengembangan sumber daya manusia</option>
                                <option value="Bidang komunikasi publik" {{ old('jabatan') == 'Bidang komunikasi publik' ? 'selected' : '' }}>Bidang komunikasi publik</option>
                            </select>
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Foto -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-camera"></i>
                        <h5>Foto Profil</h5>
                    </div>
                    
                    <div class="mb-3">
                        <label for="foto" class="form-label">
                            <i class="fas fa-image"></i>
                            Upload Foto
                        </label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                               id="foto" name="foto" accept="image/*" onchange="previewImage(this)">
                        <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <div id="preview-container" class="preview-container" style="display: none;">
                            <p class="text-muted mb-2"><strong>Preview:</strong></p>
                            <img id="preview" class="preview-image">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-user-shield"></i>
                        <h5>Induk Admin</h5>
                    </div>
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">
                            <i class="fas fa-user-cog"></i>
                            Pilih Admin Induk
                        </label>
                        <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                            <option value="">Pilih Admin</option>
                            @php $autoFill = $autoFill ?? []; @endphp
                            @foreach($admins as $adm)
                                <option value="{{ $adm->id }}" {{ (old('parent_id') == $adm->id || (empty(old('parent_id')) && isset($autoFill['parent_id']) && $autoFill['parent_id'] == $adm->id)) ? 'selected' : '' }}>
                                    {{ $adm->name }} ({{ $adm->username }})
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="parent_id_cabang" class="form-label">
                            <i class="fas fa-building"></i>
                            Cabang
                        </label>
                        <select class="form-select @error('parent_id_cabang') is-invalid @enderror" id="parent_id_cabang" name="parent_id_cabang">
                            <option value="">Pilih Cabang (Opsional)</option>
                            @php $autoFill = $autoFill ?? []; @endphp
                            @foreach($admins as $adm)
                                <option value="{{ $adm->id }}" {{ (old('parent_id_cabang') == $adm->id || (empty(old('parent_id_cabang')) && isset($autoFill['parent_id_cabang']) && $autoFill['parent_id_cabang'] == $adm->id)) ? 'selected' : '' }}>
                                    {{ $adm->name }} ({{ $adm->username }})
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id_cabang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-sticky-note"></i>
                        <h5>Keterangan Tambahan</h5>
                    </div>
                    
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">
                            <i class="fas fa-comment-alt"></i>
                            Keterangan
                        </label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" name="keterangan" rows="4"
                                  placeholder="Masukkan keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; background: #fafafa; border-radius: 8px;">
                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Anggota
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        const previewContainer = document.getElementById('preview-container');
        const preview = document.getElementById('preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.style.display = 'none';
        }
    }
</script>
@endsection
