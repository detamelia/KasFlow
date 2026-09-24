@extends('layouts.app', ['title' => 'Kelola Pemasukan KasFlow', 'role' => $role])

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Pemasukan Kas</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kelola pencatatan uang kas masuk, sponsorship, hibah, dan sumber dana organisasi.
            </p>
        </div>

        @if ($role === 'bendahara')
            <x-button
                variant="primary"
                size="md"
                onclick="openModal('modal-pemasukan-page')"
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>'
            >
                Tambah Pemasukan Baru
            </x-button>
        @endif
    </div>

    <!-- Summary KPI Cards for Pemasukan -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-card variant="emerald" title="Total Pemasukan" subtitle="Akumulasi Seluruh Uang Masuk">
            <div class="text-2xl font-extrabold text-white mt-1">
                {{ $totalPemasukanFormatted }}
            </div>
        </x-card>

        <x-card variant="default" title="Jumlah Transaksi Pemasukan" subtitle="Frekuensi Pencatatan">
            <div class="text-2xl font-bold text-slate-900 mt-1">
                {{ $jumlahTransaksi }} <span class="text-xs text-slate-500 font-normal">Transaksi</span>
            </div>
        </x-card>

        <x-card variant="default" title="Sumber Pemasukan Utama" subtitle="Kategori Dominan">
            <div class="text-xl font-bold text-emerald-600 mt-1">
                Sponsorship & Kas
            </div>
        </x-card>
    </div>

    <!-- Search & Filter Bar Component -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 card-shadow flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex-1 w-full md:w-auto flex flex-col sm:flex-row items-center gap-3">
            <div class="w-full sm:w-64">
                <x-input
                    name="search_pemasukan"
                    placeholder="Cari judul / kode..."
                    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'
                />
            </div>

            <div class="w-full sm:w-48">
                <x-select
                    name="filter_kategori"
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

    <!-- Pemasukan Table -->
    <x-table :headers="['Kode & Transaksi', 'Kategori', 'Tanggal', 'Nominal Pemasukan', 'Penanggung Jawab', 'Status', 'Aksi']">
        @foreach ($pemasukan as $item)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-xl bg-emerald-100 text-emerald-700 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block leading-snug">{{ $item['judul'] }}</span>
                            <span class="text-[11px] font-mono text-slate-400 block">{{ $item['kode'] }}</span>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4">
                    <x-badge variant="success" size="sm">
                        {{ $item['kategori'] }}
                    </x-badge>
                </td>

                <td class="px-6 py-4 text-xs text-slate-600 font-medium">
                    {{ $item['tanggal_formatted'] }}
                </td>

                <td class="px-6 py-4 font-bold text-emerald-600 text-sm">
                    + {{ $item['nominal_formatted'] }}
                </td>

                <td class="px-6 py-4 text-xs text-slate-600">
                    {{ $item['penanggung_jawab'] }}
                </td>

                <td class="px-6 py-4">
                    <x-badge variant="success" dot="true" size="sm">
                        {{ $item['status'] }}
                    </x-badge>
                </td>

                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <x-button variant="ghost" size="sm" onclick="openModal('modal-pemasukan-detail-{{ $item['id'] }}')">
                            Detail
                        </x-button>

                        @if ($role === 'bendahara')
                            <button
                                type="button"
                                onclick="openModal('modal-pemasukan-edit-{{ $item['id'] }}')"
                                class="text-slate-400 hover:text-emerald-600 p-1 transition-colors cursor-pointer"
                                title="Edit Pemasukan"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>

                            <button
                                type="button"
                                onclick="showToast('Hapus pemasukan {{ $item['kode'] }}')"
                                class="text-slate-400 hover:text-rose-600 p-1 transition-colors cursor-pointer"
                                title="Hapus"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        @endif
                    </div>

                    <!-- Modal Detail -->
                    <x-modal id="modal-pemasukan-detail-{{ $item['id'] }}" title="Detail Pemasukan {{ $item['kode'] }}">
                        <div class="space-y-4 text-sm">
                            <div class="p-4 rounded-xl bg-emerald-50 text-emerald-900 border border-emerald-100 flex justify-between items-center">
                                <div>
                                    <span class="text-xs font-semibold uppercase tracking-wider block opacity-75">Nominal Uang Masuk</span>
                                    <span class="text-2xl font-extrabold">{{ $item['nominal_formatted'] }}</span>
                                </div>
                                <x-badge variant="success" size="md">Pemasukan Kas</x-badge>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-xs">
                                <div>
                                    <span class="text-slate-400 block font-medium">Judul Pemasukan</span>
                                    <span class="font-semibold text-slate-800 text-sm">{{ $item['judul'] }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-medium">Kategori Dana</span>
                                    <span class="font-semibold text-slate-800 text-sm">{{ $item['kategori'] }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-medium">Tanggal Masuk</span>
                                    <span class="font-semibold text-slate-800">{{ $item['tanggal_formatted'] }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-medium">Pencatat (Bendahara)</span>
                                    <span class="font-semibold text-slate-800">{{ $item['penanggung_jawab'] }}</span>
                                </div>
                            </div>

                            <div class="pt-2 border-t border-slate-100">
                                <span class="text-xs text-slate-400 block font-medium mb-1">Catatan Tambahan</span>
                                <p class="text-xs text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-200/70">
                                    {{ $item['deskripsi'] }}
                                </p>
                            </div>
                        </div>

                        <x-slot name="actions">
                            <x-button variant="outline" size="sm" onclick="closeModal('modal-pemasukan-detail-{{ $item['id'] }}')">
                                Tutup
                            </x-button>
                        </x-slot>
                    </x-modal>

                    <!-- Modal Edit Pemasukan Real -->
                    <x-modal id="modal-pemasukan-edit-{{ $item['id'] }}" title="Edit Pemasukan {{ $item['kode'] }}" subtitle="Ubah rincian pemasukan kas">
                        <form onsubmit="event.preventDefault(); closeModal('modal-pemasukan-edit-{{ $item['id'] }}'); showToast('Pemasukan {{ $item['kode'] }} berhasil diperbarui!');" class="space-y-4">
                            <x-input label="Judul Pemasukan" name="judul" value="{{ $item['judul'] }}" required="true" />
                            <div class="grid grid-cols-2 gap-4">
                                <x-input label="Nominal (Rp)" name="nominal" type="number" value="{{ $item['nominal'] }}" required="true" />
                                <x-select label="Kategori" name="kategori" selected="{{ $item['kategori'] }}" :options="$kategoriList" required="true" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <x-input label="Tanggal" name="tanggal" type="date" value="{{ $item['tanggal'] }}" required="true" />
                                <x-input label="Penanggung Jawab" name="penanggung_jawab" value="{{ $item['penanggung_jawab'] }}" required="true" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi / Catatan</label>
                                <textarea name="deskripsi" rows="3" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ $item['deskripsi'] }}</textarea>
                            </div>
                            <x-input label="Upload Ulang Bukti Transfer" name="bukti" type="file" />
                            <div class="pt-2 border-t border-slate-100 flex items-center justify-end gap-3">
                                <x-button variant="outline" size="md" onclick="closeModal('modal-pemasukan-edit-{{ $item['id'] }}')">Batal</x-button>
                                <x-button variant="primary" size="md" type="submit">Simpan Perubahan</x-button>
                            </div>
                        </form>
                    </x-modal>
                </td>
            </tr>
        @endforeach
    </x-table>

    <!-- Pagination -->
    <x-pagination currentPage="1" totalPages="2" totalItems="{{ $jumlahTransaksi }}" />

</div>

<!-- Modal Form Tambah Pemasukan Page -->
<x-modal id="modal-pemasukan-page" title="Tambah Record Pemasukan Kas Baru" subtitle="Input data pemasukan uang kas organisasi">
    <form onsubmit="event.preventDefault(); closeModal('modal-pemasukan-page'); showToast('Pemasukan baru berhasil disimpan!');" class="space-y-4">
        <x-input label="Judul Pemasukan" name="judul" placeholder="Contoh: Sponsor Acara X" required="true" />
        <div class="grid grid-cols-2 gap-4">
            <x-input label="Nominal (Rp)" name="nominal" type="number" placeholder="1000000" required="true" />
            <x-select label="Kategori" name="kategori" :options="$kategoriList" required="true" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <x-input label="Tanggal" name="tanggal" type="date" value="{{ date('Y-m-d') }}" required="true" />
            <x-input label="Penanggung Jawab" name="penanggung_jawab" value="Siti Rahma" required="true" />
        </div>
        <x-input label="Bukti Transfer (PDF/Image)" name="bukti" type="file" />
        <div class="pt-2 border-t border-slate-100 flex items-center justify-end gap-3">
            <x-button variant="outline" size="md" onclick="closeModal('modal-pemasukan-page')">Batal</x-button>
            <x-button variant="primary" size="md" type="submit">Simpan Pemasukan</x-button>
        </div>
    </form>
</x-modal>
@endsection
