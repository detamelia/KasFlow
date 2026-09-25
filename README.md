# KasFlow

KasFlow adalah sistem manajemen keuangan organisasi berbasis web yang digunakan untuk mencatat, mengelola, dan memantau transaksi keuangan organisasi.

## Deskripsi Sistem

KasFlow dikembangkan sebagai sistem manajemen keuangan organisasi yang membantu proses pencatatan, pengelolaan, dan pemantauan kondisi keuangan organisasi secara terstruktur.

Sistem ini berfokus pada pengelolaan pemasukan, pengeluaran, transaksi, saldo, serta penyajian informasi keuangan yang dapat diakses sesuai dengan peran pengguna.

KasFlow memiliki dua peran pengguna, yaitu **Bendahara** serta **Ketua dan Anggota Organisasi**. Bendahara bertanggung jawab dalam mengelola data keuangan, sedangkan Ketua dan Anggota Organisasi dapat melihat dan memantau kondisi keuangan organisasi.

## Tujuan

KasFlow bertujuan untuk:

- Membantu pencatatan pemasukan organisasi.
- Membantu pencatatan pengeluaran organisasi.
- Mengelola data transaksi keuangan organisasi.
- Memantau saldo organisasi.
- Menyediakan informasi rincian keuangan organisasi.
- Memudahkan pengguna dalam memantau kondisi keuangan organisasi.
- Menyediakan antarmuka yang sederhana dan mudah digunakan.

## Pengguna Sistem

### 1. Bendahara

Bendahara merupakan pengguna yang bertanggung jawab dalam pengelolaan data keuangan organisasi.

Bendahara dapat:

- Mengelola data pemasukan.
- Mengelola data pengeluaran.
- Mengelola transaksi keuangan.
- Memantau saldo organisasi.
- Melihat rincian data keuangan.

### 2. Ketua dan Anggota Organisasi

Ketua dan Anggota Organisasi merupakan pengguna yang dapat memantau kondisi keuangan organisasi.

Ketua dan Anggota Organisasi dapat:

- Melihat kondisi keuangan organisasi.
- Melihat saldo organisasi.
- Melihat transaksi keuangan.
- Melihat rincian keuangan organisasi.

## Fitur Utama

Fitur utama yang dikembangkan pada KasFlow meliputi:

- Dashboard keuangan.
- Pencatatan pemasukan.
- Pencatatan pengeluaran.
- Pengelolaan transaksi.
- Informasi saldo.
- Rincian keuangan.
- Pemantauan kondisi keuangan organisasi.
- Autentikasi pengguna.
- Pengaturan hak akses berdasarkan peran pengguna.

## Teknologi yang Digunakan

Project KasFlow menggunakan teknologi berikut:

- **Laravel** sebagai framework pengembangan aplikasi web.
- **PHP** sebagai bahasa pemrograman.
- **Laravel Blade** sebagai template engine untuk membangun antarmuka.
- **HTML** sebagai struktur halaman.
- **CSS** untuk mengatur tampilan antarmuka.
- **JavaScript** untuk menambahkan interaksi pada halaman.
- **PostgreSQL** sebagai sistem manajemen basis data.
- **Git** sebagai version control.
- **GitHub** sebagai repository project.

## Arsitektur Sistem

KasFlow menggunakan pendekatan **Laravel Blade Monolith**.

Pada pendekatan ini, bagian frontend dan backend dikembangkan dalam satu project Laravel. Antarmuka dibangun menggunakan Laravel Blade dan terhubung langsung dengan komponen backend Laravel.

### Alasan Pemilihan Arsitektur

Pendekatan Laravel Blade Monolith dipilih karena:

1. **Struktur aplikasi lebih sederhana**

   Backend dan frontend berada dalam satu project Laravel sehingga pengembangan dan pengelolaan project lebih mudah dilakukan oleh tim.

2. **Integrasi dengan Laravel lebih mudah**

   Laravel Blade dapat digunakan secara langsung bersama routing, controller, model, dan fitur Laravel lainnya tanpa membutuhkan aplikasi frontend terpisah.

### Trade-off

Kekurangan dari pendekatan Laravel Blade Monolith adalah frontend dan backend berada dalam satu project sehingga fleksibilitas pemisahan frontend dan backend menjadi lebih rendah. Jika sistem dikembangkan untuk aplikasi mobile atau client lain, diperlukan pengembangan API tambahan agar client lain dapat mengakses data dari sistem.

## Struktur Project

Struktur utama project KasFlow mengikuti struktur aplikasi Laravel.

```text
KasFlow/
├── app/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── .env
├── .env.example
├── artisan
├── composer.json
├── composer.lock
└── README.md
```

## Prasyarat

Sebelum menjalankan project KasFlow, pastikan perangkat telah terpasang:

- PHP 8.2 atau versi yang lebih baru.
- Composer.
- Node.js dan npm.
- PostgreSQL.
- Git.

## Cara Menjalankan Project dari Nol

1. Clone repository KasFlow.

```bash
git clone https://github.com/detamelia/KasFlow.git
cd KasFlow
```

2. Install dependency Laravel.

```bash
composer install
```

3. Install dependency frontend.

```bash
npm install
```

4. Salin file konfigurasi environment.

**Linux / macOS**

```bash
cp .env.example .env
```

**Windows PowerShell**

```powershell
Copy-Item .env.example .env
```

5. Buka file `.env`, kemudian sesuaikan konfigurasi PostgreSQL.

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=kasFlow
DB_USERNAME=postgres
DB_PASSWORD=
```

6. Generate application key Laravel.

```bash
php artisan key:generate
```

7. Jalankan migration dan seeder.

```bash
php artisan migrate --seed
```

8. Jalankan server Laravel.

```bash
php artisan serve
```

9. Jalankan Vite untuk asset frontend.

```bash
npm run dev
```

Setelah seluruh langkah selesai, aplikasi dapat diakses melalui browser pada alamat:

```text
http://127.0.0.1:8000
```

## Akun Demo

Seeder menyediakan data awal agar aplikasi dapat langsung digunakan untuk demonstrasi.

| Peran | Email | Password |
|--------|-------|----------|
| Bendahara | `bendahara@kasflow.test` | `12345678` |
| Ketua/Anggota | `anggota@kasflow.test` | `12345678` |

Project KasFlow dikembangkan sebagai base project tugas akhir mata kuliah Program Studi Teknik Informatika Universitas Lampung Tahun 2026.