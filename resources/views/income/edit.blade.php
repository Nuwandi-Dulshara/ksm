@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('income.index') }}" class="btn btn-outline-secondary me-3 rounded-circle"
            style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold text-dark mb-0">Edit Income</h2>
            <p class="text-muted mb-0">Update income details and attachment.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="{{ route('income.update', $income->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <div class="form-section-title">Income Information</div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Amount Received</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="amount" class="form-control"
                                        value="{{ old('amount', $income->amount) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Client / Source</label>
                                <select name="donator_id" class="form-select" required>
                                    <option value="">Select Donator</option>
                                    @foreach($donators as $donator)
                                    <option value="{{ $donator->id }}"
                                        {{ old('donator_id', $income->donator_id) == $donator->id ? 'selected' : '' }}>
                                        {{ $donator->full_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Invoice Number</label>
                                <input type="text" name="invoice_number" class="form-control"
                                    value="{{ old('invoice_number', $income->invoice_number) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Date Received</label>
                                <input type="date" name="received_date" class="form-control"
                                    value="{{ old('received_date', \Illuminate\Support\Carbon::parse($income->received_date)->format('Y-m-d')) }}"
                                    required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" class="form-control"
                                    rows="3">{{ old('description', $income->description) }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Attach Invoice (PDF/Img)</label>
                                <input type="file" name="invoice_file" class="form-control">
                                <small class="text-muted d-block mt-2">Upload a new file only if you want to replace the
                                    current attachment.</small>
                            </div>

                            @if($income->invoice_file)
                            <div class="col-12">
                                <div class="border rounded-3 p-3 bg-light">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                        <div>
                                            <div class="fw-bold text-dark">Current Attachment</div>
                                            <small class="text-muted">The existing file will remain unless you upload a
                                                new one.</small>
                                        </div>
                                        <a href="{{ asset('storage/' . $income->invoice_file) }}" target="_blank"
                                            class="btn btn-outline-success btn-sm">
                                            <i class="fa-solid fa-file-arrow-down me-1"></i> View Current File
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('income.index') }}" class="btn btn-light border">Cancel</a>
                            <button type="submit" class="btn btn-primary fw-bold px-4">
                                <i class="fa-solid fa-save me-2"></i> Update Income
                            </button>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection