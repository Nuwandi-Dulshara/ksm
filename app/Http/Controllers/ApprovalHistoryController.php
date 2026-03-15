<?php

namespace App\Http\Controllers;

use App\Models\Outcome;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApprovalHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Outcome::with(['expenseCategory', 'creator', 'decisionBy'])
            ->whereIn('status', ['approved', 'rejected'])
            ->latest('decided_at');

        if ($request->filled('status') && in_array($request->status, ['approved', 'rejected'], true)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('month')) {
            $month = Carbon::createFromFormat('Y-m', $request->month);
            $query->whereYear('date', $month->year)
                ->whereMonth('date', $month->month);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('beneficiary', 'like', "%{$search}%")
                    ->orWhere('admin_note', 'like', "%{$search}%")
                    ->orWhereHas('creator', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%");
                    })
                    ->orWhereHas('decisionBy', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%");
                    });
            });
        }

        $approvalHistory = $query->paginate(10)->withQueryString();

        $approvedCount = Outcome::where('status', 'approved')->count();
        $rejectedCount = Outcome::where('status', 'rejected')->count();
        $totalDecisions = $approvedCount + $rejectedCount;

        return view('approval-history.index', compact(
            'approvalHistory',
            'approvedCount',
            'rejectedCount',
            'totalDecisions'
        ));
    }
}
