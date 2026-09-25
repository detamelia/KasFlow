<?php

namespace App\Http\Controllers;

use App\Support\MockKasFlowData;
use Illuminate\Http\Request;

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

        return view('pemasukan.index', [
            'role' => $role,
            'pemasukan' => $pemasukan,
            'kategoriList' => $kategoriList,
            'totalPemasukan' => $totalPemasukan,
            'totalPemasukanFormatted' => 'Rp '.number_format($totalPemasukan, 0, ',', '.'),
            'jumlahTransaksi' => count($pemasukan),
        ]);
    }
}
