import React from 'react';
import { Link } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function PemasukanShow({ item, role = 'bendahara' }) {
    return (
        <AppLayout title={`Rincian Pemasukan: ${item?.kode || 'Pemasukan'}`}>
            <div className="space-y-6 max-w-4xl mx-auto">
                <div className="flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <Link
                            href="/pemasukan"
                            className="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 shadow-xs"
                        >
                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </Link>
                        <div>
                            <span className="text-xs font-semibold text-emerald-600 block uppercase">Rincian Pos Pemasukan (React)</span>
                            <h1 className="text-2xl font-bold text-slate-900">{item?.judul}</h1>
                        </div>
                    </div>

                    <Link
                        href="/pemasukan"
                        className="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-200"
                    >
                        &larr; Kembali ke Daftar
                    </Link>
                </div>

                <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-6">
                    <div className="flex items-center justify-between pb-6 border-b border-slate-100">
                        <div>
                            <span className="text-xs text-slate-400 font-medium">Kode Transaksi</span>
                            <h2 className="text-xl font-bold text-slate-900">{item?.kode}</h2>
                        </div>
                        <div className="text-right">
                            <span className="text-xs text-slate-400 font-medium block">Nominal Pemasukan</span>
                            <span className="text-2xl font-black text-emerald-600">
                                + Rp {Number(item?.nominal || 0).toLocaleString('id-ID')}
                            </span>
                        </div>
                    </div>

                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <span className="text-xs text-slate-400 block">Kategori</span>
                            <span className="text-sm font-bold text-slate-800">{item?.kategori}</span>
                        </div>
                        <div className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <span className="text-xs text-slate-400 block">Tanggal Penerimaan</span>
                            <span className="text-sm font-bold text-slate-800">{item?.tanggal}</span>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
