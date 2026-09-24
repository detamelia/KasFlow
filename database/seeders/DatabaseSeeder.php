<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KategoriTransaksi;
use App\Models\Transaksi;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Data pengguna
        $admin = User::create([
            'name' => 'Admin KasFlow',
            'email' => 'admin@kasflow.test',
            'password' => 'password',
        ]);

        $anggota = User::create([
            'name' => 'Preisi',
            'email' => 'preisi@kasflow.test',
            'password' => 'password',
        ]);

        // Data kategori transaksi
        $iuran = KategoriTransaksi::create([
            'nama_kategori' => 'Iuran Anggota',
            'jenis' => 'pemasukan',
        ]);

        $donasi = KategoriTransaksi::create([
            'nama_kategori' => 'Donasi',
            'jenis' => 'pemasukan',
        ]);

        $atk = KategoriTransaksi::create([
            'nama_kategori' => 'ATK',
            'jenis' => 'pengeluaran',
        ]);

        $konsumsi = KategoriTransaksi::create([
            'nama_kategori' => 'Konsumsi',
            'jenis' => 'pengeluaran',
        ]);

        // Data transaksi
        Transaksi::create([
            'user_id' => $anggota->id,
            'kategori_id' => $iuran->id,
            'tanggal' => '2026-09-01',
            'keterangan' => 'Iuran anggota bulan September',
            'jumlah' => 250000,
        ]);

        Transaksi::create([
            'user_id' => $admin->id,
            'kategori_id' => $donasi->id,
            'tanggal' => '2026-09-03',
            'keterangan' => 'Donasi kegiatan kelompok',
            'jumlah' => 300000,
        ]);

        Transaksi::create([
            'user_id' => $admin->id,
            'kategori_id' => $atk->id,
            'tanggal' => '2026-09-05',
            'keterangan' => 'Pembelian alat tulis',
            'jumlah' => 120000,
        ]);

        Transaksi::create([
            'user_id' => $anggota->id,
            'kategori_id' => $konsumsi->id,
            'tanggal' => '2026-09-07',
            'keterangan' => 'Pembelian konsumsi rapat',
            'jumlah' => 100000,
        ]);

        Transaksi::create([
            'user_id' => $anggota->id,
            'kategori_id' => $iuran->id,
            'tanggal' => '2026-09-10',
            'keterangan' => 'Iuran anggota tambahan',
            'jumlah' => 150000,
        ]);
    }
}