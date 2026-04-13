@extends('admin.layouts.app')

@section('title', 'Analisis Keaktifan Anggota')

@section('styles')
    <style>
        .analisis-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .filter-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .anggota-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #ddd;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .anggota-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .anggota-card.sangat-aktif {
            border-left-color: #4caf50;
            background: linear-gradient(to right, #f1f8f4 0%, #ffffff 10%);
        }

        .anggota-card.aktif {
            border-left-color: #2196f3;
            background: linear-gradient(to right, #e3f2fd 0%, #ffffff 10%);
        }

        .anggota-card.kurang-aktif {
            border-left-color: #ff9800;
            background: linear-gradient(to right, #fff3e0 0%, #ffffff 10%);
        }

        .anggota-card.tidak-aktif {
            border-left-color: #f44336;
            background: linear-gradient(to right, #ffebee 0%, #ffffff 10%);
        }

        .anggota-foto {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .anggota-info {
            flex: 1;
            margin-left: 20px;
        }

        .anggota-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .anggota-jabatan {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
        }

        .stat-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12px;
            color: #999;
            display: block;
        }

        .stat-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .progress-bar-custom {
            height: 8px;
            border-radius: 4px;
            background: #e0e0e0;
            overflow: hidden;
            margin-top: 10px;
        }

        .progress-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .badge-kategori {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge-sangat-aktif {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
            color: white;
        }

        .badge-aktif {
            background: linear-gradient(135deg, #2196f3, #42a5f5);
            color: white;
        }

        .badge-kurang-aktif {
            background: linear-gradient(135deg, #ff9800, #ffa726);
            color: white;
        }

        .badge-tidak-aktif {
            background: linear-gradient(135deg, #f44336, #ef5350);
            color: white;
        }

        .skor-badge {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 700;
            color: white;
            margin-left: 20px;
        }

        .skor-sangat-aktif {
            background: linear-gradient(135deg, #4caf50, #66bb6a);
        }

        .skor-aktif {
            background: linear-gradient(135deg, #2196f3, #42a5f5);
        }

        .skor-kurang-aktif {
            background: linear-gradient(135deg, #ff9800, #ffa726);
        }

        .skor-tidak-aktif {
            background: linear-gradient(135deg, #f44336, #ef5350);
        }

        .export-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .export-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .ranking-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .rank-1 {
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #000;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.5);
        }

        .rank-2 {
            background: linear-gradient(135deg, #c0c0c0, #e8e8e8);
            color: #000;
        }

        .rank-3 {
            background: linear-gradient(135deg, #cd7f32, #e89b6d);
            color: #fff;
        }

        .rank-other {
            background: #f5f5f5;
            color: #666;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="analisis-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-2">
                    <i class="fas fa-chart-line me-2"></i>
                    📊 Analisis Keaktifan Anggota
                </h3>
                <p class="mb-0 opacity-90">Data keaktifan anggota berdasarkan kehadiran kegiatan dan meeting (30 hari terakhir)</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Filter & Export -->
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.analisis-keaktifan') }}" id="filterForm">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-calendar-alt text-primary me-2" style="font-size: 20px;"></i>
                        <h6 class="mb-0 fw-bold">Filter Periode Waktu</h6>
                        @if(isset($periodeLabel))
                            <span class="badge bg-primary ms-3">{{ $periodeLabel }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Pilih Periode:</label>
                    <select name="periode" id="filterPeriode" class="form-select" onchange="togglePeriodeInputs()">
                        <option value="7_hari" {{ $filterPeriode == '7_hari' ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="30_hari" {{ $filterPeriode == '30_hari' ? 'selected' : '' }}>30 Hari Terakhir</option>
                        <option value="90_hari" {{ $filterPeriode == '90_hari' ? 'selected' : '' }}>90 Hari Terakhir</option>
                        <option value="bulan" {{ $filterPeriode == 'bulan' ? 'selected' : '' }}>Per Bulan</option>
                        <option value="tahun" {{ $filterPeriode == 'tahun' ? 'selected' : '' }}>Per Tahun</option>
                        <option value="rentang" {{ $filterPeriode == 'rentang' ? 'selected' : '' }}>Rentang Waktu</option>
                        <option value="semua" {{ $filterPeriode == 'semua' ? 'selected' : '' }}>Semua Waktu</option>
                    </select>
                </div>

                <!-- Filter Bulan -->
                <div class="col-md-2" id="filterBulanContainer" style="display: {{ $filterPeriode == 'bulan' ? 'block' : 'none' }};">
                    <label class="form-label small fw-bold">Bulan:</label>
                    <select name="bulan" class="form-select">
                        <option value="">Pilih Bulan</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create(null, $m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Filter Tahun (untuk bulan dan tahun) -->
                <div class="col-md-2" id="filterTahunContainer" style="display: {{ in_array($filterPeriode, ['bulan', 'tahun']) ? 'block' : 'none' }};">
                    <label class="form-label small fw-bold">Tahun:</label>
                    <select name="tahun" class="form-select">
                        @for($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Filter Rentang Waktu -->
                <div class="col-md-2" id="filterStartDateContainer" style="display: {{ $filterPeriode == 'rentang' ? 'block' : 'none' }};">
                    <label class="form-label small fw-bold">Tanggal Mulai:</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>

                <div class="col-md-2" id="filterEndDateContainer" style="display: {{ $filterPeriode == 'rentang' ? 'block' : 'none' }};">
                    <label class="form-label small fw-bold">Tanggal Akhir:</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>

                <div class="col-md-auto">
                    <label class="form-label small fw-bold">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>
                            Terapkan Filter
                        </button>
                        <a href="{{ route('admin.analisis-keaktifan') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-1"></i>
                            Reset
                        </a>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-filter text-primary me-2"></i>
                        <span class="fw-bold">Filter Kategori:</span>
                        <select id="filterKategori" class="form-select form-select-sm ms-2" style="width: 200px;">
                            <option value="all">Semua Kategori</option>
                            <option value="sangat-aktif">Sangat Aktif</option>
                            <option value="aktif">Aktif</option>
                            <option value="kurang-aktif">Kurang Aktif</option>
                            <option value="tidak-aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <button type="button" class="export-btn" onclick="exportPDF()">
                        <i class="fas fa-file-pdf me-2"></i>
                        Simpan sebagai PDF
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Anggota List -->
    <div id="anggotaList">
        @forelse($dataAnalisis as $index => $data)
            <div class="anggota-card {{ strtolower(str_replace(' ', '-', $data['kategori'])) }}" data-kategori="{{ strtolower(str_replace(' ', '-', $data['kategori'])) }}">
                <div class="d-flex align-items-start">
                    <!-- Ranking Number -->
                    <div class="ranking-number {{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : ($index == 2 ? 'rank-3' : 'rank-other')) }}">
                        {{ $index + 1 }}
                    </div>

                    <!-- Foto -->
                    <div>
                        @if($data['anggota']->foto)
                            <img src="{{ asset('storage/anggotas/' . $data['anggota']->foto) }}" alt="{{ $data['anggota']->nama }}" class="anggota-foto">
                        @else
                            <div class="anggota-foto" style="display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea, #764ba2); color: white; font-size: 32px; font-weight: 700;">
                                {{ strtoupper(substr($data['anggota']->nama, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="anggota-info">
                        <div class="anggota-name">
                            {{ $data['anggota']->nama }}
                            <span class="badge-kategori badge-{{ strtolower(str_replace(' ', '-', $data['kategori'])) }}">
                                @if($data['kategori'] == 'Sangat Aktif')
                                    <i class="fas fa-star"></i>
                                @elseif($data['kategori'] == 'Aktif')
                                    <i class="fas fa-thumbs-up"></i>
                                @elseif($data['kategori'] == 'Kurang Aktif')
                                    <i class="fas fa-exclamation-triangle"></i>
                                @else
                                    <i class="fas fa-times-circle"></i>
                                @endif
                                {{ $data['kategori'] }}
                            </span>
                        </div>
                        <div class="anggota-jabatan">
                            <i class="fas fa-briefcase me-1"></i>
                            {{ $data['anggota']->jabatan ?? 'Anggota' }}
                        </div>

                        <!-- Stats -->
                        <div class="mb-2">
                            <div class="stat-item">
                                <span class="stat-label">
                                    <i class="fas fa-calendar-check text-primary"></i>
                                    Kegiatan (Periode)
                                </span>
                                <span class="stat-value">{{ $data['kehadiran_kegiatan'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">
                                    <i class="fas fa-users text-purple"></i>
                                    Meeting (Periode)
                                </span>
                                <span class="stat-value">{{ $data['kehadiran_meeting'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">
                                    <i class="fas fa-history text-info"></i>
                                    Total Kegiatan
                                </span>
                                <span class="stat-value">{{ $data['total_kehadiran_kegiatan'] }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">
                                    <i class="fas fa-certificate text-warning"></i>
                                    Sertifikat
                                </span>
                                <span class="stat-value">{{ $data['jumlah_sertifikat'] }}</span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-chart-bar me-1"></i>
                                Persentase Kehadiran: <strong>{{ $data['persentase_kehadiran'] }}%</strong>
                            </small>
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: {{ $data['persentase_kehadiran'] }}%; background: linear-gradient(90deg, 
                                    @if($data['kategori'] == 'Sangat Aktif') #4caf50, #66bb6a
                                    @elseif($data['kategori'] == 'Aktif') #2196f3, #42a5f5
                                    @elseif($data['kategori'] == 'Kurang Aktif') #ff9800, #ffa726
                                    @else #f44336, #ef5350
                                    @endif
                                );"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Skor Badge -->
                    <div class="skor-badge skor-{{ strtolower(str_replace(' ', '-', $data['kategori'])) }}">
                        {{ $data['skor'] }}
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Belum ada data anggota aktif.
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Export to PDF with current filter parameters
    function exportPDF() {
        const form = document.getElementById('filterForm');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        
        // Open PDF export page in new tab
        window.open('{{ route("admin.analisis-keaktifan.export-pdf") }}?' + params.toString(), '_blank');
    }
    
    // Toggle periode inputs based on selection
    function togglePeriodeInputs() {
        const periode = document.getElementById('filterPeriode').value;
        
        // Hide all containers first
        document.getElementById('filterBulanContainer').style.display = 'none';
        document.getElementById('filterTahunContainer').style.display = 'none';
        document.getElementById('filterStartDateContainer').style.display = 'none';
        document.getElementById('filterEndDateContainer').style.display = 'none';
        
        // Show relevant containers
        if (periode === 'bulan') {
            document.getElementById('filterBulanContainer').style.display = 'block';
            document.getElementById('filterTahunContainer').style.display = 'block';
        } else if (periode === 'tahun') {
            document.getElementById('filterTahunContainer').style.display = 'block';
        } else if (periode === 'rentang') {
            document.getElementById('filterStartDateContainer').style.display = 'block';
            document.getElementById('filterEndDateContainer').style.display = 'block';
        }
    }
    
    // Filter by kategori
    document.getElementById('filterKategori').addEventListener('change', function() {
        const kategori = this.value;
        const cards = document.querySelectorAll('.anggota-card');
        
        cards.forEach(card => {
            if (kategori === 'all' || card.dataset.kategori === kategori) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        togglePeriodeInputs();
    });
</script>
@endsection

