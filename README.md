# Pinjamin - Sistem Manajemen Pinjam Barang

Aplikasi web untuk memudahkan pengguna dalam berbagi dan meminjam barang antar pengguna. Dibangun dengan Laravel 11 dan Tailwind CSS.

## 📋 Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi Database](#konfigurasi-database)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Fitur dan Penggunaan](#fitur-dan-penggunaan)
- [Struktur Proyek](#struktur-proyek)

## ✨ Fitur Utama

- **Autentikasi Pengguna**: Registrasi dan login dengan Laravel Breeze
- **Manajemen Barang**: 
  - Tambah, edit, dan hapus barang milik sendiri
  - Kelola status barang (tersedia, dipinjam, tidak aktif)
  - Upload gambar barang
- **Sistem Peminjaman**:
  - Lihat daftar barang yang tersedia untuk dipinjam
  - Ajukan permintaan peminjaman dengan tanggal mulai dan akhir
  - Validasi otomatis untuk menghindari konflik tanggal
- **Manajemen Permintaan**:
  - Lihat semua permintaan peminjaman barang milik Anda
  - Approve atau reject permintaan
  - Lacak status peminjaman (pending, approved, borrowed, returned, rejected)
- **Dashboard**: Ringkasan barang milik pengguna dan status peminjaman

## 🔧 Persyaratan Sistem

- PHP 8.2 atau lebih tinggi
- Composer
- MySQL 5.7 atau lebih tinggi
- Node.js & NPM (untuk Tailwind CSS)
- Git

## 📦 Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd pinjamin
```

### 2. Install Dependencies PHP

```bash
composer install
```

### 3. Install Dependencies JavaScript

```bash
npm install
```

### 4. Copy File Environment

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

## 🗄️ Konfigurasi Database

### 1. Konfigurasi MySQL

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pinjamin
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Buat Database (Opsional)

```bash
mysql -u root -p
CREATE DATABASE pinjamin;
EXIT;
```

### 3. Jalankan Migrasi dan Seeder

```bash
php artisan migrate:fresh --seed
```

Perintah ini akan:
- Membuat semua tabel database
- Mengisi tabel kategori dengan 7 kategori default (Elektronik, Buku, Pakaian, dll)
- Membuat user test jika ada seeder

## 🚀 Menjalankan Aplikasi

### Terminal 1: Jalankan Laravel Development Server

```bash
php artisan serve
```

Server akan berjalan di: `http://127.0.0.1:8000`

### Terminal 2: Compile Tailwind CSS (Development)

```bash
npm run dev
```


## 📱 Fitur dan Penggunaan

### Login/Register

1. Buka `http://127.0.0.1:8000`
2. Klik tombol Register untuk membuat akun baru
3. Isi data: nama, email, password
4. Setelah login, Anda akan diarahkan ke Dashboard

### Dashboard - Kelola Barang Milik Anda

**Menu**: Sidebar → Dashboard

Fitur:
- **Lihat Semua Barang**: Tabel berisi semua barang milik Anda
- **Tambah Barang Baru**: Klik menu "Tambah Barang" di sidebar
  - Isi nama barang (wajib)
  - Pilih kategori (opsional)
  - Pilih kondisi: Baru, Baik, Rusak Ringan, Rusak (wajib)
  - Upload gambar barang (opsional)
  - Klik "Simpan"

- **Edit Barang**: Klik tombol "Edit" di baris barang
  - Ubah data sesuai kebutuhan
  - Update gambar atau biarkan tetap (opsional)
  - Klik "Simpan Perubahan"

- **Hapus Barang**: Klik tombol "Hapus" di baris barang
  - Konfirmasi penghapusan
  - Barang dan gambarnya akan dihapus permanen

### Pinjam Barang - Cari dan Ajukan Peminjaman

**Menu**: Sidebar → Pinjam Barang

Fitur:
- **Lihat Barang Tersedia**: Grid view barang yang bisa dipinjam
  - Hanya menampilkan barang dengan status "Tersedia"
  - Tidak menampilkan barang milik Anda sendiri
  - Pagination 12 item per halaman

- **Ajukan Peminjaman**:
  1. Klik tombol "Pinjam Barang Ini" pada barang pilihan
  2. Isi form peminjaman:
     - **Tanggal Mulai**: Pilih tanggal mulai peminjaman (harus setelah hari ini)
     - **Tanggal Selesai**: Pilih tanggal pengembalian (harus setelah tanggal mulai)
     - **Pesan**: Opsional, tinggalkan catatan untuk pemilik barang
  3. Klik "Ajukan Permintaan"

### Status Peminjaman - Lacak Peminjaman Anda

**Menu**: Sidebar → Status Peminjaman

Fitur:
- **Lihat Riwayat Peminjaman**: Tabel semua permintaan peminjaman dari Anda
- **Status Barang**:
  - 🟡 **Pending** (Kuning): Menunggu persetujuan pemilik
  - 🔵 **Approved** (Biru): Pemilik menyetujui, tunggu pengambilan barang
  - 🟣 **Borrowed** (Ungu): Barang sedang dipinjam
  - 🟢 **Returned** (Hijau): Barang sudah dikembalikan
  - 🔴 **Rejected** (Merah): Pemilik menolak permintaan

### Permintaan Peminjaman - Kelola Permintaan Masuk

**Menu**: Sidebar → Permintaan Peminjaman

Fitur:
- **Lihat Permintaan Masuk**: Daftar semua permintaan peminjaman untuk barang Anda
- **Informasi Permintaan**:
  - Nama barang yang diminta
  - Nama peminjam
  - Tanggal peminjaman (mulai - selesai)
  - Pesan dari peminjam

- **Aksi Permintaan**:
  - **Approve**: Setujui permintaan
  - **Reject**: Tolak permintaan
  - Setelah approve, Anda akan melihat tombol untuk:
    - **Tandai Dipinjam**: Ketika barang sudah diambil peminjam
    - **Tandai Dikembalikan**: Ketika barang sudah dikembalikan

## 📁 Struktur Proyek

```
pinjamin/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ItemController.php      # CRUD barang
│   │   │   ├── BorrowController.php    # Manajemen peminjaman
│   │   │   └── ProfileController.php   # Profil pengguna
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php                    # Model pengguna
│   │   ├── Item.php                    # Model barang
│   │   ├── Category.php                # Model kategori
│   │   └── BorrowRequest.php           # Model permintaan peminjaman
│   └── Providers/
├── database/
│   ├── migrations/                     # File migrasi database
│   └── seeders/                        # File seeder data
├── resources/
│   ├── css/                            # File CSS (Tailwind)
│   ├── js/                             # File JavaScript
│   └── views/
│       ├── dashboard.blade.php         # Dashboard utama
│       ├── items-form.blade.php        # Form tambah barang
│       ├── items-edit.blade.php        # Form edit barang
│       ├── borrow/
│       │   ├── index.blade.php         # Daftar barang untuk dipinjam
│       │   ├── create.blade.php        # Form peminjaman
│       │   ├── status.blade.php        # Status peminjaman
│       │   └── requests.blade.php      # Permintaan peminjaman masuk
│       ├── auth/                       # View autentikasi
│       ├── layouts/                    # Layout templates
│       └── components/                 # Blade components
├── routes/
│   ├── web.php                         # Route aplikasi web
│   └── auth.php                        # Route autentikasi
├── public/                             # File publik (CSS, JS built)
├── storage/                            # Penyimpanan file (gambar, log)
├── .env.example                        # Template file environment
├── composer.json                       # Dependencies PHP
├── package.json                        # Dependencies JavaScript
├── tailwind.config.js                  # Konfigurasi Tailwind
├── vite.config.js                      # Konfigurasi Vite
└── phpunit.xml                         # Konfigurasi testing

```

## 🗄️ Skema Database

### Tabel: users
- id
- name
- email
- password
- created_at, updated_at

### Tabel: items
- id
- owner_id (FK ke users)
- name
- category
- description
- condition (enum: baru, baik, rusak ringan, rusak)
- status (enum: available, borrowed, inactive) - default: available
- image
- created_at, updated_at

### Tabel: categories
- id
- name
- created_at, updated_at

### Tabel: borrow_requests
- id
- item_id (FK ke items)
- borrower_id (FK ke users)
- owner_id (FK ke users)
- start_date
- end_date
- message
- status (enum: pending, approved, borrowed, returned, rejected) - default: pending
- created_at, updated_at

## 🛠️ Troubleshooting

### Barang tidak muncul di halaman Pinjam Barang
- Pastikan status barang adalah "available" (tersedia)
- Pastikan barang bukan milik Anda sendiri
- Cek apakah barang sudah disimpan di database

### Error: "No Image" muncul
- Pastikan folder `storage/app/public` sudah dibuat
- Jalankan: `php artisan storage:link` untuk membuat symbolic link
- Reload halaman

### Migrasi gagal
- Pastikan database sudah dibuat
- Cek konfigurasi `.env` untuk database
- Jalankan: `php artisan migrate:fresh --seed` untuk reset

### CSS tidak ter-compile
- Jalankan: `npm run dev` di terminal terpisah
- Tunggu hingga build selesai
- Reload halaman (Ctrl+Shift+R atau Cmd+Shift+R)

## 📧 Support

Untuk pertanyaan atau laporan bug, silakan hubungi developer.

---

**Selamat menggunakan Pinjamin!** 🎉

