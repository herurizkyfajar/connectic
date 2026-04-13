@extends('admin.layouts.app')

@section('title', 'Edit Wilayah')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Wilayah</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.wilayah.update', $wilayah->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $wilayah->nama) }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipe</label>
                            <select name="tipe" class="form-select @error('tipe') is-invalid @enderror" required>
                                @foreach($tipeOptions as $t)
                                    <option value="{{ $t }}" {{ old('tipe', $wilayah->tipe) == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                                @endforeach
                            </select>
                            @error('tipe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kode</label>
                            <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $wilayah->kode) }}">
                            @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Induk</label>
                            <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                <option value="">Tidak Ada</option>
                                @foreach($parents as $p)
                                    <option value="{{ $p->id }}" {{ old('parent_id', $wilayah->parent_id) == $p->id ? 'selected' : '' }}>{{ $p->nama }} ({{ ucfirst($p->tipe) }})</option>
                                @endforeach
                            </select>
                            @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin Cabang (Pemilik Wilayah)</label>
                            <select name="parent_id_cabang" class="form-select @error('parent_id_cabang') is-invalid @enderror">
                                <option value="">Tidak Ada</option>
                                @foreach($admins as $a)
                                    <option value="{{ $a->id }}" {{ old('parent_id_cabang', $wilayah->parent_id_cabang) == $a->id ? 'selected' : '' }}>
                                        {{ $a->name }} ({{ $a->username }} - {{ $a->role }})
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id_cabang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $wilayah->deskripsi) }}</textarea>
                            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="Aktif" {{ old('status', $wilayah->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Nonaktif" {{ old('status', $wilayah->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.wilayah.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
                            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
