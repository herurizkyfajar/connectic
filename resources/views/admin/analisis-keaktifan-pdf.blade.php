<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Analisis Keaktifan Anggota - {{ $periodeLabel }}</title>
    <style>
        @media print {
            @page {
                size: A4;
                margin: 15mm;
            }
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print {
                display: none !important;
            }
            .page-break {
                page-break-after: always;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #2196f3;
        }

        .header h1 {
            font-size: 20pt;
            color: #1976d2;
            margin-bottom: 5px;
        }

        .header .subtitle {
            font-size: 12pt;
            color: #666;
            margin-bottom: 10px;
        }

        .header .period {
            font-size: 13pt;
            font-weight: bold;
            color: #2196f3;
            background: #e3f2fd;
            padding: 8px 15px;
            border-radius: 5px;
            display: inline-block;
        }

        .header .generated {
            font-size: 9pt;
            color: #999;
            margin-top: 10px;
        }

        .summary-section {
            margin: 20px 0;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 8px;
        }

        .summary-section h2 {
            font-size: 14pt;
            color: #1976d2;
            margin-bottom: 10px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .summary-card {
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid;
        }

        .summary-card.sangat-aktif {
            background: #e8f5e9;
            border-color: #4caf50;
        }

        .summary-card.aktif {
            background: #e1f5fe;
            border-color: #2196f3;
        }

        .summary-card.kurang-aktif {
            background: #fff3e0;
            border-color: #ff9800;
        }

        .summary-card.tidak-aktif {
            background: #ffebee;
            border-color: #f44336;
        }

        .summary-card .number {
            font-size: 24pt;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .summary-card.sangat-aktif .number { color: #4caf50; }
        .summary-card.aktif .number { color: #2196f3; }
        .summary-card.kurang-aktif .number { color: #ff9800; }
        .summary-card.tidak-aktif .number { color: #f44336; }

        .summary-card .label {
            font-size: 10pt;
            font-weight: bold;
        }

        .data-section {
            margin: 20px 0;
        }

        .data-section h2 {
            font-size: 14pt;
            color: #1976d2;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #2196f3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 9pt;
        }

        thead {
            background: #2196f3;
            color: white;
        }

        th {
            padding: 8px 5px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #1976d2;
        }

        td {
            padding: 6px 5px;
            border: 1px solid #ddd;
        }

        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        tbody tr:hover {
            background: #e3f2fd;
        }

        .ranking {
            width: 35px;
            text-align: center;
            font-weight: bold;
        }

        .ranking-1 { background: #ffd700; color: #000; }
        .ranking-2 { background: #c0c0c0; color: #000; }
        .ranking-3 { background: #cd7f32; color: #fff; }

        .kategori-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8pt;
            font-weight: bold;
            color: white;
        }

        .kategori-badge.sangat-aktif { background: #4caf50; }
        .kategori-badge.aktif { background: #2196f3; }
        .kategori-badge.kurang-aktif { background: #ff9800; }
        .kategori-badge.tidak-aktif { background: #f44336; }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            font-size: 9pt;
            color: #666;
            text-align: center;
        }

        .print-button-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .btn-print {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 14pt;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-print i {
            margin-right: 8px;
        }

        .stats-inline {
            font-size: 8pt;
            color: #666;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Print Button (Hidden when printing) -->
    <div class="print-button-container no-print">
        <button onclick="window.print()" class="btn-print">
            <i class="fas fa-file-pdf"></i>
            Simpan sebagai PDF
        </button>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>📊 LAPORAN ANALISIS KEAKTIFAN ANGGOTA</h1>
        <div class="subtitle">RTIK - Relawan Teknologi Informasi dan Komunikasi</div>
        <div class="period">{{ $periodeLabel }}</div>
        <div class="generated">Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</div>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <h2>📈 Ringkasan Data</h2>
        <p><strong>Total Anggota Aktif:</strong> {{ $totalAnggota }} orang</p>
        
        <div class="summary-grid">
            <div class="summary-card sangat-aktif">
                <div class="number">{{ $sangat_aktif }}</div>
                <div class="label">Sangat Aktif</div>
                <div class="stats-inline">{{ $totalAnggota > 0 ? round(($sangat_aktif/$totalAnggota)*100, 1) : 0 }}%</div>
            </div>
            <div class="summary-card aktif">
                <div class="number">{{ $aktif }}</div>
                <div class="label">Aktif</div>
                <div class="stats-inline">{{ $totalAnggota > 0 ? round(($aktif/$totalAnggota)*100, 1) : 0 }}%</div>
            </div>
            <div class="summary-card kurang-aktif">
                <div class="number">{{ $kurang_aktif }}</div>
                <div class="label">Kurang Aktif</div>
                <div class="stats-inline">{{ $totalAnggota > 0 ? round(($kurang_aktif/$totalAnggota)*100, 1) : 0 }}%</div>
            </div>
            <div class="summary-card tidak-aktif">
                <div class="number">{{ $tidak_aktif }}</div>
                <div class="label">Tidak Aktif</div>
                <div class="stats-inline">{{ $totalAnggota > 0 ? round(($tidak_aktif/$totalAnggota)*100, 1) : 0 }}%</div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-section">
        <h2>📋 Detail Keaktifan Per Anggota</h2>
        
        <table>
            <thead>
                <tr>
                    <th class="ranking">#</th>
                    <th>Nama Anggota</th>
                    <th>Jabatan</th>
                    <th class="text-center">Kegiatan</th>
                    <th class="text-center">Meeting</th>
                    <th class="text-center">Skor</th>
                    <th class="text-center">Sertifikat</th>
                    <th class="text-center">% Hadir</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataAnalisis as $index => $data)
                    <tr>
                        <td class="ranking {{ $index == 0 ? 'ranking-1' : ($index == 1 ? 'ranking-2' : ($index == 2 ? 'ranking-3' : '')) }}">
                            {{ $index + 1 }}
                        </td>
                        <td><strong>{{ $data['anggota']->nama }}</strong></td>
                        <td>{{ $data['anggota']->jabatan ?? '-' }}</td>
                        <td class="text-center">{{ $data['kehadiran_kegiatan'] }}</td>
                        <td class="text-center">{{ $data['kehadiran_meeting'] }}</td>
                        <td class="text-center"><strong>{{ $data['skor'] }}</strong></td>
                        <td class="text-center">{{ $data['jumlah_sertifikat'] }}</td>
                        <td class="text-center">{{ $data['persentase_kehadiran'] }}%</td>
                        <td>
                            <span class="kategori-badge {{ strtolower(str_replace(' ', '-', $data['kategori'])) }}">
                                {{ $data['kategori'] }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Keterangan:</strong></p>
        <p>Skor = Kehadiran Kegiatan + Kehadiran Meeting dalam periode {{ $periodeLabel }}</p>
        <p>Kategori: Sangat Aktif (≥5), Aktif (3-4), Kurang Aktif (1-2), Tidak Aktif (0)</p>
        <p style="margin-top: 10px; font-size: 8pt; color: #999;">
            Dokumen ini dibuat secara otomatis oleh Sistem Informasi Manajemen RTIK<br>
            © {{ now()->year }} RTIK - Relawan Teknologi Informasi dan Komunikasi
        </p>
    </div>

    <script>
        // Auto print dialog on page load (optional)
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 500);
        // };
    </script>
</body>
</html>



