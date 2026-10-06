<?php

namespace App\Http\Controllers;

use App\Support\MockKasFlowData;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->header('X-Inertia')) {
            return Inertia::location(route('dashboard'));
        }

        // Role diambil dari akun yang login, bukan dari URL
        $role = $request->user()->role;

        $summary = MockKasFlowData::getSummary($role);
        $transactions = MockKasFlowData::getTransactions();
        $monthlyReports = MockKasFlowData::getMonthlyReports();
        $categoryBreakdown = MockKasFlowData::getCategoryBreakdown();

        return view('dashboard', compact('summary', 'transactions', 'monthlyReports', 'categoryBreakdown', 'role'));
    }
}