@extends('layouts.app')

@section('content')

<style>
    body { background-color: #f3f4f6; }

    .form-card {
        max-width: 700px;
        margin: 50px auto;
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }

    .header-bg {
        background-color: #1e3a8a;
        color: white;
        border-radius: 12px 12px 0 0;
        padding: 25px;
    }

    .type-selector .btn-check:checked + .btn-outline-primary {
        background-color: #e0e7ff;
        color: #1e3a8a;
        border-color: #1e3a8a;
        font-weight: bold;
    }

    .upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        background-color: #f8fafc;
        transition: 0.2s;
        position: relative;
    }

    .upload-zone:hover {
        border-color: #1e3a8a;
        background-color: #eff6ff;
    }

    .upload-zone input {
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
    }
</style>

<div class="container">

    <div class="card form-card">

        <div class="header-bg text-center">
            <h3 class="mb-0 fw-bold">
                <i class="fa-solid fa-file-invoice-dollar me-2"></i>
                New Outcome Request
            </h3>
            <p class="mb-0 text-white-50">
                Submit an expense for admin approval
            </p>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('outcomes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Amount & Date -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="amount" class="form-control form-control-lg" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date</label>
                        <input type="date" name="date" class="form-control form-control-lg" required>
                    </div>
                </div>

                <hr>

                <!-- Expense Type -->
                <label class="form-label fw-bold mb-2">Expense Type</label>
                <div class="row g-2 mb-4 type-selector">
                    @foreach($expenseTypes as $type)
                        <div class="col-3">
                            <input type="radio"
                                   class="btn-check"
                                   name="expense_type_id"
                                   id="type{{ $type->id }}"
                                   value="{{ $type->id }}"
                                   onchange="loadCategories({{ $type->id }})">

                            <label class="btn btn-outline-primary w-100 py-3"
                                   for="type{{ $type->id }}">
                                {{ $type->expense_type }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Expense Category</label>
                    <select name="expense_category_id"
                            id="categoryDropdown"
                            class="form-select"
                            required>
                        <option value="">Select Category</option>
                    </select>
                </div>

                <!-- Beneficiary -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Beneficiary</label>
                    <input type="text" name="beneficiary" class="form-control">
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <!-- Upload -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Receipt Image</label>
                    <div class="upload-zone">
                        <p class="text-muted small mb-0">
                            Click to upload
                        </p>
                        <input type="file" name="receipt">
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">
                        Submit Request
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function loadCategories(expenseTypeId) {

        fetch('/get-categories/' + expenseTypeId)
            .then(response => response.json())
            .then(data => {

                let dropdown = document.getElementById('categoryDropdown');
                dropdown.innerHTML = '<option value="">Select Category</option>';

                data.forEach(category => {
                    dropdown.innerHTML +=
                        `<option value="${category.id}">
                            ${category.category_name}
                        </option>`;
                });
            });
    }
</script>

@endsection