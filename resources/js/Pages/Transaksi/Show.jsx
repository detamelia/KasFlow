import React from 'react';
import { Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function TransaksiShow({ transaction, role = 'bendahara' }) {
    const isPemasukan = transaction?.jenis === 'pemasukan';

    return (
        <AppLayout title={`Rincian Transaksi: ${transaction?.kode || 'Transaksi'}`}>
            <div className="space-y-6 max-w-4xl mx-auto">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div className="flex items-center gap-3">
                        <Link
                            href="/transaksi"
                            className="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 transition-colors shadow-xs"
                        >
                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </Link>
                        <div>
                            <span className="text-xs font-semibold text-slate-400 block uppercase">Rincian Transaksi (React)</span>
                            <h1 className="text-2xl font-bold text-slate-900">{transaction?.judul}</h1>
                        </div>
                    </div>

                    <div className="flex items-center gap-2">
                        <Link
                            href="/transaksi"
                            className="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-200"
                        >
                            &larr; Kembali ke Daftar
                        </Link>
                    </div>
                </div>

                <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-6">
                    <div className="flex items-center justify-between pb-6 border-b border-slate-100">
                        <div>
                            <span className="text-xs text-slate-400 font-medium">Kode Transaksi</span>
                            <h2 className="text-xl font-black text-slate-900">{transaction?.kode}</h2>
                        </div>
                        <div className="text-right">
                            <span className="text-xs text-slate-400 font-medium block">Nominal Kas</span>
                            <span className={`text-2xl font-black ${isPemasukan ? 'text-emerald-600' : 'text-rose-600'}`}>
                                {isPemasukan ? '+' : '-'} Rp {Number(transaction?.nominal || 0).toLocaleString('id-ID')}
                            </span>
                        </div>
                    </div>

                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <span className="text-xs text-slate-400 block">Kategori</span>
                            <span className="text-sm font-bold text-slate-800">{transaction?.kategori}</span>
                        </div>
                        <div className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <span className="text-xs text-slate-400 block">Jenis Transaksi</span>
                            <span className={`text-xs font-bold uppercase ${isPemasukan ? 'text-emerald-600' : 'text-rose-600'}`}>
                                {transaction?.jenis}
                            </span>
                        </div>
                        <div className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <span className="text-xs text-slate-400 block">Tanggal Catatan</span>
                            <span className="text-sm font-bold text-slate-800">{transaction?.tanggal}</span>
                        </div>
                        <div className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <span className="text-xs text-slate-400 block">Pencatat</span>
                            <span className="text-sm font-bold text-slate-800">{transaction?.pencatat || 'Bendahara'}</span>
                        </div>
                    </div>

                    {transaction?.keterangan && (
                        <div className="pt-2 border-t border-slate-100">
                            <span className="text-xs text-slate-400 font-medium block mb-1">Keterangan Catatan</span>
                            <p className="text-xs text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-100">{transaction.keterangan}</p>
                        </div>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
