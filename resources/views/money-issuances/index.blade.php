@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Money Issuances</h1>
            <p class="text-muted">Track and manage issued money/funds</p>
        </div>
        <div class="btn-group" role="group">
            <a href="{{ route('money-issuances.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Issue Money
            </a>
            <a href="{{ route('money-issuances.report') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-file-earmark-pdf"></i> Generate Report
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Pending</p>
                            <h4 class="mb-0">{{ $stats['total_pending'] }}</h4>
                        </div>
                        <i class="bi bi-hourglass-split text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Approved</p>
                            <h4 class="mb-0">{{ $stats['total_approved'] }}</h4>
                        </div>
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Rejected</p>
                            <h4 class="mb-0">{{ $stats['total_rejected'] }}</h4>
                        </div>
                        <i class="bi bi-x-circle text-danger" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Amount</p>
                            <h4 class="mb-0">{{ number_format($stats['total_amount_approved'] + $stats['total_amount_pending'], 0) }}</h4>
                        </div>
                        <i class="bi bi-cash-coin text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('money-issuances.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Search</label>
                    <input type="text" name="search" class="form-control" 
                        placeholder="Name, email, or reason..." 
                        value="{{ request('search') }}">
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

                <div class="col-md-2">
                    <label class="form-label fw-bold">From Date</label>
                    <input type="date" name="start_date" class="form-control" 
                        value="{{ request('start_date') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-bold">To Date</label>
                    <input type="date" name="end_date" class="form-control" 
                        value="{{ request('end_date') }}">
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Issuances Table -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
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
                    @forelse($issuances as $issuance)
                    <tr>
                        <td>
                            <strong>{{ $issuance->issued_to ?? ($issuance->issuedTo?->name ?? 'Unknown') }}</strong>
                            <br>
                            <small class="text-muted">{{ $issuance->issuedTo?->email ?? '' }}</small>
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
                                <small class="text-muted">{{ $issuance->approved_at?->format('d M Y H:i') }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('money-issuances.show-report', $issuance) }}" 
                                   class="btn btn-outline-info" title="View Report">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                                @if($issuance->status === 'pending')
                                    <a href="{{ route('money-issuances.edit', $issuance) }}" 
                                       class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-outline-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#approveModal{{ $issuance->id }}"
                                            title="Approve">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    
                                    <button type="button" class="btn btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#rejectModal{{ $issuance->id }}"
                                            title="Reject">
                                        <i class="bi bi-x-circle"></i>
                                    </button>

                                    <form action="{{ route('money-issuances.destroy', $issuance) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-secondary" 
                                                onclick="return confirm('Are you sure?')" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('money-issuances.print-individual-report', $issuance) }}" 
                                   class="btn btn-outline-secondary" title="Print Report" target="_blank">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Approve Modal -->
                    @if($issuance->status === 'pending')
                    <div class="modal fade" id="approveModal{{ $issuance->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Approve Money Issuance</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('money-issuances.approve', $issuance) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <p><strong>Recipient:</strong> {{ $issuance->issued_to ?? ($issuance->issuedTo?->name ?? 'Unknown') }}</p>
                                        <p><strong>Amount:</strong> {{ number_format($issuance->amount, 0) }} IQ</p>
                                        <p><strong>Reason:</strong> {{ $issuance->reason }}</p>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Admin Note (Optional)</label>
                                            <textarea name="admin_note" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Reject Modal -->
                    @if($issuance->status === 'pending')
                    <div class="modal fade" id="rejectModal{{ $issuance->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Reject Money Issuance</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('money-issuances.reject', $issuance) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <p><strong>Recipient:</strong> {{ $issuance->issued_to ?? ($issuance->issuedTo?->name ?? 'Unknown') }}</p>
                                        <p><strong>Amount:</strong> {{ number_format($issuance->amount, 0) }} IQ</p>
                                        <p><strong>Reason:</strong> {{ $issuance->reason }}</p>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                                            <textarea name="admin_note" class="form-control" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                            <p class="text-muted mt-3">No money issuances found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $issuances->links() }}
    </div>
</div>
@endsection
