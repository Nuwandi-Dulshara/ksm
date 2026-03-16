@extends('layouts.app')

@section('title', 'Category Outcome Summary')

@section('styles')
<style>
body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* SIDEBAR & LAYOUT */
.sidebar {
    height: 100vh;
    background-color: #1e3a8a;
    color: white;
    position: fixed;
    width: 250px;
}

.sidebar a {
    color: #cfd8dc;
    text-decoration: none;
    padding: 15px 20px;
    display: block;
    border-left: 4px solid transparent;
}

.main-content {
    margin-left: 250px;
    padding: 30px;
}

/* SUMMARY CARD STYLES */
.summary-card {
    background: white;
    padding: 40px;
    max-width: 900px;
    margin: 0 auto;
    border: 1px solid #dee2e6;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
}

.table-summary thead th {
    background-color: #343a40;
    color: white;
    text-transform: uppercase;
    padding: 12px;
    border: 1px solid #000;
}

.table-summary tbody td {
    padding: 12px;
    border: 1px solid #dee2e6;
    vertical-align: middle;
    font-size: 1.05rem;
}

.table-summary tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

/* PRINT SETTINGS */
@media print {
    @page {
        size: A4;
        margin: 15mm;
    }

    body {
        background-color: white;
    }

    .sidebar,
    .no-print {
        display: none !important;
    }

    .main-content {
        margin: 0;
        padding: 0;
    }

    .summary-card {
        border: none;
        box-shadow: none;
        padding: 0;
        max-width: 100%;
    }

    .table-summary th {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .table-summary tbody tr:nth-child(even) {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        background-color: #eee !important;
    }
}
</style>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 no-print" style="max-width: 900px; margin: 0 auto;">
    <a href="{{ route('outcomes.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="fa-solid fa-arrow-left me-2"></i> Back
    </a>
    <form method="GET" action="{{ route('category.summary') }}" class="d-flex gap-2">
        <select name="month" class="form-select w-auto fw-bold bg-white" onchange="this.form.submit()">
            @foreach($availableMonths as $month)
            <option value="{{ $month }}" {{ $selectedMonth->toDateString() === $month ? 'selected' : '' }}>
                {{ \Carbon\Carbon::parse($month)->format('F Y') }}
            </option>
            @endforeach
        </select>
        <button type="button" onclick="window.print()" class="btn btn-dark fw-bold px-4">
            <i class="fa-solid fa-print me-2"></i> Print Report
        </button>
    </form>
</div>

<div class="summary-card">

    <div class="text-center mb-5 border-bottom pb-4">
        <h2 class="fw-bold text-uppercase mb-1">My Company Ltd.</h2>
        <h4 class="text-secondary">Category Outcome Summary</h4>
        <div class="mt-2 text-muted fw-bold">Month: {{ $selectedMonth->format('F Y') }}</div>
    </div>

    <table class="table table-summary mb-5">
        <thead>
            <tr>
                <th style="width: 50px;">#</th>
                <th class="text-start ps-4">Category Name</th>
                <th class="text-center">Transaction Count</th>
                <th class="text-end pe-4">Total Amount ($)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($summaryItems as $index => $item)
            <tr>
                <td class="text-center fw-bold">{{ $index + 1 }}</td>
                <td class="ps-4">
                    <span class="fw-bold text-primary">{{ $item['category_name'] }}</span>
                    <div class="small text-muted">{{ $item['subtitle'] }}</div>
                </td>
                <td class="text-center">{{ $item['transaction_count'] }}</td>
                <td class="text-end pe-4 fw-bold">${{ number_format($item['total_amount'], 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-4 text-muted">No approved outcomes found for this month.</td>
            </tr>
            @endforelse

        </tbody>
        <tfoot style="border-top: 3px solid #000;">
            <tr class="bg-light">
                <td colspan="3" class="text-end pe-4 py-3 text-uppercase fw-bold text-muted">Grand Total
                    Expenses:
                </td>
                <td class="text-end pe-4 py-3">
                    <span class="display-6 fw-bold text-danger">${{ number_format($grandTotal, 2) }}</span>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-5 pt-4">
        <div class="col-6 text-center">
            <div class="border-top border-dark mx-5 pt-2">
                <span class="fw-bold small d-block">Accountant Signature</span>
            </div>
        </div>
        <div class="col-6 text-center">
            <div class="border-top border-dark mx-5 pt-2">
                <span class="fw-bold small d-block">Manager Approval</span>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 pt-4 text-muted small">
        Report Generated on {{ $generatedAt->format('M d, Y \a\t g:i A') }}
    </div>

</div>

@endsection