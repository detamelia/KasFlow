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
        $role = $request->query('role', 'bendahara');
        $search = $request->query('search', '');
        $jenisFilter = $request->query('jenis', 'semua');
        $dbWarning = null;

        try {
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
        } catch (\Throwable $e) {
            // Fallback graceful jika driver database (misal pdo_sqlite) belum diaktifkan di PHP lingkungan pengguna
            $dbWarning = 'Peringatan Database: ' . $e->getMessage() . '. Pastikan ekstensi "pdo_sqlite" sudah diaktifkan pada file php.ini dan jalankan "php artisan migrate".';

            $mockData = collect([
                (object)[
                    'id' => 1,
                    'nama_kategori' => 'Iuran Anggota',
                    'jenis' => 'pemasukan',
                    'transaksi_count' => 2,
                    'created_at' => now()->subDays(10),
                    'updated_at' => now()->subDays(2),
                ],
                (object)[
                    'id' => 2,
                    'nama_kategori' => 'Donasi',
                    'jenis' => 'pemasukan',
                    'transaksi_count' => 1,
                    'created_at' => now()->subDays(8),
                    'updated_at' => now()->subDays(1),
                ],
                (object)[
                    'id' => 3,
                    'nama_kategori' => 'ATK',
                    'jenis' => 'pengeluaran',
                    'transaksi_count' => 1,
                    'created_at' => now()->subDays(6),
                    'updated_at' => now()->subDays(3),
                ],
                (object)[
                    'id' => 4,
                    'nama_kategori' => 'Konsumsi',
                    'jenis' => 'pengeluaran',
                    'transaksi_count' => 1,
                    'created_at' => now()->subDays(5),
                    'updated_at' => now()->subDays(1),
                ],
            ]);

            if (!empty($search)) {
                $mockData = $mockData->filter(function ($item) use ($search) {
                    return stripos($item->nama_kategori, trim($search)) !== false;
                });
            }

            if (in_array($jenisFilter, ['pemasukan', 'pengeluaran'])) {
                $mockData = $mockData->where('jenis', $jenisFilter);
            }

            $kategoriList = $mockData->values();
            $totalKategori = 4;
            $totalPemasukan = 2;
            $totalPengeluaran = 2;
            $totalTransaksi = 5;
        }

        return view('kategori.index', compact(
            'kategoriList',
            'role',
            'search',
            'jenisFilter',
            'totalKategori',
            'totalPemasukan',
            'totalPengeluaran',
            'totalTransaksi',
            'dbWarning'
        ));
    }

    /**
     * Tampilkan form pembuatan kategori baru (akses halaman mandiri).
     */
    public function create(Request $request)
    {
        $role = $request->query('role', 'bendahara');

        return view('kategori.create', compact('role'));
    }

    /**
     * Simpan data kategori baru ke database.
     */
    public function store(Request $request)
    {
        $role = $request->input('role', $request->query('role', 'bendahara'));

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

        try {
            $kategori = KategoriTransaksi::create([
                'nama_kategori' => trim($validated['nama_kategori']),
                'jenis' => $validated['jenis'],
            ]);

            return redirect()->route('kategori.index', ['role' => $role])
                ->with('success', 'Kategori "' . $kategori->nama_kategori . '" berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->route('kategori.index', ['role' => $role])
                ->with('error', 'Gagal menyimpan kategori ke database: ' . $e->getMessage() . '. Pastikan driver database (pdo_sqlite) aktif di php.ini.');
        }
    }

    /**
     * Tampilkan form edit kategori (akses halaman mandiri).
     */
    public function edit(Request $request, $id)
    {
        $role = $request->query('role', 'bendahara');

        try {
            $kategori = KategoriTransaksi::withCount('transaksi')->findOrFail($id);
            return view('kategori.edit', compact('kategori', 'role'));
        } catch (\Throwable $e) {
            return redirect()->route('kategori.index', ['role' => $role])
                ->with('error', 'Kategori tidak dapat dimuat dari database: ' . $e->getMessage());
        }
    }

    /**
     * Perbarui data kategori di database.
     */
    public function update(Request $request, $id)
    {
        $role = $request->input('role', $request->query('role', 'bendahara'));

        try {
            $kategori = KategoriTransaksi::findOrFail($id);
        } catch (\Throwable $e) {
            return redirect()->route('kategori.index', ['role' => $role])
                ->with('error', 'Kategori tidak ditemukan di database: ' . $e->getMessage());
        }

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

        try {
            $namaLama = $kategori->nama_kategori;
            $kategori->update([
                'nama_kategori' => trim($validated['nama_kategori']),
                'jenis' => $validated['jenis'],
            ]);

            return redirect()->route('kategori.index', ['role' => $role])
                ->with('success', 'Kategori "' . $namaLama . '" berhasil diperbarui menjadi "' . $kategori->nama_kategori . '".');
        } catch (\Throwable $e) {
            return redirect()->route('kategori.index', ['role' => $role])
                ->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    /**
     * Hapus kategori dari database dengan validasi proteksi relasi transaksi.
     */
    public function destroy(Request $request, $id)
    {
        $role = $request->input('role', $request->query('role', 'bendahara'));

        try {
            $kategori = KategoriTransaksi::withCount('transaksi')->findOrFail($id);

            // Jika kategori masih memiliki transaksi, lindungi data transaksi dan beri peringatan
            if ($kategori->transaksi_count > 0) {
                return redirect()->route('kategori.index', ['role' => $role])
                    ->with('error', 'Kategori "' . $kategori->nama_kategori . '" tidak dapat dihapus karena masih digunakan oleh ' . $kategori->transaksi_count . ' transaksi.');
            }

            $namaKategori = $kategori->nama_kategori;
            $kategori->delete();

            return redirect()->route('kategori.index', ['role' => $role])
                ->with('success', 'Kategori "' . $namaKategori . '" berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->route('kategori.index', ['role' => $role])
                ->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}
