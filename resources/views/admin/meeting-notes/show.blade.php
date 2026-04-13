@extends('admin.layouts.app')

@section('title', 'Meeting Note #' . $meetingNote->document_no)

@section('page-title', 'MEETING NOTE #' . $meetingNote->document_no)

@section('styles')
<style>
    .meeting-document {
        background: white;
        padding: 3rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
    }
    
    .document-header {
        border: 2px solid #333;
        margin-bottom: 2rem;
    }
    
    .document-header table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
    }
    
    .document-header td, .document-header th {
        border: 1px solid #333;
        padding: 8px 12px;
        font-size: 14px;
    }
    
    .document-header th {
        background-color: #e9ecef;
        font-weight: 600;
        width: 150px;
    }
    
    .topic-section {
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
        color: white;
        padding: 10px 15px;
        margin: 20px 0 10px 0;
        font-weight: 700;
        text-align: center;
        border-radius: 4px;
    }
    
    .content-section {
        padding: 15px;
        background-color: #fafafa;
        border-radius: 4px;
        margin-bottom: 15px;
    }
    
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .meeting-document { box-shadow: none !important; padding: 0 !important; }
    }
</style>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="meeting-document">
        <!-- Document Header -->
        <div class="document-header">
            <table>
                <tr>
                    <th>Document No.</th>
                    <td><strong>{{ $meetingNote->document_no }}</strong></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <th>Project Name</th>
                    <td>{{ $meetingNote->project_name }}</td>
                    <th>Meeting Date</th>
                    <td>{{ $meetingNote->meeting_date->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Meeting Time</th>
                    <td>{{ $meetingNote->meeting_time }}</td>
                    <th>Meeting Location</th>
                    <td>{{ $meetingNote->meeting_location }}</td>
                </tr>
                <tr>
                    <th>Type Of Meeting</th>
                    <td colspan="3">{{ $meetingNote->type_of_meeting }}</td>
                </tr>
                <tr>
                    <th>Meeting Called by</th>
                    <td colspan="3">{{ $meetingNote->meeting_called_by }}</td>
                </tr>
                <tr>
                    <th>Attendance</th>
                    <td colspan="3">{{ $meetingNote->attendance }}</td>
                </tr>
                <tr>
                    <th>Note taker</th>
                    <td colspan="3">{{ $meetingNote->note_taker }}</td>
                </tr>
            </table>
        </div>

        <!-- Topic Section -->
        <div class="topic-section">TOPIC</div>
        <div class="content-section">
            <strong>{{ $meetingNote->topic }}</strong>
        </div>

        <!-- Meeting Result -->
        @if($meetingNote->meeting_result)
        <div class="topic-section">MEETING RESULT</div>
        <div class="content-section">
            {!! \App\Support\HtmlSanitizer::clean($meetingNote->meeting_result) !!}
        </div>
        @endif

        <!-- On Progress -->
        @if($meetingNote->on_progress)
        <div class="topic-section">ON PROGRESS</div>
        <div class="content-section">
            {!! \App\Support\HtmlSanitizer::clean($meetingNote->on_progress) !!}
        </div>
        @endif

        <!-- Akan Dilakukan -->
        @if($meetingNote->akan_dilakukan)
        <div class="topic-section">AKAN DILAKUKAN</div>
        <div class="content-section">
            {!! \App\Support\HtmlSanitizer::clean($meetingNote->akan_dilakukan) !!}
        </div>
        @endif

        <!-- Metadata -->
        <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #dee2e6; font-size: 0.875rem; color: #6c757d;">
            <p class="mb-1"><strong>Dibuat pada:</strong> {{ $meetingNote->created_at->format('d/m/Y H:i') }}</p>
            <p class="mb-0"><strong>Terakhir diupdate:</strong> {{ $meetingNote->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between align-items-center no-print" style="padding: 1.5rem; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <div>
            <a href="{{ route('admin.meeting-notes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-info">
                <i class="fas fa-print me-2"></i>Print
            </button>
            <a href="{{ route('admin.meeting-notes.edit', $meetingNote->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <form action="{{ route('admin.meeting-notes.destroy', $meetingNote->id) }}" 
                  method="POST" class="d-inline"
                  onsubmit="return confirm('Yakin ingin menghapus meeting note ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Hapus
                </button>
            </form>
        </div>
    </div>
@endsection
