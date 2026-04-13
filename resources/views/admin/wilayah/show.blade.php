@extends('admin.layouts.app')

@section('title', 'Detail Wilayah')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1"><i class="fas fa-map me-2"></i>Detail Wilayah</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.wilayah.index') }}">Kelola Wilayah</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.wilayah.edit', $wilayah->id) }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <form action="{{ route('admin.wilayah.destroy', $wilayah->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus wilayah ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger"><i class="fas fa-trash-alt me-1"></i> Hapus</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Nama</dt>
                        <dd class="col-sm-9">{{ $wilayah->nama }}</dd>

                        <dt class="col-sm-3">Tipe</dt>
                        <dd class="col-sm-9"><span class="badge bg-info">{{ ucfirst($wilayah->tipe) }}</span></dd>

                        <dt class="col-sm-3">Kode</dt>
                        <dd class="col-sm-9">{{ $wilayah->kode ?? '-' }}</dd>

                        <dt class="col-sm-3">Induk</dt>
                        <dd class="col-sm-9">{{ optional($wilayah->parent)->nama ?? '-' }}</dd>
                        
                        <dt class="col-sm-3">Admin Cabang</dt>
                        <dd class="col-sm-9">
                            @if($wilayah->parentCabangAdmin)
                                {{ $wilayah->parentCabangAdmin->name }} ({{ $wilayah->parentCabangAdmin->username }})
                            @else
                                -
                            @endif
                        </dd>

                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9">
                            <span class="badge {{ $wilayah->status === 'Aktif' ? 'bg-success' : 'bg-secondary' }}">{{ $wilayah->status }}</span>
                        </dd>

                        <dt class="col-sm-3">Deskripsi</dt>
                        <dd class="col-sm-9">{{ $wilayah->deskripsi ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Anggota Relasi Sama</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">Total: {{ $anggotaCount }}</div>
                    @if($anggotaCount > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($anggotaCabang as $a)
                                        <tr>
                                            <td>{{ $a->nama }}</td>
                                            <td>{{ $a->email }}</td>
                                            <td><span class="badge {{ $a->status === 'Aktif' ? 'bg-success' : 'bg-secondary' }}">{{ $a->status }}</span></td>
                                            <td class="text-end">
                                                <a href="{{ route('anggota.show', $a->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-muted">Belum ada anggota dengan relasi yang sama.</div>
                    @endif
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Kegiatan Relasi Sama</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">Total: {{ $kegiatanCount }}</div>
                    @if($kegiatanCount > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kegiatanCabang as $k)
                                        <tr>
                                            <td>{{ $k->judul }}</td>
                                            <td>{{ optional($k->tanggal_kegiatan)->format('d/m/Y') }}</td>
                                            <td><span class="badge {{ $k->status === 'Terlaksana' ? 'bg-success' : ($k->status === 'Ditunda' ? 'bg-warning' : 'bg-secondary') }}">{{ $k->status }}</span></td>
                                            <td class="text-end">
                                                <a href="{{ route('riwayat-kegiatan.show', $k->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-muted">Belum ada kegiatan dengan relasi yang sama.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Wilayah Turunan</h6>
                </div>
                <div class="card-body">
                    @if($wilayah->children->count() > 0)
                        <ul class="list-group">
                            @foreach($wilayah->children as $c)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $c->nama }} <small class="text-muted">({{ ucfirst($c->tipe) }})</small></span>
                                    <a href="{{ route('admin.wilayah.show', $c->id) }}" class="btn btn-sm btn-outline-secondary">Lihat</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-muted">Tidak ada wilayah turunan.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
