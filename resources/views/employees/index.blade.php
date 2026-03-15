@extends('layouts.app')

@section('title', 'Employees')

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
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Employees</h2>
            <p class="text-muted mb-0">Manage employee profiles and payroll setup.</p>
        </div>

        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i> Add Employee
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm metric-card">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-uppercase text-muted fw-semibold mb-2">
                            Total Employees
                        </h6>
                        <h2 class="fw-bold mb-0">
                            {{ $totalEmployees }}
                        </h2>
                        <small class="text-muted">Registered employees</small>
                    </div>

                    <div class="metric-icon bg-primary-gradient">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 employee-table">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Full Name</th>
                            <th class="py-3">Job Title</th>
                            <th class="py-3">Gender</th>
                            <th class="py-3">Date of Birth</th>
                            <th class="py-3">Phone</th>
                            <th class="py-3">Email</th>
                            <th class="py-3 text-end">Salary</th>
                            <th class="py-3">Join Date</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Payment Method</th>
                            <th class="py-3">Bank Details</th>
                            <th class="py-3">Document</th>
                            <th class="py-3 text-center pe-4">Action</th>
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
                            <td class="py-3 text-end">${{ number_format($employee->base_monthly_salary, 2) }}</td>
                            <td class="py-3">{{ \Carbon\Carbon::parse($employee->join_date)->format('M d, Y') }}</td>
                            <td class="py-3">
                                <span class="badge bg-secondary text-uppercase">
                                    {{ str_replace('_', ' ', $employee->employment_status) }}
                                </span>
                            </td>
                            <td class="py-3 text-capitalize">{{ $employee->payment_method }}</td>
                            <td class="py-3 employee-notes">{{ $employee->bank_details ?: 'No details provided' }}</td>
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
                                <a href="{{ route('employees.edit', $employee) }}"
                                    class="btn btn-sm btn-outline-primary me-1" title="Edit employee">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('employees.destroy', $employee) }}" method="POST"
                                    class="d-inline js-delete-form"
                                    data-confirm-title="Delete employee?"
                                    data-confirm-text="This employee profile will be permanently deleted."
                                    data-confirm-button="Yes, delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        title="Delete employee">
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
