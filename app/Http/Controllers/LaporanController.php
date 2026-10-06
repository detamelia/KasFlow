<?php

namespace App\Http\Controllers;

use App\Support\MockKasFlowData;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->header('X-Inertia')) {
            return Inertia::location(route('laporan.index'));
        }

        $role = $request->user()->role;
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
