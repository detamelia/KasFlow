<?php

namespace App\Http\Controllers;

use App\Support\MockKasFlowData;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->user()->role;
        $allTransactions = MockKasFlowData::getTransactions();

        $pengeluaran = array_values(array_filter($allTransactions, function ($t) {
            return $t['jenis'] === 'pengeluaran';
        }));

        $kategoriList = MockKasFlowData::getExpenseCategories();
        $totalPengeluaran = array_sum(array_column($pengeluaran, 'nominal'));

        $data = [
            'role' => $role,
            'pengeluaran' => $pengeluaran,
            'kategoriList' => $kategoriList,
            'totalPengeluaran' => $totalPengeluaran,
            'totalPengeluaranFormatted' => 'Rp '.number_format($totalPengeluaran, 0, ',', '.'),
            'jumlahTransaksi' => count($pengeluaran),
        ];

        if ($request->query('view') === 'blade') {
            return view('pengeluaran.index', $data);
        }

        return Inertia::render('Pengeluaran/Index', $data);
    }

    public function show(Request $request, $id)
    {
        $role = $request->user()->role;
        $allTransactions = MockKasFlowData::getTransactions();
        $found = collect($allTransactions)->first(fn ($t) => ($t['id'] ?? null) == $id || ($t['kode'] ?? null) == $id);

        if (!$found) {
            $found = [
                'id' => 1,
                'kode' => 'PGL-001',
                'judul' => 'Contoh Pengeluaran',
                'jenis' => 'pengeluaran',
                'nominal' => 450000,
                'kategori' => 'Konsumsi Rapat',
                'tanggal' => date('Y-m-d'),
            ];
        }

        if ($request->query('view') === 'blade' && view()->exists('pengeluaran.show')) {
            return view('pengeluaran.show', ['item' => $found, 'role' => $role]);
        }

        return Inertia::render('Pengeluaran/Show', [
            'item' => $found,
            'role' => $role,
        ]);
    }
}
