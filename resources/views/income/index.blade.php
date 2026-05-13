@extends('layouts.app')

@section('styles')
<style>
.card-income {
    border-left: 5px solid #10b981;
}

.btn-add-income {
    background-color: #10b981;
    color: white;
    font-weight: bold;
    border: none;
}

.btn-add-income:hover {
    background-color: #059669;
    color: white;
}
</style>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-dark">{{ __('messages.income_management') }}</h2>
        <p class="text-muted mb-0">{{ __('messages.track_all_incoming_payments') }}</p>
    </div>

    <button class="btn btn-add-income btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#addIncomeModal">
        <i class="fa-solid fa-plus me-2"></i> {{ __('messages.record_new_income') }}
    </button>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Summary Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 card-income p-3">
            <p class="text-muted small mb-1">{{ __('messages.total_income_this_month') }}</p>
            <h3 class="fw-bold text-success mb-0">
                IQ {{ number_format($totalThisMonth,2) }}
            </h3>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 p-3">
            <p class="text-muted small mb-1">{{ __('messages.last_month') }}</p>
            <h3 class="fw-bold text-dark mb-0">
                IQ {{ number_format($lastMonth,2) }}
            </h3>
        </div>
    </div>
</div>

{{-- Filter Section --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('income.index') }}">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                </div>
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control"
                        placeholder="{{ __('messages.search_by_donator') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100">
                        {{ __('messages.filter') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Transaction Table --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 fw-bold">
        <i class="fa-solid fa-list me-2 text-muted"></i> {{ __('messages.transaction_history') }}
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">{{ __('messages.date') }}</th>
                    <th>{{ __('messages.source_donator') }}</th>
                    <th>{{ __('messages.invoice_number_short') }}</th>
                    <th>{{ __('messages.description') }}</th>
                    <th>{{ __('messages.amount') }}</th>
                    <th class="text-end pe-4">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>

                @forelse($incomes as $income)
                <tr>
                    <td class="ps-4">
                        {{ \Carbon\Carbon::parse($income->received_date)->format('M d, Y') }}
                    </td>

                    <td class="fw-bold">
                        {{ $income->donator->full_name ?? '-' }}
                    </td>

                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $income->invoice_number }}
                        </span>
                    </td>

                    <td>{{ $income->description }}</td>

                    <td class="text-success fw-bold">
                        +IQ {{ number_format($income->amount,2) }}
                    </td>

                    <td class="text-end pe-4">

                        <a href="{{ route('income.show', $income->id) }}" class="btn btn-sm btn-light border"
                            title="View Invoice">
                            <i class="fa-solid fa-file-pdf text-danger"></i>
                        </a>

                        <a href="{{ route('income.edit', $income->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-pen"></i>
                        </a>

                        <form action="{{ route('income.destroy', $income->id) }}" method="POST"
                            class="d-inline js-delete-form"
                            data-confirm-text="This income will be permanently deleted.">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        No income records found.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

@include('income.partials.create-modal')

@endsection
