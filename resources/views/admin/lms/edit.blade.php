@extends('admin.layouts.app')

@section('title', 'Edit LMS')
@section('page-title', 'EDIT LMS')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Edit Konten</h5>
            <a href="{{ route('admin.lms.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.lms.update', $item) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-heading text-primary me-1"></i>Judul</label>
                    <input type="text" name="title" value="{{ old('title', $item->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-link text-primary me-1"></i>Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $item->slug) }}" class="form-control @error('slug') is-invalid @enderror" placeholder="Opsional">
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-align-left text-primary me-1"></i>Deskripsi</label>
                    <textarea name="description" rows="3" class="form-control summernote @error('description') is-invalid @enderror">{{ old('description', $item->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-file-alt text-primary me-1"></i>Konten</label>
                    <textarea name="content" rows="6" class="form-control summernote @error('content') is-invalid @enderror">{{ old('content', $item->content) }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-tags text-primary me-1"></i>Kategori</label>
                        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                            @php($currentCategory = old('category', $item->category))
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Relawan TIK" {{ $currentCategory == 'Relawan TIK' ? 'selected' : '' }}>Relawan TIK</option>
                            <option value="IT" {{ $currentCategory == 'IT' ? 'selected' : '' }}>IT</option>
                            <option value="Non-IT" {{ $currentCategory == 'Non-IT' ? 'selected' : '' }}>Non-IT</option>
                        </select>
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-signal text-primary me-1"></i>Level</label>
                        <select name="level" class="form-select @error('level') is-invalid @enderror" required>
                            @php($currentLevel = old('level', $item->level))
                            <option value="">-- Pilih Level --</option>
                            <option value="Dasar" {{ $currentLevel == 'Dasar' ? 'selected' : '' }}>Dasar</option>
                            <option value="Menengah" {{ $currentLevel == 'Menengah' ? 'selected' : '' }}>Menengah</option>
                            <option value="Lanjutan" {{ $currentLevel == 'Lanjutan' ? 'selected' : '' }}>Lanjutan</option>
                        </select>
                        @error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><i class="fas fa-toggle-on text-primary me-1"></i>Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            @php($current = old('status', $item->status))
                            <option value="Draft" {{ $current == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Published" {{ $current == 'Published' ? 'selected' : '' }}>Published</option>
                            <option value="Archived" {{ $current == 'Archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-image text-primary me-1"></i>Cover (gambar)</label>
                    @if($item->cover)
                        <div class="mb-2">
                            <img src="{{ asset('storage/lms/' . $item->cover) }}" alt="cover" style="height:80px;border-radius:4px;object-fit:cover;">
                        </div>
                    @endif
                    <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
                    @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="text-end">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
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
@endsection
