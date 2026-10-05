import React, { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function TransaksiIndex({
    transactions = [],
    role = 'bendahara',
    search = '',
    jenisFilter = 'semua',
    totalItems = 0,
}) {
    const [searchTerm, setSearchTerm] = useState(search);
    const [selectedJenis, setSelectedJenis] = useState(jenisFilter);

    const handleFilter = (e) => {
        e.preventDefault();
        router.get('/transaksi', { search: searchTerm, jenis: selectedJenis }, { preserveState: true });
    };

    const handleReset = () => {
        setSearchTerm('');
        setSelectedJenis('semua');
        router.get('/transaksi');
    };

    return (
        <AppLayout title="Semua Catatan Transaksi">
            <div className="space-y-6">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 tracking-tight">Daftar Transaksi</h1>
                        <p className="text-xs sm:text-sm text-slate-500 mt-1">
                            Semua catatan riwayat arus kas (pemasukan & pengeluaran) organisasi.
                        </p>
                    </div>

                    {role === 'bendahara' && (
                        <div className="flex items-center gap-2">
                            <a
                                href="/pemasukan/create"
                                className="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md transition-colors"
                            >
                                + Pemasukan (Blade)
                            </a>
                            <a
                                href="/pengeluaran/create"
                                className="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 shadow-md transition-colors"
                            >
                                + Pengeluaran (Blade)
                            </a>
                        </div>
                    )}
                </div>

                {/* Filter */}
                <div className="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
                    <form onSubmit={handleFilter} className="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div className="flex-1 w-full md:w-auto flex flex-col sm:flex-row items-center gap-3">
                            <input
                                type="text"
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                placeholder="Cari kode, judul, atau kategori..."
                                className="w-full sm:w-72 px-3.5 py-2 rounded-xl text-xs border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                            />
                            <select
                                value={selectedJenis}
                                onChange={(e) => setSelectedJenis(e.target.value)}
                                className="w-full sm:w-56 px-3.5 py-2 rounded-xl text-xs border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                            >
                                <option value="semua">Semua Transaksi</option>
                                <option value="pemasukan">Pemasukan (+)</option>
                                <option value="pengeluaran">Pengeluaran (-)</option>
                            </select>
                        </div>
                        <div className="flex items-center gap-2">
                            {(searchTerm || selectedJenis !== 'semua') && (
                                <button type="button" onClick={handleReset} className="px-3 py-2 text-xs font-semibold text-slate-600 bg-slate-100 rounded-xl">
                                    Reset
                                </button>
                            )}
                            <button type="submit" className="px-4 py-2 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                {/* Table */}
                <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <table className="w-full text-left text-slate-700">
                        <thead className="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase border-b border-slate-200">
                            <tr>
                                <th className="px-6 py-3.5">Kode & Tanggal</th>
                                <th className="px-6 py-3.5">Judul Transaksi</th>
                                <th className="px-6 py-3.5">Jenis & Kategori</th>
                                <th className="px-6 py-3.5 text-right">Nominal</th>
                                <th className="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-100 text-xs font-medium">
                            {transactions.length > 0 ? (
                                transactions.map((item) => (
                                    <tr key={item.id || item.kode} className="hover:bg-slate-50/80 transition-colors">
                                        <td className="px-6 py-4">
                                            <span className="font-bold text-slate-900 block">{item.kode}</span>
                                            <span className="text-[11px] text-slate-400">{item.tanggal}</span>
                                        </td>
                                        <td className="px-6 py-4 font-semibold text-slate-900">
                                            {/* Link React ke Show Page */}
                                            <Link href={`/transaksi/${item.id || item.kode}`} className="hover:text-emerald-600">
                                                {item.judul}
                                            </Link>
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className={`inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold mb-1 ${
                                                item.jenis === 'pemasukan' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700'
                                            }`}>
                                                {item.jenis === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran'}
                                            </span>
                                            <span className="block text-[11px] text-slate-500">{item.kategori}</span>
                                        </td>
                                        <td className={`px-6 py-4 text-right font-bold text-sm ${
                                            item.jenis === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600'
                                        }`}>
                                            {item.jenis === 'pemasukan' ? '+' : '-'} Rp {Number(item.nominal || 0).toLocaleString('id-ID')}
                                        </td>
                                        <td className="px-6 py-4 text-right">
                                            {/* Link ke Rincian React */}
                                            <Link
                                                href={`/transaksi/${item.id || item.kode}`}
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
                                        Tidak ada catatan transaksi yang ditemukan.
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
