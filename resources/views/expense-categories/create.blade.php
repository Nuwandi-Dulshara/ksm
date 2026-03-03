@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('expense-categories.index') }}"
       class="btn btn-outline-secondary me-3 rounded-circle"
       style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h2 class="fw-bold mb-0">Add Expense Category</h2>
        <p class="text-muted mb-0">Create category under selected expense type.</p>
    </div>
</div>

<div class="row justify-content-center">
<div class="col-lg-8">

<form action="{{ route('expense-categories.store') }}" method="POST">
@csrf

<div class="card shadow-sm border-0">
<div class="card-body p-4">

<div class="form-section-title">Category Information</div>

<div class="row g-3">

<div class="col-md-12">
<label class="form-label fw-bold">Expense Type</label>
<select name="expense_type_id" class="form-select" required>
<option value="">Select Expense Type</option>
@foreach($expenseTypes as $type)
<option value="{{ $type->id }}">{{ $type->expense_type }}</option>
@endforeach
</select>
</div>

<div class="col-md-12">
<label class="form-label fw-bold">Expense Category</label>
<input type="text" name="category_name"
class="form-control"
placeholder="Enter category name" required>
</div>

</div>

<div class="d-flex justify-content-end gap-2 mt-4">
<a href="{{ route('expense-categories.index') }}" class="btn btn-light border">Cancel</a>
<button type="submit" class="btn btn-primary fw-bold px-4">
<i class="fa-solid fa-save me-2"></i> Save Category
</button>
</div>

</div>
</div>

</form>

</div>
</div>
</div>

@endsection