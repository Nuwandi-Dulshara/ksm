<?php

namespace App\Http\Controllers;

use App\Models\FreelanceCategory;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FreelanceCategoryController extends Controller
{
    public function index()
    {
        $categories = FreelanceCategory::withCount('freelancers')->latest()->get();

        return view('freelance-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('freelance-categories.create', [
            'category' => null,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateCategory($request);
        $validated['slug'] = $this->normalizeSlug($validated['slug'] ?? $validated['name']);

        FreelanceCategory::create($validated);

        return redirect()
            ->route('freelance-categories.index')
            ->with('success', 'Freelance category created successfully.');
    }

    public function edit(FreelanceCategory $freelanceCategory)
    {
        return view('freelance-categories.edit', [
            'category' => $freelanceCategory,
        ]);
    }

    public function update(Request $request, FreelanceCategory $freelanceCategory)
    {
        $validated = $this->validateCategory($request, $freelanceCategory);
        $validated['slug'] = $this->normalizeSlug($validated['slug'] ?? $validated['name']);
        $oldSlug = $freelanceCategory->slug;

        DB::transaction(function () use ($freelanceCategory, $validated, $oldSlug) {
            $freelanceCategory->update($validated);

            if ($oldSlug !== $validated['slug']) {
                Freelancer::where('category', $oldSlug)->update([
                    'category' => $validated['slug'],
                ]);
            }
        });

        return redirect()
            ->route('freelance-categories.index')
            ->with('success', 'Freelance category updated successfully.');
    }

    public function destroy(FreelanceCategory $freelanceCategory)
    {
        if ($freelanceCategory->freelancers()->exists()) {
            return redirect()
                ->route('freelance-categories.index')
                ->with('error', 'This category is assigned to freelancers and cannot be deleted.');
        }

        $freelanceCategory->delete();

        return redirect()
            ->route('freelance-categories.index')
            ->with('success', 'Freelance category deleted successfully.');
    }

    private function validateCategory(Request $request, ?FreelanceCategory $category = null): array
    {
        $slug = $this->normalizeSlug($request->input('slug') ?: $request->input('name'));

        $request->merge(['slug' => $slug]);

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('freelance_categories', 'slug')->ignore($category?->id),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:active,inactive'],
        ]);
    }

    private function normalizeSlug(string $value): string
    {
        return Str::slug($value);
    }
}
