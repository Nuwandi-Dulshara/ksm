@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/styles/choices.min.css">
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Money Issuance Report</h1>
            <p class="text-muted">Generate and view reports by date range and filters</p>
        </div>
        <a href="{{ route('money-issuances.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <!-- Filters Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('money-issuances.report') }}" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label fw-bold">From Date</label>
                    <input type="date" name="start_date" class="form-control" 
                        value="{{ $startDate }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">To Date</label>
                    <input type="date" name="end_date" class="form-control" 
                        value="{{ $endDate }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Recipient</label>
                    <select name="issued_to_id" id="recipientSelect" class="form-select">
                        <option value="">All Recipients</option>
                        @foreach($recipients as $recipient)
                            <option value="{{ $recipient->id }}" {{ request('issued_to_id') == $recipient->id ? 'selected' : '' }}>
                                {{ $recipient->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary flex-grow-1">
                            <i class="bi bi-funnel"></i> Generate Report
                        </button>
                        <a href="{{ route('money-issuances.report') }}?print=true&start_date={{ $startDate }}&end_date={{ $endDate }}&status={{ request('status') }}&issued_to_id={{ request('issued_to_id') }}" 
                           class="btn btn-outline-secondary" target="_blank">
                            <i class="bi bi-printer"></i> Print
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="text-muted mb-2">Total Items</h5>
                    <h3>{{ $summary['total_count'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="text-muted mb-2">Total Amount</h5>
                    <h3>{{ number_format($summary['total_amount'], 0) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="text-warning mb-2">Pending</h5>
                    <h3>{{ $summary['pending_count'] }}</h3>
                    <small class="text-warning">{{ number_format($summary['pending_amount'], 0) }} IQ</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="text-success mb-2">Approved</h5>
                    <h3>{{ $summary['approved_count'] }}</h3>
                    <small class="text-success">{{ number_format($summary['approved_amount'], 0) }} IQ</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="text-danger mb-2">Rejected</h5>
                    <h3>{{ $summary['rejected_count'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Table -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Recipient</th>
                        <th>Reason</th>
                        <th>Amount</th>
                        <th>Issued Date</th>
                        <th>Status</th>
                        <th>Approved By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($issuances as $key => $issuance)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <strong>{{ $issuance->issuedTo?->name ?? 'Unknown' }}</strong>
                            <br>
                            <small class="text-muted">{{ $issuance->issuedTo?->email }}</small>
                        </td>
                        <td>{{ $issuance->reason }}</td>
                        <td class="fw-bold">{{ number_format($issuance->amount, 0) }} IQ</td>
                        <td>{{ $issuance->issued_date->format('d M Y') }}</td>
                        <td>
                            @if($issuance->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($issuance->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if($issuance->approved_by)
                                {{ $issuance->approvedBy?->name ?? 'System' }}
                                <br>
                                <small class="text-muted">{{ $issuance->approved_at?->format('d M Y') }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('money-issuances.print-individual-report', $issuance) }}" 
                               class="btn btn-sm btn-outline-secondary" target="_blank">
                                <i class="bi bi-printer"></i> Print
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                            <p class="text-muted mt-3">No records found for the selected date range</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Choices.js for Recipient select
            new Choices('#recipientSelect', {
                searchEnabled: true,
                searchChoicePosition: 'top',
                itemSelectText: 'Press to select',
                placeholderValue: 'All Recipients',
                shouldSort: false,
                allowHTML: false,
                maxItemCount: 1
            });
        });
    </script>
@endsection
