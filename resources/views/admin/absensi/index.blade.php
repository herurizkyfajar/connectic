@extends('admin.layouts.app')

@section('title', 'Riwayat Absensi')

@section('page-title', 'RIWAYAT ABSENSI')

@section('styles')
<style>
    /* Dashboard cards container - horizontal scrolling */
    .dashboard-cards-container {
        overflow-x: auto;
        overflow-y: hidden;
        margin: 50px 0 50px 0 !important;
        padding: 20px 0 30px 0 !important;
        scrollbar-width: thin;
        scrollbar-color: #ccc transparent;
    }

    .dashboard-cards-container::-webkit-scrollbar {
        height: 8px;
    }

    .dashboard-cards-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .dashboard-cards-container::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    .dashboard-cards-container::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    /* Grid layout for horizontal cards */
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        grid-template-rows: 1fr;
        gap: 12px;
        grid-auto-flow: column;
        width: 100%;
        height: max-content;
    }

    /* Force horizontal layout - no wrapping */
    .dashboard-cards .dashboard-card {
        height: 120px;
        grid-column: span 1;
        grid-row: span 1;
        flex-shrink: 0;
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
    }

    .dashboard-card {
        background: white;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    .dashboard-card.primary {
        border-left-color: #1976d2;
        background: linear-gradient(135deg, #e3f2fd 0%, #f8fbff 100%);
    }

    .dashboard-card.success {
        border-left-color: #4caf50;
        background: linear-gradient(135deg, #e8f5e8 0%, #f8fdf8 100%);
    }

    .dashboard-card.warning {
        border-left-color: #ff9800;
        background: linear-gradient(135deg, #fff3e0 0%, #fffbf8 100%);
    }

    .dashboard-card.danger {
        border-left-color: #f44336;
        background: linear-gradient(135deg, #ffebee 0%, #fef8f8 100%);
    }

    .dashboard-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(20px, -20px);
    }

    .card-icon {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }

    .dashboard-card.primary .card-icon { 
        background: linear-gradient(135deg, #1976d2, #2196f3); 
    }
    
    .dashboard-card.success .card-icon { 
        background: linear-gradient(135deg, #4caf50, #66bb6a); 
    }
    
    .dashboard-card.warning .card-icon { 
        background: linear-gradient(135deg, #ff9800, #ffb74d); 
    }
    
    .dashboard-card.danger .card-icon { 
        background: linear-gradient(135deg, #f44336, #ef5350); 
    }

    .dashboard-card h3 {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 8px 0 4px 0;
        color: #212121;
    }

    .dashboard-card p {
        margin: 0;
        color: #757575;
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .dashboard-cards {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .dashboard-cards {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .dashboard-cards .dashboard-card {
            height: 110px;
        }

        .dashboard-card h3 {
            font-size: 1.5rem;
        }

        .dashboard-card p {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 576px) {
        .dashboard-cards {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .dashboard-cards .dashboard-card {
            height: 100px;
        }

        .dashboard-card h3 {
            font-size: 1.25rem;
        }

        .card-icon {
            width: 38px;
            height: 38px;
            font-size: 18px;
            margin-bottom: 8px;
        }
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics - Horizontal Scrolling -->
    <div class="dashboard-cards-container">
        <div class="dashboard-cards">
            <div class="dashboard-card primary">
                <div class="card-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h3>{{ $totalAbsensi }}</h3>
                <p>Total Absensi</p>
            </div>
            <div class="dashboard-card success">
                <div class="card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>{{ $totalHadir }}</h3>
                <p>Hadir</p>
            </div>
            <div class="dashboard-card warning">
                <div class="card-icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <h3>{{ $totalIzin }}</h3>
                <p>Izin</p>
            </div>
            <div class="dashboard-card danger">
                <div class="card-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <h3>{{ $totalTidakHadir }}</h3>
                <p>Tidak Hadir</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">
                    <i class="fas fa-clipboard-list me-2"></i>Riwayat Absensi
                </h5>
                <a href="{{ route('admin.absensi.ranking') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-trophy me-2"></i>Lihat Ranking
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($absensiKegiatans->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-times fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data absensi</h5>
                    <p class="text-muted">Data absensi akan muncul di sini</p>
                </div>
            @else
                <!-- Filter Section -->
                <form method="GET" action="{{ route('admin.absensi.index') }}" class="mb-4">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status Kehadiran</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Izin,Sakit" {{ request('status') == 'Izin,Sakit' ? 'selected' : '' }}>Izin/Sakit (Pending)</option>
                                <option value="Tidak Hadir" {{ request('status') == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="anggota" class="form-label">Anggota</label>
                            <select class="form-select" id="anggota" name="anggota">
                                <option value="">Semua Anggota</option>
                                @foreach($anggotaOptions as $anggota)
                                    <option value="{{ $anggota->id }}" {{ request('anggota') == $anggota->id ? 'selected' : '' }}>
                                        {{ $anggota->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="kegiatan" class="form-label">Kegiatan</label>
                            <select class="form-select" id="kegiatan" name="kegiatan">
                                <option value="">Semua Kegiatan</option>
                                @foreach($kegiatanOptions as $kegiatanOption)
                                    <option value="{{ $kegiatanOption->id }}" {{ request('kegiatan') == $kegiatanOption->id ? 'selected' : '' }}>
                                        {{ $kegiatanOption->judul }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ request('tanggal') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Filter
                            </button>
                            <a href="{{ route('admin.absensi.index') }}" class="btn btn-secondary ms-2">
                                <i class="fas fa-undo me-1"></i> Reset
                            </a>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Menampilkan {{ $absensiKegiatans->count() }} dari {{ $totalAbsensi }} data
                                @if(request()->hasAny(['status', 'anggota', 'kegiatan', 'tanggal']))
                                    <small>(filter aktif)</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Client-side Filter (untuk pencarian real-time) -->
                <div class="row mb-3" style="display: none;">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="searchAnggota" placeholder="Cari nama anggota...">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="searchKegiatan" placeholder="Cari kegiatan...">
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                            <i class="fas fa-times me-1"></i> Clear Search
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Anggota</th>
                                <th>Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Waktu Absen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach($absensiKegiatans as $absensi)
                                <tr class="absensi-row"
                                    data-anggota="{{ strtolower($absensi->anggota->nama) }}"
                                    data-kegiatan="{{ strtolower($absensi->riwayatKegiatan->judul) }}"
                                    data-status="{{ strtolower($absensi->status_kehadiran) }}"
                                    data-anggota-id="{{ $absensi->anggota->id }}"
                                    data-kegiatan-id="{{ $absensi->riwayatKegiatan->id }}"
                                    data-tanggal="{{ $absensi->waktu_absen->format('Y-m-d') }}">
                                    <td>
                                        @if($absensi->anggota->foto)
                                            <img src="{{ asset('storage/anggotas/' . $absensi->anggota->foto) }}" 
                                                 alt="{{ $absensi->anggota->nama }}" class="avatar">
                                        @else
                                            <div class="avatar bg-secondary d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('anggota.show', $absensi->anggota->id) }}" class="text-decoration-none">
                                            <strong>{{ $absensi->anggota->nama }}</strong>
                                        </a>
                                        <br><small class="text-muted">{{ $absensi->anggota->email }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $absensi->riwayatKegiatan->judul }}</strong>
                                        <br><small class="text-muted">{{ $absensi->riwayatKegiatan->lokasi }}</small>
                                    </td>
                                    <td>{{ $absensi->riwayatKegiatan->tanggal_kegiatan_formatted }}</td>
                                    <td>
                                        <span class="badge {{ $absensi->status_kehadiran == 'Hadir' ? 'bg-success' : ($absensi->status_kehadiran == 'Izin' ? 'bg-warning' : ($absensi->status_kehadiran == 'Sakit' ? 'bg-info' : 'bg-danger')) }}">
                                            {{ $absensi->status_kehadiran }}
                                        </span>
                                    </td>
                                    <td>{{ $absensi->waktu_absen_formatted }}</td>
                                    <td>
                                        <a href="{{ route('admin.absensi.show', $absensi->id) }}" 
                                           class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $absensiKegiatans->firstItem() ?? 0 }} - {{ $absensiKegiatans->lastItem() ?? 0 }} dari {{ $absensiKegiatans->total() }} absensi
                    </div>
                    <div>
                        {{ $absensiKegiatans->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterStatus = document.getElementById('filterStatus');
        const searchAnggota = document.getElementById('searchAnggota');
        const searchKegiatan = document.getElementById('searchKegiatan');
        const allRows = document.querySelectorAll('.absensi-row');

        function filterRows() {
            const statusValue = filterStatus.value.toLowerCase();
            const anggotaValue = searchAnggota.value.toLowerCase().trim();
            const kegiatanValue = searchKegiatan.value.toLowerCase().trim();

            allRows.forEach(row => {
                const rowStatus = row.dataset.status;
                const rowAnggota = row.dataset.anggota;
                const rowKegiatan = row.dataset.kegiatan;

                const matchStatus = !statusValue || rowStatus.includes(statusValue);
                const matchAnggota = !anggotaValue || rowAnggota.includes(anggotaValue);
                const matchKegiatan = !kegiatanValue || rowKegiatan.includes(kegiatanValue);

                if (matchStatus && matchAnggota && matchKegiatan) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            // Update visible count
            updateVisibleCount();
        }

        function clearFilters() {
            if (searchAnggota) searchAnggota.value = '';
            if (searchKegiatan) searchKegiatan.value = '';
            if (filterStatus) filterStatus.value = '';

            allRows.forEach(row => {
                row.style.display = '';
            });

            updateVisibleCount();
        }

        function updateVisibleCount() {
            const visibleRows = Array.from(allRows).filter(row => row.style.display !== 'none');
            const countElement = document.querySelector('.text-muted');
            if (countElement) {
                countElement.innerHTML = `
                    <i class="fas fa-info-circle me-1"></i>
                    Menampilkan ${visibleRows.length} dari ${allRows.length} data
                    ${visibleRows.length !== allRows.length ? '<small>(pencarian aktif)</small>' : ''}
                `;
            }
        }

        // Event listeners
        if (filterStatus) filterStatus.addEventListener('change', filterRows);
        if (searchAnggota) searchAnggota.addEventListener('input', filterRows);
        if (searchKegiatan) searchKegiatan.addEventListener('input', filterRows);

        // Auto-submit form when filter changes (optional)
        document.querySelectorAll('#status, #anggota, #kegiatan, #tanggal').forEach(element => {
            element.addEventListener('change', function() {
                // Auto submit after 500ms delay to prevent too many requests
                clearTimeout(window.filterTimeout);
                window.filterTimeout = setTimeout(() => {
                    element.closest('form').submit();
                }, 500);
            });
        });
    });
</script>
@endsection
