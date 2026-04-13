# Metodologi Penelitian dan Pengembangan Sistem

Dokumen ini menjelaskan metode penelitian yang digunakan dalam pengembangan Sistem Informasi Manajemen Relawan TIK (RTIK).

## A. Metode Penelitian

Dalam penelitian ini, metode yang digunakan untuk pengumpulan data adalah sebagai berikut:

### 1. Observasi (*Observation*)
Penulis melakukan pengamatan langsung terhadap proses bisnis yang sedang berjalan di organisasi Relawan TIK. Fokus observasi meliputi:
- Alur pendaftaran dan pendataan anggota baru.
- Mekanisme absensi kegiatan yang masih dilakukan secara manual/semi-digital.
- Proses penerbitan dan distribusi sertifikat kegiatan.
- Kendala-kendala yang terjadi dalam manajemen data anggota dan pelaporan kegiatan.

### 2. Wawancara (*Interview*)
Penulis melakukan tanya jawab dengan pihak-pihak terkait, yaitu Pengurus Pusat (Admin Nasional) dan Pengurus Wilayah. Hal ini bertujuan untuk:
- Menggali kebutuhan fungsional sistem yang diharapkan.
- Memahami hierarki hak akses pengguna (Role Management).
- Mendapatkan masukan mengenai fitur-fitur prioritas seperti LMS dan Analisis Keaktifan.

### 3. Studi Pustaka (*Literature Review*)
Penulis mengumpulkan informasi dari berbagai sumber referensi seperti buku, jurnal ilmiah, dan dokumentasi teknis, yang meliputi:
- Konsep Sistem Informasi Manajemen (SIM).
- Dokumentasi Framework Laravel dan Database MySQL.
- Standar operasional prosedur (SOP) organisasi Relawan TIK.

---

## B. Metode Pengembangan Sistem

Metode pengembangan perangkat lunak yang digunakan dalam penelitian ini adalah **Model Waterfall** (*Air Terjun*). Model ini dipilih karena tahapan pengembangannya yang sistematis dan berurutan.

### 1. Analisis Kebutuhan (*Requirements Analysis*)
Pada tahap ini, dilakukan identifikasi kebutuhan sistem berdasarkan hasil pengumpulan data. Output dari tahap ini adalah dokumen Spesifikasi Kebutuhan Perangkat Lunak (SKPL) yang mencakup:
- Kebutuhan Fungsional (Manajemen Anggota, Kegiatan, Sertifikat).
- Kebutuhan Non-Fungsional (Spesifikasi Server, Keamanan).
- Pemodelan proses bisnis menggunakan diagram alur (*Flowchart*).

### 2. Desain Sistem (*System Design*)
Tahap perancangan sistem menerjemahkan kebutuhan ke dalam representasi perangkat lunak sebelum pengkodean dimulai.
- **Perancangan Unified Modeling Language (UML)**:
  - *Use Case Diagram*: Menggambarkan interaksi aktor dengan sistem.
  - *Activity Diagram*: Menggambarkan alur kerja aktivitas sistem.
  - *Sequence Diagram*: Menggambarkan interaksi antar objek dalam urutan waktu.
  - *Class Diagram*: Menggambarkan struktur statis kelas dalam sistem.
- **Perancangan Database**:
  - *Entity Relationship Diagram (ERD)*: Memodelkan struktur data dan relasi antar tabel.
- **Perancangan Antarmuka (UI/UX)**: Membuat rancangan tampilan aplikasi.

### 3. Implementasi & Pengkodean (*Implementation & Coding*)
Tahap ini merealisasikan desain menjadi baris kode program (*coding*) menggunakan teknologi:
- **Bahasa Pemrograman**: PHP (Backend), HTML/CSS/JS (Frontend).
- **Framework**: Laravel (versi terbaru).
- **Database**: MySQL/MariaDB.
- **Tools**: Visual Studio Code, Git, Composer.

### 4. Pengujian Sistem (*Testing*)
Pengujian dilakukan untuk memastikan sistem berjalan sesuai dengan kebutuhan dan bebas dari kesalahan (*bug*). Metode pengujian yang digunakan:
- **Black Box Testing**: Menguji fungsionalitas input dan output aplikasi tanpa melihat struktur kode internal. Fokus pengujian meliputi fitur Login, CRUD Anggota, Transaksi Absensi, dan Generate Sertifikat.

### 5. Pemeliharaan (*Maintenance*)
Tahap ini dilakukan setelah sistem diimplementasikan, meliputi:
- Perbaikan kesalahan yang baru ditemukan setelah deployment.
- Penyesuaian sistem dengan perubahan lingkungan (update server/browser).
- Peningkatan fitur (*upgrade*) sesuai masukan pengguna.
