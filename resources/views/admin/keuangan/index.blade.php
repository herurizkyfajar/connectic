@extends('admin.layouts.app')

@section('title', 'Manajemen Keuangan')

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
        grid-template-columns: repeat(3, minmax(0, 1fr));
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

    .dashboard-card.success {
        border-left-color: #4caf50;
        background: linear-gradient(135deg, #e8f5e8 0%, #f8fdf8 100%);
    }

    .dashboard-card.danger {
        border-left-color: #f44336;
        background: linear-gradient(135deg, #ffebee 0%, #fef8f8 100%);
    }

    .dashboard-card.warning {
        border-left-color: #ff9800;
        background: linear-gradient(135deg, #fff3e0 0%, #fffbf8 100%);
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

    .dashboard-card.success .card-icon { 
        background: linear-gradient(135deg, #4caf50, #66bb6a); 
    }
    
    .dashboard-card.danger .card-icon { 
        background: linear-gradient(135deg, #f44336, #ef5350); 
    }
    
    .dashboard-card.warning .card-icon { 
        background: linear-gradient(135deg, #ff9800, #ffb74d); 
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
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .dashboard-cards {
            grid-template-columns: repeat(3, minmax(0, 1fr));
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
            grid-template-columns: repeat(3, minmax(0, 1fr));
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

    .filters-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        align-items: end;
    }

    .btn-filter {
        background: #1976d2;
        border: none;
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-filter:hover {
        background: #1565c0;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3);
    }

    .btn-reset {
        background: #6c757d;
        border: none;
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        font-weight: 500;
    }

    .btn-reset:hover {
        background: #5a6268;
    }

    .table-actions {
        display: flex;
        gap: 5px;
        justify-content: center;
    }

    .badge-masuk {
        background: #28a745;
        color: white;
    }

    .badge-keluar {
        background: #dc3545;
        color: white;
    }

    @media (max-width: 768px) {
        .filter-row {
            grid-template-columns: 1fr;
        }

        .summary-cards {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">💰 Manajemen Keuangan</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Keuangan</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.keuangan.report') }}" class="btn btn-info">
                <i class="fas fa-chart-bar me-1"></i> Laporan & Grafik
            </a>
            <a href="{{ route('admin.keuangan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Tambah Data
            </a>
        </div>
    </div>

    <!-- Summary Cards - Horizontal Scrolling -->
    <div class="dashboard-cards-container">
        <div class="dashboard-cards">
            <div class="dashboard-card success">
                <div class="card-icon">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <h3>{{ 'Rp ' . number_format($totalMasuk, 0, ',', '.') }}</h3>
                <p>Total Pemasukan</p>
            </div>
            <div class="dashboard-card danger">
                <div class="card-icon">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <h3>{{ 'Rp ' . number_format($totalKeluar, 0, ',', '.') }}</h3>
                <p>Total Pengeluaran</p>
            </div>
            <div class="dashboard-card warning">
                <div class="card-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <h3>{{ 'Rp ' . number_format($saldo, 0, ',', '.') }}</h3>
                <p>Saldo</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="{{ route('admin.keuangan.index') }}" class="mb-3">
            <div class="filter-row">
                <div>
                    <label for="search" class="form-label">Pencarian</label>
                    <input type="text" 
                           class="form-control" 
                           id="search" 
                           name="search"
                           value="{{ request('search') }}" 
                           placeholder="Cari keterangan, kategori, sumber..."
                           autocomplete="off">
                </div>
                <div>
                    <label for="jenis" class="form-label">Jenis</label>
                    <select class="form-select" id="jenis" name="jenis">
                        <option value="">Semua Jenis</option>
                        <option value="masuk" {{ request('jenis') == 'masuk' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="keluar" {{ request('jenis') == 'keluar' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>
                <div>
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriOptions as $kategori)
                            <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="rentang" class="form-label">Rentang Waktu</label>
                    <select class="form-select" id="rentang" name="rentang">
                        <option value="">Semua Waktu</option>
                        <option value="hari" {{ request('rentang') == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="minggu" {{ request('rentang') == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="bulan" {{ request('rentang') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="tahun" {{ request('rentang') == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
                        <option value="custom" {{ request('rentang') == 'custom' ? 'selected' : '' }}>Rentang Manual</option>
                    </select>
                </div>
                <div id="customRange" style="display: {{ request('rentang') == 'custom' ? 'block' : 'none' }};">
                    <label for="start_date" class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                           value="{{ request('start_date') }}">
                </div>
                <div id="customRange2" style="display: {{ request('rentang') == 'custom' ? 'block' : 'none' }};">
                    <label for="end_date" class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                           value="{{ request('end_date') }}">
                </div>
                <div class="d-flex gap-2 align-items-end">
                    <button type="submit" class="btn-filter">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.keuangan.index') }}" class="btn-reset">
                        <i class="fas fa-undo me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Data Keuangan
                @if(request()->hasAny(['search', 'jenis', 'kategori', 'rentang', 'start_date', 'end_date']))
                    <small class="text-muted">(Filter Aktif)</small>
                @endif
            </h5>
            <span class="badge bg-primary">{{ $keuangans->total() }} Data</span>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($keuangans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th>Sumber/Penerima</th>
                                <th>Bukti</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($keuangans as $keuangan)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $keuangan->tanggal->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $keuangan->tanggal->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $keuangan->badge_class }}">
                                            <i class="fas fa-{{ $keuangan->jenis == 'masuk' ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                                            {{ ucfirst($keuangan->jenis) }}
                                        </span>
                                    </td>
                                    <td>{{ $keuangan->kategori }}</td>
                                    <td>
                                        <div>{{ $keuangan->keterangan ?? '-' }}</div>
                                        @if($keuangan->jenis == 'masuk' && $keuangan->sumber)
                                            <small class="text-success">Dari: {{ $keuangan->sumber }}</small>
                                        @elseif($keuangan->jenis == 'keluar' && $keuangan->penerima)
                                            <small class="text-danger">Kepada: {{ $keuangan->penerima }}</small>
                                        @endif
                                    </td>
                                    <td class="fw-bold {{ $keuangan->jenis == 'masuk' ? 'text-success' : 'text-danger' }}">
                                        {{ $keuangan->formatted_jumlah }}
                                    </td>
                                    <td>
                                        @if($keuangan->jenis == 'masuk' && $keuangan->sumber)
                                            {{ $keuangan->sumber }}
                                        @elseif($keuangan->jenis == 'keluar' && $keuangan->penerima)
                                            {{ $keuangan->penerima }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($keuangan->bukti)
                                            <a href="{{ $keuangan->bukti_url }}" target="_blank"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file me-1"></i>Lihat
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('admin.keuangan.show', $keuangan->id) }}"
                                               class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.keuangan.edit', $keuangan->id) }}"
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.keuangan.destroy', $keuangan->id) }}"
                                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
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
                <div class="d-flex justify-content-center mt-4">
                    {{ $keuangans->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data keuangan</h5>
                    <p class="text-muted mb-4">Belum ada data transaksi yang sesuai dengan filter yang dipilih.</p>
                    <a href="{{ route('admin.keuangan.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Data Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Toggle custom date range fields
    document.getElementById('rentang').addEventListener('change', function() {
        const customRange1 = document.getElementById('customRange');
        const customRange2 = document.getElementById('customRange2');

        if (this.value === 'custom') {
            customRange1.style.display = 'block';
            customRange2.style.display = 'block';
        } else {
            customRange1.style.display = 'none';
            customRange2.style.display = 'none';
        }
    });

    // Auto format number inputs
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            if (value) {
                e.target.value = parseInt(value).toLocaleString('id-ID');
            }
        });
    });

    // Submit form saat filter berubah
    document.getElementById('jenis')?.addEventListener('change', function() {
        this.closest('form').submit();
    });
    
    document.getElementById('kategori')?.addEventListener('change', function() {
        this.closest('form').submit();
    });
    
    document.getElementById('rentang')?.addEventListener('change', function() {
        if (this.value !== 'custom') {
            this.closest('form').submit();
        }
    });

    // Debug: Log saat form akan di-submit
    const filterForm = document.querySelector('form[method="GET"]');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            console.log('=== Form Submit Debug ===');
            console.log('Action:', this.action);
            console.log('Method:', this.method);
            
            const formData = new FormData(this);
            console.log('Form Data:');
            for (let [key, value] of formData.entries()) {
                console.log('  ' + key + ': "' + value + '"');
            }
            
            // Cek search input secara langsung
            const searchInput = document.getElementById('search');
            if (searchInput) {
                console.log('Search input value:', searchInput.value);
                console.log('Search input name:', searchInput.name);
            }
            console.log('========================');
        });
    }
</script>
@endsection
