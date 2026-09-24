@extends('layouts.app', ['title' => 'Kelola Pengeluaran KasFlow', 'role' => $role])

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Pengeluaran Kas</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Catat & verifikasi pengeluaran dana operasional, logistik, konsumsi, dan kegiatan organisasi.
            </p>
        </div>

        @if ($role === 'bendahara')
            <x-button
                variant="danger"
                size="md"
                onclick="openModal('modal-pengeluaran-page')"
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>'
            >
                Tambah Pengeluaran Baru
            </x-button>
        @endif
    </div>

    <!-- Summary KPI Cards for Pengeluaran -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-card variant="rose" title="Total Pengeluaran" subtitle="Akumulasi Seluruh Uang Keluar">
            <div class="text-2xl font-extrabold text-white mt-1">
                {{ $totalPengeluaranFormatted }}
            </div>
        </x-card>

        <x-card variant="default" title="Jumlah Transaksi Keluar" subtitle="Frekuensi Belanja Organisasi">
            <div class="text-2xl font-bold text-slate-900 mt-1">
                {{ $jumlahTransaksi }} <span class="text-xs text-slate-500 font-normal">Transaksi</span>
            </div>
        </x-card>

        <x-card variant="default" title="Kategori Biaya Terbesar" subtitle="Alokasi Dana Terbanyak">
            <div class="text-xl font-bold text-rose-600 mt-1">
                Logistik (35.4%)
            </div>
        </x-card>
    </div>

    <!-- Search & Filter Bar Component -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 card-shadow flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex-1 w-full md:w-auto flex flex-col sm:flex-row items-center gap-3">
            <div class="w-full sm:w-64">
                <x-input
                    name="search_pengeluaran"
                    placeholder="Cari judul / nota..."
                    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'
                />
            </div>

            <div class="w-full sm:w-48">
                <x-select
                    name="filter_kategori_pengeluaran"
                    placeholder="Semua Kategori"
                    :options="$kategoriList"
                />
            </div>
        </div>

        <div class="flex items-center gap-2 w-full md:w-auto justify-end">
            <x-button variant="outline" size="md" onclick="showToast('Filter diterapkan!')">
                Terapkan Filter
            </x-button>
        </div>
    </div>

    <!-- Pengeluaran Table -->
    <x-table :headers="['Kode & Transaksi', 'Kategori', 'Tanggal', 'Nominal Pengeluaran', 'Penanggung Jawab', 'Status Nota', 'Aksi']">
        @foreach ($pengeluaran as $item)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-xl bg-rose-100 text-rose-700 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block leading-snug">{{ $item['judul'] }}</span>
                            <span class="text-[11px] font-mono text-slate-400 block">{{ $item['kode'] }}</span>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4">
                    <x-badge variant="danger" size="sm">
                        {{ $item['kategori'] }}
                    </x-badge>
                </td>

                <td class="px-6 py-4 text-xs text-slate-600 font-medium">
                    {{ $item['tanggal_formatted'] }}
                </td>

                <td class="px-6 py-4 font-bold text-rose-600 text-sm">
                    - {{ $item['nominal_formatted'] }}
                </td>

                <td class="px-6 py-4 text-xs text-slate-600">
                    {{ $item['penanggung_jawab'] }}
                </td>

                <td class="px-6 py-4">
                    @if ($item['status'] === 'Terverifikasi')
                        <x-badge variant="success" dot="true" size="sm">Nota Valid</x-badge>
                    @else
                        <x-badge variant="warning" dot="true" size="sm">Perlu Nota</x-badge>
                    @endif
                </td>

                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <x-button variant="ghost" size="sm" onclick="openModal('modal-pengeluaran-detail-{{ $item['id'] }}')">
                            Detail
                        </x-button>

                        @if ($role === 'bendahara')
                            <button
                                type="button"
                                onclick="showToast('Simulasi Edit Pengeluaran {{ $item['kode'] }}', 'info')"
                                class="text-slate-400 hover:text-emerald-600 p-1 transition-colors cursor-pointer"
                                title="Edit"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                        @endif
                    </div>

                    <!-- Modal Detail -->
                    <x-modal id="modal-pengeluaran-detail-{{ $item['id'] }}" title="Detail Pengeluaran {{ $item['kode'] }}">
                        <div class="space-y-4 text-sm">
                            <div class="p-4 rounded-xl bg-rose-50 text-rose-900 border border-rose-100 flex justify-between items-center">
                                <div>
                                    <span class="text-xs font-semibold uppercase tracking-wider block opacity-75">Nominal Biaya Keluar</span>
                                    <span class="text-2xl font-extrabold">{{ $item['nominal_formatted'] }}</span>
                                </div>
                                <x-badge variant="danger" size="md">Pengeluaran Kas</x-badge>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-xs">
                                <div>
                                    <span class="text-slate-400 block font-medium">Keperluan Belanja</span>
                                    <span class="font-semibold text-slate-800 text-sm">{{ $item['judul'] }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-medium">Kategori Biaya</span>
                                    <span class="font-semibold text-slate-800 text-sm">{{ $item['kategori'] }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-medium">Tanggal Transaksi</span>
                                    <span class="font-semibold text-slate-800">{{ $item['tanggal_formatted'] }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-medium">Penanggung Jawab Sie</span>
                                    <span class="font-semibold text-slate-800">{{ $item['penanggung_jawab'] }}</span>
                                </div>
                            </div>

                            <div class="pt-2 border-t border-slate-100">
                                <span class="text-xs text-slate-400 block font-medium mb-1">Struk & Deskripsi</span>
                                <p class="text-xs text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-200/70">
                                    {{ $item['deskripsi'] }}
                                </p>
                            </div>
                        </div>

                        <x-slot name="actions">
                            <x-button variant="outline" size="sm" onclick="closeModal('modal-pengeluaran-detail-{{ $item['id'] }}')">
                                Tutup
                            </x-button>
                        </x-slot>
                    </x-modal>
                </td>
            </tr>
        @endforeach
    </x-table>

    <!-- Pagination -->
    <x-pagination currentPage="1" totalPages="2" totalItems="{{ $jumlahTransaksi }}" />

</div>

<!-- Modal Form Tambah Pengeluaran Page -->
<x-modal id="modal-pengeluaran-page" title="Tambah Record Pengeluaran Kas Baru" subtitle="Input data pengeluaran dana organisasi">
    <form onsubmit="event.preventDefault(); closeModal('modal-pengeluaran-page'); showToast('Pengeluaran baru berhasil disimpan!', 'info');" class="space-y-4">
        <x-input label="Judul Pengeluaran" name="judul" placeholder="Contoh: Bensin & Toll Relawan" required="true" />
        <div class="grid grid-cols-2 gap-4">
            <x-input label="Nominal (Rp)" name="nominal" type="number" placeholder="250000" required="true" />
            <x-select label="Kategori" name="kategori" :options="$kategoriList" required="true" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <x-input label="Tanggal" name="tanggal" type="date" value="{{ date('Y-m-d') }}" required="true" />
            <x-input label="Penanggung Jawab" name="penanggung_jawab" value="Ahmad Fauzi" required="true" />
        </div>
        <x-input label="Upload Struk Nota (Required)" name="bukti" type="file" required="true" />
        <div class="pt-2 border-t border-slate-100 flex items-center justify-end gap-3">
            <x-button variant="outline" size="md" onclick="closeModal('modal-pengeluaran-page')">Batal</x-button>
            <x-button variant="danger" size="md" type="submit">Simpan Pengeluaran</x-button>
        </div>
    </form>
</x-modal>
@endsection
