@extends('layouts.app')

@section('title', 'Outcome Report')

@section('styles')
<style>
/* REPORT SHEET STYLES (page-specific) */
.report-sheet {
    background: white;
    padding: 40px;
    border: 1px solid #dee2e6;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    max-width: 210mm;
    /* A4 Width */
    margin: 0 auto;
    min-height: 297mm;
}

.category-header {
    background-color: #343a40;
    color: white;
    padding: 8px 15px;
    font-weight: bold;
    text-transform: uppercase;
    margin-top: 30px;
    display: flex;
    justify-content: space-between;
}

.table-report {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
    margin-bottom: 0;
}

.table-report th {
    background-color: #e9ecef;
    border: 1px solid #adb5bd;
    padding: 8px;
    text-align: left;
}

.table-report td {
    border: 1px solid #dee2e6;
    padding: 5px 8px;
    vertical-align: middle;
}

.table-report tbody tr:nth-child(even) td {
    background-color: #f8f9fa !important;
}

.subtotal-row td {
    background-color: #e2e3e5 !important;
    font-weight: bold;
    border-top: 2px solid #343a40;
}

.grand-total-box {
    border: 3px solid #dc3545;
    background-color: #fff5f5;
    padding: 15px;
    text-align: right;
    margin-top: 40px;
    border-radius: 4px;
}

@media print {
    @page {
        size: A4;
        margin: 10mm;
    }

    body {
        background-color: white;
        -webkit-print-color-adjust: exact;
    }

    .sidebar,
    .filter-card,
    .no-print {
        display: none !important;
    }

    .main-content {
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .report-sheet {
        border: none;
        box-shadow: none;
        padding: 0;
        max-width: 100%;
        margin: 0;
    }

    .category-header,
    .subtotal-row td {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .category-section {
        page-break-inside: avoid;
    }
}
</style>
@endsection

@section('content')

<div class="card shadow-sm mb-4 filter-card border-0 border-top border-4 border-primary">
    <div class="card-body p-4">

        {{-- Header row: title LEFT | button RIGHT --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">
                <i class="fa-solid fa-filter me-2 text-primary"></i> Report Filters
            </h5>
            <button type="submit" form="filterForm" class="btn btn-dark fw-bold"
                onclick="document.getElementById('printInput').value=1;">
                <i class="fa-solid fa-print me-2"></i> Generate & Print
            </button>
        </div>

        {{-- Filter form --}}
        <form id="filterForm" class="row g-3 align-items-end" method="GET" action="{{ route('outcome-report.index') }}">

            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Category</label>
                <select class="form-select" id="categoryFilter" name="category">
                    <option value="all" {{ (isset($categoryFilter) && $categoryFilter === 'all') ? 'selected' : '' }}>
                        All Categories
                    </option>
                    @foreach($expenseCategories as $ec)
                    <option value="{{ $ec->id }}"
                        {{ (isset($categoryFilter) && (string)$categoryFilter === (string)$ec->id) ? 'selected' : '' }}>
                        {{ $ec->category_name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">Start Date</label>
                <input type="date" class="form-control" name="start_date" value="{{ $start ?? '' }}">
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted">End Date</label>
                <input type="date" class="form-control" name="end_date" value="{{ $end ?? '' }}">
            </div>

            <input type="hidden" name="print" id="printInput" value="0">

            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary w-50 fw-bold"
                    onclick="document.getElementById('printInput').value=0;">
                    <i class="fa-solid fa-filter me-2"></i> Filter
                </button>
            </div>

        </form>

    </div>
</div>

<div class="report-sheet" id="reportContainer">

    <div class="text-center mb-5 border-bottom pb-3">
        <h2 class="fw-bold text-uppercase mb-1">My Company Ltd.</h2>
        <h4 class="text-muted fw-light">Monthly Outcome Report</h4>
        <div class="d-flex justify-content-center gap-3 mt-2 text-muted small">
            <span><strong>Period:</strong> {{ 
                        \Carbon\Carbon::parse($start ?? now()->startOfMonth())->format('M d, Y')
                        }} - {{ \Carbon\Carbon::parse($end ?? now()->endOfMonth())->format('M d, Y') }}</span>
            <span>|</span>
            <span><strong>Generated:</strong> {{ \Carbon\Carbon::now()->format('M d, Y') }}</span>
        </div>
    </div>

    @if(!empty($categories) && count($categories) > 0)
    @foreach($categories as $cat)
    <div class="category-section mb-4">
        <div class="category-header">
            <span>{{ $cat['name'] }}</span>
            <span>{{ $cat['count'] }} Records</span>
        </div>
        <table class="table-report">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="width: 100px;">Date</th>
                    <th>Description / Note</th>
                    <th>Paid To</th>
                    <th class="text-end" style="width: 120px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cat['records'] as $i => $rec)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($rec['date'])->format('M d, Y') }}</td>
                    <td>{{ $rec['description'] }}</td>
                    <td>{{ $rec['beneficiary'] }}</td>
                    <td class="text-end">${{ number_format($rec['amount'], 2) }}</td>
                </tr>
                @endforeach

                <tr class="subtotal-row">
                    <td colspan="4" class="text-end">Subtotal ({{ $cat['name'] }}):</td>
                    <td class="text-end text-danger">${{ number_format($cat['subtotal'], 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endforeach
    @else
    <p class="text-center text-muted">No records found for the selected filters.</p>
    @endif

    <div class="grand-total-box">
        <div class="text-muted text-uppercase small">Total Outcome (All Categories)</div>
        <div class="display-6 fw-bold text-danger">${{ number_format($grandTotal ?? 0, 2) }}</div>
    </div>

    <div class="row mt-5 pt-5 text-center">
        <div class="col-4">
            <div class="border-top border-dark pt-2 mx-4 small fw-bold">Prepared By</div>
        </div>
        <div class="col-4">
            <div class="border-top border-dark pt-2 mx-4 small fw-bold">Accountant</div>
        </div>
        <div class="col-4">
            <div class="border-top border-dark pt-2 mx-4 small fw-bold">Manager Approval</div>
        </div>
    </div>

</div>

@push('scripts')
<script>
// Auto-print when the form was submitted with print=1
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('print') === '1') {
        // small delay so page renders before print dialog
        setTimeout(() => window.print(), 250);
    }
});
</script>
@endpush

@endsection