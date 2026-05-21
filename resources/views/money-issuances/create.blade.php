@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Issue Money</h1>
            <p class="text-muted">Register a new money issuance for approval</p>
        </div>
        <a href="{{ route('money-issuances.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('money-issuances.store') }}" method="POST">
                        @csrf

                        <div class="form-section-title">Money Issuance Details</div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Issued To <span class="text-danger">*</span></label>
                                <input type="text" name="issued_to"
                                    class="form-control @error('issued_to') is-invalid @enderror"
                                    placeholder="Type recipient name or email"
                                    value="{{ old('issued_to') }}" required>
                                @error('issued_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="col-md-6">
                                <label class="form-label fw-bold">Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">IQ</span>
                                    <input type="number" name="amount" 
                                        class="form-control fw-bold @error('amount') is-invalid @enderror"
                                        placeholder="0.00" step="0.01" min="0" 
                                        value="{{ old('amount') }}" required>
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Issued Date <span class="text-danger">*</span></label>
                                <input type="date" name="issued_date" 
                                    class="form-control @error('issued_date') is-invalid @enderror"
                                    value="{{ old('issued_date', now()->format('Y-m-d')) }}" required>
                                @error('issued_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Reason <span class="text-danger">*</span></label>
                                <input type="text" name="reason" 
                                    class="form-control @error('reason') is-invalid @enderror"
                                    placeholder="e.g. Advance salary, Project payment, Bonus"
                                    value="{{ old('reason') }}" required>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="3" placeholder="Provide additional details about this issuance...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"
                                    rows="3" placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Note:</strong> This issuance will be created with <strong>Pending</strong> status and will require admin approval.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Register Issuance
                            </button>
                            <a href="{{ route('money-issuances.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection
