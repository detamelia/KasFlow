@extends('layouts.app', ['title' => 'Manajemen Kategori KasFlow', 'role' => $role])

@section('content')
<div class="space-y-6">

    <!-- Flash Messages / Notifikasi -->
    @if (session('success'))
        <x-alert type="success" title="Berhasil" class="mb-4">
            {{ session('success') }}
        </x-alert>
    @endif

    @if (session('error'))
        <x-alert type="danger" title="Perhatian" class="mb-4">
            {{ session('error') }}
        </x-alert>
    @endif

    @if ($errors->any())
        <x-alert type="danger" title="Validasi Gagal" class="mb-4">
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Kategori</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kelola klasifikasi pos transaksi pemasukan dan pengeluaran kas organisasi.
            </p>
        </div>

        @if ($role === 'bendahara')
            <div class="flex items-center gap-2">
                <x-button
                    variant="primary"
                    size="md"
                    onclick="openModal('modal-tambah-kategori')"
                    icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>'
                >
                    + Tambah Kategori
                </x-button>
            </div>
        @endif
    </div>

    <!-- Summary KPI Cards for Kategori -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-card variant="default" title="Total Kategori" subtitle="Klasifikasi Terdaftar">
            <div class="text-2xl font-extrabold text-slate-900 mt-1 flex items-baseline gap-2">
                {{ $totalKategori }}
                <span class="text-xs text-slate-500 font-normal">Kategori</span>
            </div>
        </x-card>

        <x-card variant="emerald" title="Kategori Pemasukan" subtitle="Pos Penerimaan Kas">
            <div class="text-2xl font-extrabold text-white mt-1 flex items-baseline gap-2">
                {{ $totalPemasukan }}
                <span class="text-xs text-emerald-100 font-normal">Pos Aktif</span>
            </div>
        </x-card>

        <x-card variant="rose" title="Kategori Pengeluaran" subtitle="Pos Belanja Organisasi">
            <div class="text-2xl font-extrabold text-white mt-1 flex items-baseline gap-2">
                {{ $totalPengeluaran }}
                <span class="text-xs text-rose-100 font-normal">Pos Aktif</span>
            </div>
        </x-card>

        <x-card variant="default" title="Transaksi Terhubung" subtitle="Akumulasi Catatan Kas">
            <div class="text-2xl font-bold text-slate-900 mt-1 flex items-baseline gap-2">
                {{ $totalTransaksi }}
                <span class="text-xs text-slate-500 font-normal">Transaksi</span>
            </div>
        </x-card>
    </div>

    <!-- Search & Filter Bar Component -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 card-shadow">
        <form method="GET" action="{{ route('kategori.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-4">
            <input type="hidden" name="role" value="{{ $role }}">

            <div class="flex-1 w-full md:w-auto flex flex-col sm:flex-row items-center gap-3">
                <!-- Search Input -->
                <div class="w-full sm:w-72">
                    <x-input
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari nama kategori..."
                        icon='<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'
                    />
                </div>

                <!-- Jenis Filter Dropdown -->
                <div class="w-full sm:w-56">
                    <x-select
                        name="jenis"
                        placeholder="Semua Jenis Kategori"
                        :selected="$jenisFilter"
                        :options="[
                            'semua' => 'Semua Jenis',
                            'pemasukan' => 'Pemasukan (+)',
                            'pengeluaran' => 'Pengeluaran (-)'
                        ]"
                    />
                </div>
            </div>

            <!-- Action Buttons for Filter -->
            <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                @if (!empty($search) || ($jenisFilter !== 'semua' && !empty($jenisFilter)))
                    <x-button
                        variant="ghost"
                        size="md"
                        href="{{ route('kategori.index', ['role' => $role]) }}"
                    >
                        Reset
                    </x-button>
                @endif

                <x-button variant="outline" size="md" type="submit">
                    Terapkan Filter
                </x-button>
            </div>
        </form>
    </div>

    <!-- Category Table Component -->
    <x-table :headers="['Nama Kategori', 'Jenis', 'Dibuat', 'Diperbarui', 'Aksi']" emptyText="Belum ada data kategori yang cocok atau terdaftar.">
        @forelse ($kategoriList as $item)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <!-- 1. Nama Kategori -->
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-xl {{ $item->jenis === 'pemasukan' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} shrink-0">
                            @if ($item->jenis === 'pemasukan')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                            @endif
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block leading-snug">{{ $item->nama_kategori }}</span>
                            <span class="text-[11px] text-slate-400 font-medium">
                                {{ $item->transaksi_count }} transaksi terhubung
                            </span>
                        </div>
                    </div>
                </td>

                <!-- 2. Jenis (Badge Pemasukan / Pengeluaran) -->
                <td class="px-6 py-4">
                    @if ($item->jenis === 'pemasukan')
                        <x-badge variant="success" dot="true" size="sm">
                            Pemasukan
                        </x-badge>
                    @else
                        <x-badge variant="danger" dot="true" size="sm">
                            Pengeluaran
                        </x-badge>
                    @endif
                </td>

                <!-- 3. Dibuat -->
                <td class="px-6 py-4 text-xs text-slate-600 font-medium">
                    {{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}
                </td>

                <!-- 4. Diperbarui -->
                <td class="px-6 py-4 text-xs text-slate-600 font-medium">
                    {{ $item->updated_at ? $item->updated_at->format('d M Y, H:i') : '-' }}
                </td>

                <!-- 5. Aksi -->
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        @if ($role === 'bendahara')
                            <!-- Tombol Edit -->
                            <button
                                type="button"
                                onclick="openModal('modal-edit-kategori-{{ $item->id }}')"
                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 transition-colors cursor-pointer"
                                title="Edit Kategori"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                <span>Edit</span>
                            </button>

                            <!-- Tombol Hapus -->
                            <button
                                type="button"
                                onclick="openModal('modal-delete-kategori-{{ $item->id }}')"
                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-rose-50 hover:text-rose-700 transition-colors cursor-pointer"
                                title="Hapus Kategori"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Hapus</span>
                            </button>
                        @else
                            <span class="text-xs text-slate-400 italic">Hanya Baca</span>
                        @endif
                    </div>

                    @if ($role === 'bendahara')
                        <!-- Modal Edit Kategori -->
                        <x-modal id="modal-edit-kategori-{{ $item->id }}" title="Edit Kategori Transaksi" subtitle="Perbarui nama atau jenis pos kategori kas">
                            <form action="{{ route('kategori.update', ['kategori' => $item->id, 'role' => $role]) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="role" value="{{ $role }}">

                                <!-- Nama Kategori -->
                                <x-input
                                    label="Nama Kategori"
                                    name="nama_kategori"
                                    value="{{ $item->nama_kategori }}"
                                    placeholder="Contoh: Iuran Bulanan / Biaya Logistik"
                                    required="true"
                                />

                                <!-- Jenis Kategori -->
                                <x-select
                                    label="Jenis Transaksi"
                                    name="jenis"
                                    :selected="$item->jenis"
                                    required="true"
                                    :options="[
                                        'pemasukan' => 'Pemasukan (Uang Masuk / Kas Bertambah)',
                                        'pengeluaran' => 'Pengeluaran (Uang Keluar / Belanja Kas)'
                                    ]"
                                />

                                @if ($item->transaksi_count > 0)
                                    <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs">
                                        <span class="font-semibold">Informasi:</span> Kategori ini sedang terhubung dengan <strong>{{ $item->transaksi_count }}</strong> transaksi kas.
                                    </div>
                                @endif

                                <div class="pt-2 border-t border-slate-100 flex items-center justify-end gap-3">
                                    <x-button variant="outline" size="md" type="button" onclick="closeModal('modal-edit-kategori-{{ $item->id }}')">
                                        Batal
                                    </x-button>
                                    <x-button variant="primary" size="md" type="submit">
                                        Simpan Perubahan
                                    </x-button>
                                </div>
                            </form>
                        </x-modal>

                        <!-- Modal Hapus Kategori -->
                        <x-modal id="modal-delete-kategori-{{ $item->id }}" title="Konfirmasi Hapus Kategori" subtitle="Tindakan ini akan menghapus kategori dari sistem">
                            <div class="space-y-4 text-sm">
                                @if ($item->transaksi_count > 0)
                                    <!-- Jika masih digunakan transaksi, beri peringatan dan nonaktifkan penghapusan -->
                                    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800">
                                        <div class="flex items-start gap-2.5">
                                            <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                            <div>
                                                <h4 class="font-bold">Kategori Tidak Dapat Dihapus!</h4>
                                                <p class="text-xs mt-1 leading-relaxed">
                                                    Kategori <strong>"{{ $item->nama_kategori }}"</strong> saat ini masih digunakan oleh <strong>{{ $item->transaksi_count }} transaksi</strong>.
                                                    Untuk melindungi keaslian catatan riwayat keuangan, kategori yang memiliki transaksi tidak diperkenankan dihapus.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-2 border-t border-slate-100 flex items-center justify-end">
                                        <x-button variant="outline" size="md" type="button" onclick="closeModal('modal-delete-kategori-{{ $item->id }}')">
                                            Tutup
                                        </x-button>
                                    </div>
                                @else
                                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-slate-700">
                                        <p class="text-sm">
                                            Apakah Anda yakin ingin menghapus kategori <strong>"{{ $item->nama_kategori }}"</strong> (Jenis: <span class="capitalize font-semibold">{{ $item->jenis }}</span>)?
                                        </p>
                                        <p class="text-xs text-slate-500 mt-2">
                                            Kategori ini belum memiliki transaksi terkait dan aman untuk dihapus secara permanen.
                                        </p>
                                    </div>

                                    <form action="{{ route('kategori.destroy', ['kategori' => $item->id, 'role' => $role]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="role" value="{{ $role }}">

                                        <div class="pt-2 border-t border-slate-100 flex items-center justify-end gap-3">
                                            <x-button variant="outline" size="md" type="button" onclick="closeModal('modal-delete-kategori-{{ $item->id }}')">
                                                Batal
                                            </x-button>
                                            <x-button variant="danger" size="md" type="submit">
                                                Ya, Hapus Kategori
                                            </x-button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </x-modal>
                    @endif
                </td>
            </tr>
        @empty
            <!-- Empty state ditangani oleh x-table -->
        @endforelse
    </x-table>

</div>

<!-- Modal Form Tambah Kategori -->
@if ($role === 'bendahara')
    <x-modal id="modal-tambah-kategori" title="Tambah Kategori Transaksi Baru" subtitle="Input klasifikasi pos kas masuk atau kas keluar">
        <form action="{{ route('kategori.store', ['role' => $role]) }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            <!-- Nama Kategori -->
            <x-input
                label="Nama Kategori"
                name="nama_kategori"
                placeholder="Contoh: Iuran Sukarela, Logistik, Transportasi"
                required="true"
            />

            <!-- Jenis Kategori -->
            <x-select
                label="Jenis Transaksi"
                name="jenis"
                required="true"
                placeholder="Pilih Jenis Transaksi..."
                :options="[
                    'pemasukan' => 'Pemasukan (Uang Masuk / Kas Bertambah)',
                    'pengeluaran' => 'Pengeluaran (Uang Keluar / Belanja Kas)'
                ]"
            />

            <!-- Tombol Batal & Simpan -->
            <div class="pt-2 border-t border-slate-100 flex items-center justify-end gap-3">
                <x-button variant="outline" size="md" type="button" onclick="closeModal('modal-tambah-kategori')">
                    Batal
                </x-button>
                <x-button variant="primary" size="md" type="submit">
                    Simpan Kategori
                </x-button>
            </div>
        </form>
    </x-modal>
@endif
@endsection
