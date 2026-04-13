@extends('admin.layouts.app')

@section('title', 'Edit Data Keuangan')

@section('styles')
<style>
    .form-section {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .form-section h5 {
        color: #1976d2;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e3f2fd;
    }

    .form-floating {
        margin-bottom: 20px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1976d2;
        box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.15);
    }

    .file-upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.3s;
        cursor: pointer;
    }

    .file-upload-area:hover {
        border-color: #1976d2;
        background: #e3f2fd;
    }

    .file-upload-area.dragover {
        border-color: #1976d2;
        background: #e3f2fd;
    }

    .file-preview {
        margin-top: 15px;
        padding: 15px;
        background: white;
        border-radius: 6px;
        border: 1px solid #dee2e6;
    }

    .file-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .file-icon {
        font-size: 24px;
        color: #1976d2;
        margin-right: 10px;
    }

    .remove-file {
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .btn-submit {
        background: linear-gradient(45deg, #1976d2, #2196f3);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(25, 118, 210, 0.4);
    }

    .btn-reset {
        background: #6c757d;
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-reset:hover {
        background: #5a6268;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .current-file {
        background: #e8f5e8;
        border: 1px solid #4caf50;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .current-file-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .file-upload-area {
            padding: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">✏️ Edit Data Keuangan</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.keuangan.index') }}">Keuangan</a></li>
                    <li class="breadcrumb-item active">Edit Data</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.keuangan.show', $keuangan->id) }}" class="btn btn-info">
                <i class="fas fa-eye me-1"></i> Lihat
            </a>
            <a href="{{ route('admin.keuangan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Current Data Info -->
    <div class="alert alert-info">
        <h6><i class="fas fa-info-circle me-2"></i>Informasi Data Saat Ini</h6>
        <div class="row">
            <div class="col-md-3">
                <strong>Jenis:</strong>
                <span class="badge bg-{{ $keuangan->jenis == 'masuk' ? 'success' : 'danger' }}">
                    <i class="fas fa-{{ $keuangan->jenis == 'masuk' ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                    {{ ucfirst($keuangan->jenis) }}
                </span>
            </div>
            <div class="col-md-3">
                <strong>Jumlah:</strong> {{ $keuangan->formatted_jumlah }}
            </div>
            <div class="col-md-3">
                <strong>Tanggal:</strong> {{ $keuangan->tanggal->format('d/m/Y') }}
            </div>
            <div class="col-md-3">
                <strong>Kategori:</strong> {{ $keuangan->kategori }}
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.keuangan.update', $keuangan->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="form-section">
            <h5><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h5>
            <div class="form-row">
                <div>
                    <label for="jenis" class="form-label">Jenis Transaksi *</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis" id="jenis_masuk"
                                   value="masuk" {{ $keuangan->jenis == 'masuk' ? 'checked' : '' }}
                                   {{ old('jenis', $keuangan->jenis) == 'masuk' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="jenis_masuk">
                                <i class="fas fa-arrow-up text-success me-1"></i>
                                <strong>Pemasukan</strong>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis" id="jenis_keluar"
                                   value="keluar" {{ $keuangan->jenis == 'keluar' ? 'checked' : '' }}
                                   {{ old('jenis', $keuangan->jenis) == 'keluar' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="jenis_keluar">
                                <i class="fas fa-arrow-down text-danger me-1"></i>
                                <strong>Pengeluaran</strong>
                            </label>
                        </div>
                    </div>
                    @error('jenis')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="tanggal" class="form-label">Tanggal Transaksi *</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                           id="tanggal" name="tanggal"
                           value="{{ old('tanggal', $keuangan->tanggal->format('Y-m-d')) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="kategori" class="form-label">Kategori *</label>
                    <select class="form-select @error('kategori') is-invalid @enderror"
                            id="kategori" name="kategori" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriOptions as $kategori)
                            <option value="{{ $kategori }}"
                                {{ old('kategori', $keuangan->kategori) == $kategori ? 'selected' : '' }}>
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="jumlah" class="form-label">Jumlah *</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" class="form-control @error('jumlah') is-invalid @enderror"
                               id="jumlah" name="jumlah"
                               value="{{ old('jumlah', number_format($keuangan->jumlah, 0, ',', '.')) }}"
                               placeholder="0" required oninput="formatNumber(this)">
                        <span class="input-group-text">.00</span>
                    </div>
                    @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror"
                          id="keterangan" name="keterangan" rows="3"
                          placeholder="Deskripsi atau catatan transaksi...">{{ old('keterangan', $keuangan->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Source/Recipient Information -->
        <div class="form-section">
            <h5><i class="fas fa-exchange-alt me-2"></i>Informasi Sumber/Penerima</h5>
            <div class="form-row">
                <div id="sumberField" style="display: {{ $keuangan->jenis == 'masuk' ? 'block' : 'none' }};">
                    <label for="sumber" class="form-label">Sumber Dana</label>
                    <input type="text" class="form-control @error('sumber') is-invalid @enderror"
                           id="sumber" name="sumber"
                           value="{{ old('sumber', $keuangan->sumber) }}"
                           placeholder="Nama sumber dana (anggota, sponsor, dll)">
                    @error('sumber')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="penerimaField" style="display: {{ $keuangan->jenis == 'keluar' ? 'block' : 'none' }};">
                    <label for="penerima" class="form-label">Penerima Dana</label>
                    <input type="text" class="form-control @error('penerima') is-invalid @enderror"
                           id="penerima" name="penerima"
                           value="{{ old('penerima', $keuangan->penerima) }}"
                           placeholder="Nama penerima dana">
                    @error('penerima')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Current File Display -->
        @if($keuangan->bukti)
            <div class="form-section">
                <h5><i class="fas fa-paperclip me-2"></i>Bukti Transaksi Saat Ini</h5>
                <div class="current-file">
                    <div class="current-file-info">
                        <i class="fas fa-file file-icon"></i>
                        <div>
                            <div class="fw-bold">{{ basename($keuangan->bukti) }}</div>
                            <div class="text-muted small">File saat ini</div>
                        </div>
                        <a href="{{ $keuangan->bukti_url }}" target="_blank" class="btn btn-sm btn-info">
                            <i class="fas fa-eye me-1"></i>Lihat
                        </a>
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="replace_file" name="replace_file">
                    <label class="form-check-label" for="replace_file">
                        Ganti dengan file baru (centang jika ingin mengganti)
                    </label>
                </div>
            </div>
        @endif

        <!-- File Upload -->
        <div class="form-section">
            <h5><i class="fas fa-paperclip me-2"></i>{{ $keuangan->bukti ? 'Ganti ' : '' }}Bukti Transaksi</h5>
            <div class="file-upload-area" id="fileUploadArea" style="display: {{ $keuangan->bukti && !old('replace_file') ? 'none' : 'block' }};">
                <div class="upload-content">
                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Seret file ke sini atau klik untuk memilih</h6>
                    <p class="text-muted small">Format: JPG, PNG, PDF. Maksimal 2MB</p>
                    <input type="file" class="form-control" id="bukti" name="bukti"
                           accept=".jpg,.jpeg,.png,.pdf" style="display: none;">
                </div>
            </div>

            <div id="filePreview" class="file-preview" style="display: none;">
                <div class="file-info">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file file-icon"></i>
                        <div>
                            <div class="fw-bold" id="fileName"></div>
                            <div class="text-muted small" id="fileSize"></div>
                        </div>
                    </div>
                    <button type="button" class="remove-file" id="removeFile">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            @error('bukti')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="text-center">
            <button type="submit" class="btn btn-submit me-3">
                <i class="fas fa-save me-2"></i>Update Data
            </button>
            <a href="{{ route('admin.keuangan.show', $keuangan->id) }}" class="btn btn-secondary me-3">
                <i class="fas fa-times me-2"></i>Batal
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Toggle sumber/penerima fields based on jenis
    document.querySelectorAll('input[name="jenis"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const sumberField = document.getElementById('sumberField');
            const penerimaField = document.getElementById('penerimaField');

            if (this.value === 'masuk') {
                sumberField.style.display = 'block';
                penerimaField.style.display = 'none';
            } else if (this.value === 'keluar') {
                sumberField.style.display = 'none';
                penerimaField.style.display = 'block';
            }
        });
    });

    // Handle replace file checkbox
    document.getElementById('replace_file').addEventListener('change', function() {
        const fileUploadArea = document.getElementById('fileUploadArea');
        if (this.checked) {
            fileUploadArea.style.display = 'block';
        } else {
            fileUploadArea.style.display = 'none';
        }
    });

    // File upload handling
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileInput = document.getElementById('bukti');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFile = document.getElementById('removeFile');

    // Click to select file
    fileUploadArea.addEventListener('click', () => fileInput.click());

    // Drag and drop
    fileUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileUploadArea.classList.add('dragover');
    });

    fileUploadArea.addEventListener('dragleave', () => {
        fileUploadArea.classList.remove('dragover');
    });

    fileUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileUploadArea.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect(files[0]);
        }
    });

    // File input change
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFileSelect(e.target.files[0]);
        }
    });

    // Remove file
    removeFile.addEventListener('click', () => {
        fileInput.value = '';
        filePreview.style.display = 'none';
        fileUploadArea.style.display = 'block';
    });

    function handleFileSelect(file) {
        if (file.size > 2 * 1024 * 1024) { // 2MB limit
            alert('File terlalu besar! Maksimal 2MB.');
            return;
        }

        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung! Gunakan JPG, PNG, atau PDF.');
            return;
        }

        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);

        // Set icon based on file type
        const fileIcon = filePreview.querySelector('.file-icon');
        if (file.type.startsWith('image/')) {
            fileIcon.className = 'fas fa-image file-icon';
        } else if (file.type === 'application/pdf') {
            fileIcon.className = 'fas fa-file-pdf file-icon';
        }

        filePreview.style.display = 'block';
        fileUploadArea.style.display = 'none';
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Format number input
    function formatNumber(input) {
        let value = input.value.replace(/[^\d]/g, '');
        if (value) {
            input.value = parseInt(value).toLocaleString('id-ID');
        }
    }

    // Set default date
    document.getElementById('tanggal').value = document.getElementById('tanggal').value || new Date().toISOString().split('T')[0];
</script>
@endsection
