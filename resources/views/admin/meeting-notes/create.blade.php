<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Meeting Note - ConnecTIK Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
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
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .section-divider {
            border-top: 2px solid #e9ecef;
            margin: 2rem 0;
            padding-top: 1.5rem;
        }
        .section-title {
            color: #667eea;
            font-weight: 700;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-shield-alt me-2"></i>ConnecTIK Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.meeting-notes.index') }}">
                            <i class="fas fa-file-alt me-1"></i>Meeting Notes
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-white">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4 mb-5">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <a href="{{ route('admin.meeting-notes.index') }}" class="btn btn-outline-secondary mb-3">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <h2 class="fw-bold">
                    <i class="fas fa-plus-circle text-primary me-2"></i>
                    Tambah Meeting Note
                </h2>
                <p class="text-muted">Buat notulensi rapat baru</p>
            </div>
        </div>

        <!-- Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt me-2"></i>Form Meeting Note
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.meeting-notes.store') }}" method="POST">
                    @csrf

                    <!-- Document Information -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="document_no" class="form-label">
                                    <i class="fas fa-hashtag text-primary me-1"></i>Document No
                                </label>
                                <input type="text" 
                                       class="form-control @error('document_no') is-invalid @enderror" 
                                       id="document_no" 
                                       name="document_no" 
                                       value="{{ old('document_no', $nextDocNo) }}" 
                                       required>
                                @error('document_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="project_name" class="form-label">
                                    <i class="fas fa-project-diagram text-primary me-1"></i>Project Name
                                </label>
                                <input type="text" 
                                       class="form-control @error('project_name') is-invalid @enderror" 
                                       id="project_name" 
                                       name="project_name" 
                                       value="{{ old('project_name') }}" 
                                       required>
                                @error('project_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Meeting Details -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="meeting_date" class="form-label">
                                    <i class="fas fa-calendar text-primary me-1"></i>Meeting Date
                                </label>
                                <input type="date" 
                                       class="form-control @error('meeting_date') is-invalid @enderror" 
                                       id="meeting_date" 
                                       name="meeting_date" 
                                       value="{{ old('meeting_date') }}" 
                                       required>
                                @error('meeting_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="meeting_time" class="form-label">
                                    <i class="fas fa-clock text-primary me-1"></i>Meeting Time
                                </label>
                                <input type="text" 
                                       class="form-control @error('meeting_time') is-invalid @enderror" 
                                       id="meeting_time" 
                                       name="meeting_time" 
                                       value="{{ old('meeting_time') }}" 
                                       placeholder="14.30-16.00"
                                       required>
                                @error('meeting_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: HH.MM-HH.MM</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="meeting_location" class="form-label">
                                    <i class="fas fa-map-marker-alt text-primary me-1"></i>Meeting Location
                                </label>
                                <input type="text" 
                                       class="form-control @error('meeting_location') is-invalid @enderror" 
                                       id="meeting_location" 
                                       name="meeting_location" 
                                       value="{{ old('meeting_location') }}" 
                                       required>
                                @error('meeting_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="type_of_meeting" class="form-label">
                                    <i class="fas fa-tag text-primary me-1"></i>Type Of Meeting
                                </label>
                                <select class="form-select @error('type_of_meeting') is-invalid @enderror" 
                                        id="type_of_meeting" 
                                        name="type_of_meeting" 
                                        required>
                                    <option value="">-- Pilih Type --</option>
                                    <option value="Discussion" {{ old('type_of_meeting') == 'Discussion' ? 'selected' : '' }}>Discussion</option>
                                    <option value="Review" {{ old('type_of_meeting') == 'Review' ? 'selected' : '' }}>Review</option>
                                    <option value="Planning" {{ old('type_of_meeting') == 'Planning' ? 'selected' : '' }}>Planning</option>
                                    <option value="Coordination" {{ old('type_of_meeting') == 'Coordination' ? 'selected' : '' }}>Coordination</option>
                                    <option value="Evaluation" {{ old('type_of_meeting') == 'Evaluation' ? 'selected' : '' }}>Evaluation</option>
                                </select>
                                @error('type_of_meeting')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="meeting_called_by" class="form-label">
                                    <i class="fas fa-user-tie text-primary me-1"></i>Meeting Called By
                                </label>
                                <input type="text" 
                                       class="form-control @error('meeting_called_by') is-invalid @enderror" 
                                       id="meeting_called_by" 
                                       name="meeting_called_by" 
                                       value="{{ old('meeting_called_by') }}" 
                                       required>
                                @error('meeting_called_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="note_taker" class="form-label">
                                    <i class="fas fa-pen text-primary me-1"></i>Note Taker
                                </label>
                                <input type="text" 
                                       class="form-control @error('note_taker') is-invalid @enderror" 
                                       id="note_taker" 
                                       name="note_taker" 
                                       value="{{ old('note_taker') }}" 
                                       required>
                                @error('note_taker')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Attendance -->
                    <div class="mb-3">
                        <label for="attendance" class="form-label">
                            <i class="fas fa-users text-primary me-1"></i>Attendance
                        </label>
                        <select class="form-select @error('attendance') is-invalid @enderror" 
                                id="attendance" 
                                name="attendance[]" 
                                multiple="multiple"
                                required>
                            @foreach($anggotas as $anggota)
                                <option value="{{ $anggota->nama }}" 
                                    {{ (old('attendance') && in_array($anggota->nama, old('attendance'))) ? 'selected' : '' }}>
                                    {{ $anggota->nama }} ({{ $anggota->jabatan }})
                                </option>
                            @endforeach
                        </select>
                        @error('attendance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Pilih satu atau lebih anggota. Ketik untuk mencari.</small>
                    </div>

                    <!-- Topic -->
                    <div class="mb-3">
                        <label for="topic" class="form-label">
                            <i class="fas fa-bookmark text-primary me-1"></i>Topic
                        </label>
                        <input type="text" 
                               class="form-control @error('topic') is-invalid @enderror" 
                               id="topic" 
                               name="topic" 
                               value="{{ old('topic') }}" 
                               required>
                        @error('topic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Meeting Result -->
                    <div class="section-divider">
                        <h5 class="section-title">
                            <i class="fas fa-clipboard-check me-2"></i>Meeting Result
                        </h5>
                        <div class="mb-3">
                            <textarea class="form-control summernote @error('meeting_result') is-invalid @enderror" 
                                      id="meeting_result" 
                                      name="meeting_result" 
                                      rows="5">{{ old('meeting_result') }}</textarea>
                            @error('meeting_result')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- On Progress -->
                    <div class="section-divider">
                        <h5 class="section-title">
                            <i class="fas fa-spinner me-2"></i>On Progress
                        </h5>
                        <div class="mb-3">
                            <textarea class="form-control summernote @error('on_progress') is-invalid @enderror" 
                                      id="on_progress" 
                                      name="on_progress" 
                                      rows="5">{{ old('on_progress') }}</textarea>
                            @error('on_progress')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Akan Dilakukan -->
                    <div class="section-divider">
                        <h5 class="section-title">
                            <i class="fas fa-tasks me-2"></i>Akan Dilakukan
                        </h5>
                        <div class="mb-3">
                            <textarea class="form-control summernote @error('akan_dilakukan') is-invalid @enderror" 
                                      id="akan_dilakukan" 
                                      name="akan_dilakukan" 
                                      rows="5">{{ old('akan_dilakukan') }}</textarea>
                            @error('akan_dilakukan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Simpan Meeting Note
                        </button>
                        <a href="{{ route('admin.meeting-notes.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for Attendance
            $('#attendance').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih anggota yang hadir...',
                allowClear: true,
                width: '100%',
                tags: true, // Allow adding custom names
                tokenSeparators: [',']
            });

            // Initialize Summernote
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
</body>
</html>
