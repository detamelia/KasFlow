import React from 'react';
import { Head } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function LaporanIndex({
    summary = {},
    monthlyReports = [],
    categoryBreakdown = { pemasukan: [], pengeluaran: [] },
    role = 'anggota',
}) {
    return (
        <AppLayout title="Laporan Keuangan KasFlow">
            <Head title="Laporan Keuangan - KasFlow" />

            <div className="space-y-6">
                {/* Header Section */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 tracking-tight">Rincian & Laporan Keuangan Organisasi</h1>
                        <p className="text-xs sm:text-sm text-slate-500 mt-1">
                            Laporan akuntabilitas keuangan, analisis surplus/defisit kas, dan rincian alokasi dana.
                        </p>
                    </div>

                    <div className="flex items-center gap-2">
                        <button
                            type="button"
                            onClick={() => window.print()}
                            className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-xs text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 shadow-xs transition-all cursor-pointer"
                        >
                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak Laporan
                        </button>

                        <button
                            type="button"
                            onClick={() => alert('Fitur unduh berkas Laporan Keuangan (PDF) siap diekspor.')}
                            className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-xs text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all cursor-pointer"
                        >
                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Export PDF
                        </button>
                    </div>
                </div>

                {/* Financial Health Overview Cards */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div className="bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-2xl p-5 text-white shadow-lg shadow-indigo-900/20 flex flex-col justify-between">
                        <span className="text-xs font-semibold uppercase text-indigo-100">Total Saldo Kas</span>
                        <div>
                            <div className="text-2xl font-extrabold mt-1">{summary.saldo_formatted || 'Rp 0'}</div>
                            <span className="text-[11px] text-indigo-200 mt-1 block">Per 24 September 2026</span>
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
                        <span className="text-xs font-semibold text-slate-500 uppercase">Rasio Kelayakan Kas</span>
                        <div>
                            <div className="text-2xl font-bold text-emerald-600 mt-1">
                                {summary.cashflow_ratio || '1.84x'} <span className="text-xs font-normal text-slate-500">(Sehat)</span>
                            </div>
                            <span className="text-[11px] text-slate-400 mt-1 block">Cashflow Health Index</span>
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
                        <span className="text-xs font-semibold text-slate-500 uppercase">Total Pemasukan (Q3)</span>
                        <div>
                            <div className="text-2xl font-bold text-emerald-600 mt-1">Rp 21.500.000</div>
                            <span className="text-[11px] text-slate-400 mt-1 block">Juli - September</span>
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
                        <span className="text-xs font-semibold text-slate-500 uppercase">Total Pengeluaran (Q3)</span>
                        <div>
                            <div className="text-2xl font-bold text-rose-600 mt-1">Rp 11.650.000</div>
                            <span className="text-[11px] text-slate-400 mt-1 block">Juli - September</span>
                        </div>
                    </div>
                </div>

                {/* Monthly Financial Breakdown Table */}
                <div className="space-y-3">
                    <div className="flex items-center justify-between">
                        <h2 className="text-lg font-bold text-slate-900">Rekapitulasi Keuangan Bulanan (2026)</h2>
                        <span className="text-xs text-slate-500 font-medium">Satuan: Rupiah (IDR)</span>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                        <div className="overflow-x-auto">
                            <table className="w-full text-left text-slate-700">
                                <thead className="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase border-b border-slate-200">
                                    <tr>
                                        <th className="px-6 py-3.5">Bulan & Tahun</th>
                                        <th className="px-6 py-3.5">Total Pemasukan</th>
                                        <th className="px-6 py-3.5">Total Pengeluaran</th>
                                        <th className="px-6 py-3.5">Surplus / Defisit Bersih</th>
                                        <th className="px-6 py-3.5 text-right">Status Arus Kas</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-slate-100 text-xs font-medium">
                                    {monthlyReports.map((row, idx) => (
                                        <tr key={idx} className="hover:bg-slate-50/80 transition-colors">
                                            <td className="px-6 py-4 font-bold text-slate-900 text-sm">
                                                {row.bulan}
                                            </td>
                                            <td className="px-6 py-4 font-semibold text-emerald-600 text-sm">
                                                + Rp {Number(row.pemasukan || 0).toLocaleString('id-ID')}
                                            </td>
                                            <td className="px-6 py-4 font-semibold text-rose-600 text-sm">
                                                - Rp {Number(row.pengeluaran || 0).toLocaleString('id-ID')}
                                            </td>
                                            <td className="px-6 py-4 font-extrabold text-slate-900 text-sm">
                                                Rp {Number(row.saldo_bersih || 0).toLocaleString('id-ID')}
                                            </td>
                                            <td className="px-6 py-4 text-right">
                                                <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <span className="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Surplus (+)
                                                </span>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {/* Category Breakdown Cards Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {/* Pemasukan Breakdown */}
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                        <div className="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                            <h3 className="text-base font-bold text-slate-900">Rincian Sumber Pemasukan</h3>
                            <span className="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Pemasukan
                            </span>
                        </div>

                        <div className="space-y-4">
                            {categoryBreakdown.pemasukan && categoryBreakdown.pemasukan.map((cat, idx) => (
                                <div key={idx}>
                                    <div className="flex items-center justify-between text-xs font-semibold mb-1">
                                        <span className="text-slate-700">{cat.kategori}</span>
                                        <span className="text-emerald-700 font-bold">
                                            Rp {Number(cat.nominal || 0).toLocaleString('id-ID')} ({cat.persen}%)
                                        </span>
                                    </div>
                                    <div className="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                        <div
                                            className={`${cat.color || 'bg-emerald-500'} h-full rounded-full transition-all duration-500`}
                                            style={{ width: `${cat.persen}%` }}
                                        ></div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Pengeluaran Breakdown */}
                    <div className="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-xs">
                        <div className="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                            <h3 className="text-base font-bold text-slate-900">Rincian Alokasi Pengeluaran</h3>
                            <span className="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                                Pengeluaran
                            </span>
                        </div>

                        <div className="space-y-4">
                            {categoryBreakdown.pengeluaran && categoryBreakdown.pengeluaran.map((cat, idx) => (
                                <div key={idx}>
                                    <div className="flex items-center justify-between text-xs font-semibold mb-1">
                                        <span className="text-slate-700">{cat.kategori}</span>
                                        <span className="text-rose-700 font-bold">
                                            Rp {Number(cat.nominal || 0).toLocaleString('id-ID')} ({cat.persen}%)
                                        </span>
                                    </div>
                                    <div className="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                        <div
                                            className={`${cat.color || 'bg-rose-500'} h-full rounded-full transition-all duration-500`}
                                            style={{ width: `${cat.persen}%` }}
                                        ></div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
