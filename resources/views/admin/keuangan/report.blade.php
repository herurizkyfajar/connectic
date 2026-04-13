@extends('admin.layouts.app')

@section('title', 'Laporan Keuangan')

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

    .dashboard-card.primary {
        border-left-color: #2196F3;
        background: linear-gradient(135deg, #e3f2fd 0%, #f8fbff 100%);
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

    .dashboard-card.primary .card-icon { 
        background: linear-gradient(135deg, #1976d2, #2196f3); 
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

    .chart-container {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        position: relative;
    }

    .chart-wrapper {
        position: relative;
        height: 400px;
        width: 100%;
    }

    .chart-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        margin-top: 20px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 4px;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .category-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .category-item:last-child {
        border-bottom: none;
    }

    .category-name {
        font-weight: 500;
    }

    .category-amount {
        font-weight: 700;
        color: #1976d2;
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

    .no-data {
        text-align: center;
        padding: 50px 20px;
        color: #6c757d;
    }

    .no-data i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .filter-row {
            grid-template-columns: 1fr;
        }

        .category-grid {
            grid-template-columns: 1fr;
        }

        .chart-wrapper {
            height: 300px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">📊 Laporan Keuangan</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.keuangan.index') }}">Keuangan</a></li>
                    <li class="breadcrumb-item active">Laporan & Grafik</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.keuangan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('admin.keuangan.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-1"></i> Tambah Data
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="{{ route('admin.keuangan.report') }}" class="mb-0">
            <div class="filter-row">
                <div>
                    <label for="rentang" class="form-label">Rentang Waktu</label>
                    <select class="form-select" id="rentang" name="rentang">
                        <option value="hari" {{ $rentang == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="minggu" {{ $rentang == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="bulan" {{ $rentang == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="tahun" {{ $rentang == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
                        <option value="custom" {{ $rentang == 'custom' ? 'selected' : '' }}>Rentang Manual</option>
                    </select>
                </div>
                <div id="customRange" style="display: {{ $rentang == 'custom' ? 'block' : 'none' }};">
                    <label for="start_date" class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                           value="{{ $startDate }}">
                </div>
                <div id="customRange2" style="display: {{ $rentang == 'custom' ? 'block' : 'none' }};">
                    <label for="end_date" class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                           value="{{ $endDate }}">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-filter">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.keuangan.report') }}" class="btn-reset">
                        <i class="fas fa-undo me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Summary Cards - Horizontal Scrolling -->
    <div class="dashboard-cards-container">
        <div class="dashboard-cards">
            <div class="dashboard-card success">
                <div class="card-icon">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <h3>{{ $summary['formattedMasuk'] }}</h3>
                <p>Total Pemasukan</p>
            </div>
            <div class="dashboard-card danger">
                <div class="card-icon">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <h3>{{ $summary['formattedKeluar'] }}</h3>
                <p>Total Pengeluaran</p>
            </div>
            <div class="dashboard-card warning">
                <div class="card-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <h3>{{ $summary['formattedSaldo'] }}</h3>
                <p>Saldo</p>
            </div>
            <div class="dashboard-card primary">
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>{{ count($chartData['labels']) }}</h3>
                <p>Periode Data</p>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    @if(count($chartData['labels']) > 0)
        <div class="chart-container">
            <h5 class="mb-4">
                <i class="fas fa-chart-line me-2"></i>
                Grafik Pendapatan dan Pengeluaran
                <small class="text-muted">- {{ ucfirst($rentang) }}</small>
            </h5>
            <div class="chart-wrapper">
                <canvas id="mainChart"></canvas>
            </div>
            <div class="chart-legend">
                @foreach($chartData['datasets'] as $dataset)
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: {{ $dataset['backgroundColor'] }}"></div>
                        <span>{{ $dataset['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Category Charts -->
        <div class="category-grid">
            <!-- Pemasukan by Category -->
            @if(count($kategoriData['masuk']['labels']) > 0)
                <div class="category-card">
                    <h6 class="mb-3">
                        <i class="fas fa-arrow-up text-success me-2"></i>
                        Pemasukan per Kategori
                    </h6>
                    <div class="chart-wrapper" style="height: 250px;">
                        <canvas id="masukChart"></canvas>
                    </div>
                    <ul class="category-list mt-3">
                        @for($i = 0; $i < count($kategoriData['masuk']['labels']); $i++)
                            <li class="category-item">
                                <span class="category-name">{{ $kategoriData['masuk']['labels'][$i] }}</span>
                                <span class="category-amount">
                                    Rp {{ number_format($kategoriData['masuk']['data'][$i], 0, ',', '.') }}
                                </span>
                            </li>
                        @endfor
                    </ul>
                </div>
            @endif

            <!-- Pengeluaran by Category -->
            @if(count($kategoriData['keluar']['labels']) > 0)
                <div class="category-card">
                    <h6 class="mb-3">
                        <i class="fas fa-arrow-down text-danger me-2"></i>
                        Pengeluaran per Kategori
                    </h6>
                    <div class="chart-wrapper" style="height: 250px;">
                        <canvas id="keluarChart"></canvas>
                    </div>
                    <ul class="category-list mt-3">
                        @for($i = 0; $i < count($kategoriData['keluar']['labels']); $i++)
                            <li class="category-item">
                                <span class="category-name">{{ $kategoriData['keluar']['labels'][$i] }}</span>
                                <span class="category-amount">
                                    Rp {{ number_format($kategoriData['keluar']['data'][$i], 0, ',', '.') }}
                                </span>
                            </li>
                        @endfor
                    </ul>
                </div>
            @endif
        </div>
    @else
        <div class="chart-container">
            <div class="no-data">
                <i class="fas fa-chart-bar"></i>
                <h5>Tidak ada data untuk ditampilkan</h5>
                <p>Belum ada data keuangan untuk rentang waktu yang dipilih.</p>
                <a href="{{ route('admin.keuangan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Data Keuangan
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    // Main Chart (Pendapatan vs Pengeluaran)
    @if(count($chartData['labels']) > 0)
        const mainCtx = document.getElementById('mainChart').getContext('2d');
        new Chart(mainCtx, {
            type: 'bar',
            data: @json($chartData),
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // We use custom legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        stacked: false,
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                }
            }
        });

        // Pemasukan by Category Chart
        @if(count($kategoriData['masuk']['labels']) > 0)
            const masukCtx = document.getElementById('masukChart').getContext('2d');
            new Chart(masukCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($kategoriData['masuk']['labels']),
                    datasets: [{
                        data: @json($kategoriData['masuk']['data']),
                        backgroundColor: @json($kategoriData['masuk']['colors']),
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return context.label + ': Rp ' + context.parsed.toLocaleString('id-ID') + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        @endif

        // Pengeluaran by Category Chart
        @if(count($kategoriData['keluar']['labels']) > 0)
            const keluarCtx = document.getElementById('keluarChart').getContext('2d');
            new Chart(keluarCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($kategoriData['keluar']['labels']),
                    datasets: [{
                        data: @json($kategoriData['keluar']['data']),
                        backgroundColor: @json($kategoriData['keluar']['colors']),
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return context.label + ': Rp ' + context.parsed.toLocaleString('id-ID') + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        @endif
    @endif
</script>
@endsection
