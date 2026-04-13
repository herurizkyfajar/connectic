# Sistem Manajemen Anggota, Kegiatan, dan Sertifikat (RTIK)

Aplikasi berbasis web untuk manajemen keanggotaan, absensi kegiatan, dan penerbitan sertifikat digital otomatis. Dibangun menggunakan Laravel.

## 🚀 Fitur Utama

### 1. Manajemen Keanggotaan
- Registrasi dan profil anggota
- Dashboard anggota
- Riwayat keaktifan dan ranking anggota

### 2. Manajemen Kegiatan & Absensi
- CRUD Kegiatan (Admin)
- Absensi via QR Code atau Manual (Admin/Anggota)
- Bukti kehadiran (Upload Foto)
- Laporan kehadiran real-time

### 3. Learning Management System (LMS)
- Materi pembelajaran (Artikel/Video)
- Tracking progress membaca
- Kuis dan evaluasi (Coming Soon)

### 4. Sertifikat & Meeting Notes
- Generate sertifikat otomatis untuk peserta kegiatan
- Verifikasi keaslian sertifikat
- Notulensi rapat digital dan distribusi hasil rapat

## 🛠️ Teknologi

- **Backend**: Laravel 12.x
- **Database**: MySQL
- **Frontend**: Blade Templates + Bootstrap/Tailwind
- **Tools**: Composer, NPM

## 📋 Prasyarat

Sebelum memulai, pastikan server/local environment Anda memiliki:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database

## ⚙️ Instalasi (Local Development)

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/repo-name.git
   cd repo-name
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   Copy file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Migration**
   ```bash
   php artisan migrate --seed
   ```
   *(Gunakan `--seed` untuk mengisi data awal admin/dummy data)*

5. **Build Assets & Run**
   ```bash
   npm run build
   php artisan serve
   ```
   Akses aplikasi di `http://localhost:8000`.

## 📚 Dokumentasi

Dokumentasi lengkap tersedia di folder `docs/`:

- **[Arsitektur Sistem](docs/architecture/)**: Diagram alur dan struktur database.
- **[Panduan Deployment](docs/developer/DEPLOYMENT.md)**: Cara deploy ke cPanel/Shared Hosting.
- **[Panduan Pengguna](docs/manual/)**: Manual penggunaan untuk Admin dan Anggota.

## 🤝 Kontribusi

Silakan buat *Pull Request* untuk fitur baru atau perbaikan bug. Pastikan untuk mengikuti standar coding Laravel yang berlaku.

## 📄 Lisensi

[MIT License](LICENSE)
