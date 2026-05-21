<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $jobTitle = $request->query('job_title');
        $query = Employee::latest();
        
        if ($jobTitle) {
            $query->where('job_title', $jobTitle);
        }
        
        $employees = $query->get();
        $totalEmployees = Employee::count();
        
        // Get unique job titles for filter
        $jobTitles = Employee::select('job_title')
            ->distinct()
            ->whereNotNull('job_title')
            ->orderBy('job_title')
            ->pluck('job_title');
        
        // Group employees by job title
        $employeesByTitle = $employees->groupBy('job_title')->sort();

        return view('employees.index', compact(
            'employees', 
            'totalEmployees', 
            'jobTitles',
            'employeesByTitle',
            'jobTitle'
        ));
    }

    public function print(Request $request)
    {
        $employeeId = $request->query('id');
        
        if ($employeeId) {
            // Print individual employee
            $employee = Employee::findOrFail($employeeId);
            return view('employees.print-individual', compact('employee'));
        }

        // Print all or filtered employees
        $jobTitle = $request->query('job_title');
        $query = Employee::latest();
        
        if ($jobTitle) {
            $query->where('job_title', $jobTitle);
        }
        
        $employees = $query->get();
        $jobTitles = Employee::select('job_title')
            ->distinct()
            ->whereNotNull('job_title')
            ->pluck('job_title');

        return view('employees.print', compact('employees', 'jobTitle', 'jobTitles'));
    }

    public function export(Request $request)
    {
        $jobTitle = $request->query('job_title');
        $query = Employee::latest();
        
        if ($jobTitle) {
            $query->where('job_title', $jobTitle);
        }
        
        $employees = $query->get();

        // Create CSV content
        $csvContent = "Full Name,Job Title,Gender,Date of Birth,Phone,Email,Salary,Join Date,Employment Status,Payment Method,Bank Details\n";
        
        foreach ($employees as $employee) {
            $csvContent .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                $this->escapeCsv($employee->full_name),
                $this->escapeCsv($employee->job_title ?? ''),
                $this->escapeCsv($employee->gender ?? ''),
                $employee->date_of_birth ? date('M d, Y', strtotime($employee->date_of_birth)) : '',
                $this->escapeCsv($employee->phone_number ?? ''),
                $this->escapeCsv($employee->email ?? ''),
                $employee->base_monthly_salary,
                date('M d, Y', strtotime($employee->join_date)),
                str_replace('_', ' ', $employee->employment_status),
                $this->escapeCsv($employee->payment_method),
                $this->escapeCsv($employee->bank_details ?? '')
            );
        }

        $filename = 'employees' . ($jobTitle ? '_' . str_slug($jobTitle) : '') . '_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(
            function () use ($csvContent) {
                echo $csvContent;
            },
            $filename,
            ['Content-Type' => 'text/csv; charset=UTF-8']
        );
    }

    private function escapeCsv($value)
    {
        return str_replace('"', '""', (string)$value);
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
