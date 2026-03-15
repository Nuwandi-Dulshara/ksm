<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outcome;
use App\Models\ExpenseCategory;
use Carbon\Carbon;

class OutcomeReportController extends Controller
{
    public function index(Request $request)
    {
        // Parse filters with sensible defaults (current month)
        $startInput = $request->query('start_date');
        $endInput = $request->query('end_date');
        $categoryFilter = $request->query('category', 'all');

        // Normalize dates: if empty or invalid, fall back to current month
        try {
            $start = $startInput ? Carbon::parse($startInput)->toDateString() : Carbon::now()->startOfMonth()->toDateString();
        } catch (\Exception $e) {
            $start = Carbon::now()->startOfMonth()->toDateString();
        }

        try {
            $end = $endInput ? Carbon::parse($endInput)->toDateString() : Carbon::now()->endOfMonth()->toDateString();
        } catch (\Exception $e) {
            $end = Carbon::now()->endOfMonth()->toDateString();
        }

        // Ensure start is not after end; swap if necessary
        if (Carbon::parse($start)->gt(Carbon::parse($end))) {
            $tmp = $start;
            $start = $end;
            $end = $tmp;
        }

        // Query outcomes within date range
        $query = Outcome::with(['expenseCategory'])
            ->whereBetween('date', [$start, $end])
            ->orderBy('date');

        // Optional category filter (by category id)
        if ($categoryFilter !== null && $categoryFilter !== 'all' && $categoryFilter !== '') {
            $query->where('expense_category_id', $categoryFilter);
        }

        $outcomes = $query->get();

        // Group outcomes by category name
        $grouped = $outcomes->groupBy(function ($item) {
            return $item->expenseCategory ? $item->expenseCategory->category_name : 'Uncategorized';
        });

        $categories = [];
        $grandTotal = 0;

        foreach ($grouped as $catName => $items) {
            $records = $items->map(function ($it) {
                return [
                    'date' => $it->date,
                    'description' => $it->description ?? 'Outcome Payment',
                    'beneficiary' => $it->beneficiary ?? '',
                    'amount' => $it->amount,
                ];
            })->values();

            $subtotal = $items->sum('amount');
            $grandTotal += $subtotal;

            $categories[] = [
                'name' => $catName,
                'count' => $items->count(),
                'records' => $records,
                'subtotal' => $subtotal,
            ];
        }

        // All expense categories for the filter select
        $expenseCategories = ExpenseCategory::orderBy('category_name')->get();

        return view('outcome-report.index', compact(
            'categories',
            'expenseCategories',
            'grandTotal',
            'start',
            'end',
            'categoryFilter'
        ));
    }
}
