<?php

namespace App\Http\Controllers;

use App\Models\Outcome;
use App\Models\ExpenseType;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutcomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $outcomes = Outcome::with(['expenseType','expenseCategory'])
                    ->latest()
                    ->get();

        return view('outcomes.index', compact('outcomes'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $expenseTypes = ExpenseType::all();

        return view('outcomes.create', compact('expenseTypes'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'expense_type_id'      => 'required|exists:expense_types,id',
            'expense_category_id'  => 'required|exists:expense_categories,id',
            'amount'               => 'required|numeric|min:0',
            'date'                 => 'required|date',
            'receipt'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $receiptPath = null;

        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')
                                   ->store('receipts', 'public');
        }

        Outcome::create([
            'expense_type_id'      => $request->expense_type_id,
            'expense_category_id'  => $request->expense_category_id,
            'created_by'           => Auth::id(),
            'amount'               => $request->amount,
            'date'                 => $request->date,
            'beneficiary'          => $request->beneficiary,
            'description'          => $request->description,
            'receipt'              => $receiptPath,
            'status'               => 'pending'
        ]);

        return redirect()->route('outcomes.index')
                         ->with('success', 'Outcome created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */
    public function edit(Outcome $outcome)
    {
        $expenseTypes = ExpenseType::all();

        // IMPORTANT: load categories for selected expense type
        $categories = ExpenseCategory::where(
            'expense_type_id',
            $outcome->expense_type_id
        )->orderBy('category_name')->get();

        return view('outcomes.edit', compact(
            'outcome',
            'expenseTypes',
            'categories'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Outcome $outcome)
    {
        $request->validate([
            'expense_type_id'      => 'required|exists:expense_types,id',
            'expense_category_id'  => 'required|exists:expense_categories,id',
            'amount'               => 'required|numeric|min:0',
            'date'                 => 'required|date',
            'receipt'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $receiptPath = $outcome->receipt;

        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')
                                   ->store('receipts', 'public');
        }

        $outcome->update([
            'expense_type_id'      => $request->expense_type_id,
            'expense_category_id'  => $request->expense_category_id,
            'amount'               => $request->amount,
            'date'                 => $request->date,
            'beneficiary'          => $request->beneficiary,
            'description'          => $request->description,
            'receipt'              => $receiptPath,
        ]);

        return redirect()->route('outcomes.index')
                         ->with('success', 'Outcome updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */
    public function destroy(Outcome $outcome)
    {
        $outcome->delete();

        return redirect()->route('outcomes.index')
                         ->with('success', 'Outcome deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Approve
    |--------------------------------------------------------------------------
    */
    public function approve($id)
    {
        $outcome = Outcome::findOrFail($id);

        $outcome->update([
            'status'     => 'approved',
            'admin_note' => null,
            'decided_by' => Auth::id(),
            'decided_at' => now(),
        ]);

        return redirect()->back()
                         ->with('success','Request Approved');
    }

    /*
    |--------------------------------------------------------------------------
    | Reject
    |--------------------------------------------------------------------------
    */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_note' => 'required|string'
        ]);

        $outcome = Outcome::findOrFail($id);

        $outcome->update([
            'status'     => 'rejected',
            'admin_note' => $request->admin_note,
            'decided_by' => Auth::id(),
            'decided_at' => now(),
        ]);

        return redirect()->back()
                         ->with('success','Request Rejected');
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX - Get Categories By Expense Type
    |--------------------------------------------------------------------------
    */
    public function getCategories($expenseTypeId)
    {
        $categories = ExpenseCategory::where('expense_type_id', $expenseTypeId)
                        ->orderBy('category_name')
                        ->get();

        return response()->json($categories);
    }
}
