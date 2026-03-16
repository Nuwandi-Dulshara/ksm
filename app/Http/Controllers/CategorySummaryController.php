<?php

namespace App\Http\Controllers;

use App\Models\Outcome;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategorySummaryController extends Controller
{
    public function index(Request $request)
    {
        $availableMonths = Outcome::query()
            ->whereNotNull('date')
            ->orderByDesc('date')
            ->pluck('date')
            ->map(fn ($date) => Carbon::parse($date)->startOfMonth()->toDateString())
            ->unique()
            ->values();

        $selectedMonthInput = $request->query('month');

        try {
            $selectedMonth = $selectedMonthInput
                ? Carbon::parse($selectedMonthInput)->startOfMonth()
                : ($availableMonths->isNotEmpty()
                    ? Carbon::parse($availableMonths->first())
                    : Carbon::now()->startOfMonth());
        } catch (\Exception $e) {
            $selectedMonth = $availableMonths->isNotEmpty()
                ? Carbon::parse($availableMonths->first())
                : Carbon::now()->startOfMonth();
        }

        if (! $availableMonths->contains($selectedMonth->toDateString())) {
            $availableMonths = $availableMonths->prepend($selectedMonth->toDateString())->unique()->values();
        }

        $monthStart = $selectedMonth->copy()->startOfMonth()->toDateString();
        $monthEnd = $selectedMonth->copy()->endOfMonth()->toDateString();

        $outcomes = Outcome::with(['expenseCategory.expenseType'])
            ->where('status', 'approved')
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->orderBy('date')
            ->get();

        $summaryItems = $outcomes
            ->groupBy(fn ($outcome) => $outcome->expense_category_id ?: 'uncategorized')
            ->map(function ($items) {
                $first = $items->first();
                $category = $first?->expenseCategory;

                return [
                    'category_name' => $category?->category_name ?? 'Uncategorized',
                    'subtitle' => $category?->expenseType?->expense_type ?? 'No expense type assigned',
                    'transaction_count' => $items->count(),
                    'total_amount' => $items->sum('amount'),
                ];
            })
            ->sortBy('category_name', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();

        $grandTotal = $summaryItems->sum('total_amount');

        return view('category-summary.index', [
            'summaryItems' => $summaryItems,
            'grandTotal' => $grandTotal,
            'availableMonths' => $availableMonths,
            'selectedMonth' => $selectedMonth,
            'generatedAt' => now(),
        ]);
    }
}
