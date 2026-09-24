@extends('layouts.app', ['title' => 'Edit Kategori KasFlow', 'role' => $role])

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Header & Breadcrumbs -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('kategori.index', ['role' => $role]) }}" class="hover:text-emerald-600 transition-colors">Kategori</a>
                <span>/</span>
                <span class="text-slate-800 font-medium">Edit</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Kategori</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Perbarui rincian kategori <strong>"{{ $kategori->nama_kategori }}"</strong>.
            </p>
        </div>

        <x-button variant="outline" size="sm" href="{{ route('kategori.index', ['role' => $role]) }}">
            &larr; Kembali
        </x-button>
    </div>

    <!-- Alert error jika ada -->
    @if ($errors->any())
        <x-alert type="danger" title="Validasi Gagal">
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <!-- Card Form Edit Kategori -->
    <div class="bg-white rounded-2xl border border-slate-200/80 card-shadow p-6">
        <form action="{{ route('kategori.update', ['kategori' => $kategori->id, 'role' => $role]) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <input type="hidden" name="role" value="{{ $role }}">

            <!-- Nama Kategori (Prefilled) -->
            <x-input
                label="Nama Kategori"
                name="nama_kategori"
                value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                placeholder="Contoh: Iuran Sukarela, Logistik, Transportasi"
                required="true"
                helper="Maksimal 100 karakter."
            />

            <!-- Jenis Kategori (Prefilled) -->
            <x-select
                label="Jenis Transaksi"
                name="jenis"
                required="true"
                :selected="old('jenis', $kategori->jenis)"
                :options="[
                    'pemasukan' => 'Pemasukan (Uang Masuk / Kas Bertambah)',
                    'pengeluaran' => 'Pengeluaran (Uang Keluar / Belanja Kas)'
                ]"
            />

            @if ($kategori->transaksi_count > 0)
                <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs">
                    <span class="font-semibold">Perhatian:</span> Kategori ini terhubung dengan <strong>{{ $kategori->transaksi_count }} transaksi</strong> kas.
                </div>
            @endif

            <!-- Tombol Batal & Simpan -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <x-button variant="outline" size="md" href="{{ route('kategori.index', ['role' => $role]) }}">
                    Batal
                </x-button>
                <x-button variant="primary" size="md" type="submit">
                    Simpan Perubahan
                </x-button>
            </div>
        </form>
    </div>

</div>
@endsection
