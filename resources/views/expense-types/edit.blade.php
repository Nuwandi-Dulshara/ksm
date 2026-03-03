@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('expense-types.index') }}"
           class="btn btn-outline-secondary me-3 rounded-circle"
           style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold text-dark mb-0">Edit Expense Type</h2>
            <p class="text-muted mb-0">Update expense category.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="{{ route('expense-types.update', $expenseType->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <div class="form-section-title">Expense Type Information</div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Expense Type</label>
                                <input type="text"
                                       name="expense_type"
                                       class="form-control"
                                       value="{{ $expenseType->expense_type }}"
                                       required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('expense-types.index') }}" class="btn btn-light border">Cancel</a>
                            <button type="submit" class="btn btn-primary fw-bold px-4">
                                <i class="fa-solid fa-save me-2"></i> Update Expense Type
                            </button>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection