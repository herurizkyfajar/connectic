# Struktur dan Navigasi Aplikasi ConnecTIK

Dokumen ini menjelaskan struktur navigasi dan alur aplikasi berdasarkan peran pengguna (User Roles).

## 1. Diagram Navigasi Utama

```mermaid
graph TD
    %% Entry Points
    Start((Mulai)) --> Public[Halaman Publik]
    Public --> Landing[Landing Page]
    Public --> PubKegiatan[Daftar Kegiatan]
    Public --> PubDocs[Dokumentasi]
    Public --> Auth[Autentikasi]

    %% Authentication
    Auth --> LoginAdmin[Login Admin]
    Auth --> LoginAnggota[Login Anggota]

    %% Admin Roles Flow
    LoginAdmin --> |Valid| CheckRole{Cek Role}
    
    CheckRole --> |Admin Nasional| DashNas[Dashboard Nasional]
    CheckRole --> |Admin Wilayah| DashWil[Dashboard Wilayah]
    CheckRole --> |Admin Cabang/Lain| DashGen[Dashboard Umum]

    %% Anggota Flow
    LoginAnggota --> |Valid| AnggotaHome[Beranda Anggota]

    %% Admin Nasional Menu
    subgraph Admin_Nasional [Menu Admin Nasional]
        DashNas
        MenuNas1[Kelola Wilayah]
        MenuNas2[Kegiatan & Kalender]
        MenuNas3[Anggota]
        MenuNas4[LMS]
        MenuNas5[Analisis Keaktifan]
        MenuNas6[Tentang RTIK]
        MenuNas7[Kelola Akun]
    end

    %% Admin Wilayah Menu
    subgraph Admin_Wilayah [Menu Admin Wilayah]
        DashWil
        MenuWil1[Kelola Wilayah]
        MenuWil2[Kegiatan & Kalender]
        MenuWil3[Kelola Anggota]
        MenuWil4[Meeting Notes]
        MenuWil5[Pengajuan]
        MenuWil6[Keuangan]
        MenuWil7[Kelola Akun]
    end

    %% Anggota Menu
    subgraph Anggota_Area [Area Anggota]
        AnggotaHome
        NavAng1[Daftar Anggota]
        NavAng2[Academy / LMS]
        NavAng3[Kalender Kegiatan]
        NavAng4[Profile & Edit]
        NavAng5[Sertifikat & Absensi]
    end
```

## 2. Diagram Struktur Hirarki (Mindmap)

Jika Anda ingin melihat struktur dalam bentuk hirarki menu, gunakan diagram berikut:

```mermaid
mindmap
  root((ConnecTIK))
    Publik
      Landing Page
      Daftar Kegiatan
      Dokumentasi
      Login
    Panel Admin
      Nasional
        Dashboard
        Kelola Wilayah
        Kegiatan & Kalender
        Manajemen Anggota
        LMS
        Analisis Keaktifan
        Tentang RTIK
      Wilayah
        Dashboard
        Kelola Wilayah
        Kegiatan
        Anggota
        Meeting Notes
        Pengajuan
        Keuangan
      Cabang & Umum
        Dashboard
        Anggota
        Kegiatan
        Absensi
        Sertifikat
    Panel Anggota
      Beranda
      Academy LMS
      Cari Anggota
      Kalender Kegiatan
      Profile Saya
      Sertifikat & Riwayat
```

## 3. Detail Struktur URL dan Navigasi

### A. Publik (Tanpa Login)
*   **Beranda**: `/` (Menampilkan statistik anggota, wilayah, dan kegiatan)
*   **Kegiatan**: `/kegiatan` (Daftar kegiatan publik)
*   **Detail Kegiatan**: `/kegiatan/{id}`
*   **Dokumentasi**: `/docs/RTIK-App-Documentation.docx`
*   **Profil Anggota**: `/anggota/profil/{id}`
*   **Login**:
    *   Admin: `/admin/login`
    *   Anggota: `/anggota/login`

