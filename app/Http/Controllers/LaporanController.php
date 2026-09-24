<?php

namespace App\Http\Controllers;

use App\Support\MockKasFlowData;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role', 'bendahara');
        $summary = MockKasFlowData::getSummary($role);
        $monthlyReports = MockKasFlowData::getMonthlyReports();
        $categoryBreakdown = MockKasFlowData::getCategoryBreakdown();

        return view('laporan.index', [
            'role' => $role,
            'summary' => $summary,
            'monthlyReports' => $monthlyReports,
            'categoryBreakdown' => $categoryBreakdown,
        ]);
    }
}
