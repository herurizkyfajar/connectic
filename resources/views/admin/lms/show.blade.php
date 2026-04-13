@extends('admin.layouts.app')

@section('title', 'Detail LMS')
@section('page-title', 'DETAIL LMS')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>{{ $item->title }}</h5>
                    <div>
                        <a href="{{ route('admin.lms.edit', $item) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('admin.lms.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($item->cover)
                        <div class="mb-3">
                            <img src="{{ asset('storage/lms/' . $item->cover) }}" alt="cover" style="width:100%;max-height:300px;object-fit:cover;border-radius:6px;">
                        </div>
                    @endif
                    @if($item->description)
                        <p class="text-muted">{{ $item->description }}</p>
                    @endif
                    @if($item->content)
                        <div class="mt-3" style="line-height:1.7;">
                            {!! \App\Support\HtmlSanitizer::clean($item->content) !!}
                        </div>
                    @else
                        <div class="text-muted">Tidak ada konten.</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi</h5></div>
                <div class="card-body">
                    <div class="mb-2"><strong>Slug:</strong> <span class="text-muted">{{ $item->slug }}</span></div>
                    <div class="mb-2"><strong>Kategori:</strong> <span class="text-muted">{{ $item->category ?? '-' }}</span></div>
                    <div class="mb-2"><strong>Level:</strong> <span class="text-muted">{{ $item->level ?? '-' }}</span></div>
                    <div class="mb-2">
                        <strong>Status:</strong>
                        @php($statusClass = match($item->status){
                            'Published' => 'bg-success',
                            'Draft' => 'bg-secondary',
                            'Archived' => 'bg-warning',
                            default => 'bg-secondary'
                        })
                        <span class="badge {{ $statusClass }}">{{ $item->status }}</span>
                    </div>
                    <div class="mb-2"><strong>Dibuat:</strong> <span class="text-muted">{{ $item->created_at->format('d/m/Y H:i') }}</span></div>
                    <div class="mb-2"><strong>Diperbarui:</strong> <span class="text-muted">{{ $item->updated_at->format('d/m/Y H:i') }}</span></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-book-reader me-2"></i>Anggota Sudah Membaca</h5>
                    @php($readCount = isset($readers) ? $readers->count() : 0)
                    <span class="badge bg-light text-dark">{{ $readCount }}</span>
                </div>
                <div class="card-body">
                    @if(isset($readers) && $readers->count())
                        <ul class="list-group list-group-flush">
                            @foreach($readers as $r)
                                <li class="list-group-item d-flex align-items-center justify-content-between">
                                    <div>
                                        <strong>{{ $r->nama }}</strong>
                                        @if($r->jabatan)
                                            <span class="badge bg-info ms-2">{{ $r->jabatan }}</span>
                                        @endif
                                        <div class="text-muted small">Dibaca {{ \Carbon\Carbon::parse($r->read_at)->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <a href="{{ route('anggota.show', $r->id) }}" class="btn btn-outline-primary btn-sm" title="Lihat Anggota">
                                        <i class="fas fa-user"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-muted">Belum ada anggota yang membaca kelas ini.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
