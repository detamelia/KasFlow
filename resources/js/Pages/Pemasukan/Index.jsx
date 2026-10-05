import React from 'react';
import { Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function PemasukanIndex({
    pemasukan = [],
    role = 'bendahara',
    totalPemasukan = 0,
    totalPemasukanFormatted = 'Rp 0',
    jumlahTransaksi = 0,
}) {
    return (
        <AppLayout title="Pos Pemasukan Kas">
            <div className="space-y-6">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Pemasukan</h1>
                        <p className="text-xs sm:text-sm text-slate-500 mt-1">
                            Kelola penerimaan kas, iuran, donasi, dan sponsorship organisasi.
                        </p>
                    </div>

                    {role === 'bendahara' && (
                        /* Tautan ke halaman tambah (create) Blade sesuai aturan Tugas Studio 3 */
                        <a
                            href="/pemasukan/create"
                            className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-xs text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all"
                        >
                            + Tambah Pemasukan (Blade)
                        </a>
                    )}
                </div>

                {/* KPI */}
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div className="bg-emerald-600 p-5 rounded-2xl text-white shadow-lg shadow-emerald-600/20">
                        <span className="text-xs font-semibold text-emerald-100 uppercase">Total Akumulasi Pemasukan</span>
                        <div className="text-2xl font-extrabold text-white mt-1">{totalPemasukanFormatted}</div>
                    </div>
                    <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                        <span className="text-xs font-semibold text-slate-500 uppercase">Jumlah Transaksi Penerimaan</span>
                        <div className="text-2xl font-extrabold text-slate-900 mt-1">{jumlahTransaksi} Transaksi</div>
                    </div>
                </div>

                {/* Table */}
                <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <table className="w-full text-left text-slate-700">
                        <thead className="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase border-b border-slate-200">
                            <tr>
                                <th className="px-6 py-3.5">Kode & Tanggal</th>
                                <th className="px-6 py-3.5">Judul Pemasukan</th>
                                <th className="px-6 py-3.5">Kategori</th>
                                <th className="px-6 py-3.5 text-right">Nominal</th>
                                <th className="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-100 text-xs font-medium">
                            {pemasukan.length > 0 ? (
                                pemasukan.map((item) => (
                                    <tr key={item.id || item.kode} className="hover:bg-slate-50/80 transition-colors">
                                        <td className="px-6 py-4">
                                            <span className="font-bold text-slate-900 block">{item.kode}</span>
                                            <span className="text-[11px] text-slate-400">{item.tanggal}</span>
                                        </td>
                                        <td className="px-6 py-4 font-semibold text-slate-900">
                                            {/* Link React ke Show Page */}
                                            <Link href={`/pemasukan/${item.id || item.kode}`} className="hover:text-emerald-600">
                                                {item.judul}
                                            </Link>
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                {item.kategori}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-right font-bold text-sm text-emerald-600">
                                            + Rp {Number(item.nominal || 0).toLocaleString('id-ID')}
                                        </td>
                                        <td className="px-6 py-4 text-right">
                                            {/* Link React ke Show */}
                                            <Link
                                                href={`/pemasukan/${item.id || item.kode}`}
                                                className="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors"
                                            >
                                                Rincian (React)
                                            </Link>
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan="5" className="px-6 py-8 text-center text-slate-400">
                                        Belum ada catatan pemasukan.
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AppLayout>
    );
}
