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

    .existing-receipt img {
        max-width: 120px;
        border-radius: 6px;
        margin-top: 10px;
    }
</style>

<div class="container">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fa-solid fa-wallet me-2"></i> AccoSys
        </a>
        <a href="{{ route('outcomes.index') }}" class="btn btn-sm btn-outline-light">
            Back to Outcomes
        </a>
    </div>
</nav>

<div class="card form-card">

    <div class="header-bg text-center">
        <h3 class="mb-0 fw-bold">
            <i class="fa-solid fa-pen-to-square me-2"></i>
            Edit Outcome Request
        </h3>
        <p class="mb-0 text-white-50">
            Update expense information
        </p>
    </div>

    <div class="card-body p-4">

        <form action="{{ route('outcomes.update',$outcome->id) }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Amount & Date --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number"
                               name="amount"
                               class="form-control form-control-lg"
                               value="{{ old('amount',$outcome->amount) }}"
                               required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Date</label>
                    <input type="date"
                           name="date"
                           class="form-control form-control-lg"
                           value="{{ old('date',$outcome->date) }}"
                           required>
                </div>
            </div>

            <hr class="text-muted">

            {{-- Expense Type --}}
            <label class="form-label fw-bold mb-2">Expense Type</label>
            <div class="row g-2 mb-3 type-selector">
                @foreach($expenseTypes as $type)
                    <div class="col-3">
                        <input type="radio"
                               class="btn-check"
                               name="expense_type_id"
                               id="type{{ $type->id }}"
                               value="{{ $type->id }}"
                               {{ $outcome->expense_type_id == $type->id ? 'checked' : '' }}>

                        <label class="btn btn-outline-primary w-100 py-3"
                               for="type{{ $type->id }}">
                            <i class="fa-solid fa-layer-group d-block mb-1"></i>
                            {{ $type->expense_type }}
                        </label>
                    </div>
                @endforeach
            </div>

            {{-- Category --}}
            <div class="bg-light p-3 rounded mb-3 border">
                <label class="form-label small text-muted">Expense Category</label>
                <select name="expense_category_id" class="form-select">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ $outcome->expense_category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Beneficiary --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Beneficiary (Paid To)</label>
                <input type="text"
                       name="beneficiary"
                       class="form-control"
                       value="{{ old('beneficiary',$outcome->beneficiary) }}">
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Description (Note)</label>
                <textarea name="description"
                          class="form-control"
                          rows="3">{{ old('description',$outcome->description) }}</textarea>
            </div>

            {{-- Existing Receipt --}}
            @if($outcome->receipt)
                <div class="mb-3 existing-receipt">
                    <label class="form-label fw-bold">Current Receipt</label><br>
                    <img src="{{ asset('storage/'.$outcome->receipt) }}">
                </div>
            @endif

            {{-- Upload New Receipt --}}
            <div class="mb-4">
                <label class="form-label fw-bold">Replace Receipt</label>
                <div class="upload-zone">
                    <i class="fa-solid fa-cloud-arrow-up fa-2x text-muted mb-2"></i>
                    <p class="mb-0 text-muted small">
                        Click to upload new image (optional)
                    </p>
                    <input type="file" name="receipt">
                </div>
            </div>

            <div class="d-grid">
                <button type="submit"
                        class="btn btn-primary btn-lg fw-bold">
                    Update Request
                </button>
            </div>

        </form>

    </div>
</div>

</div>

@endsection