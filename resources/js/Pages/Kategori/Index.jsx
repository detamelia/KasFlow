import React, { useState } from 'react';
import { Link, router, usePage } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function KategoriIndex({
    kategoriList = [],
    role = 'bendahara',
    search = '',
    jenisFilter = 'semua',
    totalKategori = 0,
    totalPemasukan = 0,
    totalPengeluaran = 0,
    totalTransaksi = 0,
}) {
    const [searchTerm, setSearchTerm] = useState(search);
    const [selectedJenis, setSelectedJenis] = useState(jenisFilter);

    const handleFilter = (e) => {
        e.preventDefault();
        router.get('/kategori', { search: searchTerm, jenis: selectedJenis }, { preserveState: true });
    };

    const handleReset = () => {
        setSearchTerm('');
        setSelectedJenis('semua');
        router.get('/kategori');
    };

    const handleDelete = (id, nama) => {
        if (confirm(`Apakah Anda yakin ingin menghapus kategori "${nama}"?`)) {
            router.delete(`/kategori/${id}`);
        }
    };

    return (
        <AppLayout title="Manajemen Kategori">
            <div className="space-y-6">
                {/* Header Section */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Kategori</h1>
                        <p className="text-xs sm:text-sm text-slate-500 mt-1">
                            Kelola klasifikasi pos transaksi pemasukan dan pengeluaran kas organisasi.
                        </p>
                    </div>

                    {role === 'bendahara' && (
                        <div className="flex items-center gap-2">
                            {/* Memakai tag a biasa ke formulir Blade sesuai aturan Tugas Studio 3 */}
                            <a
                                href="/kategori/create"
                                className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-xs text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all cursor-pointer"
                            >
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Tambah Kategori (Blade)</span>
                            </a>
                        </div>
                    )}
                </div>

                {/* Summary KPI Cards */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                        <span className="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Kategori</span>
                        <div className="text-2xl font-extrabold text-slate-900 mt-1 flex items-baseline gap-2">
                            {totalKategori}
                            <span className="text-xs text-slate-500 font-normal">Kategori</span>
                        </div>
                    </div>

                    <div className="bg-emerald-600 p-5 rounded-2xl text-white shadow-lg shadow-emerald-600/20">
                        <span className="text-xs font-semibold text-emerald-100 uppercase tracking-wider">Kategori Pemasukan</span>
                        <div className="text-2xl font-extrabold text-white mt-1 flex items-baseline gap-2">
                            {totalPemasukan}
                            <span className="text-xs text-emerald-100 font-normal">Pos Aktif</span>
                        </div>
                    </div>

                    <div className="bg-rose-600 p-5 rounded-2xl text-white shadow-lg shadow-rose-600/20">
                        <span className="text-xs font-semibold text-rose-100 uppercase tracking-wider">Kategori Pengeluaran</span>
                        <div className="text-2xl font-extrabold text-white mt-1 flex items-baseline gap-2">
                            {totalPengeluaran}
                            <span className="text-xs text-rose-100 font-normal">Pos Aktif</span>
                        </div>
                    </div>

                    <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                        <span className="text-xs font-semibold text-slate-500 uppercase tracking-wider">Transaksi Terhubung</span>
                        <div className="text-2xl font-extrabold text-slate-900 mt-1 flex items-baseline gap-2">
                            {totalTransaksi}
                            <span className="text-xs text-slate-500 font-normal">Transaksi</span>
                        </div>
                    </div>
                </div>

                {/* Filter & Search Bar */}
                <div className="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
                    <form onSubmit={handleFilter} className="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div className="flex-1 w-full md:w-auto flex flex-col sm:flex-row items-center gap-3">
                            <div className="w-full sm:w-72">
                                <input
                                    type="text"
                                    value={searchTerm}
                                    onChange={(e) => setSearchTerm(e.target.value)}
                                    placeholder="Cari nama kategori..."
                                    className="w-full px-3.5 py-2 rounded-xl text-xs border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                                />
                            </div>

                            <div className="w-full sm:w-56">
                                <select
                                    value={selectedJenis}
                                    onChange={(e) => setSelectedJenis(e.target.value)}
                                    className="w-full px-3.5 py-2 rounded-xl text-xs border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500"
                                >
                                    <option value="semua">Semua Jenis</option>
                                    <option value="pemasukan">Pemasukan (+)</option>
                                    <option value="pengeluaran">Pengeluaran (-)</option>
                                </select>
                            </div>
                        </div>

                        <div className="flex items-center gap-2 w-full md:w-auto justify-end">
                            {(searchTerm || selectedJenis !== 'semua') && (
                                <button
                                    type="button"
                                    onClick={handleReset}
                                    className="px-3.5 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors"
                                >
                                    Reset
                                </button>
                            )}

                            <button
                                type="submit"
                                className="px-4 py-2 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-xl transition-colors"
                            >
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>

                {/* Table Component */}
                <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-slate-700">
                            <thead className="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                                <tr>
                                    <th className="px-6 py-3.5">Nama Kategori</th>
                                    <th className="px-6 py-3.5">Jenis</th>
                                    <th className="px-6 py-3.5">Diperbarui</th>
                                    <th className="px-6 py-3.5 text-right">Aksi (Rincian & Form)</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 text-xs font-medium">
                                {kategoriList.length > 0 ? (
                                    kategoriList.map((item) => (
                                        <tr key={item.id} className="hover:bg-slate-50/80 transition-colors">
                                            <td className="px-6 py-4">
                                                <div className="flex items-center gap-3">
                                                    <div className={`p-2.5 rounded-xl shrink-0 ${
                                                        item.jenis === 'pemasukan' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'
                                                    }`}>
                                                        {item.jenis === 'pemasukan' ? (
                                                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                                        ) : (
                                                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                                                        )}
                                                    </div>
                                                    <div>
                                                        {/* Link React ke Halaman Show */}
                                                        <Link
                                                            href={`/kategori/${item.id}`}
                                                            className="font-bold text-slate-900 hover:text-emerald-600 block leading-snug transition-colors"
                                                        >
                                                            {item.nama_kategori}
                                                        </Link>
                                                        <span className="text-[11px] text-slate-400">
                                                            {item.transaksi_count || 0} transaksi terhubung
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td className="px-6 py-4">
                                                <span className={`inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold ${
                                                    item.jenis === 'pemasukan'
                                                        ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                                                        : 'bg-rose-50 text-rose-700 border border-rose-200'
                                                }`}>
                                                    <span className={`w-1.5 h-1.5 rounded-full ${item.jenis === 'pemasukan' ? 'bg-emerald-500' : 'bg-rose-500'}`}></span>
                                                    {item.jenis === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran'}
                                                </span>
                                            </td>

                                            <td className="px-6 py-4 text-slate-500">
                                                {item.updated_at ? new Date(item.updated_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : '-'}
                                            </td>

                                            <td className="px-6 py-4 text-right">
                                                <div className="flex items-center justify-end gap-2">
                                                    {/* Link React ke Show Page */}
                                                    <Link
                                                        href={`/kategori/${item.id}`}
                                                        className="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors"
                                                        title="Lihat Rincian (React)"
                                                    >
                                                        <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                        <span>Rincian</span>
                                                    </Link>

                                                    {role === 'bendahara' && (
                                                        <>
                                                            {/* Tag a biasa ke Edit Blade sesuai aturan Tugas Studio 3 */}
                                                            <a
                                                                href={`/kategori/${item.id}/edit`}
                                                                className="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors"
                                                                title="Edit Form (Blade)"
                                                            >
                                                                <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                                <span>Edit</span>
                                                            </a>

                                                            <button
                                                                onClick={() => handleDelete(item.id, item.nama_kategori)}
                                                                className="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 transition-colors"
                                                                title="Hapus"
                                                            >
                                                                <svg className="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                            </button>
                                                        </>
                                                    )}
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="4" className="px-6 py-8 text-center text-slate-400">
                                            Belum ada kategori terdaftar atau cocok dengan pencarian.
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
