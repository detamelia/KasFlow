<?php

namespace App\Http\Controllers;

use App\Support\MockKasFlowData;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->user()->role;
        $jenisFilter = $request->query('jenis', 'semua');
        $search = $request->query('search', '');

        $transactions = MockKasFlowData::getTransactions();

        if ($jenisFilter !== 'semua') {
            $transactions = array_values(array_filter($transactions, function ($t) use ($jenisFilter) {
                return $t['jenis'] === $jenisFilter;
            }));
        }

        if (! empty($search)) {
            $transactions = array_values(array_filter($transactions, function ($t) use ($search) {
                return stripos($t['judul'], $search) !== false ||
                       stripos($t['kode'], $search) !== false ||
                       stripos($t['kategori'], $search) !== false;
            }));
        }

        if ($request->query('view') === 'blade') {
            return view('transaksi.index', [
                'role' => $role,
                'transactions' => $transactions,
                'jenisFilter' => $jenisFilter,
                'search' => $search,
                'totalItems' => count($transactions),
            ]);
        }

        return Inertia::render('Transaksi/Index', [
            'role' => $role,
            'transactions' => $transactions,
            'jenisFilter' => $jenisFilter,
            'search' => $search,
            'totalItems' => count($transactions),
        ]);
    }

    public function show(Request $request, $id)
    {
        $role = $request->user()->role;
        $all = MockKasFlowData::getTransactions();
        $found = collect($all)->first(fn ($t) => ($t['id'] ?? null) == $id || ($t['kode'] ?? null) == $id);

        if (!$found) {
            $found = $all[0] ?? [
                'id' => 1,
                'kode' => 'TRX-001',
                'judul' => 'Contoh Transaksi',
                'jenis' => 'pemasukan',
                'nominal' => 500000,
                'kategori' => 'Iuran Anggota',
                'tanggal' => date('Y-m-d'),
            ];
        }

        if ($request->query('view') === 'blade' && view()->exists('transaksi.show')) {
            return view('transaksi.show', ['transaction' => $found, 'role' => $role]);
        }

        return Inertia::render('Transaksi/Show', [
            'transaction' => $found,
            'role' => $role,
        ]);
    }
}
