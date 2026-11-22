# Sistem Booking Rental Mobil Berbasis Web

![Laravel](https://img.shields.io/badge/Laravel-12-red) ![PHP](https://img.shields.io/badge/PHP-8.2-blue) ![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-blue) ![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4-blue)

## Deskripsi

**Sistem Booking Rental Mobil Berbasis Web** adalah aplikasi Proyek Akhir/Ujikom yang dibangun menggunakan **Laravel 12** dengan **Blade Template** dan **Tailwind CSS**, serta **PostgreSQL** sebagai database utama.

Aplikasi ini memiliki dua peran (role) utama:

- **Admin** — mengelola mobil, kategori, customer, booking, dan verifikasi pembayaran.
- **Customer** — mencari mobil, melakukan booking, melakukan pembayaran, dan melihat riwayat.

Fitur unggulan meliputi **pencegahan double booking**, **perhitungan harga otomatis di backend**, **generate booking code**, dan **verifikasi pembayaran** yang berjalan penuh di sisi server (Laravel).

---

## Teknologi

| Komponen                | Teknologi                                                  |
|-------------------------|------------------------------------------------------------|
| Backend & Framework     | Laravel 12                                                 |
| Frontend                | Laravel Blade + Tailwind CSS                               |
| Database                | PostgreSQL 16                                              |
| Autentikasi             | Laravel Breeze (Blade)                                     |
| Interaksi Frontend      | JavaScript (Alpine.js)                                     |
| Plugin/Perpustakaan     | SweetAlert2, Chart.js, Lucide Icons                        |

---

## Fitur

### Customer
- Register, Login, Logout
- Melihat Home, daftar mobil, detail mobil
- Pencarian & filter mobil
- Memilih mobil & tanggal rental
- Cek ketersediaan & pencegahan double booking
- Melakukan booking & melihat total biaya
- Instruksi pembayaran & upload bukti pembayaran
- Melihat status & riwayat booking
- Melihat & mengedit profil

### Admin
- Login & Logout khusus admin
- Dashboard dengan statistik & grafik (Chart.js)
- CRUD mobil & CRUD kategori
- Manajemen customer
- Manajemen seluruh booking
- Verifikasi / penolakan pembayaran
- Mengubah status booking

---

## Struktur Status

### Status Booking
```
pending → waiting_payment → payment_verification → confirmed → ongoing → completed
                                                    ↘ cancelled
```

### Status Mobil
```
available, rented, maintenance
```

### Status Pembayaran
```
pending, verified, rejected
```

---

## Persyaratan Sistem (Prasyarat)

Sebelum menginstal, pastikan Anda telah menginstall:

- **PHP** >= 8.2 (dengan ekstensi `pdo_pgsql` dan `pgsql` aktif)
- **Composer** >= 2
- **PostgreSQL** >= 14
- **Node.js** & **npm** (untuk Tailwind/Vite)

---

## Instalasi

### 1. Clone / Salin Proyek

```bash
git clone <repo-url> rental-mobil
cd rental-mobil
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Install Dependensi Frontend

```bash
npm install
```

### 4. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Kemudian atur koneksi database:

```
APP_NAME="Rental Mobil"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=rental_mobil
DB_USERNAME=rental_user
DB_PASSWORD=rental_secret_2026
```

Generate application key:

```bash
php artisan key:generate
```

---

## Konfigurasi PostgreSQL

Buat database dan user di PostgreSQL:

```sql
CREATE ROLE rental_user LOGIN PASSWORD 'rental_secret_2026';
CREATE DATABASE rental_mobil OWNER rental_user;
```

Buatsymlink storage untuk akses file upload (gambar mobil & bukti pembayaran):

```bash
php artisan storage:link
```

---

## Migration & Seeder

Jalankan migration dan seeder data demo:

```bash
php artisan migrate:fresh --seed
```

Perintah ini akan:
- Membuat seluruh tabel: `users`, `categories`, `cars`, `bookings`, `payments`.
- Mengisi data demo: 1 admin, 2 customer, 4 kategori, 6 mobil, beberapa booking & pembayaran.

---

## Menjalankan Aplikasi

Jalankan server Laravel dan build asset frontend:

**Terminal 1** — Server Laravel:
```bash
php artisan serve
```

**Terminal 2** — Build / watch Tailwind dan JavaScript:
```bash
npm run dev
```

Buka aplikasi di browser:
```
http://127.0.0.1:8000
```

---

## Akun Demo

| Role     | Email                  | Password      |
|----------|------------------------|---------------|
| Admin    | `admin@rentalmobil.com`| `admin123`    |
| Customer | `customer1@example.com`| `customer123` |
| Customer | `customer2@example.com`| `customer123` |

> **Admin:** Login di halaman `/login`, kemudian akan diarahkan ke dashboard admin (`/admin/dashboard`).
> **Customer:** Login di halaman `/login`, kemudian akan diarahkan ke dashboard customer (`/customer/dashboard`).

---

## Panduan Penggunaan

### Alur Booking Customer
1. Buka halaman **Daftar Mobil** `/cars`.
2. Pilih mobil → klik **Booking Sekarang**.
3. (Jika belum login, sistem akan mengarahkan untuk login/register.)
4. Pilih tanggal mulai & selesai, lalu klik **Konfirmasi Booking**.
5. Sistem memeriksa ketersediaan & menghitung total harga di backend.
6. Setelah booking dibuat, status menjadi **Menunggu Pembayaran**.
7. Klik **Bayar Sekarang**, unggah bukti transfer.
8. Status berubah menjadi **Menunggu Verifikasi**.
9. Admin memverifikasi → status menjadi **Confirmed**.
10. Rental berlangsung → **Ongoing** → **Completed**.

### Alur Verifikasi Admin
1. Login sebagai admin → menu **Verifikasi Pembayaran**.
2. Klik **Review** pada pembayaran yang menunggu.
3. Periksa bukti pembayaran.
4. Klik **Terima** (payment = verified, booking = confirmed, mobil = rented) atau **Tolak**.

---

## Dokumentasi Logic Penting

Komentar kode tersedia langsung di dalam source untuk bagian-bagian penting, antara lain:

- **Pencegahan double booking** → `app/Http/Controllers/Customer/BookingController.php`
- **Perhitungan harga** → `app/Http/Controllers/Customer/BookingController.php`
- **Generate booking code** → `app/Http/Controllers/Customer/BookingController.php`
- **Verifikasi pembayaran** → `app/Http/Controllers/Admin/PaymentController.php`
- **Role middleware** → `app/Http/Middleware/RoleMiddleware.php`

---

## Keamanan

- **Autentikasi** & **password hashing** (bcrypt) via Laravel.
- **Proteksi CSRF** otomatis pada seluruh form.
- **Backend validation** pada semua input.
- **Role authorization** via middleware `role:admin` / `role:customer`.
  - Customer **tidak dapat** mengakses `/admin/*` (ditolak 403).
- **File upload validation** (tipe & ukuran gambar).

---

## Lisensi

Dibuat untuk keperluan **Proyek Akhir / Ujikom**. Framework menggunakan [Laravel](https://laravel.com) (MIT License).
