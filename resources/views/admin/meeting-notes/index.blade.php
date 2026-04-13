@extends('admin.layouts.app')

@section('title', 'Meeting Notes')

@section('page-title', 'MEETING NOTES')

@section('content')
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h4>
                <i class="fas fa-file-alt text-primary me-2"></i>
                Meeting Notes
            </h4>
            <p class="text-muted mb-0">Kelola notulensi rapat dan dokumentasi meeting</p>
        </div>
        <div class="col-md-4 text-end">
            @php
                $role = optional(Auth::guard('admin')->user())->role;
                $isWilayah = $role === 'admin_wilayah';
            @endphp
            <a href="{{ route('admin.meeting-notes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Meeting Note
            </a>
            @unless($isWilayah)
                <a href="{{ route('admin.meeting-notes.ranking') }}" class="btn btn-info">
                    <i class="fas fa-trophy me-2"></i>Ranking
                </a>
            @endunless
        </div>
    </div>

    <!-- Meeting Notes Table -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Daftar Meeting Notes
                </h5>
                <span class="badge bg-light text-dark">{{ $meetings->total() }} Total</span>
            </div>
        </div>
        <div class="card-body">
            @if($meetings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">Doc No</th>
                                <th>Project Name</th>
                                <th>Meeting Date</th>
                                <th>Meeting Time</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th class="text-center" style="width: 200px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meetings as $meeting)
                            <tr>
                                <td class="text-center">
                                    <strong class="text-primary">#{{ $meeting->document_number }}</strong>
                                </td>
                                <td>
                                    <div><strong>{{ $meeting->project_name }}</strong></div>
                                    @if($meeting->project_category)
                                        <small class="text-muted">{{ $meeting->project_category }}</small>
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-calendar text-muted me-1"></i>
                                    {{ \Carbon\Carbon::parse($meeting->meeting_date)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <i class="fas fa-clock text-muted me-1"></i>
                                    {{ $meeting->meeting_time }}
                                </td>
                                <td>
                                    <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                    {{ $meeting->location }}
                                </td>
                                <td>
                                    <span class="badge {{ $meeting->type == 'Internal' ? 'bg-info' : 'bg-success' }}">
                                        {{ $meeting->type }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.meeting-notes.show', $meeting->id) }}" 
                                           class="btn btn-info btn-sm" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.meeting-notes.edit', $meeting->id) }}" 
                                           class="btn btn-warning btn-sm" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.meeting-notes.destroy', $meeting->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this meeting note?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
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
                        Showing {{ $meetings->firstItem() ?? 0 }} - {{ $meetings->lastItem() ?? 0 }} of {{ $meetings->total() }} meetings
                    </div>
                    <div>
                        {{ $meetings->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">No Meeting Notes Yet</h5>
                    <p class="text-muted">Start documenting your meetings</p>
                    <a href="{{ route('admin.meeting-notes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create First Meeting Note
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
