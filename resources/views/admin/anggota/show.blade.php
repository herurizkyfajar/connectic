@extends('admin.layouts.app')

@section('title', 'Detail Anggota')

@section('page-title', 'DETAIL ANGGOTA')

@section('styles')
<style>
    .profile-card {
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
        color: white;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);
    }
    
    .profile-image-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 1.5rem;
    }
    
    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
    
    .profile-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: white;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    }
    
    .info-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }
    
    .info-card-title {
        font-size: 0.875rem;
        color: #757575;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }
    
    .info-card-value {
        font-size: 1.25rem;
        color: #212121;
        font-weight: 500;
    }
    
    .info-card-icon {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }
    
    .info-item {
        padding: 1rem;
        border-left: 3px solid #1976d2;
        background: #fafafa;
        border-radius: 4px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        background: #f5f5f5;
        border-left-color: #1565c0;
        transform: translateX(3px);
    }
    
    .info-label {
        font-weight: 600;
        color: #424242;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
    }
    
    .info-label i {
        margin-right: 8px;
        color: #1976d2;
    }
    
    .info-value {
        color: #616161;
        font-size: 0.95rem;
    }
    
    .section-header {
        display: flex;
        align-items: center;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #e0e0e0;
    }
    
    .section-header i {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
    
    .stat-box {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border-left: 4px solid;
        transition: all 0.3s ease;
    }
    
    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    
    .stat-box.primary {
        border-left-color: #1976d2;
    }
    
    .stat-box.success {
        border-left-color: #4caf50;
    }
    
    .stat-box.info {
        border-left-color: #00bcd4;
    }
    
    .stat-box h3 {
        font-size: 2rem;
        font-weight: 500;
        margin: 0.5rem 0;
        color: #212121;
    }
    
    .stat-box p {
        margin: 0;
        color: #757575;
        font-size: 0.875rem;
    }

    .member-card .card-scroll { width: 100%; height: auto; overflow-x: auto; overflow-y: hidden; display: block; padding: 12px; box-sizing: border-box; }
    .member-card .card-wrapper { background: #ffffff; border-radius: 18px; box-shadow: 0 20px 50px rgba(0,0,0,0.12); overflow: hidden; width: 540px; height: 340px; border: 1px solid rgba(25,118,210,0.12); position: relative; display: inline-block; }
    .member-card .card-header { background: linear-gradient(135deg, #0d47a1 0%, #1976d2 50%, #2196f3 100%); color: #fff; padding: 8px 10px; position: relative; }
    .member-card .card-header::after { content: ""; position: absolute; right: -60px; top: -40px; width: 160px; height: 160px; background: radial-gradient(closest-side, rgba(255,255,255,0.18), transparent 70%); transform: rotate(25deg); }
    .member-card .card-header .title { font-size: 18px; line-height: 30px; font-weight: 800; letter-spacing: 0.6px; text-transform: uppercase; font-family: 'Montserrat','Inter','Roboto',sans-serif; }
    .member-card .card-header .subtitle { font-size: 11px; opacity: 0.9; }
    .member-card .logo-right { position: absolute; right: 10px; top: 8px; width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.18); display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px); overflow: hidden; }
    .member-card .logo-right img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .member-card .chip { display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; border-radius: 999px; font-weight: 600; font-size: 12px; margin-top: 10px; background: rgba(255,255,255,0.22); color: #fff; }
    .member-card .card-body { padding: 8px 10px; display: grid; grid-template-columns: 162px 1fr; gap: 8px; }
    .member-card .photo { width: 162px; height: 216px; border-radius: 8px; background: linear-gradient(180deg, #f7f7f7 0, #f1f1f1 100%); display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #e7e7e7; box-shadow: inset 0 1px 0 rgba(255,255,255,0.6); }
    .member-card .photo img { width: 100%; height: 100%; object-fit: cover; }
    .member-card .photo i { font-size: 64px; color: #888; }
    .member-card .info-table { width: 100%; font-size: 13px; border-collapse: separate; border-spacing: 0 3px; }
    .member-card .info-table td { padding: 0 5px; vertical-align: top; line-height: 18px; }
    .member-card .label { width: 120px; color: #0d47a1; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; font-size: 13px; line-height: 18px; }
    .member-card .colon { width: 12px; color: #8a8a8a; }
    .member-card .value { color: #2a2a2a; font-weight: 600; font-size: 13px; line-height: 18px; }
    .member-card .value.address { display: block; overflow: visible; line-height: 18px; }
    .member-card .divider { height: 1px; background: linear-gradient(90deg, transparent, rgba(0,0,0,0.08), transparent); margin: 10px 0; }
    .member-card .footer { display: block; padding: 0 10px 6px; }
    .member-card .note { color: #5a5a5a; font-size: 10px; }
    .member-card .info-col { display: flex; flex-direction: column; gap: 6px; }
    .member-card .barcode-fixed { position: absolute; right: 10px; bottom: 8px; }
</style>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        text: "{{ route('anggota.profil', $anggota->id) }}",
        width: 128,
        height: 128,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });

    var qrcodeCardEl = document.getElementById("qrcode-card");
    if (qrcodeCardEl) {
        new QRCode(qrcodeCardEl, {
            text: "{{ route('anggota.profil', $anggota->id) }}",
            width: 60,
            height: 60,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    }

    function downloadQRCode() {
        // Tunggu sebentar untuk memastikan QR code sudah di-render
        setTimeout(function() {
            var qrContainer = document.getElementById("qrcode");
            var img = qrContainer.getElementsByTagName("img")[0];
            
            // Jika img belum ada (karena qrcode.js menggunakan canvas dulu), coba ambil canvas
            if (!img) {
                var canvas = qrContainer.getElementsByTagName("canvas")[0];
                if (canvas) {
                    var image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
                    var link = document.createElement('a');
                    link.download = "QRCode-{{ $anggota->nama }}.png";
                    link.href = image;
                    link.click();
                }
            } else {
                // Jika sudah ada img tag (biasanya qrcode.js mengganti canvas dengan img)
                var link = document.createElement('a');
                link.download = "QRCode-{{ $anggota->nama }}.png";
                link.href = img.src;
                link.click();
            }
        }, 100);
    }

    function downloadMemberCardPng() {
        var el = document.querySelector('.member-card .card-wrapper');
        if (!el) return;
        html2canvas(el, { scale: 2, useCORS: true, backgroundColor: null }).then(function(canvas) {
            var image = canvas.toDataURL('image/png');
            var link = document.createElement('a');
            link.download = 'Kartu-{{ $anggota->nama }}.png';
            link.href = image;
            link.click();
        });
    }

    @if(request('download') === 'png')
    setTimeout(function(){
        downloadMemberCardPng();
    }, 700);
    @endif
</script>
@endsection

@section('content')
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="mb-4">
        <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
        <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <form action="{{ route('anggota.destroy', $anggota->id) }}" 
              method="POST" class="d-inline"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-2"></i>Hapus
            </button>
        </form>
    </div>

    <div class="row">
        <!-- Profile Card -->
        <div class="col-md-4 mb-4">
            @php
                $wilayahCabang = \App\Models\Wilayah::where('parent_id_cabang', $anggota->parent_id_cabang)->first();
                $provinsiNama = $wilayahCabang && $wilayahCabang->parent ? $wilayahCabang->parent->nama : null;
                $cabangNama = $wilayahCabang ? $wilayahCabang->nama : null;
            @endphp
            <div class="member-card">
                <div class="card-scroll">
                    <div class="card-wrapper">
                        <div class="card-header">
                            <div class="logo-right">
                                <img src="{{ asset('images/rtik.jpg') }}" alt="Logo" style="width:44px;height:44px;object-fit:cover;">
                            </div>
                            <div class="title">Kartu anggota Relawan TIK</div>
                            <div class="subtitle">Identitas anggota</div>
                        </div>
                        <div class="card-body">
                            <div class="photo">
                                @if($anggota->foto)
                                    <img src="{{ asset('storage/anggotas/' . $anggota->foto) }}" alt="{{ $anggota->nama }}">
                                @else
                                    <i class="fas fa-user" style="font-size:64px;color:#888;"></i>
                                @endif
                            </div>
                            <div class="info-col">
                                <table class="info-table">
                                    <tr>
                                        <td class="label">NIA</td>
                                        <td class="colon">:</td>
                                        <td class="value"></td>
                                    </tr>
                                    <tr>
                                        <td class="label">Nama</td>
                                        <td class="colon">:</td>
                                        <td class="value">{{ $anggota->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label">Telepon</td>
                                        <td class="colon">:</td>
                                        <td class="value">{{ $anggota->telepon ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label">Jenis Kelamin</td>
                                        <td class="colon">:</td>
                                        <td class="value">{{ $anggota->jenis_kelamin ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label">Daerah</td>
                                        <td class="colon">:</td>
                                        <td class="value">{{ ($cabangNama ?? '-') . ' — ' . ($provinsiNama ?? '-') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label">Alamat</td>
                                        <td class="colon">:</td>
                                        <td class="value address">{{ $anggota->alamat ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="footer"></div>
                        <div class="barcode-fixed">
                            <div id="qrcode-card" class="d-flex" style="width: fit-content;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-center mt-2">
                <button type="button" class="btn btn-sm btn-primary" onclick="downloadMemberCardPng()">
                    <i class="fas fa-download me-1"></i>Download Kartu (PNG)
                </button>
            </div>
        
            <!-- QR Code Card -->
            <div class="card mb-4 text-center p-3 shadow-sm border-0" style="border-radius: 8px;">
                <h6 class="text-muted mb-3" style="font-size: 0.875rem; font-weight: 500;">ID CARD DIGITAL</h6>
                <div id="qrcode" class="d-flex justify-content-center bg-white p-2 border rounded mx-auto" style="width: fit-content;"></div>
                <div class="mt-2 small text-muted">Scan untuk profil publik</div>
                <div class="d-flex gap-2 justify-content-center mt-3">
                    <button onclick="downloadQRCode()" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-download me-1"></i>Download
                    </button>
                    <a href="{{ route('anggota.profil', $anggota->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-external-link-alt me-1"></i>Lihat Profil
                    </a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="stat-box primary">
                        <i class="fas fa-certificate" style="font-size: 2rem; color: #1976d2;"></i>
                        <h3>{{ $sertifikats->count() }}</h3>
                        <p>Sertifikat</p>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="stat-box success">
                        <i class="fas fa-calendar-check" style="font-size: 2rem; color: #4caf50;"></i>
                        <h3>{{ $riwayatKegiatans->count() }}</h3>
                        <p>Kegiatan Diikuti</p>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="stat-box info">
                        <i class="fas fa-birthday-cake" style="font-size: 2rem; color: #00bcd4;"></i>
                        <h3>{{ $anggota->umur }}</h3>
                        <p>Tahun</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Information -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Lengkap
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-envelope"></i>Email
                                </div>
                                <div class="info-value">{{ $anggota->email }}</div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-phone"></i>Telepon
                                </div>
                                <div class="info-value">{{ $anggota->telepon }}</div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-calendar"></i>Tanggal Lahir
                                </div>
                                <div class="info-value">
                                    {{ $anggota->tanggal_lahir_formatted }} 
                                    <span class="badge bg-info ms-2">{{ $anggota->umur }} tahun</span>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-venus-mars"></i>Jenis Kelamin
                                </div>
                                <div class="info-value">{{ $anggota->jenis_kelamin }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-network-wired"></i>Aktif di
                                </div>
                                <div class="info-value">
                                    @php
                                        $aktifDi = is_array($anggota->aktif_di) ? $anggota->aktif_di : [];
                                        $labelMap = ['nasional' => 'Nasional', 'wilayah' => 'Wilayah', 'cabang' => 'Cabang', 'komisariat' => 'Komisariat'];
                                    @endphp
                                    @if(!empty($aktifDi))
                                        @foreach($aktifDi as $val)
                                            <span class="badge bg-info me-1">{{ $labelMap[$val] ?? ucfirst($val) }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-map-marker-alt"></i>Alamat
                                </div>
                                <div class="info-value">{{ $anggota->alamat }}</div>
                            </div>
                            
                            @if($anggota->pekerjaan)
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-briefcase"></i>Pekerjaan
                                </div>
                                <div class="info-value">{{ $anggota->pekerjaan }}</div>
                            </div>
                            @endif
                            
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-clock"></i>Terdaftar
                                </div>
                                <div class="info-value">{{ $anggota->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-edit"></i>Terakhir Diupdate
                                </div>
                                <div class="info-value">{{ $anggota->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    @if($anggota->keterangan)
                    <div class="info-item mt-3">
                        <div class="info-label">
                            <i class="fas fa-sticky-note"></i>Keterangan
                        </div>
                        <div class="info-value">{{ $anggota->keterangan }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Sertifikat -->
            <div class="card mt-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="mb-0">
                            <i class="fas fa-certificate me-2"></i>Riwayat Sertifikat
                        </h5>
                        <a href="{{ route('admin.sertifikat.create') }}?anggota_id={{ $anggota->id }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>Tambah Sertifikat
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($sertifikats->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-certificate fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-3">Anggota ini belum memiliki sertifikat</p>
                            <a href="{{ route('admin.sertifikat.create') }}?anggota_id={{ $anggota->id }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Sertifikat Pertama
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kegiatan</th>
                                        <th>Nomor Sertifikat</th>
                                        <th>Tanggal Terbit</th>
                                        <th>Penyelenggara</th>
                                        <th class="text-center">File</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sertifikats as $index => $sertifikat)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div><strong>{{ $sertifikat->riwayatKegiatan->judul }}</strong></div>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $sertifikat->riwayatKegiatan->tanggal_kegiatan_formatted }}
                                                </small>
                                            </td>
                                            <td>
                                                @if($sertifikat->nomor_sertifikat)
                                                    <code>{{ $sertifikat->nomor_sertifikat }}</code>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $sertifikat->tanggal_terbit_formatted }}</td>
                                            <td>{{ $sertifikat->penyelenggara }}</td>
                                            <td class="text-center">
                                                @if($sertifikat->file_sertifikat)
                                                    <a href="{{ route('admin.sertifikat.download', $sertifikat->id) }}" 
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Download File">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="{{ route('admin.sertifikat.show', $sertifikat->id) }}" 
                                                       class="btn btn-info btn-sm"
                                                       title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.sertifikat.edit', $sertifikat->id) }}" 
                                                       class="btn btn-warning btn-sm"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.sertifikat.destroy', $sertifikat->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus sertifikat ini?')">
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
                        
                        <div class="mt-3">
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Total Sertifikat:</strong> {{ $sertifikats->count() }} sertifikat
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Kegiatan -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>Riwayat Kegiatan Terakhir
                    </h5>
                </div>
                <div class="card-body">
                    @if($riwayatKegiatans->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Anggota ini belum mengikuti kegiatan apapun</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kegiatan</th>
                                        <th>Tanggal</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Jenis</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatKegiatans as $index => $kegiatan)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div><strong>{{ $kegiatan->judul }}</strong></div>
                                                <small class="text-muted">{{ Str::limit($kegiatan->deskripsi, 50) }}</small>
                                            </td>
                                            <td>
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $kegiatan->tanggal_kegiatan_formatted }}
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $kegiatan->waktu_mulai }} - {{ $kegiatan->waktu_selesai }}
                                                </small>
                                            </td>
                                            <td>
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ $kegiatan->lokasi }}
                                            </td>
                                            <td>
                                                <span class="badge {{ $kegiatan->status == 'Terlaksana' ? 'bg-success' : ($kegiatan->status == 'Dibatalkan' ? 'bg-danger' : 'bg-warning') }}">
                                                    {{ $kegiatan->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $kegiatan->jenis_kegiatan }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('riwayat-kegiatan.show', $kegiatan->id) }}" 
                                                   class="btn btn-sm btn-info"
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Total Kegiatan Diikuti:</strong> {{ $riwayatKegiatans->count() }} kegiatan (10 terakhir)
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
