<?php

namespace App\Http\Controllers;

use App\Support\MockKasFlowData;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role', 'bendahara');
        $allTransactions = MockKasFlowData::getTransactions();

        $pengeluaran = array_values(array_filter($allTransactions, function ($t) {
            return $t['jenis'] === 'pengeluaran';
        }));

        $kategoriList = MockKasFlowData::getExpenseCategories();
        $totalPengeluaran = array_sum(array_column($pengeluaran, 'nominal'));

        return view('pengeluaran.index', [
            'role' => $role,
            'pengeluaran' => $pengeluaran,
            'kategoriList' => $kategoriList,
            'totalPengeluaran' => $totalPengeluaran,
            'totalPengeluaranFormatted' => 'Rp '.number_format($totalPengeluaran, 0, ',', '.'),
            'jumlahTransaksi' => count($pengeluaran),
        ]);
    }
}
