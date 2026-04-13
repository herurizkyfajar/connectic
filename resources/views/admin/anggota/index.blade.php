@extends('admin.layouts.app')

@section('title', 'Data Anggota')

@section('page-title', 'DATA ANGGOTA')

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

    .dashboard-card.info {
        border-left-color: #00bcd4;
        background: linear-gradient(135deg, #e0f7fa 0%, #f8fdff 100%);
    }

    .dashboard-card .card-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        margin-bottom: 8px;
    }

    .dashboard-card.primary .card-icon {
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
    }

    .dashboard-card.success .card-icon {
        background: linear-gradient(135deg, #4caf50 0%, #81c784 100%);
    }

    .dashboard-card.warning .card-icon {
        background: linear-gradient(135deg, #ff9800 0%, #ffb74d 100%);
    }

    .dashboard-card.info .card-icon {
        background: linear-gradient(135deg, #00bcd4 0%, #4dd0e1 100%);
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

        .dashboard-card .card-icon {
            width: 35px;
            height: 35px;
            font-size: 18px;
        }
    }
    
    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        transition: transform 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .avatar:hover {
        transform: scale(1.15);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .clickable-name {
        transition: color 0.3s ease;
        font-weight: 500;
    }
    .clickable-name:hover {
        color: #1976d2 !important;
        text-decoration: underline !important;
    }
    .action-buttons {
        display: flex;
        gap: 5px;
        justify-content: center;
    }
    
    /* Search & Filter Styling */
    .filter-section {
        background: #fafafa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    
    /* Table styling */
    .table tbody tr {
        transition: all 0.3s ease;
    }
    .table tbody tr:hover {
        background: #f8f9fa;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    /* Pagination styling */
    .pagination {
        gap: 5px;
    }
    .page-item .page-link {
        border-radius: 4px;
        border: 1px solid #e0e0e0;
        color: #424242;
        font-weight: 500;
        min-width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        padding: 0.5rem 0.75rem;
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
        border-color: #1976d2;
        color: white;
        box-shadow: 0 3px 10px rgba(25, 118, 210, 0.3);
    }
    .page-item .page-link:hover:not(.active) {
        background-color: #f5f5f5;
        border-color: #1976d2;
        color: #1976d2;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(25, 118, 210, 0.2);
    }
    .page-item.disabled .page-link {
        background-color: #fafafa;
        border-color: #e0e0e0;
        color: #9e9e9e;
        cursor: not-allowed;
    }
    .page-link:focus {
        box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.25);
        z-index: 3;
    }
    
    /* Pagination info */
    .pagination-info {
        color: #757575;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
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

    <!-- Statistics Cards - Horizontal Scrolling -->
    <div class="dashboard-cards-container">
        <div class="dashboard-cards">
            <div class="dashboard-card primary">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>{{ $countTotal }}</h3>
                <p>Total Anggota</p>
            </div>
            <div class="dashboard-card success">
                <div class="card-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <h3>{{ $countAktif }}</h3>
                <p>Anggota Aktif</p>
            </div>
            <div class="dashboard-card warning">
                <div class="card-icon">
                    <i class="fas fa-user-times"></i>
                </div>
                <h3>{{ $countTidakAktif }}</h3>
                <p>Tidak Aktif</p>
            </div>
            <div class="dashboard-card info">
                <div class="card-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3>{{ $countJabatan }}</h3>
                <p>Dengan Jabatan</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>Data Anggota
                </h5>
                <a href="{{ route('anggota.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-2"></i>Tambah Anggota
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($anggotas->count() > 0)
                <!-- Filter & Search Section -->
                <div class="filter-section">
                <form method="GET" action="{{ route('anggota.index') }}" class="row">
                    <div class="col-md-6 mb-2">
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Cari nama, email, telepon, atau jabatan..."
                                   value="{{ request('search') }}">
                            @if(request('search'))
                            <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary" title="Clear Search">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak aktif" {{ request('status') == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select class="form-select" name="jabatan" onchange="this.form.submit()">
                            <option value="">Semua Jabatan</option>
                            <option value="ketua umum" {{ request('jabatan') == 'ketua umum' ? 'selected' : '' }}>Ketua Umum</option>
                            <option value="wakil ketua" {{ request('jabatan') == 'wakil ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                            <option value="sekretaris" {{ request('jabatan') == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                            <option value="bendahara" {{ request('jabatan') == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                            <option value="bidang kesekretariatan" {{ request('jabatan') == 'bidang kesekretariatan' ? 'selected' : '' }}>Bidang Kesekretariatan</option>
                            <option value="bidang kemitraan dan legal" {{ request('jabatan') == 'bidang kemitraan dan legal' ? 'selected' : '' }}>Bidang Kemitraan dan Legal</option>
                            <option value="bidang program dan aptika" {{ request('jabatan') == 'bidang program dan aptika' ? 'selected' : '' }}>Bidang Program dan Aptika</option>
                            <option value="bidang penelitian dan pengembangan sumber daya manusia" {{ request('jabatan') == 'bidang penelitian dan pengembangan sumber daya manusia' ? 'selected' : '' }}>Bidang Penelitian dan Pengembangan SDM</option>
                            <option value="bidang komunikasi publik" {{ request('jabatan') == 'bidang komunikasi publik' ? 'selected' : '' }}>Bidang Komunikasi Publik</option>
                        </select>
                    </div>
                </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 70px;">Foto</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Jabatan</th>
                                <th>Aktif di</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach($anggotas as $anggota)
                                <tr>
                                    <td class="text-center">
                                        <a href="{{ route('anggota.show', $anggota->id) }}" class="d-inline-block" style="text-decoration: none;">
                                            @if($anggota->foto)
                                                <img src="{{ asset('storage/anggotas/' . $anggota->foto) }}" 
                                                     alt="{{ $anggota->nama }}" class="avatar" style="cursor: pointer;">
                                            @else
                                                <div class="avatar bg-secondary d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('anggota.show', $anggota->id) }}" class="text-decoration-none text-dark">
                                            <strong class="clickable-name">{{ $anggota->nama }}</strong>
                                        </a>
                                        @if($anggota->pekerjaan)
                                            <br><small class="text-muted">{{ $anggota->pekerjaan }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $anggota->email }}</td>
                                    <td>{{ $anggota->telepon }}</td>
                                    <td>
                                        @if($anggota->jabatan)
                                            <span class="badge bg-info">{{ $anggota->jabatan }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $aktifDi = is_array($anggota->aktif_di) ? $anggota->aktif_di : [];
                                            $labelMap = ['nasional' => 'Nasional', 'wilayah' => 'Wilayah', 'cabang' => 'Cabang', 'komisariat' => 'Komisariat'];
                                        @endphp
                                        @if(!empty($aktifDi))
                                            @foreach($aktifDi as $val)
                                                <span class="badge bg-secondary me-1">{{ $labelMap[$val] ?? ucfirst($val) }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $anggota->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $anggota->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="{{ route('anggota.show', $anggota->id) }}" 
                                               class="btn btn-info btn-sm" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('anggota.edit', $anggota->id) }}" 
                                               class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('anggota.destroy', $anggota->id) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
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
                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                    <div class="pagination-info mb-2 mb-md-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Menampilkan <strong>{{ $anggotas->firstItem() ?? 0 }}</strong> - <strong>{{ $anggotas->lastItem() ?? 0 }}</strong> dari <strong>{{ $anggotas->total() }}</strong> anggota
                    </div>
                    <nav aria-label="Pagination">
                        <ul class="pagination mb-0">
                            {{-- Previous Page Link --}}
                            @if ($anggotas->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $anggotas->previousPageUrl() }}" rel="prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @php
                                $start = max($anggotas->currentPage() - 2, 1);
                                $end = min($start + 4, $anggotas->lastPage());
                                $start = max($end - 4, 1);
                            @endphp

                            @if($start > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $anggotas->url(1) }}">1</a>
                                </li>
                                @if($start > 2)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $anggotas->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $anggotas->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            @if($end < $anggotas->lastPage())
                                @if($end < $anggotas->lastPage() - 1)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link" href="{{ $anggotas->url($anggotas->lastPage()) }}">{{ $anggotas->lastPage() }}</a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($anggotas->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $anggotas->nextPageUrl() }}" rel="next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data anggota</h5>
                    <p class="text-muted">Klik tombol "Tambah Anggota" untuk menambahkan anggota pertama.</p>
                    <a href="{{ route('anggota.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Anggota Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit form when typing (with debounce)
        const searchInput = document.querySelector('input[name="search"]');

        if (searchInput) {
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    // Auto-submit form after 500ms of no typing
                    if (this.value.length >= 2 || this.value.length === 0) {
                        this.closest('form').submit();
                    }
                }, 500);
            });
        }
    });
</script>
@endsection
