import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function KategoriShow({ kategori, role = 'bendahara', relatedTransaksi = [] }) {
    const isPemasukan = kategori?.jenis === 'pemasukan';

    return (
        <AppLayout title={`Rincian Kategori: ${kategori?.nama_kategori || 'Kategori'}`}>
            <div className="space-y-6 max-w-4xl mx-auto">
                {/* Back Button and Title */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div className="flex items-center gap-3">
                        {/* Pakai Link dari Inertia untuk perpindahan antar React page */}
                        <Link
                            href="/kategori"
                            className="p-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors shadow-xs"
                            title="Kembali ke Daftar Kategori"
                        >
                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </Link>
                        <div>
                            <span className="text-xs font-semibold text-slate-400 block uppercase tracking-wider">Rincian Modul Kategori</span>
                            <h1 className="text-2xl font-bold text-slate-900 tracking-tight">{kategori?.nama_kategori}</h1>
                        </div>
                    </div>

                    <div className="flex items-center gap-2">
                        {/* Link React kembali ke Index */}
                        <Link
                            href="/kategori"
                            className="px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-colors shadow-xs"
                        >
                            &larr; Kembali ke Daftar
                        </Link>

                        {role === 'bendahara' && (
                            /* Tautan ke halaman ubah (edit) menggunakan tag a biasa sesuai petunjuk Tugas Studio 3 */
                            <a
                                href={`/kategori/${kategori?.id}/edit`}
                                className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors shadow-md shadow-emerald-600/20"
                            >
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                <span>Edit Kategori (Blade)</span>
                            </a>
                        )}
                    </div>
                </div>

                {/* Main Category Card Detail */}
                <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-6">
                    <div className="flex items-center justify-between pb-6 border-b border-slate-100">
                        <div className="flex items-center gap-4">
                            <div className={`p-4 rounded-2xl ${isPemasukan ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'}`}>
                                {isPemasukan ? (
                                    <svg className="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                ) : (
                                    <svg className="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                                )}
                            </div>
                            <div>
                                <span className="text-xs text-slate-400 font-medium">Nama Kategori</span>
                                <h2 className="text-xl font-extrabold text-slate-900">{kategori?.nama_kategori}</h2>
                            </div>
                        </div>

                        <span className={`inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold uppercase ${
                            isPemasukan
                                ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                                : 'bg-rose-50 text-rose-700 border border-rose-200'
                        }`}>
                            <span className={`w-2 h-2 rounded-full ${isPemasukan ? 'bg-emerald-500' : 'bg-rose-500'}`}></span>
                            Pos {isPemasukan ? 'Pemasukan (+)' : 'Pengeluaran (-)'}
                        </span>
                    </div>

                    <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                        <div className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <span className="text-xs text-slate-400 font-medium block">Total Transaksi</span>
                            <span className="text-lg font-bold text-slate-900">{kategori?.transaksi_count || relatedTransaksi.length || 0} Catatan</span>
                        </div>
                        <div className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <span className="text-xs text-slate-400 font-medium block">Tanggal Dibuat</span>
                            <span className="text-sm font-semibold text-slate-700">
                                {kategori?.created_at ? new Date(kategori.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-'}
                            </span>
                        </div>
                        <div className="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <span className="text-xs text-slate-400 font-medium block">Terakhir Diperbarui</span>
                            <span className="text-sm font-semibold text-slate-700">
                                {kategori?.updated_at ? new Date(kategori.updated_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-'}
                            </span>
                        </div>
                    </div>
                </div>

                {/* Related Transactions List */}
                <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                    <h3 className="text-sm font-bold text-slate-900">Daftar Transaksi Terkait Kategori Ini</h3>
                    {relatedTransaksi.length > 0 ? (
                        <div className="divide-y divide-slate-100 text-xs">
                            {relatedTransaksi.map((t) => (
                                <div key={t.id || t.kode} className="py-3 flex items-center justify-between">
                                    <div>
                                        <p className="font-semibold text-slate-900">{t.judul || t.keterangan}</p>
                                        <span className="text-[11px] text-slate-400">{t.tanggal || t.created_at}</span>
                                    </div>
                                    <span className={`font-bold ${isPemasukan ? 'text-emerald-600' : 'text-rose-600'}`}>
                                        {isPemasukan ? '+' : '-'} Rp {Number(t.nominal || 0).toLocaleString('id-ID')}
                                    </span>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <p className="text-xs text-slate-400 py-4 text-center">Belum ada rincian riwayat transaksi untuk pos kategori ini.</p>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
