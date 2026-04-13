@extends('admin.layouts.app')

@section('title', 'Kelola Wilayah')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1"><i class="fas fa-map-marked-alt me-2"></i>Kelola Wilayah</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active">Kelola Wilayah</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.wilayah.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Tambah Wilayah
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('admin.wilayah.index') }}" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Cari nama/kode/tipe..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="tipe" class="form-select">
                            <option value="">Semua Tipe</option>
                            @foreach($tipeOptions as $t)
                                <option value="{{ $t }}" {{ request('tipe') == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-primary w-100" type="submit">
                            Filter
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>TIPE</th>
                            <th>KODE</th>
                            <th>NAMA</th>
                            <th>INDUK</th>
                            <th>ANGGOTA</th>
                            <th>KEGIATAN</th>
                            <th>STATUS</th>
                            <th class="text-end">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wilayahs as $w)
                            <tr>
                                <td>
                                    <span class="badge bg-info text-uppercase">{{ $w->tipe }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $w->kode ?? '-' }}</div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.wilayah.show', $w->id) }}" class="fw-bold text-decoration-none">{{ $w->nama }}</a>
                                </td>
                                <td>{{ optional($w->parent)->nama ?? '-' }}</td>
                                @php
                                    $cabangAdminId = $w->parent_id_cabang;
                                    $anggotaCount = $cabangAdminId
                                        ? \App\Models\Anggota::where('parent_id', $cabangAdminId)->count()
                                        : 0;
                                    $kegiatanCount = $cabangAdminId
                                        ? \App\Models\RiwayatKegiatan::where('parent_id', $cabangAdminId)->count()
                                        : 0;
                                @endphp
                                <td>{{ $anggotaCount }}</td>
                                <td>{{ $kegiatanCount }}</td>
                                <td>
                                    @if($w->status == 'Aktif')
                                        <span class="badge bg-success">AKTIF</span>
                                    @else
                                        <span class="badge bg-danger">{{ strtoupper($w->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.wilayah.edit', $w->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.wilayah.destroy', $w->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus wilayah ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                         @empty
                             <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data wilayah.</td>
                             </tr>
                         @endforelse
                    </tbody>
                </table>
            </div>

            {{ $wilayahs->links() }}
        </div>
    </div>
</div>
@endsection
