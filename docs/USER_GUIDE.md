# Panduan Penggunaan Aplikasi ConnecTIK

Selamat datang di panduan penggunaan aplikasi **ConnecTIK**. Dokumen ini berisi penjelasan fitur, langkah-langkah penggunaan, dan ilustrasi untuk membantu Anda memaksimalkan penggunaan aplikasi ini.

---

## Daftar Isi
1. [Akses & Login](#1-akses--login)
2. [Panduan Panel Admin](#2-panduan-panel-admin)
   - [Dashboard](#21-dashboard)
   - [Manajemen Wilayah](#22-manajemen-wilayah)
   - [Manajemen Anggota](#23-manajemen-anggota)
   - [Kegiatan & Absensi](#24-kegiatan--absensi)
   - [LMS (Academy)](#25-lms-academy)
   - [Sertifikat](#26-sertifikat)
   - [Keuangan & Pengajuan](#27-keuangan--pengajuan)
3. [Panduan Panel Anggota](#3-panduan-panel-anggota)
   - [Beranda & Profil](#31-beranda--profil)
   - [Academy (LMS)](#32-academy-lms)
   - [Riwayat Kegiatan & Sertifikat](#33-riwayat-kegiatan--sertifikat)

---

## 1. Akses & Login

Aplikasi memiliki dua pintu masuk utama: satu untuk **Admin** (Pengurus) dan satu untuk **Anggota**.

### Halaman Publik
Halaman awal (`/`) menampilkan statistik umum, peta sebaran, dan berita kegiatan terbaru yang dapat diakses oleh siapa saja.

### Login Admin
Digunakan oleh Admin Nasional, Wilayah, Cabang, dan Pembina.
1. Buka URL `/admin/login`.
2. Masukkan **Email** dan **Password**.
3. Klik tombol **Login**.

> **Catatan:** Jika Anda lupa password, hubungi Admin Nasional atau IT Support.

### Login Anggota
Digunakan oleh seluruh anggota terdaftar.
1. Buka URL `/anggota/login`.
2. Masukkan **Nomor Anggota (NIA)** atau **Email**.
3. Masukkan **Password**.
4. Klik tombol **Masuk**.

---

## 2. Panduan Panel Admin

### 2.1. Dashboard
Setelah login, Anda akan diarahkan ke Dashboard. Tampilan dashboard menyesuaikan dengan peran (role) Anda.

*   **Admin Nasional:** Melihat statistik seluruh Indonesia.
*   **Admin Wilayah:** Melihat statistik provinsi yang dikelola.
*   **Admin Cabang:** Melihat statistik kabupaten/kota terkait.

**Fitur Utama Dashboard:**
*   **Kartu Statistik:** Jumlah Anggota, Kegiatan Terlaksana, Wilayah, dll.
*   **Grafik Keaktifan:** Visualisasi tren kegiatan.
*   **Peta Sebaran:** Lokasi anggota dan wilayah.

### 2.2. Manajemen Wilayah
*(Khusus Admin Nasional & Wilayah)*

Menu ini digunakan untuk mengatur struktur organisasi (Provinsi, Kabupaten/Kota, Komisariat).

**Langkah Menambah Wilayah:**
1. Klik menu **Kelola Wilayah** di sidebar.
2. Klik tombol **Tambah Wilayah**.
3. Isi form:
   - **Nama Wilayah**: Misal "Jawa Barat".
   - **Tipe**: Provinsi/Kabupaten/Kota.
   - **Kode Wilayah**: Kode unik (opsional).
   - **Admin Pengelola**: Pilih akun admin yang bertanggung jawab.
4. Klik **Simpan**.

### 2.3. Manajemen Anggota
Menu **Anggota** digunakan untuk mendata seluruh anggota organisasi.

**Langkah Menambah Anggota Baru:**
1. Masuk ke menu **Anggota**.
2. Klik **Tambah Anggota**.
3. Lengkapi formulir:
   - **Data Diri**: Nama, NIK, Email, No HP.
   - **Keanggotaan**: NIA (Nomor Induk Anggota), Jabatan, Tanggal Bergabung.
   - **Wilayah**: Pilih Provinsi dan Kab/Kota asal.
   - **Foto**: Upload foto profil (format JPG/PNG).
4. Klik **Simpan**.

> **Tips:** Gunakan fitur **Filter** di atas tabel untuk mencari anggota berdasarkan Nama, Wilayah, atau Status.

### 2.4. Kegiatan & Absensi
Menu ini adalah inti dari pencatatan aktivitas organisasi.

#### A. Membuat Kegiatan Baru
1. Buka menu **Kegiatan** -> **Riwayat Kegiatan**.
2. Klik **Tambah Kegiatan**.
3. Isi detail kegiatan:
   - **Judul & Deskripsi**.
   - **Waktu**: Tanggal, Jam Mulai, Jam Selesai.
   - **Jenis**: Rapat, Seminar, Pelatihan, dll.
   - **Status**: Terlaksana, Akan Datang, dll.
   - **Dokumentasi**: Upload foto kegiatan/laporan (PDF/Img).
4. Klik **Simpan**.

#### B. Mengisi Absensi Peserta
Setelah kegiatan dibuat, Anda bisa mencatat siapa saja yang hadir.
1. Di daftar kegiatan, klik tombol **Detail** (ikon mata) pada kegiatan yang dimaksud.
2. Scroll ke bagian **Peserta / Absensi**.
3. Anda bisa menambahkan peserta satu per satu atau menggunakan fitur **Absensi Massal** (jika tersedia).
4. Tentukan status kehadiran: *Hadir, Izin, Sakit, Tidak Hadir*.

#### C. Kalender Kegiatan
Klik menu **Kalender Kegiatan** untuk melihat jadwal dalam tampilan kalender bulanan. Klik pada tanggal/event untuk melihat detail ringkas.

### 2.5. LMS (Academy)
Fitur Learning Management System untuk berbagi materi pembelajaran kepada anggota.

**Langkah Membuat Materi:**
1. Masuk menu **LMS**.
2. Klik **Tambah Materi**.
3. Isi form:
   - **Judul Materi**.
   - **Kategori & Level** (Pemula/Menengah/Lanjut).
   - **Konten**: Tulis artikel atau embed video di editor teks.
   - **Cover**: Upload gambar sampul.
   - **Status**: Pilih *Published* agar bisa dilihat anggota.
4. Klik **Simpan**.

### 2.6. Sertifikat
Admin dapat menerbitkan sertifikat untuk anggota yang mengikuti kegiatan tertentu.

**Cara Menerbitkan Sertifikat:**
1. Buka menu **Sertifikat**.
2. Klik **Buat Sertifikat**.
3. Pilih **Anggota** penerima.
4. Pilih **Kegiatan** terkait (data diambil dari Riwayat Kegiatan).
5. Masukkan **Nomor Sertifikat** dan **Tanggal Terbit**.
6. Upload file sertifikat (PDF/Gambar) yang sudah didesain.
7. Klik **Simpan**.

### 2.7. Keuangan & Pengajuan
*   **Keuangan**: Catat pemasukan (iuran, donasi) dan pengeluaran organisasi.
*   **Pengajuan**: Buat proposal atau pengajuan dana ke tingkat di atasnya (misal Cabang ke Wilayah).

---

## 3. Panduan Panel Anggota

### 3.1. Beranda & Profil
Setelah login, anggota akan melihat **Beranda** yang berisi pengumuman atau statistik personal.

*   **Edit Profil**: Klik foto profil di pojok kanan atas -> **Profile**. Anda dapat memperbarui biodata, foto, dan password.

### 3.2. Academy (LMS)
Anggota dapat belajar mandiri melalui menu **Academy**.
1. Klik menu **Academy** (ikon topi wisuda).
2. Pilih materi yang ingin dipelajari.
3. Baca materi atau tonton video.
4. Klik tombol **Tandai Sudah Dibaca** (jika ada) untuk mencatat progres belajar Anda.

### 3.3. Riwayat Kegiatan & Sertifikat
Anggota dapat memantau keaktifan mereka sendiri.

*   **Kalender Kegiatan**: Melihat jadwal kegiatan organisasi.
*   **Sertifikat Saya**:
    1. Masuk ke menu **Profile** atau **Sertifikat**.
    2. Anda akan melihat daftar sertifikat yang diterbitkan untuk Anda.
    3. Klik tombol **Download** untuk mengunduh file sertifikat.

---

## Bantuan & Dukungan
Jika Anda mengalami kendala teknis atau menemukan *bug* pada aplikasi, silakan hubungi tim pengembang atau administrator sistem melalui email yang tertera di footer aplikasi.
