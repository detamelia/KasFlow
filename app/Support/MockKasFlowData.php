<?php

namespace App\Support;

class MockKasFlowData
{
    public static function getSummary(?string $role = 'bendahara'): array
    {
        return [
            'organization_name' => 'Himpunan Mahasiswa Informatika (HMI)',
            'period' => 'September 2026',
            'role' => $role ?? 'bendahara',
            'saldo_utama' => 18450000,
            'saldo_formatted' => 'Rp 18.450.000',
            'pemasukan_bulan_ini' => 7500000,
            'pemasukan_formatted' => 'Rp 7.500.000',
            'pemasukan_trend' => '+14.8%',
            'pengeluaran_bulan_ini' => 3250000,
            'pengeluaran_formatted' => 'Rp 3.250.000',
            'pengeluaran_trend' => '-5.2%',
            'total_transaksi' => 42,
            'transaksi_pending' => 3,
            'cashflow_ratio' => '2.3x',
        ];
    }

    public static function getTransactions(): array
    {
        return [
            [
                'id' => 1,
                'kode' => 'TRX-2026-001',
                'jenis' => 'pemasukan',
                'judul' => 'Iuran Kas Anggota - September 2026',
                'kategori' => 'Uang Kas',
                'nominal' => 2500000,
                'nominal_formatted' => 'Rp 2.500.000',
                'tanggal' => '2026-09-22',
                'tanggal_formatted' => '22 Sep 2026',
                'penanggung_jawab' => 'Siti Rahma (Bendahara 1)',
                'status' => 'Terverifikasi',
                'deskripsi' => 'Pembayaran iuran kas bulanan dari 50 anggota terpilih.',
                'bukti' => 'bukti_kas_sep.pdf',
            ],
            [
                'id' => 2,
                'kode' => 'TRX-2026-002',
                'jenis' => 'pengeluaran',
                'judul' => 'Pembelian Banner & Spanduk Workshop AI',
                'kategori' => 'Logistik',
                'nominal' => 850000,
                'nominal_formatted' => 'Rp 850.000',
                'tanggal' => '2026-09-20',
                'tanggal_formatted' => '20 Sep 2026',
                'penanggung_jawab' => 'Ahmad Fauzi (Sie Divisi Acara)',
                'status' => 'Terverifikasi',
                'deskripsi' => 'Cetak 3 buah flexi banner outdoor untuk Acara Workshop AI 2026.',
                'bukti' => 'nota_print_banner.jpg',
            ],
            [
                'id' => 3,
                'kode' => 'TRX-2026-003',
                'jenis' => 'pemasukan',
                'judul' => 'Sponsorship Utama dari PT TechInovasi',
                'kategori' => 'Sponsorship',
                'nominal' => 5000000,
                'nominal_formatted' => 'Rp 5.000.000',
                'tanggal' => '2026-09-18',
                'tanggal_formatted' => '18 Sep 2026',
                'penanggung_jawab' => 'Budi Santoso (Humas)',
                'status' => 'Terverifikasi',
                'deskripsi' => 'Dana dana sponsor kegiatan Seminar Nasional Web Framework.',
                'bukti' => 'transfer_sponsor_tech.pdf',
            ],
            [
                'id' => 4,
                'kode' => 'TRX-2026-004',
                'jenis' => 'pengeluaran',
                'judul' => 'Konsumsi Rapat Pleno Anggaran Q3',
                'kategori' => 'Konsumsi',
                'nominal' => 450000,
                'nominal_formatted' => 'Rp 450.000',
                'tanggal' => '2026-09-15',
                'tanggal_formatted' => '15 Sep 2026',
                'penanggung_jawab' => 'Dina Amalia (Sekretaris)',
                'status' => 'Terverifikasi',
                'deskripsi' => 'Snack & minuman untuk 25 peserta rapat pleno pengurus.',
                'bukti' => 'nota_snack_warung.jpg',
            ],
            [
                'id' => 5,
                'kode' => 'TRX-2026-005',
                'jenis' => 'pengeluaran',
                'judul' => 'Langganan Cloud Server & Domain Website',
                'kategori' => 'Operasional',
                'nominal' => 650000,
                'nominal_formatted' => 'Rp 650.000',
                'tanggal' => '2026-09-10',
                'tanggal_formatted' => '10 Sep 2026',
                'penanggung_jawab' => 'Rian Ardianto (Kominfo)',
                'status' => 'Terverifikasi',
                'deskripsi' => 'Perpanjangan VPS & domain .or.id organisasi selama 1 tahun.',
                'bukti' => 'invoice_cloud_vps.pdf',
            ],
            [
                'id' => 6,
                'kode' => 'TRX-2026-006',
                'jenis' => 'pengeluaran',
                'judul' => 'Pengadaan Alat Tulis & Binder Arsip',
                'kategori' => 'Logistik',
                'nominal' => 300000,
                'nominal_formatted' => 'Rp 300.000',
                'tanggal' => '2026-09-08',
                'tanggal_formatted' => '08 Sep 2026',
                'penanggung_jawab' => 'Siti Rahma (Bendahara 1)',
                'status' => 'Pending',
                'deskripsi' => 'Kertas A4 3 rim, binder arsip transaksi, & stempel organisasi.',
                'bukti' => 'struk_atkhub.jpg',
            ],
            [
                'id' => 7,
                'kode' => 'TRX-2026-007',
                'jenis' => 'pemasukan',
                'judul' => 'Dana Hibah Kemahasiswaan Fakultas',
                'kategori' => 'Dana Hibah',
                'nominal' => 3500000,
                'nominal_formatted' => 'Rp 3.500.000',
                'tanggal' => '2026-09-02',
                'tanggal_formatted' => '02 Sep 2026',
                'penanggung_jawab' => 'Muhammad Rizky (Ketua)',
                'status' => 'Terverifikasi',
                'deskripsi' => 'Pencairan dana hibah kompetisi kegiatan mahasiwa tahap 1.',
                'bukti' => 'sk_hibah_pencairan.pdf',
            ],
            [
                'id' => 8,
                'kode' => 'TRX-2026-008',
                'jenis' => 'pengeluaran',
                'judul' => 'Transportasi Delegasi Lomba Karya Tulis',
                'kategori' => 'Transportasi',
                'nominal' => 1000000,
                'nominal_formatted' => 'Rp 1.000.000',
                'tanggal' => '2026-08-28',
                'tanggal_formatted' => '28 Agt 2026',
                'penanggung_jawab' => 'Andi Wijaya (Pendamping Team)',
                'status' => 'Terverifikasi',
                'deskripsi' => 'Bensin & tiket travel 3 anggota delegasi ke Universitas Gajah Mada.',
                'bukti' => 'tiket_travel_ugm.pdf',
            ],
        ];
    }

