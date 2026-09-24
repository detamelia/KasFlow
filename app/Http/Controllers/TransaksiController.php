<?php

namespace App\Http\Controllers;

use App\Support\MockKasFlowData;
use Illuminate\Http\Request;

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

        return view('transaksi.index', [
            'role' => $role,
            'transactions' => $transactions,
            'jenisFilter' => $jenisFilter,
            'search' => $search,
            'totalItems' => count($transactions),
        ]);
    }
}
