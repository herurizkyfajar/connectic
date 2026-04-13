<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use ZipArchive;

class DocsController extends Controller
{
    public function docx()
    {
        $filename = 'RTIK-App-Documentation.docx';
        $saveDir = storage_path('app/public/docs');
        if (!is_dir($saveDir)) {
            @mkdir($saveDir, 0775, true);
        }
        $filePath = $saveDir . DIRECTORY_SEPARATOR . $filename;
        $zip = new ZipArchive();
        $zip->open($filePath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/><Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/><Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/></Types>');
        $zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/><Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/></Relationships>');
        $core = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:dcmitype="http://purl.org/dc/dcmitype/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><dc:title>Dokumentasi Aplikasi RTIK</dc:title><dc:creator>RTIK System</dc:creator><cp:lastModifiedBy>RTIK System</cp:lastModifiedBy><dcterms:created xsi:type="dcterms:W3CDTF">'.now()->toIso8601String().'</dcterms:created><dcterms:modified xsi:type="dcterms:W3CDTF">'.now()->toIso8601String().'</dcterms:modified></cp:coreProperties>';
        $zip->addFromString('docProps/core.xml', $core);
        $zip->addFromString('docProps/app.xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties" xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes"><Application>RTIK</Application></Properties>');
        $lines = [];
        $lines[] = ['text' => 'Dokumentasi Aplikasi RTIK', 'bold' => true, 'size' => 16];
        $lines[] = ['text' => 'Versi: Laravel 12, PHP ^8.2'];
        $lines[] = ['text' => 'Tanggal: 23 Desember 2025'];
        $lines[] = ['break' => true];
        $lines[] = ['text' => 'Ringkasan', 'bold' => true];
        $lines[] = ['text' => 'Aplikasi RTIK mencakup pengelolaan anggota, kegiatan & absensi, sertifikat, meeting notes, LMS, keuangan, dan wilayah. Frontend menggunakan Blade/Bootstrap/Vite, backend Laravel & Eloquent.'];
        $lines[] = ['break' => true];
        $lines[] = ['text' => 'Teknologi', 'bold' => true];
        $lines[] = ['text' => '• Backend: Laravel 12, PHP ^8.2'];
        $lines[] = ['text' => '• Frontend: Blade, Bootstrap 5, Font Awesome, Vite + TailwindCSS'];
        $lines[] = ['text' => '• Database: MySQL/SQLite'];
        $lines[] = ['text' => '• Storage: Disk public untuk file'];
        $lines[] = ['break' => true];
        $lines[] = ['text' => 'Instalasi', 'bold' => true];
        $lines[] = ['text' => '• composer install'];
        $lines[] = ['text' => '• Salin .env dan set APP_KEY, database'];
        $lines[] = ['text' => '• php artisan key:generate'];
        $lines[] = ['text' => '• php artisan migrate'];
        $lines[] = ['text' => '• npm install && npm run build'];
        $lines[] = ['break' => true];
        $lines[] = ['text' => 'Konfigurasi', 'bold' => true];
        $lines[] = ['text' => '• .env: APP_NAME, APP_ENV, APP_DEBUG, APP_URL'];
        $lines[] = ['text' => '• .env: DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD'];
        $lines[] = ['text' => '• FILESYSTEM_DISK=public untuk akses file upload'];
        $lines[] = ['break' => true];
        $lines[] = ['text' => 'Fitur Utama', 'bold' => true];
        $lines[] = ['text' => '• Manajemen Anggota: CRUD, profil, beranda, daftar anggota'];
        $lines[] = ['text' => '• Riwayat Kegiatan & Absensi: CRUD, status kehadiran, bukti, kalender'];
        $lines[] = ['text' => '• Meeting Notes: CRUD, ranking kehadiran, nomor dokumen'];
        $lines[] = ['text' => '• LMS: konten, status publikasi, penandaan baca'];
        $lines[] = ['text' => '• Sertifikat Anggota: CRUD, unduh sertifikat'];
        $lines[] = ['text' => '• Keuangan: transaksi masuk/keluar, laporan'];
        $lines[] = ['text' => '• Wilayah: struktur bertingkat parent/children'];
        $lines[] = ['text' => '• Tentang RTIK: penjelasan dan struktur organisasi'];
        $lines[] = ['break' => true];
        $lines[] = ['text' => 'Rute Inti', 'bold' => true];
        $lines[] = ['text' => '• routes/web.php: Admin login, dashboard, CRUD modul'];
        $lines[] = ['text' => '• routes/web.php: Anggota login, beranda, profil, akademi, absensi, sertifikat'];
        $lines[] = ['text' => '• routes/web.php: Publik profil anggota read-only'];
        $lines[] = ['break' => true];
        $lines[] = ['text' => 'Model & Relasi', 'bold' => true];
        $lines[] = ['text' => '• Anggota: hasMany AbsensiKegiatan, hasMany SertifikatAnggota'];
        $lines[] = ['text' => '• RiwayatKegiatan: hasMany AbsensiKegiatan, hasMany SertifikatAnggota'];
        $lines[] = ['text' => '• AbsensiKegiatan: belongsTo Anggota, belongsTo RiwayatKegiatan'];
        $lines[] = ['text' => '• MeetingNote: generator nomor dokumen, tanggal format'];
        $lines[] = ['text' => '• Keuangan: scopes, format mata uang, URL bukti'];
        $lines[] = ['text' => '• Lms: konten pembelajaran'];
        $lines[] = ['text' => '• Wilayah: parent/children'];
        $lines[] = ['break' => true];
        $lines[] = ['text' => 'Skema Database', 'bold' => true];
        $lines[] = ['text' => '• anggotas: identitas, auth, status, jabatan, aktif_di (JSON)'];
        $lines[] = ['text' => '• riwayat_kegiatans: detail kegiatan, status'];
        $lines[] = ['text' => '• absensi_kegiatans: relasi anggota-kegiatan, kehadiran, bukti'];
        $lines[] = ['text' => '• sertifikat_anggotas: nomor, tanggal, penyelenggara, file'];
        $lines[] = ['text' => '• meeting_notes: metadata rapat dan hasil'];
        $lines[] = ['text' => '• lms, lms_reads: konten dan pembacaan'];
        $lines[] = ['text' => '• keuangans: transaksi keuangan'];
        $lines[] = ['text' => '• wilayahs: struktur bertingkat'];
        $lines[] = ['break' => true];
        $lines[] = ['text' => 'Keamanan', 'bold' => true];
        $lines[] = ['text' => '• Guard admin dan anggota'];
        $lines[] = ['text' => '• Validasi upload tipe/ukuran'];
        $lines[] = ['text' => '• Unique constraint absensi untuk cegah duplikasi'];
        $lines[] = ['break' => true];
        $lines[] = ['text' => 'Laporan & Analitik', 'bold' => true];
        $lines[] = ['text' => '• Analisis keaktifan anggota: kategori, persentase, skor'];
        $lines[] = ['text' => '• Ranking kehadiran meeting notes'];
        $lines[] = ['break' => true];
        $lines[] = ['text' => 'Deploy cPanel', 'bold' => true];
        $lines[] = ['text' => '• Gunakan cpanel_public_index.php sebagai public_html/index.php'];
        $lines[] = ['text' => '• Aplikasi Laravel diletakkan di folder terpisah'];
        $lines[] = ['break' => true];
        $lines[] = ['text' => 'Perintah Penting', 'bold' => true];
        $lines[] = ['text' => '• composer run setup'];
        $lines[] = ['text' => '• composer run test'];
        $lines[] = ['text' => '• php artisan config:clear'];
        $lines[] = ['break' => true];
        $lines[] = ['text' => 'Troubleshooting', 'bold' => true];
        $lines[] = ['text' => '• php artisan storage:link untuk akses file'];
        $lines[] = ['text' => '• npm run build untuk aset produksi'];
        $lines[] = ['text' => '• Periksa .env dan jalankan migrate jika error DB'];
        $lines[] = ['break' => true];
        $docStart = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><w:document xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape" mc:Ignorable="w14 wp14"><w:body>';
        $docEnd = '<w:sectPr><w:pgSz w:w="12240" w:h="15840"/><w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1440" w:header="720" w:footer="720" w:gutter="0"/></w:sectPr></w:body></w:document>';
        $xml = $docStart;
        foreach ($lines as $line) {
            if (isset($line['break'])) {
                $xml .= '<w:p/>';
                continue;
            }
            $text = htmlspecialchars($line['text'], ENT_XML1 | ENT_COMPAT, 'UTF-8');
            $rPr = '';
            if (!empty($line['bold'])) {
                $rPr .= '<w:rPr><w:b/></w:rPr>';
            } else {
                $rPr .= '<w:rPr/>';
            }
            $xml .= '<w:p><w:r>'.$rPr.'<w:t xml:space="preserve">'.$text.'</w:t></w:r></w:p>';
        }
        $xml .= $docEnd;
        $zip->addFromString('word/document.xml', $xml);
        $zip->close();
        return Response::download($filePath, $filename);
    }
}
