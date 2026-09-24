@extends('layouts.app', ['title' => 'Riwayat Transaksi KasFlow', 'role' => $role])

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Riwayat Master Transaksi</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Semua rekam jejak arus kas masuk & keluar organisasi secara menyeluruh.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <x-button variant="outline" size="sm" onclick="showToast('Mencetak daftar transaksi dummy...', 'info')">
                Export Excel / CSV
            </x-button>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 card-shadow flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Tabs Filter -->
        <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200/80 w-full md:w-auto">
            <a
                href="{{ route('transaksi.index', ['role' => $role, 'jenis' => 'semua']) }}"
                class="flex-1 md:flex-none text-center px-4 py-2 text-xs font-semibold rounded-lg transition-all {{ $jenisFilter === 'semua' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}"
            >
                Semua Transaksi
            </a>
            <a
                href="{{ route('transaksi.index', ['role' => $role, 'jenis' => 'pemasukan']) }}"
                class="flex-1 md:flex-none text-center px-4 py-2 text-xs font-semibold rounded-lg transition-all {{ $jenisFilter === 'pemasukan' ? 'bg-white text-emerald-700 shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}"
            >
                Pemasukan (+)
            </a>
            <a
                href="{{ route('transaksi.index', ['role' => $role, 'jenis' => 'pengeluaran']) }}"
                class="flex-1 md:flex-none text-center px-4 py-2 text-xs font-semibold rounded-lg transition-all {{ $jenisFilter === 'pengeluaran' ? 'bg-white text-rose-700 shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}"
            >
                Pengeluaran (-)
            </a>
        </div>

        <!-- Search Box -->
        <form action="{{ route('transaksi.index') }}" method="GET" class="w-full md:w-72 flex gap-2">
            <input type="hidden" name="role" value="{{ $role }}">
            <input type="hidden" name="jenis" value="{{ $jenisFilter }}">
            
            <x-input
                name="search"
                value="{{ $search }}"
                placeholder="Cari transaksi..."
                icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'
            />

            <x-button type="submit" variant="secondary" size="md">Cari</x-button>
        </form>
    </div>

    <!-- Master Transactions Table -->
    <x-table :headers="['Kode & Jenis', 'Judul Transaksi', 'Kategori', 'Tanggal', 'Nominal', 'Status', 'Aksi']">
        @foreach ($transactions as $t)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2.5">
                        <div class="p-2 rounded-xl {{ $t['jenis'] === 'pemasukan' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} shrink-0">
                            @if ($t['jenis'] === 'pemasukan')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                            @endif
                        </div>
                        <div>
                            <span class="font-mono text-xs font-bold text-slate-800 block">{{ $t['kode'] }}</span>
                            <span class="text-[10px] uppercase tracking-wider font-semibold {{ $t['jenis'] === 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $t['jenis'] }}
                            </span>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4 font-semibold text-slate-900 text-xs sm:text-sm">
                    {{ $t['judul'] }}
                </td>

                <td class="px-6 py-4">
                    <x-badge variant="{{ $t['jenis'] === 'pemasukan' ? 'success' : 'danger' }}" size="sm">
                        {{ $t['kategori'] }}
                    </x-badge>
                </td>

                <td class="px-6 py-4 text-xs text-slate-600 font-medium">
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

                <td class="px-6 py-4">
                    <x-button variant="ghost" size="sm" onclick="openModal('modal-trx-master-{{ $t['id'] }}')">
                        Detail
                    </x-button>

                    <!-- Modal Detail -->
                    <x-modal id="modal-trx-master-{{ $t['id'] }}" title="Rincian Transaksi {{ $t['kode'] }}">
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
                                    <span class="text-slate-400 block font-medium">Tanggal Tanggal</span>
                                    <span class="font-semibold text-slate-800">{{ $t['tanggal_formatted'] }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-medium">Penanggung Jawab</span>
                                    <span class="font-semibold text-slate-800">{{ $t['penanggung_jawab'] }}</span>
                                </div>
                            </div>

                            <div class="pt-2 border-t border-slate-100">
                                <span class="text-xs text-slate-400 block font-medium mb-1">Catatan Deskripsi</span>
                                <p class="text-xs text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-200/70">
                                    {{ $t['deskripsi'] }}
                                </p>
                            </div>
                        </div>

                        <x-slot name="actions">
                            <x-button variant="outline" size="sm" onclick="closeModal('modal-trx-master-{{ $t['id'] }}')">
                                Tutup
                            </x-button>
                        </x-slot>
                    </x-modal>
                </td>
            </tr>
        @endforeach
    </x-table>

    <!-- Pagination -->
    <x-pagination currentPage="1" totalPages="3" totalItems="{{ $totalItems }}" />

</div>
@endsection
