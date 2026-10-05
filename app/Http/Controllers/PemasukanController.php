<?php

namespace App\Http\Controllers;

use App\Support\MockKasFlowData;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->user()->role;
        $allTransactions = MockKasFlowData::getTransactions();

        $pemasukan = array_values(array_filter($allTransactions, function ($t) {
            return $t['jenis'] === 'pemasukan';
        }));

        $kategoriList = MockKasFlowData::getIncomeCategories();
        $totalPemasukan = array_sum(array_column($pemasukan, 'nominal'));

        $data = [
            'role' => $role,
            'pemasukan' => $pemasukan,
            'kategoriList' => $kategoriList,
            'totalPemasukan' => $totalPemasukan,
            'totalPemasukanFormatted' => 'Rp '.number_format($totalPemasukan, 0, ',', '.'),
            'jumlahTransaksi' => count($pemasukan),
        ];

        if ($request->query('view') === 'blade') {
            return view('pemasukan.index', $data);
        }

        return Inertia::render('Pemasukan/Index', $data);
    }

    public function show(Request $request, $id)
    {
        $role = $request->user()->role;
        $allTransactions = MockKasFlowData::getTransactions();
        $found = collect($allTransactions)->first(fn ($t) => ($t['id'] ?? null) == $id || ($t['kode'] ?? null) == $id);

        if (!$found) {
            $found = [
                'id' => 1,
                'kode' => 'PMK-001',
                'judul' => 'Contoh Pemasukan',
                'jenis' => 'pemasukan',
                'nominal' => 2500000,
                'kategori' => 'Donasi Alumni',
                'tanggal' => date('Y-m-d'),
            ];
        }

        if ($request->query('view') === 'blade' && view()->exists('pemasukan.show')) {
            return view('pemasukan.show', ['item' => $found, 'role' => $role]);
        }

        return Inertia::render('Pemasukan/Show', [
            'item' => $found,
            'role' => $role,
        ]);
    }
}
