<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Kartu Anggota - PDF A4</title>
    <style>
        @page { size: A4; margin: 10mm; }
        html, body { width: 210mm; height: 297mm; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; margin: 0; }
        .page { page-break-after: always; }
        .page:last-child { page-break-after: auto; }
        .grid { display: grid; grid-template-columns: repeat(2, 90mm); grid-auto-rows: 55mm; gap: 5mm; }
        .card-wrapper { background: #ffffff; border-radius: 4mm; overflow: hidden; width: 90mm; height: 55mm; border: 0.3mm solid rgba(25,118,210,0.2); position: relative; }
        .card-header { background: linear-gradient(135deg, #0d47a1 0%, #1976d2 50%, #2196f3 100%); color: #fff; padding: 3mm; position: relative; }
        .card-header .title { font-size: 10pt; line-height: 12pt; font-weight: 800; letter-spacing: 0.4px; text-transform: uppercase; white-space: nowrap; }
        .card-header .subtitle { font-size: 7pt; opacity: 0.95; white-space: nowrap; }
        .logo-right { position: absolute; right: 3mm; top: 3mm; width: 10mm; height: 10mm; border-radius: 50%; background: rgba(255,255,255,0.18); display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .logo-right img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .card-body { padding: 3mm; display: grid; grid-template-columns: 27mm 1fr; gap: 2mm; }
        .photo { width: 27mm; height: 38mm; border-radius: 2mm; background: #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 0.2mm solid #e7e7e7; }
        .photo img { width: 100%; height: 100%; object-fit: cover; }
        .info-table { width: 100%; font-size: 9.5pt; border-collapse: collapse; table-layout: fixed; }
        .info-table td { padding: 0.6mm 0; vertical-align: top; line-height: 1.3; text-align: left; }
        .label { width: 22mm; color: #0d47a1; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; white-space: nowrap; text-align: left; }
        .colon { width: 3mm; color: #7a7a7a; text-align: center; }
        .value { color: #1f2937; font-weight: 600; text-align: left; }
        .barcode-fixed { position: absolute; right: 3mm; bottom: 3mm; }
        .footer { height: 0; }

        @media print {
            .card-wrapper { box-shadow: none; }
        }
    </style>
</head>
<body>
    @foreach($anggotas->chunk(8) as $chunk)
    <div class="page">
        <div class="grid">
        @foreach($chunk as $anggota)
            @php
                $wilayahCabang = \App\Models\Wilayah::where('parent_id_cabang', $anggota->parent_id_cabang)->first();
                $provinsiNama = $wilayahCabang && $wilayahCabang->parent ? $wilayahCabang->parent->nama : null;
                $cabangNama = $wilayahCabang ? $wilayahCabang->nama : null;
                $qrText = route('anggota.profil', $anggota->id);
            @endphp
            <div class="card-wrapper">
                <div class="card-header">
                    <div class="logo-right">
                        <img src="{{ asset('images/rtik.jpg') }}" alt="Logo">
                    </div>
                    <div class="title">Kartu anggota Relawan TIK</div>
                    <div class="subtitle">Identitas anggota</div>
                </div>
                <div class="card-body">
                    <div class="photo">
                        @if($anggota->foto)
                            <img src="{{ asset('storage/anggotas/' . $anggota->foto) }}" alt="{{ $anggota->nama }}">
                        @else
                            <span style="font-size:12pt;color:#888;">No Foto</span>
                        @endif
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
                <div class="footer"></div>
                <div class="barcode-fixed">
                    <div id="qrcode-card-{{ $anggota->id }}" style="width:60px;height:60px;"></div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    @endforeach
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        (function(){
            var items = @json($anggotas->pluck('id'));
            items.forEach(function(id){
                var el = document.getElementById('qrcode-card-' + id);
                if (el) {
                    new QRCode(el, {
                        text: '{{ url('/anggota/profil') }}/' + id,
                        width: 60,
                        height: 60,
                        colorDark: '#000000',
                        colorLight: '#ffffff',
                        correctLevel: QRCode.CorrectLevel.H
                    });
                }
            });
            setTimeout(function(){ window.print(); }, 600);
        })();
    </script>
</body>
</html>