    public static function getIncomeCategories(): array
    {
        return ['Uang Kas', 'Sponsorship', 'Dana Hibah', 'Donasi', 'Pendaftaran Event', 'Lain-lain'];
    }

    public static function getExpenseCategories(): array
    {
        return ['Operasional', 'Logistik', 'Konsumsi', 'Transportasi', 'Acara/Event', 'Perlengkapan', 'Lain-lain'];
    }

    public static function getMonthlyReports(): array
    {
        return [
            ['bulan' => 'Mei 2026', 'pemasukan' => 6200000, 'pengeluaran' => 4100000, 'saldo_bersih' => 2100000],
            ['bulan' => 'Juni 2026', 'pemasukan' => 8500000, 'pengeluaran' => 5200000, 'saldo_bersih' => 3300000],
            ['bulan' => 'Juli 2026', 'pemasukan' => 4900000, 'pengeluaran' => 3800000, 'saldo_bersih' => 1100000],
            ['bulan' => 'Agustus 2026', 'pemasukan' => 9100000, 'pengeluaran' => 4600000, 'saldo_bersih' => 4500000],
            ['bulan' => 'September 2026', 'pemasukan' => 7500000, 'pengeluaran' => 3250000, 'saldo_bersih' => 4250000],
        ];
    }

    public static function getCategoryBreakdown(): array
    {
        return [
            'pemasukan' => [
                ['kategori' => 'Sponsorship', 'nominal' => 5000000, 'persen' => 66.7, 'color' => 'bg-emerald-500'],
                ['kategori' => 'Uang Kas', 'nominal' => 2500000, 'persen' => 33.3, 'color' => 'bg-teal-500'],
            ],
            'pengeluaran' => [
                ['kategori' => 'Logistik', 'nominal' => 1150000, 'persen' => 35.4, 'color' => 'bg-rose-500'],
                ['kategori' => 'Operasional', 'nominal' => 650000, 'persen' => 20.0, 'color' => 'bg-amber-500'],
                ['kategori' => 'Konsumsi', 'nominal' => 450000, 'persen' => 13.8, 'color' => 'bg-indigo-500'],
                ['kategori' => 'Transportasi', 'nominal' => 1000000, 'persen' => 30.8, 'color' => 'bg-sky-500'],
            ],
        ];
    }
}
