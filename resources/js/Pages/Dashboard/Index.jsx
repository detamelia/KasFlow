import React, { useState } from 'react';
import { Link, Head } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function DashboardIndex({
    summary = {},
    transactions = [],
    monthlyReports = [],
    categoryBreakdown = { pengeluaran: [] },
    role = 'anggota',
}) {
    const [selectedTransaction, setSelectedTransaction] = useState(null);
    const [toastMessage, setToastMessage] = useState(null);

    const showToast = (msg) => {
        setToastMessage(msg);
        setTimeout(() => setToastMessage(null), 3500);
    };

    const maxVal = 10000000;

    return (
        <AppLayout title="Dashboard KasFlow">
            <Head title="Dashboard - KasFlow" />

            {/* Toast Notification */}
            {toastMessage && (
                <div className="fixed bottom-5 right-5 z-50 bg-slate-900 text-white text-xs sm:text-sm px-4 py-3 rounded-xl shadow-xl flex items-center gap-3 border border-slate-700 animate-fade-in">
                    <span className="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>{toastMessage}</span>
                </div>
            )}

            <div className="space-y-6">
                {/* Header Section */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 tracking-tight">Ringkasan Keuangan Organisasi</h1>
                        <p className="text-xs sm:text-sm text-slate-500 mt-1">
                            Pantau saldo, arus kas pemasukan & pengeluaran Himpunan Mahasiswa Informatika.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        {role === 'bendahara' ? (
                            <>
                                <Link
                                    href="/pemasukan"
                                    className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-xs text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all cursor-pointer"
                                >
                                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Pemasukan
                                </Link>

                                <Link
                                    href="/pengeluaran"
                                    className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-xs text-white bg-rose-600 hover:bg-rose-700 shadow-lg shadow-rose-600/20 transition-all cursor-pointer"
                                >
                                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M20 12H4" />
                                    </svg>
                                    Pengeluaran
                                </Link>
                            </>
                        ) : (
                            <button
                                type="button"
                                onClick={() => showToast('Laporan Keuangan sedang disiapkan untuk diunduh.')}
                                className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-xs text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 shadow-xs transition-all cursor-pointer"
                            >
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh Ringkasan (PDF)
                            </button>
                        )}
                    </div>
                </div>

                {/* 4 Financial Metrics Cards */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    {/* Saldo Utama Card */}
                    <div className="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl p-5 text-white shadow-lg shadow-emerald-900/20 relative overflow-hidden flex flex-col justify-between">
                        <div className="flex items-center justify-between mb-3">
                            <span className="text-xs font-semibold uppercase tracking-wider text-emerald-100">Total Saldo Utama</span>
                            <div className="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-xs flex items-center justify-center">
                                <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div className="text-2xl sm:text-3xl font-extrabold tracking-tight">
                                {summary.saldo_formatted || 'Rp 0'}
                            </div>
                            <p className="text-[11px] text-emerald-100/90 mt-2 font-medium">
                                Status Kas Sesuai & Safe Margin
                            </p>
                        </div>
                    </div>

                    {/* Pemasukan Bulan Ini */}
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
                        <div className="flex items-center justify-between mb-3">
                            <div>
                                <span className="text-xs font-semibold text-slate-500 uppercase">Pemasukan Bulan Ini</span>
                                <span className="text-[11px] block text-slate-400">September 2026</span>
                            </div>
                            <span className="text-xs font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                +14.8%
                            </span>
                        </div>
                        <div className="text-2xl font-bold tracking-tight text-emerald-600">
                            {summary.pemasukan_formatted || 'Rp 0'}
                        </div>
                    </div>

                    {/* Pengeluaran Bulan Ini */}
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
                        <div className="flex items-center justify-between mb-3">
                            <div>
                                <span className="text-xs font-semibold text-slate-500 uppercase">Pengeluaran Bulan Ini</span>
                                <span className="text-[11px] block text-slate-400">September 2026</span>
                            </div>
                            <span className="text-xs font-bold px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                                -5.2%
                            </span>
                        </div>
                        <div className="text-2xl font-bold tracking-tight text-rose-600">
                            {summary.pengeluaran_formatted || 'Rp 0'}
                        </div>
                    </div>

                    {/* Total Transaksi */}
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
                        <div className="flex items-center justify-between mb-3">
                            <div>
                                <span className="text-xs font-semibold text-slate-500 uppercase">Total Transaksi</span>
                                <span className="text-[11px] block text-slate-400">Pemasukan & Pengeluaran</span>
                            </div>
                            <span className="text-xs font-bold px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                {summary.transaksi_pending || 0} Pending
                            </span>
                        </div>
                        <div className="text-2xl font-bold tracking-tight text-slate-900">
                            {summary.total_transaksi || 0} <span className="text-xs font-medium text-slate-500">Record</span>
                        </div>
                    </div>
                </div>

                {/* Charts & Category Distribution Section */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Monthly Cashflow Chart Visual */}
                    <div className="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-6">
                            <div>
                                <h3 className="text-base font-bold text-slate-900">Grafik Arus Kas 5 Bulan Terakhir</h3>
                                <p className="text-xs text-slate-500 mt-0.5">Perbandingan Pemasukan (Hijau) & Pengeluaran (Merah)</p>
                            </div>
                            <div className="flex items-center gap-3 text-xs font-semibold">
                                <span className="flex items-center gap-1.5">
                                    <span className="w-3 h-3 rounded-md bg-emerald-500"></span> Pemasukan
                                </span>
                                <span className="flex items-center gap-1.5">
                                    <span className="w-3 h-3 rounded-md bg-rose-400"></span> Pengeluaran
                                </span>
                            </div>
                        </div>

                        {/* Bar Chart Visual */}
                        <div className="h-60 flex items-end justify-between gap-4 pt-4 px-2 border-b border-slate-100">
                            {monthlyReports.map((item, idx) => {
                                const pemasukanHeight = Math.min(100, Math.max(15, ((item.pemasukan || 0) / maxVal) * 100));
                                const pengeluaranHeight = Math.min(100, Math.max(15, ((item.pengeluaran || 0) / maxVal) * 100));

                                return (
                                    <div key={idx} className="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                                        <div className="w-full flex justify-center items-end gap-1.5 h-48">
                                            {/* Pemasukan Bar */}
                                            <div
                                                style={{ height: `${pemasukanHeight}%` }}
                                                className="w-4 sm:w-6 bg-emerald-500 rounded-t-lg transition-all duration-300 group-hover:bg-emerald-600 relative cursor-pointer"
                                                title={`Pemasukan ${item.bulan}: Rp ${Number(item.pemasukan || 0).toLocaleString('id-ID')}`}
                                            ></div>
                                            {/* Pengeluaran Bar */}
                                            <div
                                                style={{ height: `${pengeluaranHeight}%` }}
                                                className="w-4 sm:w-6 bg-rose-400 rounded-t-lg transition-all duration-300 group-hover:bg-rose-500 relative cursor-pointer"
                                                title={`Pengeluaran ${item.bulan}: Rp ${Number(item.pengeluaran || 0).toLocaleString('id-ID')}`}
                                            ></div>
                                        </div>
                                        <span className="text-[11px] font-medium text-slate-500 group-hover:text-slate-900 transition-colors">
                                            {item.bulan.split(' ')[0]}
                                        </span>
                                    </div>
                                );
                            })}
                        </div>
                        <div className="mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs text-slate-500">
                            <span>
                                Rata-rata Surplus Bersih: <strong className="text-emerald-700">Rp 2.650.000 / Bulan</strong>
                            </span>
                            <Link href="/laporan" className="text-emerald-600 hover:text-emerald-700 font-semibold flex items-center gap-1">
                                Lihat Analisis Detail &rarr;
                            </Link>
                        </div>
                    </div>

                    {/* Category Distribution Progress Widget */}
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs flex flex-col justify-between">
                        <div>
                            <h3 className="text-base font-bold text-slate-900 mb-1">Proporsi Pengeluaran</h3>
                            <p className="text-xs text-slate-500 mb-5">Distribusi pengeluaran berdasarkan kategori bulan ini</p>

                            <div className="space-y-4">
                                {categoryBreakdown.pengeluaran && categoryBreakdown.pengeluaran.map((cat, idx) => (
                                    <div key={idx}>
                                        <div className="flex items-center justify-between text-xs font-semibold mb-1">
                                            <span className="text-slate-700">{cat.kategori}</span>
                                            <span className="text-slate-900">
                                                Rp {Number(cat.nominal || 0).toLocaleString('id-ID')} ({cat.persen}%)
                                            </span>
                                        </div>
                                        <div className="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                            <div
                                                className={`${cat.color || 'bg-emerald-500'} h-full rounded-full transition-all duration-500`}
                                                style={{ width: `${cat.persen}%` }}
                                            ></div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>

                        <div className="mt-6 pt-4 border-t border-slate-100">
                            <div className="bg-emerald-50 rounded-xl p-3 border border-emerald-100 flex items-center gap-3">
                                <svg className="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p className="text-xs text-emerald-800">
                                    Pengeluaran dominan: <strong className="font-bold">Logistik (35.4%)</strong> untuk perlengkapan event.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Recent Transactions Table Section */}
                <div className="space-y-4">
                    <div className="flex items-center justify-between">
                        <div>
                            <h2 className="text-lg font-bold text-slate-900">Transaksi Terbaru</h2>
                            <p className="text-xs text-slate-500">Daftar transaksi kas organisasi yang tercatat paling akhir</p>
                        </div>

                        <Link
                            href="/transaksi"
                            className="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1"
                        >
                            Lihat Semua Transaksi
                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </Link>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                        <div className="overflow-x-auto">
                            <table className="w-full text-left text-slate-700">
                                <thead className="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase border-b border-slate-200">
                                    <tr>
                                        <th className="px-6 py-3.5">Kode & Transaksi</th>
                                        <th className="px-6 py-3.5">Kategori</th>
                                        <th className="px-6 py-3.5">Tanggal</th>
                                        <th className="px-6 py-3.5">Nominal</th>
                                        <th className="px-6 py-3.5">Status</th>
                                        <th className="px-6 py-3.5">Penanggung Jawab</th>
                                        <th className="px-6 py-3.5 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-slate-100 text-xs font-medium">
                                    {transactions.map((t) => (
                                        <tr key={t.id || t.kode} className="hover:bg-slate-50/80 transition-colors">
                                            <td className="px-6 py-4">
                                                <div className="flex items-center gap-3">
                                                    <div
                                                        className={`p-2 rounded-xl shrink-0 ${
                                                            t.jenis === 'pemasukan'
                                                                ? 'bg-emerald-100 text-emerald-700'
                                                                : 'bg-rose-100 text-rose-700'
                                                        }`}
                                                    >
                                                        {t.jenis === 'pemasukan' ? (
                                                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                                            </svg>
                                                        ) : (
                                                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                                            </svg>
                                                        )}
                                                    </div>
                                                    <div>
                                                        <span className="font-bold text-slate-900 block leading-snug">{t.judul}</span>
                                                        <span className="text-[11px] font-mono text-slate-400 block">{t.kode}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td className="px-6 py-4">
                                                <span className="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                                    {t.kategori}
                                                </span>
                                            </td>

                                            <td className="px-6 py-4 text-xs font-medium text-slate-600">
                                                {t.tanggal_formatted || t.tanggal}
                                            </td>

                                            <td
                                                className={`px-6 py-4 font-bold text-sm ${
                                                    t.jenis === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600'
                                                }`}
                                            >
                                                {t.jenis === 'pemasukan' ? '+' : '-'} {t.nominal_formatted || `Rp ${Number(t.nominal).toLocaleString('id-ID')}`}
                                            </td>

                                            <td className="px-6 py-4">
                                                {t.status === 'Terverifikasi' ? (
                                                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                        <span className="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                        Terverifikasi
                                                    </span>
                                                ) : t.status === 'Pending' ? (
                                                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                        <span className="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                        Pending
                                                    </span>
                                                ) : (
                                                    <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                                        <span className="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                        Ditolak
                                                    </span>
                                                )}
                                            </td>

                                            <td className="px-6 py-4 text-xs text-slate-600">
                                                {t.penanggung_jawab}
                                            </td>

                                            <td className="px-6 py-4 text-right">
                                                <button
                                                    type="button"
                                                    onClick={() => setSelectedTransaction(t)}
                                                    className="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer"
                                                >
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {/* Modal Detail Transaksi */}
            {selectedTransaction && (
                <div
                    className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fade-in"
                    onClick={() => setSelectedTransaction(null)}
                >
                    <div
                        className="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-4"
                        onClick={(e) => e.stopPropagation()}
                    >
                        <div className="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div>
                                <h3 className="text-base font-bold text-slate-900">Rincian Transaksi</h3>
                                <p className="text-xs font-mono text-slate-400">{selectedTransaction.kode}</p>
                            </div>
                            <button
                                type="button"
                                onClick={() => setSelectedTransaction(null)}
                                className="text-slate-400 hover:text-slate-600 p-1 rounded-lg cursor-pointer"
                            >
                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div className="space-y-4 text-sm">
                            <div
                                className={`p-4 rounded-xl flex justify-between items-center ${
                                    selectedTransaction.jenis === 'pemasukan'
                                        ? 'bg-emerald-50 text-emerald-900 border border-emerald-100'
                                        : 'bg-rose-50 text-rose-900 border border-rose-100'
                                }`}
                            >
                                <div>
                                    <span className="text-[11px] font-semibold uppercase tracking-wider block opacity-75">
                                        Nominal {selectedTransaction.jenis}
                                    </span>
                                    <span className="text-2xl font-extrabold">
                                        {selectedTransaction.nominal_formatted || `Rp ${Number(selectedTransaction.nominal).toLocaleString('id-ID')}`}
                                    </span>
                                </div>
                                <span
                                    className={`text-xs px-2.5 py-1 rounded-full font-bold uppercase ${
                                        selectedTransaction.jenis === 'pemasukan'
                                            ? 'bg-emerald-200 text-emerald-800'
                                            : 'bg-rose-200 text-rose-800'
                                    }`}
                                >
                                    {selectedTransaction.jenis}
                                </span>
                            </div>

                            <div className="grid grid-cols-2 gap-4 text-xs">
                                <div>
                                    <span className="text-slate-400 block font-medium">Judul Transaksi</span>
                                    <span className="font-semibold text-slate-800 text-sm">{selectedTransaction.judul}</span>
                                </div>
                                <div>
                                    <span className="text-slate-400 block font-medium">Kategori</span>
                                    <span className="font-semibold text-slate-800 text-sm">{selectedTransaction.kategori}</span>
                                </div>
                                <div>
                                    <span className="text-slate-400 block font-medium">Tanggal Pencatatan</span>
                                    <span className="font-semibold text-slate-800">{selectedTransaction.tanggal_formatted || selectedTransaction.tanggal}</span>
                                </div>
                                <div>
                                    <span className="text-slate-400 block font-medium">Penanggung Jawab</span>
                                    <span className="font-semibold text-slate-800">{selectedTransaction.penanggung_jawab}</span>
                                </div>
                            </div>

                            <div className="pt-2 border-t border-slate-100">
                                <span className="text-xs text-slate-400 block font-medium mb-1">Deskripsi & Catatan</span>
                                <p className="text-xs text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-200/70 leading-relaxed">
                                    {selectedTransaction.deskripsi || 'Tidak ada catatan tambahan.'}
                                </p>
                            </div>

                            <div>
                                <span className="text-xs text-slate-400 block font-medium mb-1">Bukti Transfer / Nota Struk</span>
                                <div className="p-3 bg-slate-100 rounded-xl border border-slate-200 flex items-center justify-between text-xs">
                                    <div className="flex items-center gap-2">
                                        <svg className="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                        <span className="font-medium text-slate-700">{selectedTransaction.bukti}</span>
                                    </div>
                                    <button
                                        type="button"
                                        onClick={() => showToast(`Membuka file bukti: ${selectedTransaction.bukti}`)}
                                        className="text-xs font-semibold px-2.5 py-1 rounded-md bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors cursor-pointer"
                                    >
                                        Lihat File
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div className="pt-3 border-t border-slate-100 flex justify-end">
                            <button
                                type="button"
                                onClick={() => setSelectedTransaction(null)}
                                className="px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer"
                            >
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </AppLayout>
    );
}
