<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Meeting - ConnecTIK Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar { background:#fff; border-bottom:1px solid #e5e7eb; }
        .navbar .container-fluid { display:grid; grid-template-columns:1fr auto 1fr; align-items:center; }
        .navbar .navbar-brand { color:#1877F2; font-weight:700; justify-self:start; }
        .nav-center { justify-self:center; }
        .nav-right { justify-self:end; }
        .nav-center .nav-icon { width:60px; height:44px; display:flex; align-items:center; justify-content:center; border-radius:8px; color:#5f676b; text-decoration:none; }
        .nav-center .nav-icon:hover { background:#f0f2f5; color:#1c1e21; }
        .nav-center .nav-icon.active { box-shadow: inset 0 -3px 0 #1877F2; color:#1877F2; }
        .nav-right .nav-circle { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:#f0f2f5; color:#1c1e21; text-decoration:none; }
        .nav-right .nav-circle:hover { background:#e9ecef; }
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
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background: #f8f9fa;
            border: none;
            font-weight: 600;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .badge {
            border-radius: 20px;
            padding: 5px 12px;
        }
        .meeting-row {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .meeting-row:hover {
            transform: translateX(5px);
        }
    </style>
</head>
<body>
    <nav class="navbar sticky-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a class="navbar-brand" href="{{ route('anggota.beranda') }}">ConnecTIK Anggota</a>
            <div class="nav-center d-flex align-items-center gap-1">
                <a class="nav-icon" href="{{ route('anggota.beranda') }}"><i class="fas fa-home"></i></a>
                <a class="nav-icon" href="{{ route('anggota.anggota-list') }}" title="Daftar Anggota"><i class="fas fa-users"></i></a>
                <a class="nav-icon" href="{{ route('anggota.academy') }}" title="Academy"><i class="fas fa-graduation-cap"></i></a>
                <a class="nav-icon" href="{{ route('anggota.kegiatan.calendar') }}" title="Kalender Kegiatan"><i class="fas fa-calendar-days"></i></a>
            </div>
            <div class="nav-right d-flex align-items-center gap-2">
                <form method="POST" action="{{ route('anggota.logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn p-0 nav-circle" title="Logout"><i class="fas fa-sign-out-alt"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="fw-bold">
                    <i class="fas fa-file-alt text-primary me-2"></i>
                    Riwayat Meeting Notes
                </h2>
                <p class="text-muted">Lihat dokumentasi dan notulensi rapat</p>
            </div>
        </div>

        <!-- Meeting Notes Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Daftar Meeting Notes
                </h5>
                <span class="badge bg-light text-dark">{{ $meetings->total() }} Total</span>
            </div>
            <div class="card-body p-0">
                @if($meetings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">Doc No</th>
                                <th>Project Name</th>
                                <th>Meeting Date</th>
                                <th>Meeting Time</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th class="text-center" style="width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meetings as $meeting)
                            <tr class="meeting-row" onclick="window.location='{{ route('anggota.meeting-notes.show', $meeting->id) }}'">
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $meeting->document_no }}</span>
                                </td>
                                <td>
                                    <strong>{{ $meeting->project_name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $meeting->topic }}</small>
                                </td>
                                <td>
                                    <i class="fas fa-calendar text-primary me-1"></i>
                                    {{ $meeting->meeting_date->format('d M Y') }}
                                </td>
                                <td>
                                    <i class="fas fa-clock text-primary me-1"></i>
                                    {{ $meeting->meeting_time }}
                                </td>
                                <td>
                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                    {{ $meeting->meeting_location }}
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $meeting->type_of_meeting }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('anggota.meeting-notes.show', $meeting->id) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="Lihat Detail"
                                       onclick="event.stopPropagation()">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Menampilkan {{ $meetings->firstItem() }} - {{ $meetings->lastItem() }} 
                            dari {{ $meetings->total() }} meeting notes
                        </div>
                        <div>
                            {{ $meetings->links() }}
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada meeting notes.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>










