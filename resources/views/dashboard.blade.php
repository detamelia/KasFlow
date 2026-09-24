@extends('layouts.app', ['title' => 'Dashboard KasFlow', 'role' => $role])

@section('content')
<div class="space-y-6">

    <!-- Header Section with Welcome & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Ringkasan Keuangan Organisasi</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Pantau saldo, arus kas pemasukan & pengeluaran Himpunan Mahasiswa Informatika.
            </p>
        </div>

        <div class="flex items-center gap-2">
            @if ($role === 'bendahara')
                <x-button
                    variant="primary"
                    size="md"
                    onclick="openModal('modal-tambah-pemasukan')"
                    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>'
                >
                    + Pemasukan
                </x-button>

                <x-button
                    variant="danger"
                    size="md"
                    onclick="openModal('modal-tambah-pengeluaran')"
                    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>'
                >
                    + Pengeluaran
                </x-button>
            @else
                <x-button
                    variant="outline"
                    size="md"
                    onclick="showToast('Laporan Keuangan sedang disiapkan untuk diunduh.', 'info')"
                    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>'
                >
                    Unduh Ringkasan (PDF)
                </x-button>
            @endif
        </div>
    </div>

    <!-- 4 Key Financial Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Saldo Utama -->
        <x-card
            variant="emerald"
            title="Total Saldo Utama"
            subtitle="Kas Organisasi Terkini"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>'
        >
            <div class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white mt-1">
                {{ $summary['saldo_formatted'] }}
            </div>
            <p class="text-xs text-emerald-100/90 mt-2 font-medium">
                Status Kas Sesuai & Safe Margin
            </p>
        </x-card>

        <!-- Pemasukan Bulan Ini -->
        <x-card
            variant="default"
            title="Pemasukan Bulan Ini"
            subtitle="September 2026"
            trend="+14.8%"
            trendType="up"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>'
        >
            <div class="text-2xl font-bold tracking-tight text-emerald-600">
                {{ $summary['pemasukan_formatted'] }}
            </div>
        </x-card>

        <!-- Pengeluaran Bulan Ini -->
        <x-card
            variant="default"
            title="Pengeluaran Bulan Ini"
            subtitle="September 2026"
            trend="-5.2%"
            trendType="down"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>'
        >
            <div class="text-2xl font-bold tracking-tight text-rose-600">
                {{ $summary['pengeluaran_formatted'] }}
            </div>
        </x-card>

        <!-- Total Transaksi & Status -->
        <x-card
            variant="default"
            title="Total Transaksi"
            subtitle="Pemasukan & Pengeluaran"
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>'
        >
            <div class="flex items-center justify-between">
                <div class="text-2xl font-bold tracking-tight text-slate-900">
                    {{ $summary['total_transaksi'] }} <span class="text-xs font-medium text-slate-500">Record</span>
                </div>
                <x-badge variant="warning" dot="true" size="sm">
                    {{ $summary['transaksi_pending'] }} Pending
                </x-badge>
            </div>
        </x-card>
    </div>

    <!-- Charts & Category Distribution Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Cashflow Chart Visual -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 card-shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Grafik Arus Kas 5 Bulan Terakhir</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Perbandingan Pemasukan (Hijau) & Pengeluaran (Merah)</p>
                </div>
                <div class="flex items-center gap-3 text-xs font-semibold">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-emerald-500"></span> Pemasukan</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-rose-500"></span> Pengeluaran</span>
                </div>
            </div>

            <!-- Custom Clean SVG/CSS Bar Chart -->
            <div class="h-60 flex items-end justify-between gap-4 pt-4 px-2 border-b border-slate-100">
                @foreach ($monthlyReports as $item)
                    @php
                        $maxVal = 10000000;
                        $pemasukanHeight = min(100, max(15, ($item['pemasukan'] / $maxVal) * 100));
                        $pengeluaranHeight = min(100, max(15, ($item['pengeluaran'] / $maxVal) * 100));
                    @endphp
                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                        <div class="w-full flex justify-center items-end gap-1.5 h-48">
                            <!-- Pemasukan Bar -->
                            <div
                                style="height: {{ $pemasukanHeight }}%"
                                class="w-4 sm:w-6 bg-emerald-500 rounded-t-lg transition-all duration-300 group-hover:bg-emerald-600 relative"
                                title="Pemasukan {{ $item['bulan'] }}: Rp {{ number_format($item['pemasukan'],0,',','.') }}"
                            ></div>
                            <!-- Pengeluaran Bar -->
                            <div
                                style="height: {{ $pengeluaranHeight }}%"
                                class="w-4 sm:w-6 bg-rose-400 rounded-t-lg transition-all duration-300 group-hover:bg-rose-500 relative"
                                title="Pengeluaran {{ $item['bulan'] }}: Rp {{ number_format($item['pengeluaran'],0,',','.') }}"
                            ></div>
                        </div>
                        <span class="text-[11px] font-medium text-slate-500 group-hover:text-slate-900 transition-colors">
                            {{ explode(' ', $item['bulan'])[0] }}
                        </span>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
                <span>Rata-rata Surplus Bersih: <strong class="text-emerald-700">Rp 2.650.000 / Bulan</strong></span>
                <a href="{{ route('laporan.index', ['role' => $role]) }}" class="text-emerald-600 hover:text-emerald-700 font-semibold">Lihat Analisis Detail &rarr;</a>
            </div>
        </div>

        <!-- Category Distribution Progress Widget -->
        <div class="bg-white rounded-2xl border border-slate-200/80 card-shadow p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900 mb-1">Proporsi Pengeluaran</h3>
                <p class="text-xs text-slate-500 mb-5">Distribusi pengeluaran berdasarkan kategori bulan ini</p>

                <div class="space-y-4">
                    @foreach ($categoryBreakdown['pengeluaran'] as $cat)
                        <div>
                            <div class="flex items-center justify-between text-xs font-semibold mb-1">
                                <span class="text-slate-700">{{ $cat['kategori'] }}</span>
                                <span class="text-slate-900">Rp {{ number_format($cat['nominal'],0,',','.') }} ({{ $cat['persen'] }}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="{{ $cat['color'] }} h-full rounded-full" style="width: {{ $cat['persen'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100">
                <div class="bg-emerald-50 rounded-xl p-3 border border-emerald-100 flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs text-emerald-800">
                        Pengeluaran dominan: <strong class="font-bold">Logistik (35.4%)</strong> untuk perlengkapan event.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table Section -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Transaksi Terbaru</h2>
                <p class="text-xs text-slate-500">Daftar transaksi kas organisasi yang tercatat paling akhir</p>
            </div>

            <a
                href="{{ route('transaksi.index', ['role' => $role]) }}"
                class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1"
            >
                Lihat Semua Transaksi
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <x-table :headers="['Kode & Transaksi', 'Kategori', 'Tanggal', 'Nominal', 'Status', 'Penanggung Jawab', 'Aksi']">
            @foreach ($transactions as $t)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-xl {{ $t['jenis'] === 'pemasukan' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} shrink-0">
                                @if ($t['jenis'] === 'pemasukan')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                                @endif
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block leading-snug">{{ $t['judul'] }}</span>
                                <span class="text-[11px] font-mono text-slate-400 block">{{ $t['kode'] }}</span>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <x-badge variant="neutral" size="sm">
                            {{ $t['kategori'] }}
                        </x-badge>
                    </td>

                    <td class="px-6 py-4 text-xs font-medium text-slate-600">
                        {{ $t['tanggal_formatted'] }}
                    </td>

                    <td class="px-6 py-4 font-bold text-sm {{ $t['jenis'] === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ $t['jenis'] === 'pemasukan' ? '+' : '-' }} {{ $t['nominal_formatted'] }}
                    </td>

                    <td class="px-6 py-4">
                        @if ($t['status'] === 'Terverifikasi')
                            <x-badge variant="success" dot="true" size="sm">Terverifikasi</x-badge>
                        @elseif ($t['status'] === 'Pending')
                            <x-badge variant="warning" dot="true" size="sm">Pending</x-badge>
                        @else
                            <x-badge variant="danger" dot="true" size="sm">Ditolak</x-badge>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-xs text-slate-600">
                        {{ $t['penanggung_jawab'] }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <x-button
                                variant="ghost"
                                size="sm"
                                onclick="openModal('modal-detail-{{ $t['id'] }}')"
                                title="Lihat Detail Transaksi"
                            >
                                Detail
                            </x-button>

                            @if ($role === 'bendahara')
                                <button
                                    type="button"
                                    onclick="openModal('modal-edit-{{ $t['id'] }}')"
                                    class="text-slate-400 hover:text-emerald-600 p-1 transition-colors cursor-pointer"
                                    title="Edit Transaksi"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                            @endif
                        </div>

                        <!-- Modal Detail Transaksi -->
                        <x-modal id="modal-detail-{{ $t['id'] }}" title="Rincian Transaksi {{ $t['kode'] }}">
                            <div class="space-y-4 text-sm">
                                <div class="p-4 rounded-xl {{ $t['jenis'] === 'pemasukan' ? 'bg-emerald-50 text-emerald-900 border border-emerald-100' : 'bg-rose-50 text-rose-900 border border-rose-100' }} flex justify-between items-center">
                                    <div>
                                        <span class="text-xs font-semibold uppercase tracking-wider block opacity-75">Nominal {{ ucfirst($t['jenis']) }}</span>
                                        <span class="text-2xl font-extrabold">{{ $t['nominal_formatted'] }}</span>
                                    </div>
                                    <x-badge variant="{{ $t['jenis'] === 'pemasukan' ? 'success' : 'danger' }}" size="md">
                                        {{ ucfirst($t['jenis']) }}
                                    </x-badge>
                                </div>

                                <div class="grid grid-cols-2 gap-4 text-xs">
                                    <div>
                                        <span class="text-slate-400 block font-medium">Judul Transaksi</span>
                                        <span class="font-semibold text-slate-800 text-sm">{{ $t['judul'] }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block font-medium">Kategori</span>
                                        <span class="font-semibold text-slate-800 text-sm">{{ $t['kategori'] }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block font-medium">Tanggal Pencatatan</span>
                                        <span class="font-semibold text-slate-800">{{ $t['tanggal_formatted'] }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block font-medium">Penanggung Jawab</span>
                                        <span class="font-semibold text-slate-800">{{ $t['penanggung_jawab'] }}</span>
                                    </div>
                                </div>

                                <div class="pt-2 border-t border-slate-100">
                                    <span class="text-xs text-slate-400 block font-medium mb-1">Deskripsi & Catatan</span>
                                    <p class="text-xs text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-200/70 leading-relaxed">
                                        {{ $t['deskripsi'] }}
                                    </p>
                                </div>

                                <div>
                                    <span class="text-xs text-slate-400 block font-medium mb-1">Bukti Transfer / Nota Struk</span>
                                    <div class="p-3 bg-slate-100 rounded-xl border border-slate-200 flex items-center justify-between text-xs">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                            <span class="font-medium text-slate-700">{{ $t['bukti'] }}</span>
                                        </div>
                                        <x-button variant="outline" size="sm" onclick="showToast('Membuka file bukti {{ $t['bukti'] }}')">
                                            Lihat File
                                        </x-button>
                                    </div>
                                </div>
                            </div>

                            <x-slot name="actions">
                                <x-button variant="outline" size="sm" onclick="closeModal('modal-detail-{{ $t['id'] }}')">
                                    Tutup
                                </x-button>
                            </x-slot>
                        </x-modal>

                        <!-- Modal Edit Transaksi (Komponen Edit Real) -->
                        <x-modal id="modal-edit-{{ $t['id'] }}" title="Edit Transaksi {{ $t['kode'] }}" subtitle="Ubah rincian pencatatan data transaksi">
                            <form onsubmit="event.preventDefault(); closeModal('modal-edit-{{ $t['id'] }}'); showToast('Perubahan transaksi {{ $t['kode'] }} berhasil disimpan!');" class="space-y-4">
                                <x-input
                                    label="Judul Transaksi"
                                    name="judul"
                                    value="{{ $t['judul'] }}"
                                    required="true"
                                />

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <x-input
                                        label="Nominal (Rp)"
                                        name="nominal"
                                        type="number"
                                        value="{{ $t['nominal'] }}"
                                        required="true"
                                    />

                                    <x-select
                                        label="Kategori"
                                        name="kategori"
                                        selected="{{ $t['kategori'] }}"
                                        :options="$t['jenis'] === 'pemasukan' ? ['Uang Kas', 'Sponsorship', 'Dana Hibah', 'Donasi', 'Pendaftaran Event', 'Lain-lain'] : ['Operasional', 'Logistik', 'Konsumsi', 'Transportasi', 'Acara/Event', 'Perlengkapan', 'Lain-lain']"
                                        required="true"
                                    />
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <x-input
                                        label="Tanggal Transaksi"
                                        name="tanggal"
                                        type="date"
                                        value="{{ $t['tanggal'] }}"
                                        required="true"
                                    />

                                    <x-input
                                        label="Penanggung Jawab"
                                        name="penanggung_jawab"
                                        value="{{ $t['penanggung_jawab'] }}"
                                        required="true"
                                    />
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi / Catatan</label>
                                    <textarea
                                        name="deskripsi"
                                        rows="3"
                                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                                    >{{ $t['deskripsi'] }}</textarea>
                                </div>

                                <x-input
                                    label="Perbarui File Bukti / Nota"
                                    name="bukti"
                                    type="file"
                                    helper="Biarkan kosong jika tidak ingin mengubah file bukti"
                                />

                                <div class="pt-2 border-t border-slate-100 flex items-center justify-end gap-3">
                                    <x-button variant="outline" size="md" onclick="closeModal('modal-edit-{{ $t['id'] }}')">
                                        Batal
                                    </x-button>
                                    <x-button variant="primary" size="md" type="submit">
                                        Simpan Perubahan
                                    </x-button>
                                </div>
                            </form>
                        </x-modal>
                    </td>
                </tr>
            @endforeach
        </x-table>
    </div>

</div>

<!-- Modal Modul Tambah Pemasukan -->
<x-modal id="modal-tambah-pemasukan" title="Tambah Record Pemasukan Kas Baru" subtitle="Input data pemasukan uang kas organisasi">
    <form id="form-pemasukan" onsubmit="event.preventDefault(); closeModal('modal-tambah-pemasukan'); showToast('Pemasukan baru berhasil dicatat!');" class="space-y-4">
        <x-input
            label="Judul Pemasukan"
            name="judul"
            placeholder="Contoh: Iuran Anggota Oktober 2026 / Sponsor..."
            required="true"
        />

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input
                label="Nominal Pemasukan (Rp)"
                name="nominal"
                type="number"
                placeholder="500000"
                required="true"
            />

            <x-select
                label="Kategori Pemasukan"
                name="kategori"
                :options="['Uang Kas', 'Sponsorship', 'Dana Hibah', 'Donasi', 'Pendaftaran Event', 'Lain-lain']"
                required="true"
            />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input
                label="Tanggal Pemasukan"
                name="tanggal"
                type="date"
                value="{{ date('Y-m-d') }}"
                required="true"
            />

            <x-input
                label="Penanggung Jawab"
                name="penanggung_jawab"
                value="Siti Rahma (Bendahara 1)"
                required="true"
            />
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi / Keterangan</label>
            <textarea
                name="deskripsi"
                rows="3"
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                placeholder="Rincian asal dana pemasukan..."
            ></textarea>
        </div>

        <x-input
            label="Upload Bukti Transfer / Kwitansi (PDF/Image)"
            name="bukti"
            type="file"
            helper="Format didukung: JPG, PNG, PDF max 5MB"
        />

        <div class="pt-2 border-t border-slate-100 flex items-center justify-end gap-3">
            <x-button variant="outline" size="md" onclick="closeModal('modal-tambah-pemasukan')">
                Batal
            </x-button>
            <x-button variant="primary" size="md" type="submit">
                Simpan Pemasukan
            </x-button>
        </div>
    </form>
</x-modal>

<!-- Modal Modul Tambah Pengeluaran -->
<x-modal id="modal-tambah-pengeluaran" title="Tambah Record Pengeluaran Kas Baru" subtitle="Input data pengeluaran dana organisasi">
    <form id="form-pengeluaran" onsubmit="event.preventDefault(); closeModal('modal-tambah-pengeluaran'); showToast('Pengeluaran baru berhasil dicatat!', 'info');" class="space-y-4">
        <x-input
            label="Judul Pengeluaran"
            name="judul"
            placeholder="Contoh: Pembelian Banner / Konsumsi Rapat..."
            required="true"
        />

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input
                label="Nominal Pengeluaran (Rp)"
                name="nominal"
                type="number"
                placeholder="150000"
                required="true"
            />

            <x-select
                label="Kategori Pengeluaran"
                name="kategori"
                :options="['Operasional', 'Logistik', 'Konsumsi', 'Transportasi', 'Acara/Event', 'Perlengkapan', 'Lain-lain']"
                required="true"
            />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input
                label="Tanggal Pengeluaran"
                name="tanggal"
                type="date"
                value="{{ date('Y-m-d') }}"
                required="true"
            />

            <x-input
                label="Penanggung Jawab"
                name="penanggung_jawab"
                value="Ahmad Fauzi (Sie Divisi Acara)"
                required="true"
            />
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi / Rincian Pengeluaran</label>
            <textarea
                name="deskripsi"
                rows="3"
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 focus:border-rose-500 focus:ring-2 focus:ring-rose-500 focus:outline-none"
                placeholder="Detail keperluan pengeluaran dana..."
            ></textarea>
        </div>

        <x-input
            label="Upload Struk / Nota Pembelian"
            name="bukti"
            type="file"
            required="true"
            helper="Wajib menyertakan bukti fisik nota untuk audit Bendahara"
        />

        <div class="pt-2 border-t border-slate-100 flex items-center justify-end gap-3">
            <x-button variant="outline" size="md" onclick="closeModal('modal-tambah-pengeluaran')">
                Batal
            </x-button>
            <x-button variant="danger" size="md" type="submit">
                Simpan Pengeluaran
            </x-button>
        </div>
    </form>
</x-modal>
@endsection
