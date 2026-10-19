<?php

namespace App\Http\Controllers;

use App\Support\MockKasFlowData;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->user()->role;
        $summary = MockKasFlowData::getSummary($role);
        $monthlyReports = MockKasFlowData::getMonthlyReports();
        $categoryBreakdown = MockKasFlowData::getCategoryBreakdown();

        $data = [
            'role' => $role,
            'summary' => $summary,
            'monthlyReports' => $monthlyReports,
            'categoryBreakdown' => $categoryBreakdown,
        ];

        if ($request->query('view') === 'blade') {
            return view('laporan.index', $data);
        }

        return Inertia::render('Laporan/Index', $data);
    }
}
