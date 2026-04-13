@extends('admin.layouts.app')

@section('title', 'Manajemen Sertifikat')

@section('page-title', 'MANAJEMEN SERTIFIKAT')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">
                    <i class="fas fa-certificate me-2"></i>Manajemen Sertifikat Anggota
                </h5>
                <a href="{{ route('admin.sertifikat.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-2"></i>Tambah Sertifikat
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($sertifikats->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-certificate fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data sertifikat</h5>
                    <p class="text-muted">Tambahkan sertifikat pertama Anda</p>
                    <a href="{{ route('admin.sertifikat.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Sertifikat
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Anggota</th>
                                <th>Kegiatan</th>
                                <th>Nomor Sertifikat</th>
                                <th>Tanggal Terbit</th>
                                <th>Penyelenggara</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sertifikats as $index => $sertifikat)
                                <tr>
                                    <td>{{ $sertifikats->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $sertifikat->anggota->nama }}</strong>
                                    </td>
                                    <td>
                                        <div>{{ $sertifikat->riwayatKegiatan->judul }}</div>
                                        <small class="text-muted">{{ $sertifikat->riwayatKegiatan->tanggal_kegiatan_formatted }}</small>
                                    </td>
                                    <td>{{ $sertifikat->nomor_sertifikat ?? '-' }}</td>
                                    <td>{{ $sertifikat->tanggal_terbit_formatted }}</td>
                                    <td>{{ $sertifikat->penyelenggara }}</td>
                                    <td>
                                        @if($sertifikat->file_sertifikat)
                                            <a href="{{ route('admin.sertifikat.download', $sertifikat->id) }}" 
                                               class="btn btn-sm btn-outline-primary"
                                               title="Download File">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.sertifikat.show', $sertifikat->id) }}" 
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.sertifikat.edit', $sertifikat->id) }}" 
                                               class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.sertifikat.destroy', $sertifikat->id) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Yakin ingin menghapus sertifikat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $sertifikats->firstItem() ?? 0 }} - {{ $sertifikats->lastItem() ?? 0 }} dari {{ $sertifikats->total() }} sertifikat
                    </div>
                    <div>
                        {{ $sertifikats->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
