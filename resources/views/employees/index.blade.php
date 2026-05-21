@extends('layouts.app')

@section('title', __('messages.employees'))

@section('styles')
<style>
.employee-table {
    min-width: 1500px;
}

.employee-table th,
.employee-table td {
    vertical-align: middle;
    white-space: nowrap;
}

.employee-table .employee-name,
.employee-table .employee-notes {
    white-space: normal;
}

.filter-section {
    margin-bottom: 20px;
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.filter-header h5 {
    margin: 0;
    font-weight: 600;
    color: #333;
}

.filter-controls {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
}

.filter-select {
    min-width: 200px;
}

.action-buttons {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.action-buttons button,
.action-buttons a {
    padding: 8px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
}

.btn-print {
    background-color: #1976d2;
    color: white;
}

.btn-print:hover {
    background-color: #1565c0;
}

.btn-export {
    background-color: #388e3c;
    color: white;
}

.btn-export:hover {
    background-color: #2e7d32;
}

@media print {
    .filter-section,
    .action-buttons {
        display: none;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">{{ __('messages.employees') }}</h2>
            <p class="text-muted mb-0">Manage employee profiles and payroll setup.</p>
        </div>

        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i> {{ __('messages.add_employee') }}
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm metric-card">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-uppercase text-muted fw-semibold mb-2">
                            {{ __('messages.total_employees') }}
                        </h6>
                        <h2 class="fw-bold mb-0">
                            {{ $totalEmployees }}
                        </h2>
                        <small class="text-muted">{{ $jobTitle ? "in '$jobTitle'" : 'All employees' }}</small>
                    </div>

                    <div class="metric-icon bg-primary-gradient">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Filter Section --}}
    <div class="filter-section">
        <div class="filter-header">
            <h5><i class="fa-solid fa-filter me-2"></i> Filter by Job Title</h5>
        </div>

        <form method="GET" class="filter-controls">
            <select name="job_title" class="form-select filter-select">
                <option value="">All Job Titles</option>
                @foreach($jobTitles as $title)
                    <option value="{{ $title }}" {{ $jobTitle === $title ? 'selected' : '' }}>
                        {{ $title }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-outline-primary">
                <i class="fa-solid fa-magnifying-glass me-2"></i> Filter
            </button>

            @if($jobTitle)
            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-x me-2"></i> Clear Filter
            </a>
            @endif
        </form>
    </div>

    {{-- Action Buttons --}}
    <div class="action-buttons">
        <button class="btn-print" onclick="window.print()">
            <i class="fa-solid fa-print me-2"></i> Print
        </button>
        <a href="{{ route('employees.export', request()->query()) }}" class="btn-export">
            <i class="fa-solid fa-download me-2"></i> Export to CSV
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 employee-table">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">{{ __('messages.full_name') }}</th>
                            <th class="py-3">{{ __('messages.job_title') }}</th>
                            <th class="py-3">{{ __('messages.gender') }}</th>
                            <th class="py-3">Date of Birth</th>
                            <th class="py-3">Phone</th>
                            <th class="py-3">Email</th>
                            <th class="py-3 text-end">{{ __('messages.salary') }}</th>
                            <th class="py-3">{{ __('messages.join_date') }}</th>
                            <th class="py-3">{{ __('messages.employment_status') }}</th>
                            <th class="py-3">{{ __('messages.payment_method') }}</th>
                            <th class="py-3">Bank Details</th>
                            <th class="py-3">{{ __('messages.documents') }}</th>
                            <th class="py-3 text-center pe-4">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($employees as $employee)
                        <tr>
                            <td class="px-4 py-3 employee-name">
                                <div class="fw-bold">{{ $employee->full_name }}</div>
                            </td>

                            <td class="py-3">{{ $employee->job_title ?: 'Not specified' }}</td>
                            <td class="py-3 text-capitalize">{{ $employee->gender ?: 'Not specified' }}</td>

                            <td class="py-3">
                                {{ $employee->date_of_birth ? \Carbon\Carbon::parse($employee->date_of_birth)->format('M d, Y') : 'Not specified' }}
                            </td>

                            <td class="py-3">{{ $employee->phone_number ?: 'Not specified' }}</td>
                            <td class="py-3">{{ $employee->email ?: 'No email provided' }}</td>

                            <td class="py-3 text-end">
                                IQ {{ number_format($employee->base_monthly_salary, 2) }}
                            </td>

                            <td class="py-3">
                                {{ \Carbon\Carbon::parse($employee->join_date)->format('M d, Y') }}
                            </td>

                            <td class="py-3">
                                <span class="badge bg-secondary text-uppercase">
                                    {{ str_replace('_', ' ', $employee->employment_status) }}
                                </span>
                            </td>

                            <td class="py-3 text-capitalize">
                                {{ $employee->payment_method }}
                            </td>

                            <td class="py-3 employee-notes">
                                {{ $employee->bank_details ?: 'No details provided' }}
                            </td>

                            <td class="py-3">
                                @if($employee->document_path)
                                <a href="{{ asset('storage/' . $employee->document_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="fa-solid fa-file-lines"></i>
                                </a>
                                @else
                                <span class="text-muted">No file</span>
                                @endif
                            </td>

                            <td class="py-3 text-center pe-4">
                                <a href="{{ route('employees.print', ['id' => $employee->id]) }}"
                                    class="btn btn-sm btn-outline-info me-1" target="_blank"
                                    title="Print">
                                    <i class="fa-solid fa-print"></i>
                                </a>

                                <a href="{{ route('employees.edit', $employee) }}"
                                    class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('employees.destroy', $employee) }}" method="POST"
                                    class="d-inline js-delete-form" data-confirm-title="Delete employee?"
                                    data-confirm-text="This employee profile will be permanently deleted."
                                    data-confirm-button="Yes, delete">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="13" class="text-center text-muted py-5">
                                No employees found. Add the first employee profile to get started.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection
