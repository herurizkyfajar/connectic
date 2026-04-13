# Spesifikasi Kebutuhan Sistem (System Requirements Specification)

Dokumen ini menjelaskan kebutuhan fungsional dan non-fungsional untuk Sistem Informasi Relawan TIK (RTIK).

## A. Kebutuhan Fungsional (Functional Requirements)

### 1. Modul Manajemen Pengguna (Auth & Roles)
- **FR-01**: Sistem harus memungkinkan Admin untuk login menggunakan email dan password.
- **FR-02**: Sistem harus memungkinkan Anggota untuk login menggunakan kredensial yang diberikan.
- **FR-03**: Sistem harus membatasi akses fitur berdasarkan role pengguna (Admin Nasional, Admin Wilayah, Anggota).
- **FR-04**: Sistem harus memungkinkan Anggota untuk memperbarui profil data diri dan foto.

### 2. Modul Manajemen Anggota
- **FR-05**: Admin dapat melihat daftar seluruh anggota beserta status keaktifannya.
- **FR-06**: Admin dapat menambah, mengedit, dan menonaktifkan akun anggota.
- **FR-07**: Admin dapat mereset password anggota jika diperlukan.
- **FR-08**: Sistem harus dapat menampilkan profil publik anggota di Landing Page.

### 3. Modul Kegiatan & Absensi
- **FR-09**: Admin dapat membuat jadwal kegiatan baru (Nama, Tanggal, Lokasi, Deskripsi).
- **FR-10**: Admin dapat membuka dan menutup sesi absensi kegiatan.
- **FR-11**: Anggota dapat melakukan absensi pada kegiatan aktif.
- **FR-12**: Anggota wajib mengupload bukti foto saat melakukan absensi.
- **FR-13**: Admin dapat melakukan input absensi manual untuk anggota (bulk action).
- **FR-14**: Sistem harus merekap data kehadiran secara real-time.

### 4. Modul LMS (Learning Management System)
- **FR-15**: Admin dapat mengupload materi pembelajaran (Artikel, PDF, Link Video).
- **FR-16**: Anggota dapat mengakses dan membaca materi pembelajaran di menu Academy.
- **FR-17**: Sistem mencatat riwayat materi yang telah dibaca oleh anggota.

### 5. Modul Sertifikat & Dokumen
- **FR-18**: Sistem dapat men-generate sertifikat otomatis untuk peserta yang hadir dalam kegiatan.
- **FR-19**: Anggota dapat mencari dan mendownload sertifikat kegiatan yang diikutinya.
- **FR-20**: Admin dapat membuat dan menyimpan Notulensi Rapat (Meeting Notes).
- **FR-21**: Anggota dapat melihat arsip hasil rapat (Meeting Notes).

### 6. Modul Analisis & Pelaporan
- **FR-22**: Sistem menghitung skor keaktifan anggota berdasarkan frekuensi kehadiran dan akses LMS.
- **FR-23**: Sistem menampilkan Leaderboard/Ranking anggota teraktif.
- **FR-24**: Admin dapat mengunduh laporan rekapitulasi kehadiran dalam format PDF/Excel.

---

## B. Kebutuhan Non-Fungsional (Non-Functional Requirements)

1.  **Pengembang (Developer)**
    
    a.  **Kebutuhan Perangkat Lunak (*Software*), yang meliputi:**
        1)  Visual Studio Code atau PhpStorm untuk pengembangan kode program;
        2)  MySQL atau MariaDB sebagai manajemen database;
        3)  Google Chrome atau Microsoft Edge sebagai web browser;
        4)  Git untuk kontrol versi;
        5)  Composer untuk manajemen dependensi PHP;
        6)  XAMPP/Laragon sebagai local server environment.

    b.  **Kebutuhan minimum Perangkat Keras (*Hardware*), yang meliputi:**
        1)  Komputer pengembang menggunakan web browser chrome dengan minimum prosesor Intel Core i3 atau setara;
        2)  Memori (RAM) minimal 4 GB (disarankan 8 GB);
        3)  Ruang penyimpanan (Disk) minimal 20 GB tersedia.

2.  **Pengguna (User)**
    
    Pengguna, Admin Nasional, Admin Wilayah, dan Anggota Relawan menggunakan web browser Google Chrome atau Microsoft Edge minimal Windows 7 / 10 / 11; Masyarakat dan Anggota Relawan yang mengakses melalui perangkat mobile menggunakan sistem operasi minimal Android 7.0 atau iOS 12.