### B. Panel Admin (`/admin`)
Menu yang ditampilkan menyesuaikan dengan role pengguna.

#### 1. Admin Nasional (`role: admin_nasional`)
*   **Dashboard**: `/admin/nasional/dashboard`
*   **Kelola Wilayah**: `/admin/wilayah`
*   **Kegiatan**:
    *   List: `/admin/riwayat-kegiatan`
    *   Kalender: `/admin/riwayat-kegiatan/calendar`
*   **Anggota**: `/admin/anggota`
*   **LMS**: `/admin/lms`
*   **Analisis Keaktifan**: `/admin/analisis-keaktifan`
*   **Tentang RTIK**:
    *   Penjelasan: `/admin/tentang/penjelasan`
    *   Struktur Organisasi: `/admin/tentang/struktur`
*   **Kelola Akun**: `/admin/nasional/account`

#### 2. Admin Wilayah (`role: admin_wilayah`)
*   **Dashboard**: `/admin/wilayah/dashboard`
*   **Kelola Wilayah**: `/admin/wilayah`
*   **Kegiatan**: `/admin/riwayat-kegiatan`
*   **Kelola Anggota**: `/admin/anggota`
*   **Meeting Notes**: `/admin/meeting-notes`
*   **Pengajuan**: `/admin/pengajuan`
*   **Keuangan**: `/admin/keuangan`
*   **Analisis Keaktifan**: `/admin/analisis-keaktifan`
*   **Kelola Akun**: `/admin/account`

#### 3. Admin Cabang & Lainnya (`role: admin_cabang`, `pembina`, dll)
*   **Home**: `/admin/dashboard`
*   **Anggota**: `/admin/anggota`
*   **Kegiatan**: `/admin/riwayat-kegiatan`
*   **Analisis Keaktifan**: `/admin/analisis-keaktifan`
*   **Ranking**: `/admin/absensi/ranking`
*   **Fitur Tambahan (Kecuali Pembina)**:
    *   Absensi: `/admin/absensi`
    *   Sertifikat: `/admin/sertifikat` (Kecuali Cabang)
    *   Meeting Notes: `/admin/meeting-notes`
    *   Pengajuan: `/admin/pengajuan`
    *   LMS: `/admin/lms`
    *   Keuangan: `/admin/keuangan`
    *   Akses Anggota: `/admin/anggota-access`

### C. Panel Anggota (`/anggota`)
*   **Beranda**: `/anggota/beranda`
*   **Daftar Anggota**: `/anggota/anggota-list` (Pencarian anggota)
*   **Academy (LMS)**:
    *   List: `/anggota/academy`
    *   Detail: `/anggota/academy/{slug}`
*   **Kegiatan**:
    *   Kalender: `/anggota/kegiatan/calendar`
    *   Detail: `/anggota/kegiatan/{id}`
    *   Absensi: `/anggota/absensi-kegiatan`
*   **Profile**:
    *   Lihat: `/anggota/profile`
    *   Edit: `/anggota/edit-profile`
*   **Dokumen & Informasi**:
    *   Sertifikat: `/anggota/sertifikat`
    *   Meeting Notes: `/anggota/meeting-notes`
    *   Tentang RTIK: `/anggota/tentang/penjelasan`

## 3. Struktur Folder Views (`resources/views`)

*   `admin/` - Tampilan untuk panel admin
    *   `layouts/` - Layout utama admin (sidebar, navbar)
    *   `nasional/` - View khusus admin nasional
    *   `wilayah/` - View khusus admin wilayah
    *   `anggota/` - Manajemen anggota oleh admin
    *   ... (folder fitur lainnya: keuangan, lms, sertifikat, dll)
*   `anggota/` - Tampilan untuk panel anggota
    *   `layout.blade.php` - Layout utama anggota
    *   `beranda.blade.php`
    *   `academy.blade.php`
    *   ...
*   `public/` - Komponen tampilan publik tambahan
*   `welcome.blade.php` - Landing page utama
