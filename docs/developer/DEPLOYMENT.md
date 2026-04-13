# Panduan Deployment ke cPanel (Shared Hosting)

Panduan ini dikhususkan untuk lingkungan shared hosting (cPanel) dimana akses SSH atau fungsi `exec()` mungkin dibatasi.

## 📋 Prasyarat Server
- PHP >= 8.2
- MySQL / MariaDB
- Ekstensi PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML.

## 🚀 Langkah-langkah Deployment

### 1. Persiapan File (Local)
Sebelum mengupload ke hosting, pastikan aplikasi siap di local:

1. Jalankan build assets untuk production:
   ```bash
   npm run build
   ```
2. Bersihkan cache config:
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```
3. Kompres seluruh folder project menjadi `.zip` (kecuali `node_modules` dan `.git`).

### 2. Upload ke cPanel
1. Login ke cPanel -> **File Manager**.
2. Upload file `.zip` ke folder di luar `public_html` (misal: `/home/username/laravel`).
3. Ekstrak file `.zip`.

### 3. Konfigurasi Database
1. Buka **MySQL Databases** di cPanel.
2. Buat Database baru.
3. Buat User Database baru dan password.
4. Add User to Database (Centang "ALL PRIVILEGES").
5. Edit file `.env` di folder laravel Anda:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://domainanda.com
   
   DB_DATABASE=username_namadb
   DB_USERNAME=username_dbuser
   DB_PASSWORD=password_anda
   ```

### 4. Setup Public Folder
Agar domain mengakses folder `public` Laravel secara aman:

**Opsi A: Mengubah Document Root (Disarankan)**
- Minta support hosting untuk mengubah Document Root domain ke `/home/username/laravel/public`.

**Opsi B: Symlink (Alternatif Umum)**
1. Hapus folder `public_html` bawaan (atau backup dulu).
2. Buat symlink dari `laravel/public` ke `public_html`.
   Anda bisa menggunakan script PHP sederhana jika SSH tidak tersedia.

### 5. Storage Link (PENTING)
Laravel perlu menyimpan file upload (foto, sertifikat) di folder `storage/app/public` yang harus bisa diakses dari web.

**Jika SSH Tersedia:**
```bash
php artisan storage:link
```

**Jika SSH Tidak Tersedia / `symlink()` Disabled:**
1. Upload file `cpanel_create_symlink.php` (ada di root project) ke folder `public_html`.
2. Edit konfigurasi di dalam file tersebut (username & path).
3. Akses `https://domainanda.com/cpanel_create_symlink.php`.
4. **HAPUS** file tersebut setelah sukses.

### 6. Migrasi Database
Jika tidak bisa menjalankan `php artisan migrate` via terminal:
1. Export database local Anda ke file `.sql`.
2. Buka **phpMyAdmin** di cPanel.
3. Pilih database tujuan dan Import file `.sql`.

## ⚠️ Troubleshooting Umum

### Permission Error (403/500)
Pastikan folder `storage` dan `bootstrap/cache` memiliki permission `755` (atau `775`).
```bash
chmod -R 755 storage bootstrap/cache
```

### 500 Internal Server Error
- Cek file `.env` pastikan tidak ada spasi di nama database/password.
- Cek logs di `storage/logs/laravel.log`.

### Gambar/File Tidak Muncul (404)
- Pastikan symlink storage sudah dibuat (Langkah 5).
- Pastikan file ada di `storage/app/public`.

## 🛠️ Maintenance

Untuk update aplikasi:
1. Upload file codingan baru (Controller, View, dll).
2. Jika ada perubahan database, jalankan migrasi.
3. Jika mengubah `.env`, jalankan `php artisan config:clear`.
