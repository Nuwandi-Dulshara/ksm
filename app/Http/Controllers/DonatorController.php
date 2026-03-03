<?php

namespace App\Http\Controllers;

use App\Models\Donator;
use Illuminate\Http\Request;

class DonatorController extends Controller
{
    public function index()
    {
        $donators = Donator::latest()->get();
        $totalDonators = Donator::count();

        return view('donators.index', compact('donators', 'totalDonators'));
    }

    public function create()
    {
        return view('donators.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        Donator::create($request->all());

        return redirect()->route('donators.index')
            ->with('success', 'Donator registered successfully.');
    }

    public function edit(Donator $donator)
    {
        return view('donators.edit', compact('donator'));
    }

    public function update(Request $request, Donator $donator)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $donator->update($request->all());

        return redirect()->route('donators.index')
            ->with('success', 'Donator updated successfully.');
    }

    public function destroy(Donator $donator)
    {
        $donator->delete();

        return redirect()->route('donators.index')
            ->with('success', 'Donator deleted successfully.');
    }
}