@extends('layouts.app')

@section('styles')
    <style>
        .form-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .page-title {
            color: #1e3a8a;
            font-weight: 700;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Edit Money Issuance</h1>
            <p class="text-muted">Modify issuance details (Pending only)</p>
        </div>
        <a href="{{ route('money-issuances.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('money-issuances.update', $moneyIssuance) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-section-title">Money Issuance Details</div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Issued To <span class="text-danger">*</span></label>
                                <input type="text" name="issued_to"
                                    class="form-control @error('issued_to') is-invalid @enderror"
                                    placeholder="Type recipient name or email"
                                    value="{{ old('issued_to', $moneyIssuance->issued_to) }}" required>
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
                                        value="{{ old('amount', $moneyIssuance->amount) }}" required>
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Issued Date <span class="text-danger">*</span></label>
                                <input type="date" name="issued_date" 
                                    class="form-control @error('issued_date') is-invalid @enderror"
                                    value="{{ old('issued_date', $moneyIssuance->issued_date->format('Y-m-d')) }}" required>
                                @error('issued_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Reason <span class="text-danger">*</span></label>
                                <input type="text" name="reason" 
                                    class="form-control @error('reason') is-invalid @enderror"
                                    placeholder="e.g. Advance salary, Project payment, Bonus"
                                    value="{{ old('reason', $moneyIssuance->reason) }}" required>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="3" placeholder="Provide additional details about this issuance...">{{ old('description', $moneyIssuance->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"
                                    rows="3" placeholder="Any additional notes...">{{ old('notes', $moneyIssuance->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-warning" role="alert">
                            <i class="fa-solid fa-triangle-exclamation"></i> 
                            <strong>Important:</strong> You can only edit issuances with <strong>Pending</strong> status.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-circle-check"></i> Update Issuance
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });
            }
        });
    </script>
@endsection
