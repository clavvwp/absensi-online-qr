# Sistem Absensi Online QR Code

Aplikasi **Sistem Absensi Online QR Code** merupakan aplikasi berbasis web yang dibuat untuk mempermudah proses pencatatan dan pengelolaan kehadiran siswa menggunakan teknologi QR Code.

Sistem ini memiliki dua hak akses utama, yaitu **Admin** dan **Wali Kelas**. Admin bertugas mengelola data siswa, QR Code, dan proses pemindaian absensi. Wali Kelas dapat memantau serta mengelola rekap kehadiran siswa berdasarkan kelas masing-masing.

## Fitur Utama

### 1. Admin
- Login dan autentikasi Admin.
- Dashboard informasi jumlah siswa, kelas, dan kehadiran hari ini.
- Mengelola data siswa.
- Menambahkan siswa beserta kelasnya.
- Membuat QR Code siswa secara otomatis berdasarkan NIS.
- Menampilkan QR Code setiap siswa.
- Melakukan scan QR Code menggunakan kamera.
- Menyimpan data kehadiran secara otomatis ketika QR berhasil dipindai.
- Melihat riwayat dan rekap absensi berdasarkan tanggal.
- Mencegah siswa melakukan absensi lebih dari satu kali pada tanggal yang sama.

### 2. Wali Kelas
- Login menggunakan akun Wali Kelas.
- Melihat daftar siswa berdasarkan kelas yang menjadi tanggung jawabnya.
- Melihat rekap kehadiran siswa berdasarkan tanggal.
- Memantau jumlah siswa hadir, izin, sakit, dan belum melakukan absensi.
- Memperbarui status kehadiran siswa menjadi hadir, izin, atau sakit.

### 3. Sistem QR Code
- QR Code dibuat otomatis ketika Admin menambahkan siswa.
- QR Code menggunakan NIS sebagai token identifikasi siswa.
- Pemindaian dilakukan menggunakan kamera perangkat.
- Hasil scan dikirim ke server untuk divalidasi.
- Data absensi disimpan ke database secara otomatis.
- Sistem memvalidasi QR aktif dan mencegah absensi ganda.

## Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| PHP 8.3+ | Bahasa pemrograman backend |
| Laravel 13 | Framework backend |
| MySQL | Database |
| HTML | Struktur halaman |
| CSS | Tampilan aplikasi |
| JavaScript | Interaksi dan pemindaian QR |
| Blade | Template engine Laravel |
| Tailwind CSS 4 | Styling frontend |
| Vite | Build frontend assets |
| html5-qrcode | Pemindaian QR melalui kamera |
| QRCode.js | Pembuatan QR Code |

## Persyaratan Instalasi

Pastikan perangkat sudah memiliki:

- PHP versi 8.3 atau lebih baru.
- Composer.
- Node.js dan NPM.
- Laragon.
- MySQL.
- Git.

## Cara Instalasi

### 1. Clone Repository

Buka terminal dan jalankan:

```bash
git clone https://github.com/clavvwp/absensi-online-qr.git
```

Masuk ke direktori project:

```bash
cd absensi-online-qr
```

### 2. Install Dependency Laravel

```bash
composer install
```

### 3. Install Dependency Frontend

```bash
npm install
```

### 4. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### 5. Konfigurasi Database

Buka Laragon dan jalankan MySQL.

Buat database baru dengan nama:

```text
absensi_qr
```

Kemudian buka file `.env` dan sesuaikan konfigurasi database:

```env
APP_NAME="Absensi QR"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_qr
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password database dengan konfigurasi MySQL masing-masing.

### 6. Generate Application Key

```bash
php artisan key:generate
```

### 7. Jalankan Migration dan Seeder

```bash
php artisan migrate --seed
```

Perintah tersebut akan membuat tabel database sekaligus mengisi data awal untuk keperluan pengujian.

**Catatan:** Seeder menyediakan akun Admin, Wali Kelas, satu kelas, dan dua data siswa contoh.

### 8. Build Frontend

```bash
npm run build
```

### 9. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser melalui:

```text
http://127.0.0.1:8000
```

## Akun Pengujian

Setelah menjalankan seeder, tersedia akun berikut:

| Role | Email | Password |
|---|---|---|
| Admin | admin@absensi.com | admin123 |
| Wali Kelas | budi@absensi.com | budi01 |

**Penting:** Akun tersebut hanya untuk pengujian lokal. Ganti password dan jangan gunakan akun demo tersebut untuk deployment produksi.

## Alur Penggunaan Sistem

### Admin
1. Login sebagai Admin.
2. Masuk ke halaman dashboard.
3. Tambahkan data siswa dan tentukan kelasnya.
4. Sistem membuat QR Code berdasarkan NIS siswa.
5. Buka halaman QR untuk melihat QR Code siswa.
6. Buka halaman Scan QR.
7. Izinkan akses kamera pada browser.
8. Arahkan kamera ke QR Code siswa.
9. Sistem memvalidasi QR dan menyimpan absensi secara otomatis.
10. Admin dapat melihat hasil absensi pada halaman rekap presensi.

### Wali Kelas
1. Login sebagai Wali Kelas.
2. Masuk ke dashboard.
3. Pilih tanggal presensi.
4. Lihat daftar siswa dan status kehadirannya.
5. Perbarui status siswa jika diperlukan.

## Struktur Project

```text
absensi-online-qr/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── AuthController.php
│   │   │   └── WaliController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   │
│   └── Models/
│       ├── User.php
│       ├── Kelas.php
│       ├── Siswa.php
│       ├── Qr.php
│       └── Presensi.php
│
├── database/
│   ├── migrations/
│   └── seeders/
│
├── public/
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── layouts/
│       └── wali/
│
├── routes/
│   └── web.php
│
├── tests/
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── package.json
└── README.md
```

## Keamanan dan Catatan
- Akses kamera memerlukan izin browser dan secure context seperti localhost atau HTTPS.
- Ganti akun dan password bawaan sebelum aplikasi digunakan secara nyata.

##  Developer

**Sistem Absensi Online QR Code**

Dikembangkan sebagai project pembelajaran dan implementasi sistem informasi absensi siswa berbasis web menggunakan Laravel dan QR Code.

Repository: https://github.com/clavvwp/absensi-online-qr

