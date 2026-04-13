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

    .member-card-modal .card-wrapper { background: #ffffff; border-radius: 18px; overflow: hidden; width: 540px; height: 340px; border: 1px solid rgba(25,118,210,0.12); position: relative; display: inline-block; }
    .member-card-modal .card-header { background: linear-gradient(135deg, #0d47a1 0%, #1976d2 50%, #2196f3 100%); color: #fff; padding: 8px 10px; position: relative; }
    .member-card-modal .card-header .title { font-size: 18px; line-height: 30px; font-weight: 800; letter-spacing: 0.6px; text-transform: uppercase; }
    .member-card-modal .card-header .subtitle { font-size: 11px; opacity: 0.9; }
    .member-card-modal .logo-right { position: absolute; right: 10px; top: 8px; width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.18); display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .member-card-modal .logo-right img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .member-card-modal .card-body { padding: 8px 10px; display: grid; grid-template-columns: 162px 1fr; gap: 8px; }
    .member-card-modal .photo { width: 162px; height: 216px; border-radius: 8px; background: linear-gradient(180deg, #f7f7f7 0, #f1f1f1 100%); display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #e7e7e7; }
    .member-card-modal .photo img { width: 100%; height: 100%; object-fit: cover; }
        .member-card-modal .info-table { width: 100%; font-size: 13px; border-collapse: separate; border-spacing: 0 3px; }
        .member-card-modal .info-table td { padding: 0 5px; vertical-align: top; line-height: 18px; text-align: left; }
        .member-card-modal .label { width: 120px; color: #0d47a1; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; font-size: 13px; line-height: 18px; text-align: left; }
        .member-card-modal .colon { width: 12px; color: #8a8a8a; }
        .member-card-modal .value { color: #2a2a2a; font-weight: 600; font-size: 13px; line-height: 18px; text-align: left; }
    .member-card-modal .barcode-fixed { position: absolute; right: 10px; bottom: 8px; }
    
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
                <div class="d-flex gap-2">
                    <button type="button" id="downloadSelectedBtn" class="btn btn-outline-success btn-sm" onclick="downloadSelectedCardsZip()" disabled>
                        <i class="fas fa-file-archive me-2"></i>Download Terpilih (ZIP)
                    </button>
                    <button type="button" id="loadAllBtn" class="btn btn-outline-dark btn-sm" onclick="loadAllAnggota()">
                        <i class="fas fa-list me-2"></i>Tampil Semua (tanpa reload)
                    </button>
                    <a href="{{ route('anggota.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-2"></i>Tambah Anggota
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
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
                    <div class="col-md-3 mb-2">
                        <select class="form-select" name="provinsi" onchange="this.form.submit()">
                            <option value="">Semua Provinsi</option>
                            @isset($provinsiOptions)
                                @foreach($provinsiOptions as $p)
                                    <option value="{{ $p->id }}" {{ (string)request('provinsi') === (string)$p->id ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select class="form-select" name="cabang" onchange="this.form.submit()">
                            <option value="">Semua Cabang</option>
                            @isset($cabangOptions)
                                @foreach($cabangOptions as $c)
                                    <option value="{{ $c->parent_id_cabang }}" {{ (string)request('cabang') === (string)$c->parent_id_cabang ? 'selected' : '' }}>
                                        {{ $c->nama }}@if($c->parent) — {{ $c->parent->nama }} @endif
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </form>
                </div>
            @if($anggotas->count() > 0)

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 40px;"><input type="checkbox" id="selectAll"></th>
                                <th class="text-center" style="width: 70px;">Foto</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Jabatan</th>
                                <th>Aktif di</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach($anggotas as $anggota)
                                <tr>
                                    @php
                                        $wilayahCabang = \App\Models\Wilayah::where('parent_id_cabang', $anggota->parent_id_cabang)->first();
                                        $provinsiNama = $wilayahCabang && $wilayahCabang->parent ? $wilayahCabang->parent->nama : null;
                                        $cabangNama = $wilayahCabang ? $wilayahCabang->nama : null;
                                    @endphp
                                    <td class="text-center">
                                        <input type="checkbox" class="select-card"
                                               data-id="{{ $anggota->id }}"
                                               data-nama="{{ $anggota->nama }}"
                                               data-telepon="{{ $anggota->telepon }}"
                                               data-jenis_kelamin="{{ $anggota->jenis_kelamin }}"
                                               data-daerah="{{ ($cabangNama ?? '-') . ' — ' . ($provinsiNama ?? '-') }}"
                                               data-alamat="{{ $anggota->alamat }}"
                                               data-foto="{{ $anggota->foto ? asset('storage/anggotas/' . $anggota->foto) : '' }}">
                                    </td>
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
                                            @php
                                                $wilayahCabang = \App\Models\Wilayah::where('parent_id_cabang', $anggota->parent_id_cabang)->first();
                                                $provinsiNama = $wilayahCabang && $wilayahCabang->parent ? $wilayahCabang->parent->nama : null;
                                                $cabangNama = $wilayahCabang ? $wilayahCabang->nama : null;
                                            @endphp
                                            <button type="button" class="btn btn-success btn-sm" title="Download Kartu Nama"
                                                data-id="{{ $anggota->id }}"
                                                data-nama="{{ $anggota->nama }}"
                                                data-telepon="{{ $anggota->telepon }}"
                                                data-jenis_kelamin="{{ $anggota->jenis_kelamin }}"
                                                data-daerah="{{ ($cabangNama ?? '-') . ' — ' . ($provinsiNama ?? '-') }}"
                                                data-alamat="{{ $anggota->alamat }}"
                                                data-foto="{{ $anggota->foto ? asset('storage/anggotas/' . $anggota->foto) : '' }}"
                                                onclick="openDownloadCardModal(this)">
                                                <i class="fas fa-id-card"></i>
                                            </button>
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
                    @if(request()->has('search') || request('status') || request('jabatan') || request('provinsi') || request('cabang'))
                        <h5 class="text-muted">Tidak ada data sesuai filter</h5>
                        <p class="text-muted">Ubah filter atau reset untuk melihat semua data.</p>
                        <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-2"></i>Reset Filter
                        </a>
                    @else
                        <h5 class="text-muted">Belum ada data anggota</h5>
                        <p class="text-muted">Klik tombol "Tambah Anggota" untuk menambahkan anggota pertama.</p>
                        <a href="{{ route('anggota.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Anggota Pertama
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
    <div id="bulkCardRender" style="position: fixed; left: -10000px; top: -10000px; width:0; height:0; overflow:hidden;"></div>
    <div class="modal fade" id="downloadCardModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content member-card-modal">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-id-card me-2"></i>Preview Kartu Nama</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="card-wrapper mx-auto">
                        <div class="card-header">
                            <div class="logo-right">
                                <img src="{{ asset('images/rtik.jpg') }}" alt="Logo">
                            </div>
                            <div class="title">Kartu anggota Relawan TIK</div>
                            <div class="subtitle">Identitas anggota</div>
                        </div>
                        <div class="card-body">
                            <div class="photo">
                                <img id="cardFoto" src="" alt="Foto">
                            </div>
                            <table class="info-table">
                                <tr>
                                    <td class="label">NIA</td>
                                    <td class="colon">:</td>
                                    <td class="value"></td>
                                </tr>
                                <tr>
                                    <td class="label">Nama</td>
                                    <td class="colon">:</td>
                                    <td class="value" id="cardNama"></td>
                                </tr>
                                <tr>
                                    <td class="label">Telepon</td>
                                    <td class="colon">:</td>
                                    <td class="value" id="cardTelepon"></td>
                                </tr>
                                <tr>
                                    <td class="label">Jenis Kelamin</td>
                                    <td class="colon">:</td>
                                    <td class="value" id="cardJK"></td>
                                </tr>
                                <tr>
                                    <td class="label">Daerah</td>
                                    <td class="colon">:</td>
                                    <td class="value" id="cardDaerah"></td>
                                </tr>
                                <tr>
                                    <td class="label">Alamat</td>
                                    <td class="colon">:</td>
                                    <td class="value" id="cardAlamat"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="barcode-fixed">
                            <div id="qrcode-card-index" style="width:60px;height:60px;"></div>
                        </div>
                    </div>
                    <div class="mt-3 text-muted" id="downloadStatus" style="display:none;">Mengunduh...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="downloadMemberCardFromModal()">Download PNG</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
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

        const selectAll = document.getElementById('selectAll');
        const downloadBtn = document.getElementById('downloadSelectedBtn');
        function updateDownloadBtnState() {
            const selected = document.querySelectorAll('.select-card:checked');
            downloadBtn.disabled = selected.length === 0;
        }
        if (selectAll) {
            selectAll.addEventListener('change', function(){
                document.querySelectorAll('.select-card').forEach(cb => { cb.checked = selectAll.checked; });
                updateDownloadBtnState();
            });
        }
        document.querySelectorAll('.select-card').forEach(cb => {
            cb.addEventListener('change', function(){
                if (!this.checked && selectAll.checked) selectAll.checked = false;
                updateDownloadBtnState();
            });
        });
    });

    function openDownloadCardModal(btn) {
        const id = btn.getAttribute('data-id');
        const nama = btn.getAttribute('data-nama') || '';
        const telp = btn.getAttribute('data-telepon') || '';
        const jk = btn.getAttribute('data-jenis_kelamin') || '';
        const daerah = btn.getAttribute('data-daerah') || '';
        const alamat = btn.getAttribute('data-alamat') || '';
        const foto = btn.getAttribute('data-foto') || '';

        document.getElementById('cardNama').textContent = nama;
        document.getElementById('cardTelepon').textContent = telp || '-';
        document.getElementById('cardJK').textContent = jk || '-';
        document.getElementById('cardDaerah').textContent = daerah || '-';
        document.getElementById('cardAlamat').textContent = alamat || '-';

        const imgEl = document.getElementById('cardFoto');
        if (foto) { imgEl.src = foto; } else { imgEl.src = ''; }

        const qrEl = document.getElementById('qrcode-card-index');
        qrEl.innerHTML = '';
        new QRCode(qrEl, {
            text: '{{ url('/anggota/profil') }}' + '/' + id,
            width: 60,
            height: 60,
            colorDark: '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });

        const modalEl = document.getElementById('downloadCardModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
        setTimeout(downloadMemberCardFromModal, 600);
    }

    function downloadMemberCardFromModal() {
        const wrapper = document.querySelector('#downloadCardModal .card-wrapper');
        if (!wrapper) return;
        document.getElementById('downloadStatus').style.display = 'block';
        html2canvas(wrapper, { scale: 2, useCORS: true, backgroundColor: null }).then(function(canvas) {
            const image = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            const nama = document.getElementById('cardNama').textContent || 'Kartu-Anggota';
            link.download = 'Kartu-' + nama + '.png';
            link.href = image;
            link.click();
            document.getElementById('downloadStatus').style.display = 'none';
        });
    }

    async function renderCardPng(member) {
        const container = document.getElementById('bulkCardRender');
        const wrapper = document.createElement('div');
        wrapper.className = 'member-card-modal';
        wrapper.innerHTML = `
        <div class="card-wrapper">
            <div class="card-header">
                <div class="logo-right"><img src="{{ asset('images/rtik.jpg') }}" alt="Logo"></div>
                <div class="title">Kartu anggota Relawan TIK</div>
                <div class="subtitle">Identitas anggota</div>
            </div>
            <div class="card-body">
                <div class="photo">${member.foto ? `<img src="${member.foto}"/>` : '<span style="font-size:12pt;color:#888;">No Foto</span>'}</div>
                <table class="info-table">
                    <tr><td class="label">NIA</td><td class="colon">:</td><td class="value"></td></tr>
                    <tr><td class="label">Nama</td><td class="colon">:</td><td class="value">${member.nama || '-'}</td></tr>
                    <tr><td class="label">Telepon</td><td class="colon">:</td><td class="value">${member.telepon || '-'}</td></tr>
                    <tr><td class="label">Jenis Kelamin</td><td class="colon">:</td><td class="value">${member.jenis_kelamin || '-'}</td></tr>
                    <tr><td class="label">Daerah</td><td class="colon">:</td><td class="value">${member.daerah || '-'}</td></tr>
                    <tr><td class="label">Alamat</td><td class="colon">:</td><td class="value">${member.alamat || '-'}</td></tr>
                </table>
            </div>
            <div class="barcode-fixed"><div id="qrcode-card-bulk-${member.id}" style="width:60px;height:60px;"></div></div>
        </div>`;
        container.appendChild(wrapper);
        new QRCode(document.getElementById(`qrcode-card-bulk-${member.id}`), {
            text: '{{ url('/anggota/profil') }}' + '/' + member.id,
            width: 60,
            height: 60,
            colorDark: '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });
        await new Promise(r => setTimeout(r, 300));
        const card = wrapper.querySelector('.card-wrapper');
        const canvas = await html2canvas(card, { scale: 2, useCORS: true, backgroundColor: null });
        const dataUrl = canvas.toDataURL('image/png');
        container.removeChild(wrapper);
        return dataUrl;
    }

    async function downloadSelectedCardsZip() {
        const selected = Array.from(document.querySelectorAll('.select-card:checked'));
        if (selected.length === 0) return;
        const zip = new JSZip();
        const folder = zip.folder('kartu-anggota');
        for (const cb of selected) {
            const member = {
                id: cb.getAttribute('data-id'),
                nama: cb.getAttribute('data-nama'),
                telepon: cb.getAttribute('data-telepon'),
                jenis_kelamin: cb.getAttribute('data-jenis_kelamin'),
                daerah: cb.getAttribute('data-daerah'),
                alamat: cb.getAttribute('data-alamat'),
                foto: cb.getAttribute('data-foto')
            };
            const pngDataUrl = await renderCardPng(member);
            const base64 = pngDataUrl.split(',')[1];
            folder.file(`Kartu-${member.nama || member.id}.png`, base64, { base64: true });
        }
        const blob = await zip.generateAsync({ type: 'blob' });
        const ts = new Date();
        const name = `kartu-anggota-${ts.getFullYear()}${('0'+(ts.getMonth()+1)).slice(-2)}${('0'+ts.getDate()).slice(-2)}-${('0'+ts.getHours()).slice(-2)}${('0'+ts.getMinutes()).slice(-2)}.zip`;
        saveAs(blob, name);
    }

    async function loadAllAnggota() {
        const form = document.querySelector('form[action="{{ route('anggota.index') }}"]');
        const params = new URLSearchParams(new FormData(form));
        const url = '{{ route('anggota.api') }}' + '?' + params.toString();
        const loadBtn = document.getElementById('loadAllBtn');
        loadBtn.disabled = true;
        loadBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memuat...';
        try {
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            const json = await res.json();
            const tbody = document.getElementById('tableBody');
            const rows = [];
            json.items.forEach(item => {
                rows.push(`
                <tr>
                    <td class="text-center">
                        <input type="checkbox" class="select-card"
                               data-id="${item.id}"
                               data-nama="${item.nama || ''}"
                               data-telepon="${item.telepon || ''}"
                               data-jenis_kelamin="${item.jenis_kelamin || ''}"
                               data-daerah="${item.daerah || '-'}"
                               data-alamat="${item.alamat || ''}"
                               data-foto="${item.foto || ''}">
                    </td>
                    <td class="text-center">
                        ${item.foto ? `<img src="${item.foto}" alt="${item.nama}" class="avatar" style="cursor:pointer;">` : `<div class="avatar bg-secondary d-inline-flex align-items-center justify-content-center"><i class="fas fa-user text-white"></i></div>`}
                    </td>
                    <td>
                        <strong class="clickable-name">${item.nama}</strong>
                    </td>
                    <td>${item.email || ''}</td>
                    <td>${item.telepon || ''}</td>
                    <td>${item.jabatan ? `<span class="badge bg-info">${item.jabatan}</span>` : '<span class="text-muted">-</span>'}</td>
                    <td><span class="badge bg-secondary">-</span></td>
                    <td class="text-center">
                        <span class="badge ${item.status === 'Aktif' ? 'bg-success' : 'bg-danger'}">${item.status}</span>
                    </td>
                    <td class="text-center">
                        <div class="action-buttons">
                            <button type="button" class="btn btn-success btn-sm" title="Download Kartu Nama"
                                data-id="${item.id}"
                                data-nama="${item.nama || ''}"
                                data-telepon="${item.telepon || ''}"
                                data-jenis_kelamin="${item.jenis_kelamin || ''}"
                                data-daerah="${item.daerah || ''}"
                                data-alamat="${item.alamat || ''}"
                                data-foto="${item.foto || ''}"
                                onclick="openDownloadCardModal(this)">
                                <i class="fas fa-id-card"></i>
                            </button>
                        </div>
                    </td>
                </tr>`);
            });
            tbody.innerHTML = rows.join('');
            // Disable pagination controls when showing all
            const pagination = document.querySelector('nav[aria-label="Pagination"]');
            if (pagination) pagination.style.display = 'none';
            const info = document.querySelector('.pagination-info');
            if (info) info.innerHTML = `<i class="fas fa-info-circle me-2"></i>Menampilkan <strong>${json.count}</strong> anggota (tampil semua)`;
            // Rebind checkbox listeners
            document.querySelectorAll('.select-card').forEach(cb => {
                cb.addEventListener('change', function(){
                    updateDownloadBtnState();
                });
            });
        } catch (e) {
            alert('Gagal memuat semua anggota.');
        } finally {
            loadBtn.disabled = false;
            loadBtn.innerHTML = '<i class="fas fa-list me-2"></i>Tampil Semua (tanpa reload)';
        }
    }
</script>
@endsection
