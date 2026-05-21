@extends('layouts.app')

@section('title', __('messages.employees'))

@section('styles')
<style>
    .job-title-section {
        margin-bottom: 40px;
    }

    .job-title-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border-radius: 12px 12px 0 0;
        margin-bottom: 0;
    }

    .job-title-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 18px;
    }

    .job-title-header .employee-count {
        font-size: 12px;
        opacity: 0.9;
        margin-top: 5px;
    }

    .employee-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 15px;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 0 0 12px 12px;
    }

    .employee-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 4px solid #667eea;
    }

    .employee-card:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .employee-card-header {
        margin-bottom: 15px;
        border-bottom: 1px solid #eee;
        padding-bottom: 12px;
    }

    .employee-name {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin: 0 0 8px 0;
    }

    .employee-status {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 10px;
        border-radius: 20px;
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .employee-status.part_time {
        background-color: #fff3e0;
        color: #e65100;
    }

    .employee-status.probation {
        background-color: #f3e5f5;
        color: #6a1b9a;
    }

    .employee-info {
        font-size: 13px;
        line-height: 1.8;
        color: #666;
    }

    .employee-info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .employee-info-label {
        font-weight: 600;
        color: #555;
        min-width: 80px;
    }

    .employee-info-value {
        color: #333;
        text-align: right;
    }

    .employee-salary {
        background-color: #e3f2fd;
        padding: 10px;
        border-radius: 6px;
        margin-top: 10px;
        text-align: center;
        font-weight: 600;
        color: #1565c0;
    }

    .employee-actions {
        display: flex;
        gap: 8px;
        margin-top: 15px;
        padding-top: 12px;
        border-top: 1px solid #eee;
    }

    .employee-actions button,
    .employee-actions a {
        flex: 1;
        padding: 6px 8px;
        font-size: 12px;
        border-radius: 6px;
    }

    .filter-section {
        margin-bottom: 30px;
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

    .action-buttons button {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
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

    .no-employees {
        text-align: center;
        padding: 40px;
        color: #999;
    }

    .no-employees i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    @media print {
        .filter-section,
        .action-buttons {
            display: none;
        }

        .employee-cards {
            background-color: white;
        }

        .employee-card {
            page-break-inside: avoid;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">{{ __('messages.employees') }}</h2>
            <p class="text-muted mb-0">Manage and view employee profiles organized by job title.</p>
        </div>

        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i> {{ __('messages.add_employee') }}
        </a>
    </div>

    {{-- Summary Card --}}
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

    {{-- Success Message --}}
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
        <a href="{{ route('employees.export', request()->query()) }}" class="btn-export" style="text-decoration: none; display: inline-block;">
            <i class="fa-solid fa-download me-2"></i> Export to CSV
        </a>
    </div>

    {{-- Employee Cards Grouped by Job Title --}}
    @if($employeesByTitle->isEmpty())
        <div class="no-employees">
            <i class="fa-solid fa-inbox"></i>
            <h4>No Employees Found</h4>
            <p>{{ $jobTitle ? "No employees with job title '$jobTitle'" : 'Add the first employee profile to get started.' }}</p>
        </div>
    @else
        @foreach($employeesByTitle as $title => $titleEmployees)
        <div class="job-title-section">
            <div class="job-title-header">
                <h4>
                    <i class="fa-solid fa-briefcase me-2"></i>
                    {{ $title ?? 'Not Specified' }}
                </h4>
                <div class="employee-count">
                    {{ $titleEmployees->count() }} {{ $titleEmployees->count() === 1 ? 'employee' : 'employees' }}
                </div>
            </div>

            <div class="employee-cards">
                @foreach($titleEmployees as $employee)
                <div class="employee-card">
                    <div class="employee-card-header">
                        <h5 class="employee-name">{{ $employee->full_name }}</h5>
                        <span class="employee-status {{ str_replace(' ', '_', strtolower($employee->employment_status)) }}">
                            {{ str_replace('_', ' ', $employee->employment_status) }}
                        </span>
                    </div>

                    <div class="employee-info">
                        <div class="employee-info-row">
                            <span class="employee-info-label">Gender:</span>
                            <span class="employee-info-value text-capitalize">{{ $employee->gender ?? 'N/A' }}</span>
                        </div>

                        <div class="employee-info-row">
                            <span class="employee-info-label">Email:</span>
                            <span class="employee-info-value" style="text-align: left; font-size: 12px;">{{ $employee->email ?? 'No email' }}</span>
                        </div>

                        <div class="employee-info-row">
                            <span class="employee-info-label">Phone:</span>
                            <span class="employee-info-value">{{ $employee->phone_number ?? 'N/A' }}</span>
                        </div>

                        <div class="employee-info-row">
                            <span class="employee-info-label">Join Date:</span>
                            <span class="employee-info-value">
                                {{ \Carbon\Carbon::parse($employee->join_date)->format('M d, Y') }}
                            </span>
                        </div>

                        <div class="employee-salary">
                            IQ {{ number_format($employee->base_monthly_salary, 2) }}/month
                        </div>
                    </div>

                    <div class="employee-actions">
                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>

                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-contents js-delete-form"
                            data-confirm-title="Delete employee?" 
                            data-confirm-text="This employee profile will be permanently deleted."
                            data-confirm-button="Yes, delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection
