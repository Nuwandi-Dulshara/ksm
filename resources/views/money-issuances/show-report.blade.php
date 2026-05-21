@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Issuance Details</h1>
            <p class="text-muted">View detailed information for this money issuance</p>
        </div>
        <div class="btn-group" role="group">
            <a href="{{ route('money-issuances.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <a href="{{ route('money-issuances.print-individual-report', $moneyIssuance) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                <i class="bi bi-printer"></i> Print
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Details Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Issuance Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Recipient</p>
                            <h5>{{ $moneyIssuance->issuedTo?->name ?? 'Unknown' }}</h5>
                            <small class="text-muted">{{ $moneyIssuance->issuedTo?->email }}</small>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Amount</p>
                            <h3 class="text-success">{{ number_format($moneyIssuance->amount, 0) }} IQ</h3>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Issued Date</p>
                            <h5>{{ $moneyIssuance->issued_date->format('d M Y') }}</h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <p class="text-muted mb-1">Reason</p>
                            <h5>{{ $moneyIssuance->reason }}</h5>
                        </div>
                    </div>

                    @if($moneyIssuance->description)
                    <div class="row mb-4">
                        <div class="col-12">
                            <p class="text-muted mb-1">Description</p>
                            <p>{{ $moneyIssuance->description }}</p>
                        </div>
                    </div>
                    @endif

                    @if($moneyIssuance->notes)
                    <div class="row">
                        <div class="col-12">
                            <p class="text-muted mb-1">Notes</p>
                            <p>{{ $moneyIssuance->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Status & Approval Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Status & Approval</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Current Status</p>
                            @if($moneyIssuance->status === 'pending')
                                <span class="badge bg-warning text-dark" style="font-size: 14px; padding: 8px 12px;">Pending</span>
                            @elseif($moneyIssuance->status === 'approved')
                                <span class="badge bg-success" style="font-size: 14px; padding: 8px 12px;">Approved</span>
                            @else
                                <span class="badge bg-danger" style="font-size: 14px; padding: 8px 12px;">Rejected</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Created By</p>
                            <p>{{ $moneyIssuance->createdBy?->name ?? 'System' }}</p>
                        </div>
                    </div>

                    @if($moneyIssuance->approved_by)
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Approved By</p>
                            <p>{{ $moneyIssuance->approvedBy?->name ?? 'System' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Approved Date</p>
                            <p>{{ $moneyIssuance->approved_at?->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($moneyIssuance->admin_note)
                    <div class="row">
                        <div class="col-12">
                            <p class="text-muted mb-1">Admin Note</p>
                            <p class="alert alert-info mb-0">{{ $moneyIssuance->admin_note }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Info Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Quick Summary</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">AMOUNT</small>
                        <div style="font-size: 28px; font-weight: bold; color: #28a745;">
                            {{ number_format($moneyIssuance->amount, 0) }}
                        </div>
                        <small>IQ</small>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <small class="text-muted">Status</small>
                        <div>
                            @if($moneyIssuance->status === 'pending')
                                <span class="badge bg-warning text-dark w-100" style="padding: 8px;">Awaiting Approval</span>
                            @elseif($moneyIssuance->status === 'approved')
                                <span class="badge bg-success w-100" style="padding: 8px;">Approved</span>
                            @else
                                <span class="badge bg-danger w-100" style="padding: 8px;">Rejected</span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">ISSUED DATE</small>
                        <p class="mb-0">{{ $moneyIssuance->issued_date->format('d M Y') }}</p>
                    </div>

                    <div>
                        <small class="text-muted d-block mb-1">CREATED AT</small>
                        <p class="mb-0">{{ $moneyIssuance->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            @if($moneyIssuance->status === 'pending')
            <div class="card border-0 shadow-sm border-warning mt-3">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Pending Actions</h5>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                        <i class="bi bi-check-circle"></i> Approve
                    </button>
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="bi bi-x-circle"></i> Reject
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Approve Modal -->
    @if($moneyIssuance->status === 'pending')
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Money Issuance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('money-issuances.approve', $moneyIssuance) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p><strong>Recipient:</strong> {{ $moneyIssuance->issuedTo?->name }}</p>
                        <p><strong>Amount:</strong> {{ number_format($moneyIssuance->amount, 0) }} IQ</p>
                        <p><strong>Reason:</strong> {{ $moneyIssuance->reason }}</p>
                        
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

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Money Issuance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('money-issuances.reject', $moneyIssuance) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p><strong>Recipient:</strong> {{ $moneyIssuance->issuedTo?->name }}</p>
                        <p><strong>Amount:</strong> {{ number_format($moneyIssuance->amount, 0) }} IQ</p>
                        <p><strong>Reason:</strong> {{ $moneyIssuance->reason }}</p>
                        
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
</div>
@endsection
