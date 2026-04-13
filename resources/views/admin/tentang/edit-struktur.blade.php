@extends('admin.layouts.app')

@section('title', 'Edit Struktur Organisasi')

@section('page-title', 'EDIT STRUKTUR ORGANISASI')

@section('styles')
<style>
    .struktur-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-left: 5px solid #1976d2;
    }
    
    .position-title {
        color: #1976d2;
        font-weight: 700;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
    }
</style>
@endsection

@section('content')

<div class="row">
    @foreach($positions as $key => $label)
    @php
        // Determine the array key for $struktur based on logic in controller
        $strukturKey = '';
        $isSingular = in_array($key, ['Ketua umum', 'Wakil ketua', 'Sekretaris', 'Bendahara']);
        
        if ($key == 'Ketua umum') $strukturKey = 'ketua_umum';
        elseif ($key == 'Wakil ketua') $strukturKey = 'wakil_ketua';
        elseif ($key == 'Sekretaris') $strukturKey = 'sekretaris';
        elseif ($key == 'Bendahara') $strukturKey = 'bendahara';
        elseif (str_contains($key, 'kesekretariatan')) $strukturKey = 'kesekretariatan';
        elseif (str_contains($key, 'kemitraan')) $strukturKey = 'kemitraan_legal';
        elseif (str_contains($key, 'program')) $strukturKey = 'program_aptika';
        elseif (str_contains($key, 'penelitian')) $strukturKey = 'penelitian_sdm';
        elseif (str_contains($key, 'komunikasi')) $strukturKey = 'komunikasi_publik';

        $currentHolders = [];
        if (isset($struktur[$strukturKey])) {
            if ($isSingular) {
                $currentHolders[] = $struktur[$strukturKey];
            } else {
                $currentHolders = $struktur[$strukturKey];
            }
        }
    @endphp

    <div class="col-md-6 mb-4">
        <div class="struktur-card">
            <h5 class="position-title">{{ $label }}</h5>
            
            <!-- List Current Members -->
            @if(count($currentHolders) > 0)
                <div class="mb-3">
                    <label class="form-label text-muted small">Pejabat Saat Ini:</label>
                    <ul class="list-group">
                        @foreach($currentHolders as $holder)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $holder->nama }}</strong>
                                <br>
                                <small class="text-muted">{{ $holder->email }}</small>
                            </div>
                            <form action="{{ route('admin.tentang.struktur.remove') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini dari struktur?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="member_id" value="{{ $holder->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus dari jabatan">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="alert alert-light mb-3 text-center">
                    <small class="text-muted">Belum ada pejabat yang ditunjuk</small>
                </div>
            @endif

            <!-- Add New Member -->
            <form action="{{ route('admin.tentang.struktur.update') }}" method="POST">
                @csrf
                <input type="hidden" name="jabatan" value="{{ $key }}">
                
                <div class="input-group">
                    <select name="member_id" class="form-select" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}">{{ $member->nama }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tetapkan
                    </button>
                </div>
                @if($isSingular && count($currentHolders) > 0)
                    <div class="form-text text-warning small">
                        <i class="fas fa-exclamation-triangle"></i> Menetapkan anggota baru akan menggantikan pejabat saat ini.
                    </div>
                @endif
            </form>
        </div>
    </div>
    @endforeach
</div>

@endsection
