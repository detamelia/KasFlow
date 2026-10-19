<?php

namespace App\Http\Controllers;

use App\Support\MockKasFlowData;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Role diambil dari akun yang login, bukan dari URL
        $role = $request->user()->role;

        $summary = MockKasFlowData::getSummary($role);
        $transactions = MockKasFlowData::getTransactions();
        $monthlyReports = MockKasFlowData::getMonthlyReports();
        $categoryBreakdown = MockKasFlowData::getCategoryBreakdown();

        $data = compact('summary', 'transactions', 'monthlyReports', 'categoryBreakdown', 'role');

        if ($request->query('view') === 'blade') {
            return view('dashboard', $data);
        }

        return Inertia::render('Dashboard/Index', $data);
    }
}