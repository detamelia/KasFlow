<?php

namespace App\Http\Controllers;

use App\Models\KategoriTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    /**
     * Tampilkan daftar kategori dengan filter pencarian dan jenis.
     */
    public function index(Request $request)
    {
        $role = $request->user()->role;
        $search = $request->query('search', '');
        $jenisFilter = $request->query('jenis', 'semua');

        $query = KategoriTransaksi::withCount('transaksi');

        if (!empty($search)) {
            $query->where('nama_kategori', 'like', '%' . trim($search) . '%');
        }

        if (in_array($jenisFilter, ['pemasukan', 'pengeluaran'])) {
            $query->where('jenis', $jenisFilter);
        }

        $kategoriList = $query->orderBy('nama_kategori', 'asc')->get();

        // Data KPI Summary
        $totalKategori = KategoriTransaksi::count();
        $totalPemasukan = KategoriTransaksi::where('jenis', 'pemasukan')->count();
        $totalPengeluaran = KategoriTransaksi::where('jenis', 'pengeluaran')->count();
        $totalTransaksi = Transaksi::count();

        return view('kategori.index', compact(
            'kategoriList',
            'role',
            'search',
            'jenisFilter',
            'totalKategori',
            'totalPemasukan',
            'totalPengeluaran',
            'totalTransaksi'
        ));
    }

    /**
     * Tampilkan form pembuatan kategori baru (akses halaman mandiri).
     */
    public function create(Request $request)
    {
        $role = $request->user()->role;

        return view('kategori.create', compact('role'));
    }

    /**
     * Simpan data kategori baru ke database.
     */
    public function store(Request $request)
    {
        $role = $request->user()->role;

        $validated = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                'unique:kategori_transaksi,nama_kategori',
            ],
            'jenis' => [
                'required',
                'string',
                Rule::in(['pemasukan', 'pengeluaran']),
            ],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.string' => 'Nama kategori harus berupa teks yang valid.',
            'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 100 karakter.',
            'nama_kategori.unique' => 'Nama kategori tersebut sudah terdaftar.',
            'jenis.required' => 'Jenis kategori wajib dipilih.',
            'jenis.in' => 'Jenis kategori harus berupa "pemasukan" atau "pengeluaran".',
        ]);

        $kategori = KategoriTransaksi::create([
            'nama_kategori' => trim($validated['nama_kategori']),
            'jenis' => $validated['jenis'],
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori "' . $kategori->nama_kategori . '" berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit kategori (akses halaman mandiri).
     */
    public function edit(Request $request, $id)
    {
        $role = $request->user()->role;
        $kategori = KategoriTransaksi::withCount('transaksi')->findOrFail($id);

        return view('kategori.edit', compact('kategori', 'role'));
    }

    /**
     * Perbarui data kategori di database.
     */
    public function update(Request $request, $id)
    {
        $role = $request->user()->role;
        $kategori = KategoriTransaksi::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kategori_transaksi', 'nama_kategori')->ignore($kategori->id),
            ],
            'jenis' => [
                'required',
                'string',
                Rule::in(['pemasukan', 'pengeluaran']),
            ],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.string' => 'Nama kategori harus berupa teks yang valid.',
            'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 100 karakter.',
            'nama_kategori.unique' => 'Nama kategori tersebut sudah digunakan.',
            'jenis.required' => 'Jenis kategori wajib dipilih.',
            'jenis.in' => 'Jenis kategori harus berupa "pemasukan" atau "pengeluaran".',
        ]);

        $namaLama = $kategori->nama_kategori;
        $kategori->update([
            'nama_kategori' => trim($validated['nama_kategori']),
            'jenis' => $validated['jenis'],
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori "' . $namaLama . '" berhasil diperbarui menjadi "' . $kategori->nama_kategori . '".');
    }

    /**
     * Hapus kategori dari database dengan validasi proteksi relasi transaksi.
     */
    public function destroy(Request $request, $id)
    {
        $role = $request->user()->role;
        $kategori = KategoriTransaksi::withCount('transaksi')->findOrFail($id);

        // Jika kategori masih memiliki transaksi, lindungi data transaksi dan beri peringatan
        if ($kategori->transaksi_count > 0) {
            return redirect()->route('kategori.index')
                ->with('error', 'Kategori "' . $kategori->nama_kategori . '" tidak dapat dihapus karena masih digunakan oleh ' . $kategori->transaksi_count . ' transaksi.');
        }

        $namaKategori = $kategori->nama_kategori;
        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori "' . $namaKategori . '" berhasil dihapus.');
    }
}
