<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Donator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class IncomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Income::with('donator');

        // Filter by Month
        if ($request->filled('month')) {
            $month = Carbon::parse($request->month);

            $query->whereMonth('received_date', $month->month)
                  ->whereYear('received_date', $month->year);
        }

        // Search by Invoice or Donator Name
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('donator', function ($d) use ($search) {
                      $d->where('full_name', 'like', "%{$search}%");
                  });
            });
        }

        $incomes = $query->latest()->get();

        // Summary Cards
        $totalThisMonth = Income::whereMonth('received_date', now()->month)
            ->whereYear('received_date', now()->year)
            ->sum('amount');

        $lastMonth = Income::whereMonth('received_date', now()->subMonth()->month)
            ->whereYear('received_date', now()->subMonth()->year)
            ->sum('amount');

        $donators = Donator::all();

        return view('income.index', compact(
            'incomes',
            'totalThisMonth',
            'lastMonth',
            'donators'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'donator_id'    => 'required|exists:donators,id',
            'amount'        => 'required|numeric|min:0',
            'invoice_number' => 'required|unique:incomes,invoice_number',
            'received_date' => 'required|date',
            'invoice_file'   => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp|max:5120',
        ]);

        $filePath = null;

        if ($request->hasFile('invoice_file')) {
            $filePath = $request->file('invoice_file')
                ->store('invoices', 'public');
        }

        Income::create([
            'donator_id'     => $request->donator_id,
            'amount'         => $request->amount,
            'invoice_number' => $request->invoice_number,
            'received_date'  => $request->received_date,
            'description'    => $request->description,
            'invoice_file'   => $filePath,
        ]);

        return redirect()->route('income.index')
            ->with('success', 'Income recorded successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(Income $income)
    {
        $income->load('donator');

        return view('income.invoice', compact('income'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Income $income)
    {
        $donators = Donator::all();

        return view('income.edit', compact('income', 'donators'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Income $income)
    {
        $request->validate([
            'donator_id'     => 'required|exists:donators,id',
            'amount'         => 'required|numeric|min:0',
            'invoice_number' => 'required|unique:incomes,invoice_number,' . $income->id,
            'received_date'  => 'required|date',
            'invoice_file'   => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp|max:5120',
        ]);

        $updateData = [
            'donator_id'     => $request->donator_id,
            'amount'         => $request->amount,
            'invoice_number' => $request->invoice_number,
            'received_date'  => $request->received_date,
            'description'    => $request->description,
        ];

        if ($request->hasFile('invoice_file')) {
            if ($income->invoice_file && Storage::disk('public')->exists($income->invoice_file)) {
                Storage::disk('public')->delete($income->invoice_file);
            }

            $updateData['invoice_file'] = $request->file('invoice_file')
                ->store('invoices', 'public');
        }

        $income->update($updateData);

        return redirect()->route('income.index')
            ->with('success', 'Income updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Income $income)
    {
        if ($income->invoice_file && Storage::disk('public')->exists($income->invoice_file)) {
            Storage::disk('public')->delete($income->invoice_file);
        }

        $income->delete();

        return redirect()->route('income.index')
            ->with('success', 'Income deleted successfully.');
    }

}
