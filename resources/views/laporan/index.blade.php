@extends('layouts.app', ['title' => 'Laporan Keuangan KasFlow', 'role' => $role])

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Rincian & Laporan Keuangan Organisasi</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Laporan akuntabilitas keuangan, analisis surplus/defisit kas, dan rincian alokasi dana.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <x-button
                variant="outline"
                size="md"
                onclick="window.print()"
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>'
            >
                Cetak Laporan
            </x-button>

            <x-button
                variant="primary"
                size="md"
                onclick="showToast('Mengunduh Berkas Laporan Keuangan (PDF)...')"
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>'
            >
                Export PDF
            </x-button>
        </div>
    </div>

    <!-- Financial Health Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-card variant="indigo" title="Total Saldo Kas" subtitle="Per 24 September 2026">
            <div class="text-2xl font-extrabold text-white mt-1">
                {{ $summary['saldo_formatted'] }}
            </div>
        </x-card>

        <x-card variant="default" title="Rasio Kelayakan Kas" subtitle="Cashflow Health Index">
            <div class="text-2xl font-bold text-emerald-600 mt-1">
                {{ $summary['cashflow_ratio'] }} <span class="text-xs font-normal text-slate-500">(Sehat)</span>
            </div>
        </x-card>

        <x-card variant="default" title="Total Pemasukan (Q3)" subtitle="Juli - September">
            <div class="text-2xl font-bold text-emerald-600 mt-1">
                Rp 21.500.000
            </div>
        </x-card>

        <x-card variant="default" title="Total Pengeluaran (Q3)" subtitle="Juli - September">
            <div class="text-2xl font-bold text-rose-600 mt-1">
                Rp 11.650.000
            </div>
        </x-card>
    </div>

    <!-- Monthly Financial Breakdown Table -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900">Rekapitulasi Keuangan Bulanan (2026)</h2>
            <span class="text-xs text-slate-500 font-medium">Satuan: Rupiah (IDR)</span>
        </div>

        <x-table :headers="['Bulan & Tahun', 'Total Pemasukan', 'Total Pengeluaran', 'Surplus / Defisit Bersih', 'Status Arus Kas']">
            @foreach ($monthlyReports as $row)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-6 py-4 font-bold text-slate-900 text-sm">
                        {{ $row['bulan'] }}
                    </td>

                    <td class="px-6 py-4 font-semibold text-emerald-600 text-sm">
                        + Rp {{ number_format($row['pemasukan'], 0, ',', '.') }}
                    </td>

                    <td class="px-6 py-4 font-semibold text-rose-600 text-sm">
                        - Rp {{ number_format($row['pengeluaran'], 0, ',', '.') }}
                    </td>

                    <td class="px-6 py-4 font-extrabold text-slate-900 text-sm">
                        Rp {{ number_format($row['saldo_bersih'], 0, ',', '.') }}
                    </td>

                    <td class="px-6 py-4">
                        <x-badge variant="success" dot="true" size="sm">
                            Surplus (+)
                        </x-badge>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>

    <!-- Category Breakdown Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Pemasukan Breakdown -->
        <div class="bg-white rounded-2xl border border-slate-200/80 card-shadow p-6">
            <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900">Rincian Sumber Pemasukan</h3>
                <x-badge variant="success" size="sm">Pemasukan</x-badge>
            </div>

            <div class="space-y-4">
                @foreach ($categoryBreakdown['pemasukan'] as $cat)
                    <div>
                        <div class="flex items-center justify-between text-xs font-semibold mb-1">
                            <span class="text-slate-700">{{ $cat['kategori'] }}</span>
                            <span class="text-emerald-700">Rp {{ number_format($cat['nominal'],0,',','.') }} ({{ $cat['persen'] }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="{{ $cat['color'] }} h-full rounded-full" style="width: {{ $cat['persen'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pengeluaran Breakdown -->
        <div class="bg-white rounded-2xl border border-slate-200/80 card-shadow p-6">
            <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900">Rincian Alokasi Pengeluaran</h3>
                <x-badge variant="danger" size="sm">Pengeluaran</x-badge>
            </div>

            <div class="space-y-4">
                @foreach ($categoryBreakdown['pengeluaran'] as $cat)
                    <div>
                        <div class="flex items-center justify-between text-xs font-semibold mb-1">
                            <span class="text-slate-700">{{ $cat['kategori'] }}</span>
                            <span class="text-rose-700">Rp {{ number_format($cat['nominal'],0,',','.') }} ({{ $cat['persen'] }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="{{ $cat['color'] }} h-full rounded-full" style="width: {{ $cat['persen'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
