<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    public function index()
    {
        $expenseTypes = ExpenseType::latest()->get();
        return view('expense-types.index', compact('expenseTypes'));
    }

    public function create()
    {
        return view('expense-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_type' => 'required|string|max:255'
        ]);

        ExpenseType::create($request->all());

        return redirect()->route('expense-types.index')
            ->with('success', 'Expense Type created successfully.');
    }

    public function edit(ExpenseType $expenseType)
    {
        return view('expense-types.edit', compact('expenseType'));
    }

    public function update(Request $request, ExpenseType $expenseType)
    {
        $request->validate([
            'expense_type' => 'required|string|max:255'
        ]);

        $expenseType->update($request->all());

        return redirect()->route('expense-types.index')
            ->with('success', 'Expense Type updated successfully.');
    }

    public function destroy(ExpenseType $expenseType)
    {
        $expenseType->delete();

        return redirect()->route('expense-types.index')
            ->with('success', 'Expense Type deleted successfully.');
    }
}