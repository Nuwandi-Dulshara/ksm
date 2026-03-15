<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->get();
        $totalEmployees = Employee::count();

        return view('employees.index', compact('employees', 'totalEmployees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateEmployee($request);

        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('employees/documents', 'public');
        }

        unset($validated['document']);

        Employee::create($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee profile saved successfully.');
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $this->validateEmployee($request, $employee);

        if ($request->hasFile('document')) {
            if ($employee->document_path && Storage::disk('public')->exists($employee->document_path)) {
                Storage::disk('public')->delete($employee->document_path);
            }

            $validated['document_path'] = $request->file('document')->store('employees/documents', 'public');
        }

        unset($validated['document']);

        $employee->update($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee profile updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->document_path && Storage::disk('public')->exists($employee->document_path)) {
            Storage::disk('public')->delete($employee->document_path);
        }

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee profile deleted successfully.');
    }

    private function validateEmployee(Request $request, ?Employee $employee = null): array
    {
        return $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'in:male,female'],
            'date_of_birth' => ['nullable', 'date'],
            'phone_number' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255', 'unique:employees,email,' . ($employee?->id ?? 'NULL')],
            'base_monthly_salary' => ['required', 'numeric', 'min:0'],
            'join_date' => ['required', 'date'],
            'employment_status' => ['required', 'in:active,probation,part_time'],
            'payment_method' => ['required', 'in:cash,bank'],
            'bank_details' => ['nullable', 'string'],
            'document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);
    }
}
