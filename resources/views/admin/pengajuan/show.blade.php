@extends('admin.layouts.app')

@section('title', 'Detail Pengajuan')
@section('page-title', 'DETAIL PENGAJUAN')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Pengajuan</h5>
                    <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Judul Pengajuan</th>
                            <td>{{ $pengajuan->judul_pengajuan }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <td>{{ $pengajuan->tanggal_pengajuan->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($pengajuan->status == 'Pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($pengajuan->status == 'Disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($pengajuan->status == 'Ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">{{ $pengajuan->status }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Wilayah</th>
                            <td>
                                @if($pengajuan->parent)
                                    {{ $pengajuan->parent->name }} ({{ $pengajuan->parent->username }})
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Cabang</th>
                            <td>
                                @if($pengajuan->parentCabang)
                                    {{ $pengajuan->parentCabang->name }} ({{ $pengajuan->parentCabang->username }})
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Link Berkas</th>
                            <td>
                                @if($pengajuan->link_berkas)
                                    <a href="{{ $pengajuan->link_berkas }}" target="_blank" class="btn btn-info btn-sm">
                                        <i class="fas fa-link"></i> Lihat Berkas
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{!! nl2br(e($pengajuan->deskripsi)) !!}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('pengajuan.edit', $pengajuan->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
