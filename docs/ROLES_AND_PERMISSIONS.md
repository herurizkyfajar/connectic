# Hak Akses & Role Pengguna

Dokumen ini menjelaskan struktur peran (role), hierarki pengguna, serta hak akses dan batasan yang berlaku dalam aplikasi **ConnecTIK**.

## 1. Jenis User (Tipe Pengguna)

Sistem ini membagi pengguna menjadi dua kategori utama:
1.  **Administrator (Admin)**: Pengelola sistem dan organisasi.
2.  **Anggota**: Pengguna umum (member) organisasi.

### Kategori Admin
Admin memiliki tingkatan (level) yang menentukan cakupan data yang dapat dikelola:

| Role | Deskripsi | Cakupan Data (Scope) |
| :--- | :--- | :--- |
| **Admin Nasional** | Administrator tertinggi (Super Admin). | Seluruh Indonesia (Semua Provinsi & Cabang). |
| **Admin Wilayah** | Pengurus tingkat Provinsi. | Hanya Provinsi terkait dan Kota/Kab di bawahnya. |
| **Admin Cabang** | Pengurus tingkat Kabupaten/Kota. | Hanya Kabupaten/Kota terkait. |
| **Pembina** | Pengawas atau penasihat. | Seluruh data (Umumnya *Read-Only*). |

---

## 2. Hak dan Batasan Masing-Masing Role

Berikut adalah detail matriks izin akses untuk setiap peran:

### A. Admin Nasional (Super Admin)
Role ini memegang kendali penuh atas sistem.
*   **Hak Akses:**
    *   **Akses Penuh**: Dapat mengakses semua menu dan fitur.
    *   **Manajemen Wilayah**: Menambah, mengedit, menghapus data Provinsi dan Kabupaten/Kota se-Indonesia.
    *   **Manajemen Admin**: Membuat akun untuk Admin Wilayah dan Cabang.
    *   **Global Monitoring**: Melihat statistik dan analisis keaktifan seluruh level.
    *   **Konten Global**: Mengelola "Tentang RTIK", LMS (Academy), dan Sertifikat.

### B. Admin Wilayah
Bertanggung jawab atas satu provinsi.
*   **Hak Akses:**
    *   **Manajemen Wilayah**: Mengelola data Kabupaten/Kota di bawah provinsinya.
    *   **Manajemen Anggota**: Mengelola anggota yang terdaftar di provinsi tersebut.
    *   **Operasional**: Mengelola Kegiatan, Meeting Notes, Pengajuan, dan Keuangan tingkat provinsi.
*   **Batasan:**
    *   Tidak bisa melihat/mengedit data provinsi lain.
    *   Tidak bisa mengubah pengaturan sistem global (Tentang RTIK).

### C. Admin Cabang
Bertanggung jawab atas satu kabupaten/kota.
*   **Hak Akses:**
    *   **Manajemen Anggota**: Membuat dan mengelola data anggota di cabangnya.
    *   **Kegiatan**: Membuat dan mengelola kegiatan cabang.
    *   **Absensi**: Melakukan absensi peserta kegiatan cabang.
*   **Batasan:**
    *   **Sertifikat**: Tidak dapat menerbitkan sertifikat (harus melalui Wilayah/Nasional).
    *   **Konten Informasi**: Tidak dapat mengubah "Tentang RTIK".
    *   Tidak bisa melihat data cabang lain.

### D. Pembina
Peran khusus untuk pemantauan.
*   **Hak Akses:**
    *   **Dashboard**: Melihat statistik utama.
    *   **Monitoring**: Melihat daftar anggota, daftar kegiatan, dan analisis keaktifan.
    *   **Ranking**: Melihat peringkat keaktifan anggota/wilayah.
*   **Batasan:**
    *   **Read-Only**: Tidak dapat menambah, mengedit, atau menghapus data (Anggota, Kegiatan, Keuangan, dll).
    *   Tidak memiliki akses ke menu operasional (Absensi, Pengajuan, Meeting Notes).

### E. Anggota
Pengguna akhir aplikasi.
*   **Hak Akses:**
    *   **Profil**: Mengelola data diri dan foto profil.
    *   **Academy (LMS)**: Mengakses materi pembelajaran dan menandai progres baca.
    *   **Kegiatan**: Melihat kalender kegiatan dan detail acara.
    *   **Dokumen**: Mengunduh sertifikat milik sendiri.
*   **Batasan:**
    *   Tidak dapat melihat data pribadi anggota lain (kecuali yang bersifat publik).
    *   Tidak dapat masuk ke panel Admin.

---

## 3. Matriks Ringkasan Fitur

| Fitur | Admin Nasional | Admin Wilayah | Admin Cabang | Pembina | Anggota |
| :--- | :---: | :---: | :---: | :---: | :---: |
| **Login Admin** | ✅ | ✅ | ✅ | ✅ | ❌ |
| **Login Anggota** | ❌ | ❌ | ❌ | ❌ | ✅ |
| **Kelola Wilayah** | ✅ (Semua) | ✅ (Sub) | ❌ | 👁️ (Lihat) | ❌ |
| **Kelola Anggota** | ✅ | ✅ | ✅ | 👁️ (Lihat) | ❌ |
| **Kelola Kegiatan** | ✅ | ✅ | ✅ | 👁️ (Lihat) | 👁️ (Lihat) |
| **Absensi** | ✅ | ✅ | ✅ | ❌ | ❌ |
| **Sertifikat** | ✅ | ✅ | ❌ | ❌ | 📥 (Unduh) |
| **LMS (Academy)** | ✅ | ✅ | ✅ | ❌ | 📖 (Baca) |
| **Keuangan** | ✅ | ✅ | ✅ | ❌ | ❌ |
| **Pengajuan** | ✅ | ✅ | ✅ | ❌ | ❌ |
| **Tentang RTIK** | ✅ | ✅ | ❌ | 👁️ (Lihat) | 👁️ (Lihat) |

> **Keterangan:**
> *   ✅ : Akses Penuh (Create, Read, Update, Delete)
> *   👁️ : Hanya Melihat (Read Only)
> *   ❌ : Tidak Ada Akses
> *   📥 : Hanya Download
> *   📖 : Hanya Baca/Belajar
