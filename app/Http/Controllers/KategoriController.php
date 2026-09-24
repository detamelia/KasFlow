<?php

namespace App\Http\Controllers;

use App\Models\KategoriTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    /**
     * Cek apakah driver database dan tabel kategori siap digunakan.
     */
    private function isDatabaseAvailable(): bool
    {
        try {
            if (config('database.default') === 'sqlite' && !extension_loaded('pdo_sqlite')) {
                return false;
            }

            DB::connection()->getPdo();
            return Schema::hasTable('kategori_transaksi');
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Ambil data fallback yang disimpan di session jika environment belum memiliki driver database.
     */
    private function getFallbackList(Request $request): array
    {
        if (!$request->session()->has('mock_kategori_data')) {
            $initial = [
                [
                    'id' => 1,
                    'nama_kategori' => 'Iuran Anggota',
                    'jenis' => 'pemasukan',
                    'transaksi_count' => 2,
                    'created_at' => Carbon::now()->subDays(10)->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->subDays(2)->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => 2,
                    'nama_kategori' => 'Donasi',
                    'jenis' => 'pemasukan',
                    'transaksi_count' => 1,
                    'created_at' => Carbon::now()->subDays(8)->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => 3,
                    'nama_kategori' => 'ATK',
                    'jenis' => 'pengeluaran',
                    'transaksi_count' => 1,
                    'created_at' => Carbon::now()->subDays(6)->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => 4,
                    'nama_kategori' => 'Konsumsi',
                    'jenis' => 'pengeluaran',
                    'transaksi_count' => 1,
                    'created_at' => Carbon::now()->subDays(5)->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => 5,
                    'nama_kategori' => 'Sponsorship',
                    'jenis' => 'pemasukan',
                    'transaksi_count' => 0,
                    'created_at' => Carbon::now()->subDays(3)->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => 6,
                    'nama_kategori' => 'Operasional',
                    'jenis' => 'pengeluaran',
                    'transaksi_count' => 0,
                    'created_at' => Carbon::now()->subDays(2)->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s'),
                ],
            ];
            $request->session()->put('mock_kategori_data', $initial);
        }

        return $request->session()->get('mock_kategori_data', []);
    }

    /**
     * Tampilkan daftar kategori dengan filter pencarian dan jenis.
     */
    public function index(Request $request)
    {
        $role = $request->query('role', 'bendahara');
        $search = $request->query('search', '');
        $jenisFilter = $request->query('jenis', 'semua');

        if ($this->isDatabaseAvailable()) {
            $query = KategoriTransaksi::withCount('transaksi');

            if (!empty($search)) {
                $query->where('nama_kategori', 'like', '%' . trim($search) . '%');
            }

            if (in_array($jenisFilter, ['pemasukan', 'pengeluaran'])) {
                $query->where('jenis', $jenisFilter);
            }

            $kategoriList = $query->orderBy('nama_kategori', 'asc')->get();

            $totalKategori = KategoriTransaksi::count();
            $totalPemasukan = KategoriTransaksi::where('jenis', 'pemasukan')->count();
            $totalPengeluaran = KategoriTransaksi::where('jenis', 'pengeluaran')->count();
            $totalTransaksi = Transaksi::count();
        } else {
            // Mode fallback aman tanpa database driver (misal di PC teman tanpa pdo_sqlite)
            $rawList = $this->getFallbackList($request);

            $collection = collect($rawList)->map(function ($item) {
                return (object)[
                    'id' => $item['id'],
                    'nama_kategori' => $item['nama_kategori'],
                    'jenis' => $item['jenis'],
                    'transaksi_count' => $item['transaksi_count'],
                    'created_at' => Carbon::parse($item['created_at']),
                    'updated_at' => Carbon::parse($item['updated_at']),
                ];
            });

            if (!empty($search)) {
                $collection = $collection->filter(function ($item) use ($search) {
                    return stripos($item->nama_kategori, trim($search)) !== false;
                });
            }

            if (in_array($jenisFilter, ['pemasukan', 'pengeluaran'])) {
                $collection = $collection->where('jenis', $jenisFilter);
            }

            $kategoriList = $collection->sortBy('nama_kategori')->values();

            $allFallback = collect($rawList);
            $totalKategori = $allFallback->count();
            $totalPemasukan = $allFallback->where('jenis', 'pemasukan')->count();
            $totalPengeluaran = $allFallback->where('jenis', 'pengeluaran')->count();
            $totalTransaksi = $allFallback->sum('transaksi_count');
        }

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
        $role = $request->query('role', 'bendahara');

        return view('kategori.create', compact('role'));
    }

    /**
     * Simpan data kategori baru ke database atau session fallback.
     */
    public function store(Request $request)
    {
        $role = $request->input('role', $request->query('role', 'bendahara'));

        $uniqueRule = $this->isDatabaseAvailable()
            ? 'unique:kategori_transaksi,nama_kategori'
            : '';

        $validated = $request->validate([
            'nama_kategori' => array_filter([
                'required',
                'string',
                'max:100',
                $uniqueRule,
            ]),
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

        $namaKategori = trim($validated['nama_kategori']);
        $jenis = $validated['jenis'];

        if ($this->isDatabaseAvailable()) {
            $kategori = KategoriTransaksi::create([
                'nama_kategori' => $namaKategori,
                'jenis' => $jenis,
            ]);
            $displayName = $kategori->nama_kategori;
        } else {
            $list = $this->getFallbackList($request);
            $newId = count($list) > 0 ? max(array_column($list, 'id')) + 1 : 1;
            $now = Carbon::now()->format('Y-m-d H:i:s');

            $list[] = [
                'id' => $newId,
                'nama_kategori' => $namaKategori,
                'jenis' => $jenis,
                'transaksi_count' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $request->session()->put('mock_kategori_data', $list);
            $displayName = $namaKategori;
        }

        return redirect()->route('kategori.index', ['role' => $role])
            ->with('success', 'Kategori "' . $displayName . '" berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit kategori (akses halaman mandiri).
     */
    public function edit(Request $request, $id)
    {
        $role = $request->query('role', 'bendahara');

        if ($this->isDatabaseAvailable()) {
            $kategori = KategoriTransaksi::withCount('transaksi')->findOrFail($id);
        } else {
            $list = $this->getFallbackList($request);
            $found = collect($list)->firstWhere('id', (int)$id);

            if (!$found) {
                return redirect()->route('kategori.index', ['role' => $role])
                    ->with('error', 'Kategori tidak ditemukan.');
            }

            $kategori = (object)[
                'id' => $found['id'],
                'nama_kategori' => $found['nama_kategori'],
                'jenis' => $found['jenis'],
                'transaksi_count' => $found['transaksi_count'],
                'created_at' => Carbon::parse($found['created_at']),
                'updated_at' => Carbon::parse($found['updated_at']),
            ];
        }

        return view('kategori.edit', compact('kategori', 'role'));
    }

    /**
     * Perbarui data kategori di database atau session fallback.
     */
    public function update(Request $request, $id)
    {
        $role = $request->input('role', $request->query('role', 'bendahara'));

        $uniqueRule = $this->isDatabaseAvailable()
            ? Rule::unique('kategori_transaksi', 'nama_kategori')->ignore($id)
            : '';

        $validated = $request->validate([
            'nama_kategori' => array_filter([
                'required',
                'string',
                'max:100',
                $uniqueRule,
            ]),
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

        $namaBaru = trim($validated['nama_kategori']);
        $jenisBaru = $validated['jenis'];

        if ($this->isDatabaseAvailable()) {
            $kategori = KategoriTransaksi::findOrFail($id);
            $namaLama = $kategori->nama_kategori;
            $kategori->update([
                'nama_kategori' => $namaBaru,
                'jenis' => $jenisBaru,
            ]);
        } else {
            $list = $this->getFallbackList($request);
            $namaLama = $namaBaru;

            foreach ($list as &$item) {
                if ($item['id'] == (int)$id) {
                    $namaLama = $item['nama_kategori'];
                    $item['nama_kategori'] = $namaBaru;
                    $item['jenis'] = $jenisBaru;
                    $item['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
                    break;
                }
            }
            unset($item);

            $request->session()->put('mock_kategori_data', $list);
        }

        return redirect()->route('kategori.index', ['role' => $role])
            ->with('success', 'Kategori "' . $namaLama . '" berhasil diperbarui menjadi "' . $namaBaru . '".');
    }

    /**
     * Hapus kategori dengan proteksi relasi transaksi.
     */
    public function destroy(Request $request, $id)
    {
        $role = $request->input('role', $request->query('role', 'bendahara'));

        if ($this->isDatabaseAvailable()) {
            $kategori = KategoriTransaksi::withCount('transaksi')->findOrFail($id);

            if ($kategori->transaksi_count > 0) {
                return redirect()->route('kategori.index', ['role' => $role])
                    ->with('error', 'Kategori "' . $kategori->nama_kategori . '" tidak dapat dihapus karena masih digunakan oleh ' . $kategori->transaksi_count . ' transaksi.');
            }

            $namaKategori = $kategori->nama_kategori;
            $kategori->delete();
        } else {
            $list = $this->getFallbackList($request);
            $foundIndex = null;
            $foundItem = null;

            foreach ($list as $index => $item) {
                if ($item['id'] == (int)$id) {
                    $foundIndex = $index;
                    $foundItem = $item;
                    break;
                }
            }

            if (!$foundItem) {
                return redirect()->route('kategori.index', ['role' => $role])
                    ->with('error', 'Kategori tidak ditemukan.');
            }

            if ($foundItem['transaksi_count'] > 0) {
                return redirect()->route('kategori.index', ['role' => $role])
                    ->with('error', 'Kategori "' . $foundItem['nama_kategori'] . '" tidak dapat dihapus karena masih digunakan oleh ' . $foundItem['transaksi_count'] . ' transaksi.');
            }

            $namaKategori = $foundItem['nama_kategori'];
            array_splice($list, $foundIndex, 1);
            $request->session()->put('mock_kategori_data', $list);
        }

        return redirect()->route('kategori.index', ['role' => $role])
            ->with('success', 'Kategori "' . $namaKategori . '" berhasil dihapus.');
    }
}
