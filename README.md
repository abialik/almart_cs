# Almart CS - Sistem Manajemen Toko Online

Almart CS adalah platform e-commerce modern yang dibangun dengan framework Laravel, dirancang untuk mempermudah manajemen toko, operasional petugas, dan pengalaman berbelanja pelanggan.

## 🛠️ Teknologi yang Digunakan

- **Framework**: [Laravel 12](https://laravel.com) - Framework PHP untuk pengrajin web.
- **Frontend**: Tailwind CSS & Vite.
- **Database**: MySQL/MariaDB.
- **Authentication**: [Laravel Breeze](https://laravel.com/docs/breeze) - Menyediakan sistem login dan registrasi yang minimalis dan kokoh.
- **Server Lokal**: Direkomendasikan menggunakan **XAMPP** (sesuai struktur path project) atau **Laragon**.

## 🔑 Akun Demo (Default)

Gunakan akun berikut untuk mencoba fitur-fitur di setiap role. Pastikan Anda telah menjalankan seeder (`php artisan db:seed --class=UserSeeder`).

| Role     | Email                | Password     |
|----------|----------------------|--------------|
| **Admin**    | `admin@almart.com`   | `admin123`   |
| **Petugas**  | `petugas@almart.com` | `petugas123` |
| **Customer** | `customer@almart.com` | `customer123` |

## 👥 Penjelasan Role

Aplikasi ini memiliki 3 level akses (role) yang berbeda:

### 1. Admin
Role tertinggi yang memiliki kendali penuh atas manajemen sistem.
- **Manajemen Katalog**: Mengatur kategori produk dan data produk (tambah, edit, hapus).
- **Manajemen Pesanan**: Memvalidasi pembayaran dari customer dan memantau status semua pesanan.
- **Layanan Pelanggan**: Membalas komplain (complaints) dan mengelola pengajuan retur (returns).
- **Manajemen Pengguna**: Mengelola akun petugas dan customer.
- **Dashboard**: Melihat statistik penjualan dan ringkasan data melalui dashboard utama.

### 2. Petugas (Staff)
Role operasional yang fokus pada penyelesaian pesanan di gudang/toko.
- **Order Picking**: Memproses pesanan yang sudah dibayar, menyiapkan barang (picking), dan memvalidasi ketersediaan stok.
- **Pickup Validation**: Melakukan validasi saat pelanggan mengambil pesanan (jika menggunakan metode pickup).
- **Update Status**: Memperbarui status pesanan dari "Paid" menjadi "Processed" atau "Shipped".
- **Cetak Struk**: Mencetak struk belanja untuk pesanan pelanggan.

### 3. Customer (Pelanggan)
Pengguna umum yang melakukan transaksi di Almart.
- **Belanja**: Menjelajahi produk, mencari kategori, dan menambahkan barang ke Keranjang (Cart) atau Wishlist.
- **Checkout**: Melakukan pemesanan, memilih alamat pengiriman, dan mengunggah bukti pembayaran manual.
- **Tracking**: Memantau status pesanan secara real-time.
- **Layanan Pasca-Beli**: Mengajukan komplain jika ada masalah atau melakukan retur barang sesuai ketentuan.

## 📦 Manajemen Database

Project ini menggunakan fitur bawaan Laravel untuk mengelola struktur database. Anda **tidak perlu** mengimpor file `.sql` secara manual.

### 1. Persiapan Database
- Buka **PHPMyAdmin** (biasanya di `http://localhost/phpmyadmin`).
- Buat database baru dengan nama `almart_cs` (atau nama lain sesuai keinginan Anda).

### 2. Konfigurasi Koneksi
- Buka file `.env` di root project.
- Cari bagian `DB_DATABASE` dan pastikan namanya sesuai dengan database yang Anda buat:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=almart_cs
  DB_USERNAME=root
  DB_PASSWORD=
  ```

### 3. Menjalankan Migration & Seeder
Setelah database dibuat dan konfigurasi `.env` sudah benar, jalankan perintah ini di terminal:
```bash
# Untuk membuat struktur tabel
php artisan migrate

# Untuk mengisi data awal (Admin, Produk, dll)
php artisan db:seed

# ATAU jalankan sekaligus
php artisan migrate --seed
```

> [!IMPORTANT]
> **Mengapa tidak ada file .sql?**
> Kami menggunakan **Migrations** agar setiap perubahan struktur database tercatat dalam kode dan bisa dibagikan dengan mudah ke tim lain melalui Git tanpa risiko konflik file besar.

---

## 🚀 Cara Menjalankan Project

1. Pastikan **XAMPP** atau **Laragon** sudah berjalan (Apache & MySQL).
2. Clone repository dan masuk ke folder project.
3. Jalankan `composer install` dan `npm install`.
4. Salin `.env.example` menjadi `.env` jika belum ada:
   ```bash
   cp .env.example .env
   ```
5. Generate security key:
   ```bash
   php artisan key:generate
   ```
6. Ikuti langkah **Manajemen Database** di atas untuk menyiapkan tabel dan data.
7. Jalankan server:
   ```bash
   php artisan serve
   ```
8. Jalankan build frontend:
   ```bash
   npm run dev
   ```

