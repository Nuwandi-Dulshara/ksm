<?php

namespace App\Http\Controllers;

use App\Models\Outcome;
use App\Models\Income;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingRequests = Outcome::with(['expenseCategory', 'creator'])
            ->where('status','pending')
            ->latest()
            ->get();

        $totalIncome = Income::sum('amount');

        $totalOutcome = Outcome::where('status','approved')->sum('amount');

        $netBalance = $totalIncome - $totalOutcome;

        $pendingCount = Outcome::where('status','pending')->count();

        return view('dashboard', compact(
            'pendingRequests',
            'totalIncome',
            'totalOutcome',
            'netBalance',
            'pendingCount'
        ));
    }
}
