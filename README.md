# KasFlow

KasFlow adalah sistem manajemen keuangan organisasi berbasis web yang digunakan untuk mencatat, mengelola, dan memantau transaksi keuangan organisasi.

## Deskripsi Sistem

KasFlow dikembangkan sebagai sistem manajemen keuangan organisasi yang membantu proses pencatatan, pengelolaan, dan pemantauan kondisi keuangan organisasi secara terstruktur.

Sistem ini berfokus pada pengelolaan pemasukan, pengeluaran, transaksi, saldo, serta penyajian informasi keuangan yang dapat diakses sesuai dengan peran pengguna.

KasFlow memiliki pengguna utama yaitu Bendahara serta Ketua dan Anggota Organisasi. Bendahara bertanggung jawab dalam mengelola data keuangan, sedangkan Ketua dan Anggota Organisasi dapat melihat dan memantau kondisi keuangan organisasi.

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

Ketua dan anggota organisasi merupakan pengguna yang dapat memantau kondisi keuangan organisasi.

Ketua dan anggota organisasi dapat:

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

Pada pendekatan ini, bagian backend dan frontend dikembangkan dalam satu project Laravel. Antarmuka dibangun menggunakan Laravel Blade dan terhubung langsung dengan komponen backend Laravel.

### Alasan Pemilihan Arsitektur

Pendekatan Laravel Blade Monolith dipilih karena:

1. **Struktur aplikasi lebih sederhana**

   Backend dan frontend berada dalam satu project Laravel sehingga pengembangan dan pengelolaan project lebih mudah dilakukan oleh tim.

2. **Integrasi dengan Laravel lebih mudah**

   Laravel Blade dapat digunakan secara langsung bersama routing, controller, model, dan fitur Laravel lainnya tanpa membutuhkan aplikasi frontend terpisah.

### Trade-off

Kekurangan dari pendekatan ini adalah frontend dan backend berada dalam satu project sehingga perubahan pada salah satu bagian perlu memperhatikan keterkaitan dengan bagian lainnya.

## Struktur Project

Struktur utama project KasFlow mengikuti struktur aplikasi Laravel:

```text
KasFlow/
├── app/
├── bootstrap/
├── config/
├── database/
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