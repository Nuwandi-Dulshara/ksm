<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FreelancerController extends Controller
{
    public function index(Request $request)
    {
        $query = Freelancer::query()->latest();

        if ($request->filled('search')) {
            $search = $request->string('search');

            $query->where(function ($builder) use ($search) {
                $builder->where('full_name', 'like', "%{$search}%")
                    ->orWhere('service_skill', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $freelancers = $query->get();
        $totalFreelancers = Freelancer::count();
        $xakveenCount = Freelancer::where('category', 'xakveen')->where('status', '!=', 'inactive')->count();
        $pagesCount = Freelancer::where('category', 'pages')->where('status', '!=', 'inactive')->count();

        return view('freelancers.index', compact(
            'freelancers',
            'totalFreelancers',
            'xakveenCount',
            'pagesCount'
        ));
    }

    public function create()
    {
        return view('freelancers.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateFreelancer($request);

        if ($request->hasFile('contract')) {
            $validated['contract_path'] = $request->file('contract')->store('freelancers/contracts', 'public');
        }

        unset($validated['contract']);

        Freelancer::create($validated);

        return redirect()
            ->route('freelancers.index')
            ->with('success', 'Freelancer profile saved successfully.');
    }

    public function edit(Freelancer $freelancer)
    {
        return view('freelancers.edit', compact('freelancer'));
    }

    public function update(Request $request, Freelancer $freelancer)
    {
        $validated = $this->validateFreelancer($request, $freelancer);

        if ($request->hasFile('contract')) {
            if ($freelancer->contract_path && Storage::disk('public')->exists($freelancer->contract_path)) {
                Storage::disk('public')->delete($freelancer->contract_path);
            }

            $validated['contract_path'] = $request->file('contract')->store('freelancers/contracts', 'public');
        }

        unset($validated['contract']);

        $freelancer->update($validated);

        return redirect()
            ->route('freelancers.index')
            ->with('success', 'Freelancer profile updated successfully.');
    }

    public function destroy(Freelancer $freelancer)
    {
        if ($freelancer->contract_path && Storage::disk('public')->exists($freelancer->contract_path)) {
            Storage::disk('public')->delete($freelancer->contract_path);
        }

        $freelancer->delete();

        return redirect()
            ->route('freelancers.index')
            ->with('success', 'Freelancer profile deleted successfully.');
    }

    private function validateFreelancer(Request $request, ?Freelancer $freelancer = null): array
    {
        return $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:xakveen,pages'],
            'service_skill' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255', 'unique:freelancers,email,' . ($freelancer?->id ?? 'NULL')],
            'billing_rate' => ['required', 'numeric', 'min:0'],
            'rate_type' => ['required', 'in:hourly,project,monthly,article,post'],
            'status' => ['required', 'in:active,busy,inactive'],
            'payment_details' => ['nullable', 'string'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
            'contract' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:5120'],
        ]);
    }
}
