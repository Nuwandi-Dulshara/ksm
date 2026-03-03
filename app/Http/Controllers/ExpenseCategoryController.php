<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ExpenseCategory::with('expenseType')->latest()->get();

        return view('expense-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $expenseTypes = ExpenseType::all();

        return view('expense-categories.create', compact('expenseTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'expense_type_id' => 'required|exists:expense_types,id',
            'category_name'   => 'required|string|max:255',
        ]);

        ExpenseCategory::create([
            'expense_type_id' => $request->expense_type_id,
            'category_name'   => $request->category_name,
        ]);

        return redirect()->route('expense-categories.index')
                         ->with('success', 'Expense Category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        $expenseTypes = ExpenseType::all();

        return view('expense-categories.edit', compact('expenseCategory', 'expenseTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $request->validate([
            'expense_type_id' => 'required|exists:expense_types,id',
            'category_name'   => 'required|string|max:255',
        ]);

        $expenseCategory->update([
            'expense_type_id' => $request->expense_type_id,
            'category_name'   => $request->category_name,
        ]);

        return redirect()->route('expense-categories.index')
                         ->with('success', 'Expense Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();

        return redirect()->route('expense-categories.index')
                         ->with('success', 'Expense Category deleted successfully.');
    }
}