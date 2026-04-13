<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Note #{{ $meetingNote->document_no }} - ConnecTIK Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
        }
        
        /* Meeting Document Styles */
        .meeting-document {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .document-header {
            border: 2px solid #333;
            padding: 0;
            margin-bottom: 30px;
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
            background-color: #667eea;
            color: white;
            padding: 10px 15px;
            margin: 20px 0 10px 0;
            font-weight: 700;
            text-align: center;
            border-radius: 5px;
        }
        .content-section {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            border-radius: 5px;
        }
        .section-title {
            color: #667eea;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        .print-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }
        
        @media print {
            .navbar, .print-button, .action-buttons, .no-print {
                display: none !important;
            }
            .meeting-document {
                box-shadow: none;
                padding: 20px;
            }
            body {
                background: white;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark no-print">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-user-circle me-2"></i>ConnecTIK Anggota
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('anggota.beranda') }}">
                            <i class="fas fa-house me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('anggota.profile') }}">
                            <i class="fas fa-home me-1"></i>Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('anggota.meeting-notes.index') }}">
                            <i class="fas fa-file-alt me-1"></i>Riwayat Meeting
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('anggota.logout') }}" method="POST" class="d-inline">
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

    <div class="container mt-4 mb-5">
        <!-- Action Buttons -->
        <div class="row mb-4 no-print">
            <div class="col-md-12">
                <a href="{{ route('anggota.meeting-notes.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print me-2"></i>Print
                </button>
            </div>
        </div>

        <!-- Meeting Document -->
        <div class="meeting-document">
            <!-- Document Header Table -->
            <div class="document-header">
                <table>
                    <tr>
                        <th>Document No.</th>
                        <td>{{ $meetingNote->document_no }}</td>
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
            <div class="topic-section">
                Topic
            </div>
            <div style="padding: 15px; border: 1px solid #ddd; margin-bottom: 20px;">
                <strong>{{ $meetingNote->topic }}</strong>
            </div>

            <!-- Meeting Result -->
            @if($meetingNote->meeting_result)
            <div class="content-section">
                <div class="section-title">
                    <i class="fas fa-clipboard-check me-2"></i>Meeting Result
                </div>
                <div>{!! \App\Support\HtmlSanitizer::clean($meetingNote->meeting_result) !!}</div>
            </div>
            @endif

            <!-- On Progress -->
            @if($meetingNote->on_progress)
            <div class="content-section">
                <div class="section-title">
                    <i class="fas fa-spinner me-2"></i>On Progress
                </div>
                <div>{!! \App\Support\HtmlSanitizer::clean($meetingNote->on_progress) !!}</div>
            </div>
            @endif

            <!-- Akan Dilakukan -->
            @if($meetingNote->akan_dilakukan)
            <div class="content-section">
                <div class="section-title">
                    <i class="fas fa-tasks me-2"></i>Akan Dilakukan
                </div>
                <div>{!! \App\Support\HtmlSanitizer::clean($meetingNote->akan_dilakukan) !!}</div>
            </div>
            @endif

            <!-- Footer Info -->
            <div class="mt-5 pt-4 border-top">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>Dibuat: {{ $meetingNote->created_at->format('d F Y H:i') }}
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>Terakhir diupdate: {{ $meetingNote->updated_at->format('d F Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Page Number (for print) -->
            <div class="text-end mt-3">
                <small class="text-muted">Page 1 of 1</small>
            </div>
        </div>
    </div>

    <!-- Floating Print Button -->
    <button onclick="window.print()" class="btn btn-primary btn-lg print-button no-print">
        <i class="fas fa-print me-2"></i>Print
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
