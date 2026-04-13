<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Anggota - {{ $anggota->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <style>
        body { background: radial-gradient(1200px 500px at 10% 10%, #eaf2ff 0, #f2f6ff 35%, #f6f8fc 100%); min-height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; overflow-x: auto; overflow-y: hidden; }
        .card-scroll { width: 100vw; height: 100vh; overflow-x: auto; overflow-y: hidden; display: block; padding: 12px; box-sizing: border-box; }
        .card-wrapper { background: #ffffff; border-radius: 18px; box-shadow: 0 20px 50px rgba(0,0,0,0.12); overflow: hidden; width: 540px; height: 340px; border: 1px solid rgba(25,118,210,0.12); position: relative; display: inline-block; }
        .card-header { background: linear-gradient(135deg, #0d47a1 0%, #1976d2 50%, #2196f3 100%); color: #fff; padding: 8px 10px; position: relative; }
        .card-header::after { content: ""; position: absolute; right: -60px; top: -40px; width: 160px; height: 160px; background: radial-gradient(closest-side, rgba(255,255,255,0.18), transparent 70%); transform: rotate(25deg); }
        .card-header .title { font-size: 18px; line-height: 30px; font-weight: 800; letter-spacing: 0.6px; text-transform: uppercase; font-family: 'Montserrat', 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card-header .subtitle { font-size: 11px; opacity: 0.9; }
        .logo-right { position: absolute; right: 10px; top: 8px; width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.18); display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px); overflow: hidden; }
        .logo-right img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .chip { display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; border-radius: 999px; font-weight: 600; font-size: 12px; margin-top: 10px; background: rgba(255,255,255,0.22); color: #fff; }
        .card-body { padding: 8px 10px; display: grid; grid-template-columns: 30% 1fr; gap: 8px; }
        .photo { width: 100%; aspect-ratio: 3 / 4; border-radius: 8px; background: linear-gradient(180deg, #f7f7f7 0, #f1f1f1 100%); display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #e7e7e7; box-shadow: inset 0 1px 0 rgba(255,255,255,0.6); }
        .photo img { width: 100%; height: 100%; object-fit: cover; }
        .info-table { width: 100%; font-size: 13px; border-collapse: separate; border-spacing: 0 3px; }
        .info-table td { padding: 0 5px; vertical-align: top; line-height: 18px; }
        .label { width: 120px; color: #0d47a1; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; font-size: 13px; line-height: 18px; }
        .colon { width: 12px; color: #8a8a8a; }
        .value { color: #2a2a2a; font-weight: 600; font-size: 13px; line-height: 18px; }
        .value.address { display: block; overflow: visible; line-height: 18px; }
        .divider { height: 1px; background: linear-gradient(90deg, transparent, rgba(0,0,0,0.08), transparent); margin: 10px 0; }
        .footer { display: block; padding: 0 10px 6px; }
        .note { color: #5a5a5a; font-size: 10px; }
        .info-col { display: flex; flex-direction: column; gap: 6px; }
        .barcode-box { background: transparent; border: none; border-radius: 0; padding: 0; display: flex; flex-direction: column; align-items: flex-end; }
        .barcode-fixed { position: absolute; right: 10px; bottom: 8px; }
    </style>
    <style>
        @media print {
            body { background: #ffffff; }
            .card-wrapper { width: 85.6mm; height: 53.98mm; box-shadow: none; border: 0; }
            .card-header { padding: 10mm 8mm 6mm; }
            .card-body { padding: 4mm 6mm; gap: 3mm; grid-template-columns: 30% 1fr; }
            .label { font-size: 9pt; }
            .value { font-size: 9.5pt; }
            .footer { padding: 0 6mm 4mm; grid-template-columns: 1fr 24mm; }
        }
    </style>
</head>
<body>
    @php
        $wilayahCabang = \App\Models\Wilayah::where('parent_id_cabang', $anggota->parent_id_cabang)->first();
        $provinsiNama = $wilayahCabang && $wilayahCabang->parent ? $wilayahCabang->parent->nama : null;
        $cabangNama = $wilayahCabang ? $wilayahCabang->nama : null;
        $qrText = route('anggota.profil', $anggota->id);
    @endphp
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
            <div id="qrcode" class="d-flex" style="width: fit-content;"></div>
        </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        new QRCode(document.getElementById("qrcode"), { text: "{{ $qrText }}", width: 60, height: 60, colorDark: "#000000", colorLight: "#ffffff", correctLevel: QRCode.CorrectLevel.H });
    </script>
</body>
</html>
