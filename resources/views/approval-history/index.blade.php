@extends('layouts.app')

@section('title', 'Approval History')

@section('styles')
<style id="approval-history-print-styles">
@media print {
    @page {
        size: A4 landscape;
        margin: 12mm;
    }

    body {
        background: #fff !important;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Approval Log</h2>
            <p class="text-muted mb-0">Audit trail of all approved and rejected outcome requests.</p>
        </div>
        <button class="btn btn-outline-secondary" onclick="printApprovalLog()">
            <i class="fa-solid fa-print me-2"></i> Print Log
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
            <div class="card border-0 shadow-sm metric-card">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-uppercase text-muted fw-semibold mb-2">Total Decisions</h6>
                        <h2 class="fw-bold mb-0">{{ $totalDecisions }}</h2>
                        <small class="text-muted">Approved and rejected requests</small>
                    </div>
                    <div class="metric-icon bg-primary-gradient">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
            <div class="card border-0 shadow-sm metric-card">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-uppercase text-muted fw-semibold mb-2">Approved</h6>
                        <h2 class="fw-bold mb-0">{{ $approvedCount }}</h2>
                        <small class="text-muted">Accepted requests</small>
                    </div>
                    <div class="metric-icon bg-success">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm metric-card">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-uppercase text-muted fw-semibold mb-2">Rejected</h6>
                        <h2 class="fw-bold mb-0">{{ $rejectedCount }}</h2>
                        <small class="text-muted">Declined requests</small>
                    </div>
                    <div class="metric-icon bg-danger">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('approval.history') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="small text-muted fw-bold">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Decisions</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved Only
                        </option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected Only
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small text-muted fw-bold">Month</label>
                    <input type="month" name="month" class="form-control form-control-sm"
                        value="{{ request('month') }}">
                </div>
                <div class="col-md-4">
                    <label class="small text-muted fw-bold">Search</label>
                    <input type="text" name="search" class="form-control form-control-sm"
                        value="{{ request('search') }}" placeholder="Search by description, beneficiary, or user...">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button class="btn btn-sm btn-primary w-100">Filter Results</button>
                </div>
            </form>
        </div>
    </div>

    <div id="approval-history-print-area" class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Request Date</th>
                            <th>Request Details</th>
                            <th>Requested By</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Decision By</th>
                            <th>Admin Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($approvalHistory as $item)
                        <tr class="{{ $item->status === 'rejected' ? 'table-danger bg-opacity-10' : '' }}">
                            <td class="ps-4 text-muted small">
                                {{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}<br>
                                {{ \Carbon\Carbon::parse($item->created_at)->format('h:i A') }}
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->description ?: 'No description provided' }}
                                </div>
                                <div class="small text-muted">
                                    {{ $item->expenseCategory->category_name ?? 'No category' }}
                                    @if($item->beneficiary)
                                    | {{ $item->beneficiary }}
                                    @endif
                                </div>
                            </td>
                            <td>{{ optional($item->creator)->name ?? optional($item->creator)->username ?? 'Unknown user' }}
                            </td>
                            <td class="fw-bold">${{ number_format($item->amount, 2) }}</td>
                            <td>
                                @if($item->status === 'approved')
                                <span class="badge bg-success">
                                    <i class="fa-solid fa-check me-1"></i> Approved
                                </span>
                                @else
                                <span class="badge bg-danger">
                                    <i class="fa-solid fa-xmark me-1"></i> Rejected
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="small fw-bold">
                                    {{ optional($item->decisionBy)->name ?? optional($item->decisionBy)->username ?? 'Unknown user' }}
                                </div>
                                <div class="small text-muted">
                                    {{ $item->decided_at ? \Carbon\Carbon::parse($item->decided_at)->format('M d, h:i A') : '-' }}
                                </div>
                            </td>
                            <td class="small {{ $item->status === 'rejected' ? 'text-danger fw-bold' : 'text-muted' }}">
                                {{ $item->admin_note ?: '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                No approval history found for the selected filters.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($approvalHistory->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $approvalHistory->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function printApprovalLog() {
    const printArea = document.getElementById('approval-history-print-area');
    const printStyles = document.getElementById('approval-history-print-styles');
    const printWindow = window.open('', '_blank', 'width=1200,height=800');

    if (!printArea || !printStyles || !printWindow) {
        return;
    }

    printWindow.document.open();
    printWindow.document.write(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Approval History</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <style>
                ${printStyles.innerHTML}
                body {
                    background: #fff !important;
                    padding: 24px;
                }

                .card {
                    border: none !important;
                    box-shadow: none !important;
                }

                .card-footer {
                    display: none !important;
                }

                .table {
                    font-size: 12px;
                }

                .badge {
                    color: #fff !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
            </style>
        </head>
        <body>
            ${printArea.outerHTML}
        </body>
        </html>
    `);
    printWindow.document.close();

    printWindow.onload = function() {
        printWindow.focus();

        window.setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 300);
    };
}
</script>
@endpush