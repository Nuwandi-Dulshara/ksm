@extends('layouts.app')

@section('content')

<style>
    body { background-color: #f8f9fa; }

    .card-outcome {
        border-left: 5px solid #dc3545;
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Outcome Log</h2>
            <p class="text-muted mb-0">
                Track all expenses, purchases, and salaries.
            </p>
        </div>

        <a href="{{ route('outcomes.create') }}"
           class="btn btn-danger btn-lg shadow-sm fw-bold">
            <i class="fa-solid fa-minus me-2"></i> New Expense
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-4 mb-4">

        {{-- Total Spent --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 card-outcome p-3">
                <p class="text-muted small mb-1">Total Spent</p>
                <h3 class="fw-bold text-danger mb-0">
                    -${{ number_format($outcomes->sum('amount'),2) }}
                </h3>
            </div>
        </div>

        {{-- Pending --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3">
                <p class="text-muted small mb-1">Pending Approval</p>
                <h3 class="fw-bold text-warning mb-0">
                    -${{ number_format($outcomes->where('status','pending')->sum('amount'),2) }}
                </h3>
            </div>
        </div>

        {{-- Top Category --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3">
                <p class="text-muted small mb-1">Top Category</p>

                @php
                    $topCategory = $outcomes
                        ->filter(function($o){
                            return $o->expenseCategory;
                        })
                        ->groupBy(function($o){
                            return $o->expenseCategory->category_name;
                        })
                        ->sortByDesc(function($group){
                            return $group->count();
                        })
                        ->keys()
                        ->first();
                @endphp

                <h5 class="fw-bold text-dark mb-0">
                    {{ $topCategory ?? 'N/A' }}
                </h5>
            </div>
        </div>

    </div>


    {{-- Filters (3 Filters Exactly Like Frontend) --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <div class="row g-2">

                {{-- Category --}}
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">All Categories</option>
                        @foreach($outcomes->pluck('expenseCategory.category_name')->unique() as $cat)
                            @if($cat)
                                <option>{{ $cat }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                {{-- Month --}}
                <div class="col-md-3">
                    <input type="month" class="form-control">
                </div>

                {{-- Search --}}
                <div class="col-md-4">
                    <input type="text"
                           class="form-control"
                           placeholder="Search by description...">
                </div>

                {{-- Button --}}
                <div class="col-md-2">
                    <button class="btn btn-dark w-100">
                        Filter
                    </button>
                </div>

            </div>
        </div>
    </div>


    {{-- Expense Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 fw-bold d-flex justify-content-between">
            <span>
                <i class="fa-solid fa-list me-2 text-muted"></i>
                Expense History
            </span>

            <span class="badge bg-danger bg-opacity-10 text-danger">
                {{ now()->format('M Y') }}
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Date</th>
                        <th>Expense Title</th>
                        <th>Category</th>
                        <th>Paid To</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th class="text-end pe-4">Receipt</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($outcomes as $outcome)

                <tr @if($outcome->status == 'pending') class="table-warning bg-opacity-10" @endif>

                    <td class="ps-4">
                        {{ \Carbon\Carbon::parse($outcome->date)->format('M d, Y') }}
                    </td>

                    <td class="fw-bold">
                        {{ $outcome->description }}
                    </td>

                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $outcome->expenseCategory->category_name ?? '-' }}
                        </span>
                    </td>

                    <td>{{ $outcome->beneficiary }}</td>

                    <td>
                        @if($outcome->status == 'approved')
                            <span class="badge bg-success bg-opacity-10 text-success">
                                Approved
                            </span>
                        @elseif($outcome->status == 'rejected')
                            <span class="badge bg-danger bg-opacity-10 text-danger">
                                Rejected
                            </span>
                        @else
                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>
                        @endif
                    </td>

                    <td class="text-danger fw-bold">
                        -${{ number_format($outcome->amount,2) }}
                    </td>

                    <td class="text-end pe-4">

                        {{-- Receipt Logic --}}
                        @if($outcome->status == 'approved' && $outcome->receipt)
                            <a href="{{ asset('storage/'.$outcome->receipt) }}"
                            target="_blank"
                            class="btn btn-sm btn-light border"
                            title="View Receipt">
                                <i class="fa-solid fa-print"></i>
                            </a>

                        @elseif($outcome->status == 'pending')
                            <button class="btn btn-sm btn-light border" disabled title="Pending Approval">
                                <i class="fa-solid fa-clock text-muted"></i>
                            </button>

                        @elseif($outcome->status == 'rejected')
                            <button class="btn btn-sm btn-light border" disabled title="Rejected">
                                <i class="fa-solid fa-xmark text-danger"></i>
                            </button>
                        @endif


                        {{-- Edit --}}
                        <a href="{{ route('outcomes.edit',$outcome->id) }}"
                        class="btn btn-sm btn-outline-primary"
                        title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('outcomes.destroy',$outcome->id) }}"
                            method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure you want to delete this expense?')"
                                    title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        No expenses found.
                    </td>
                </tr>
                @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection