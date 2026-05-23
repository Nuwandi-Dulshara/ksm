<?php

namespace App\Http\Controllers;

use App\Models\MoneyIssuance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MoneyIssuanceController extends Controller
{
    public function index(Request $request)
    {
        $query = MoneyIssuance::with(['issuedTo', 'createdBy', 'approvedBy'])->latest('issued_date');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder->whereHas('issuedTo', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('reason', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('start_date')) {
            $query->whereDate('issued_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('issued_date', '<=', $request->end_date);
        }

        $issuances = $query->paginate(15);
        
        // Statistics
        $stats = [
            'total_pending' => MoneyIssuance::pending()->count(),
            'total_approved' => MoneyIssuance::approved()->count(),
            'total_rejected' => MoneyIssuance::rejected()->count(),
            'total_amount_pending' => MoneyIssuance::pending()->sum('amount'),
            'total_amount_approved' => MoneyIssuance::approved()->sum('amount'),
        ];

        $recipients = User::where('status', 'active')->orderBy('name')->get();

        return view('money-issuances.index', compact('issuances', 'stats', 'recipients'));
    }

    public function create()
    {
        $recipients = User::where('status', 'active')->orderBy('name')->get();
        return view('money-issuances.create', compact('recipients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'issued_to' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
            'issued_date' => 'required|date|before_or_equal:today',
        ]);

        // Try to find matching user by name or email
        $recipient = User::where('status', 'active')
            ->where(function ($query) use ($validated) {
                $query->where('name', $validated['issued_to'])
                    ->orWhere('email', $validated['issued_to']);
            })
            ->first();

        // Store issued_to as string and optional issued_to_id if user exists
        $validated['issued_to_id'] = $recipient?->id;
        $validated['created_by'] = Auth::id();
        $validated['status'] = 'pending';
        $validated['recipient_type'] = 'other'; // Default type

        MoneyIssuance::create($validated);

        return redirect()
            ->route('money-issuances.index')
            ->with('success', 'Money issuance registered successfully and is pending approval.');
    }

    public function edit(MoneyIssuance $moneyIssuance)
    {
        $recipients = User::where('status', 'active')->orderBy('name')->get();
        return view('money-issuances.edit', compact('moneyIssuance', 'recipients'));
    }

    public function update(Request $request, MoneyIssuance $moneyIssuance)
    {
        // Only allow editing if status is pending
        if ($moneyIssuance->status !== 'pending') {
            return redirect()->route('money-issuances.index')
                ->with('error', 'Cannot edit an already decided issuance.');
        }

        $validated = $request->validate([
            'issued_to' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
            'issued_date' => 'required|date|before_or_equal:today',
        ]);

        // Try to find matching user by name or email
        $recipient = User::where('status', 'active')
            ->where(function ($query) use ($validated) {
                $query->where('name', $validated['issued_to'])
                    ->orWhere('email', $validated['issued_to']);
            })
            ->first();

        // Store issued_to as string and optional issued_to_id if user exists
        $validated['issued_to_id'] = $recipient?->id;

        $moneyIssuance->update($validated);

        return redirect()
            ->route('money-issuances.index')
            ->with('success', 'Money issuance updated successfully.');
    }

    public function destroy(MoneyIssuance $moneyIssuance)
    {
        if ($moneyIssuance->status !== 'pending') {
            return redirect()->route('money-issuances.index')
                ->with('error', 'Cannot delete an already decided issuance.');
        }

        $moneyIssuance->delete();

        return redirect()
            ->route('money-issuances.index')
            ->with('success', 'Money issuance deleted successfully.');
    }

    public function approve(Request $request, MoneyIssuance $moneyIssuance)
    {
        if ($moneyIssuance->status !== 'pending') {
            return redirect()->route('money-issuances.index')
                ->with('error', 'This issuance has already been decided.');
        }

        $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $moneyIssuance->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_note' => $request->admin_note,
        ]);

        return redirect()
            ->route('money-issuances.index')
            ->with('success', 'Money issuance approved successfully.');
    }

    public function reject(Request $request, MoneyIssuance $moneyIssuance)
    {
        if ($moneyIssuance->status !== 'pending') {
            return redirect()->route('money-issuances.index')
                ->with('error', 'This issuance has already been decided.');
        }

        $request->validate([
            'admin_note' => 'required|string|max:500',
        ]);

        $moneyIssuance->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_note' => $request->admin_note,
        ]);

        return redirect()
            ->route('money-issuances.index')
            ->with('success', 'Money issuance rejected.');
    }

    public function report(Request $request)
    {
        $query = MoneyIssuance::with(['issuedTo', 'createdBy', 'approvedBy']);

        // Date range filter
        if ($request->filled('start_date')) {
            $query->whereDate('issued_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('issued_date', '<=', $request->end_date);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Recipient filter
        if ($request->filled('issued_to_id')) {
            $query->where('issued_to_id', $request->issued_to_id);
        }

        $issuances = $query->latest('issued_date')->get();

        $summary = [
            'total_count' => $issuances->count(),
            'total_amount' => $issuances->sum('amount'),
            'pending_count' => $issuances->where('status', 'pending')->count(),
            'approved_count' => $issuances->where('status', 'approved')->count(),
            'rejected_count' => $issuances->where('status', 'rejected')->count(),
            'pending_amount' => $issuances->where('status', 'pending')->sum('amount'),
            'approved_amount' => $issuances->where('status', 'approved')->sum('amount'),
        ];

        $recipients = User::where('status', 'active')->orderBy('name')->get();
        $startDate = $request->start_date ?? Carbon::now()->subMonths(1)->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::now()->format('Y-m-d');

        if ($request->get('print') === 'true') {
            return view('money-issuances.print-report', compact('issuances', 'summary', 'startDate', 'endDate'));
        }

        return view('money-issuances.report', compact('issuances', 'summary', 'recipients', 'startDate', 'endDate'));
    }

    public function showReport(MoneyIssuance $moneyIssuance)
    {
        return view('money-issuances.show-report', compact('moneyIssuance'));
    }

    public function printIndividualReport(Request $request, MoneyIssuance $moneyIssuance)
    {
        return view('money-issuances.print-individual-report', compact('moneyIssuance'));
    }
}
