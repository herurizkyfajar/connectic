@extends('admin.layouts.app')

@section('title', 'LMS')
@section('page-title', 'LMS')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-8">
            <h4>
                <i class="fas fa-graduation-cap text-primary me-2"></i>
                Kelola LMS
            </h4>
            <p class="text-muted mb-0">Konten pembelajaran sederhana untuk anggota</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.lms.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Konten
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Konten</h5>
            </div>
        </div>
        <div class="card-body">
            @if($items->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 70px;" class="text-center">Cover</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Diperbarui</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td class="text-center">
                                        @if($item->cover)
                                            <img src="{{ asset('storage/lms/' . $item->cover) }}" alt="cover" style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                                        @else
                                            <div class="text-muted">-</div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $item->title }}</strong>
                                        <div class="text-muted small">{{ $item->slug }}</div>
                                    </td>
                                    <td>{{ $item->category ?? '-' }}</td>
                                    <td>{{ $item->level ?? '-' }}</td>
                                    <td>
                                        @php($statusClass = match($item->status){
                                            'Published' => 'bg-success',
                                            'Draft' => 'bg-secondary',
                                            'Archived' => 'bg-warning',
                                            default => 'bg-secondary'
                                        })
                                        <span class="badge {{ $statusClass }}">{{ $item->status }}</span>
                                    </td>
                                    <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.lms.show', $item) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.lms.edit', $item) }}" class="btn btn-outline-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.lms.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus konten ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $items->links() }}
            @else
                <div class="text-muted">Belum ada konten LMS.</div>
            @endif
        </div>
    </div>
@endsection

