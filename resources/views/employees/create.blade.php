@extends('layouts.app')

@section('title', 'Add New Employee')

@section('styles')
<style>
.form-section-title {
    font-size: 0.85rem;
    font-weight: bold;
    text-transform: uppercase;
    color: #6c757d;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 5px;
    margin-bottom: 15px;
    margin-top: 20px;
}
</style>
@endsection

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary me-3 rounded-circle"
        style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h2 class="fw-bold text-dark mb-0">Add New Employee</h2>
        <p class="text-muted mb-0">Create a profile to track salary and attendance.</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <div class="form-section-title">Personal Information</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="full_name" class="form-control" placeholder="e.g. Sarah Smith"
                                value="{{ old('full_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Job Title / Position</label>
                            <input type="text" name="job_title" class="form-control" placeholder="e.g. HR Manager"
                                value="{{ old('job_title') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Gender</label>
                            <select name="gender" class="form-select">
                                <option selected disabled value="">Select Gender...</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control"
                                value="{{ old('date_of_birth') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Phone Number</label>
                            <input type="tel" name="phone_number" class="form-control" placeholder="+964 ..."
                                value="{{ old('phone_number') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="email@company.com"
                                value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-section-title">Financial Details (Salary)</div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-success">Base Monthly Salary</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="base_monthly_salary" class="form-control fw-bold"
                                    placeholder="0.00" step="0.01" min="0" value="{{ old('base_monthly_salary') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Join Date</label>
                            <input type="date" name="join_date" class="form-control" value="{{ old('join_date') }}"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Employment Status</label>
                            <select name="employment_status" class="form-select">
                                <option value="active"
                                    {{ old('employment_status', 'active') === 'active' ? 'selected' : '' }}>
                                    Active (Full Time)
                                </option>
                                <option value="probation"
                                    {{ old('employment_status') === 'probation' ? 'selected' : '' }}>
                                    Probation Period
                                </option>
                                <option value="part_time"
                                    {{ old('employment_status') === 'part_time' ? 'selected' : '' }}>
                                    Part Time
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-section-title">Payment Info (Private)</div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="payment_method" id="payCash"
                                    value="cash" {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }}>
                                <label class="form-check-label" for="payCash">Cash Payment</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="payment_method" id="payBank"
                                    value="bank" {{ old('payment_method') === 'bank' ? 'checked' : '' }}>
                                <label class="form-check-label" for="payBank">Bank Transfer</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-muted small">Bank Details / IBAN / Notes</label>
                            <textarea name="bank_details" class="form-control" rows="2"
                                placeholder="e.g. FIB Bank, Account: 1234-5678...">{{ old('bank_details') }}</textarea>
                        </div>
                    </div>

                    <div class="form-section-title">Documents</div>
                    <div class="mb-4">
                        <label class="form-label text-muted small">Upload ID Card or Contract
                            (PDF/Image)</label>
                        <input type="file" name="document" class="form-control">
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('employees.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="fa-solid fa-save me-2"></i> Save Employee Profile
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection