@extends('admin.layouts.app')

@section('title', 'Edit Pengajuan')
@section('page-title', 'EDIT PENGAJUAN')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Form Edit Pengajuan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengajuan.update', $pengajuan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="judul_pengajuan" class="form-label">Judul Pengajuan</label>
                            <input type="text" class="form-control @error('judul_pengajuan') is-invalid @enderror" id="judul_pengajuan" name="judul_pengajuan" value="{{ old('judul_pengajuan', $pengajuan->judul_pengajuan) }}" required>
                            @error('judul_pengajuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                            <input type="date" class="form-control @error('tanggal_pengajuan') is-invalid @enderror" id="tanggal_pengajuan" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', $pengajuan->tanggal_pengajuan->format('Y-m-d')) }}" required>
                            @error('tanggal_pengajuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Admin Provinsi</label>
                            @if(isset($autoFill['parent_id']))
                                <input type="hidden" name="parent_id" value="{{ $autoFill['parent_id'] }}">
                                <input type="text" class="form-control" value="{{ optional(\App\Models\Admin::find($autoFill['parent_id']))->name ?? '-' }}" disabled>
                            @else
                                <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                    <option value="">Pilih Admin Provinsi</option>
                                    @foreach($adminWilayahs as $admin)
                                        <option value="{{ $admin->id }}" {{ old('parent_id', $pengajuan->parent_id) == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="parent_id_cabang" class="form-label">Admin Cabang (Opsional)</label>
                            @if(isset($autoFill['parent_id_cabang']))
                                <input type="hidden" name="parent_id_cabang" value="{{ $autoFill['parent_id_cabang'] }}">
                                <input type="text" class="form-control" value="{{ optional(\App\Models\Admin::find($autoFill['parent_id_cabang']))->name ?? '-' }}" disabled>
                            @else
                                <select class="form-select @error('parent_id_cabang') is-invalid @enderror" id="parent_id_cabang" name="parent_id_cabang">
                                    <option value="">Pilih Admin Cabang</option>
                                    @foreach($adminCabangs as $admin)
                                        <option value="{{ $admin->id }}" {{ old('parent_id_cabang', $pengajuan->parent_id_cabang) == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            @error('parent_id_cabang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="Pending" {{ old('status', $pengajuan->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Disetujui" {{ old('status', $pengajuan->status) == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="Ditolak" {{ old('status', $pengajuan->status) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $pengajuan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="link_berkas" class="form-label">Link Berkas</label>
                            <input type="text" class="form-control @error('link_berkas') is-invalid @enderror" id="link_berkas" name="link_berkas" value="{{ old('link_berkas', $pengajuan->link_berkas) }}" placeholder="https://example.com/file.pdf">
                            @error('link_berkas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
