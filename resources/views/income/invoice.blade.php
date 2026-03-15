@extends('layouts.app')

@section('styles')
<style>
body {
    background: #f3f4f6;
}

.invoice-wrapper {
    max-width: 900px;
    margin: auto;
}

.invoice-card {
    border: none;
    border-top: 5px solid #10b981;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

.invoice-logo {
    font-size: 28px;
    font-weight: 700;
    color: #1e3a8a;
}

.invoice-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.invoice-header-meta {
    text-align: right;
}

.table-invoice thead th {
    background: #f8f9fa;
    text-transform: uppercase;
    font-size: 13px;
    color: #6c757d;
}

.total-box {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

@media (max-width: 767.98px) {
    .invoice-header {
        flex-direction: column;
    }

    .invoice-header-meta {
        text-align: left;
        margin-top: 16px;
    }
}
</style>
@endsection


@section('content')

<div class="container-fluid py-4">

    {{-- Buttons --}}
    <div class="d-flex justify-content-between mb-4">

        <a href="{{ route('income.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>

        <div>
            <button onclick="printInvoice()" class="btn btn-primary">
                <i class="fa-solid fa-print"></i> Print / Save PDF
            </button>

            @if($income->invoice_file)
            <a href="{{ asset('storage/'.$income->invoice_file) }}" target="_blank" class="btn btn-success">
                <i class="fa-solid fa-file-pdf"></i> View Attachment
            </a>
            @endif
        </div>

    </div>


    {{-- INVOICE --}}
    <div class="invoice-wrapper">
        <div class="card invoice-card">
            <div class="card-body p-5">

                {{-- Header --}}
                <div class="invoice-header mb-5">
                    <div>
                        <div class="invoice-logo">
                            <i class="fa-solid fa-wallet"></i> AccoSys
                        </div>
                        <p class="text-muted mb-0">AccoSys Finance Management</p>
                        <p class="text-muted mb-0">Sri Lanka</p>
                        <p class="text-muted">support@accosys.com</p>
                    </div>
                    <div class="invoice-header-meta">
                        <h2 class="fw-bold">INVOICE</h2>
                        <h5 class="text-muted">#{{ $income->invoice_number }}</h5>
                        <span class="badge bg-success fs-6 mt-2">PAID IN FULL</span>
                    </div>
                </div>

                {{-- Bill To --}}
                <div class="row border-top border-bottom py-4 mb-4">
                    <div class="col-md-6">
                        <small class="text-muted text-uppercase fw-bold">Bill To</small>
                        <h5 class="fw-bold mt-1">{{ $income->donator->full_name }}</h5>
                        <p class="text-muted mb-0">{{ $income->donator->address ?? 'No address provided' }}</p>
                        <p class="text-muted">{{ $income->donator->email ?? 'No email provided' }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p class="mb-0">
                            <span class="text-muted">Invoice Date :</span>
                            <strong>{{ \Carbon\Carbon::parse($income->received_date)->format('M d, Y') }}</strong>
                        </p>
                    </div>
                </div>

                {{-- Table --}}
                <div class="table-responsive mb-4">
                    <table class="table table-invoice">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><strong>{{ $income->description ?? 'Income Payment' }}</strong></td>
                                <td class="text-end fw-bold">${{ number_format($income->amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Bottom --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="alert alert-light border">
                            <strong><i class="fa-solid fa-circle-info"></i> Notes</strong>
                            <p class="mb-0 small text-muted">Thank you for your contribution.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="total-box">
                            <div class="d-flex justify-content-between">
                                <strong class="fs-5">Grand Total</strong>
                                <strong class="fs-4 text-success">${{ number_format($income->amount, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="text-center text-muted mt-5 small">
                    If you have any questions, please contact us.
                </div>

            </div>
        </div>
    </div>

</div>

@endsection


@push('scripts')
<script>
function printInvoice() {

    // ── All invoice data passed from Blade ──────────────────────────────────
    const data = {
        invoiceNumber: '{{ $income->invoice_number }}',
        invoiceDate: '{{ \Carbon\Carbon::parse($income->received_date)->format("M d, Y") }}',
        clientName: '{{ addslashes($income->donator->full_name) }}',
        clientAddress: '{{ addslashes($income->donator->address ?? "No address provided") }}',
        clientEmail: '{{ addslashes($income->donator->email ?? "No email provided") }}',
        description: '{{ addslashes($income->description ?? "Income Payment") }}',
        amount: '{{ number_format($income->amount, 2) }}',
    };

    // ── Self-contained print HTML (no Bootstrap grid, pure table layout) ───
    const html = `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice ${data.invoiceNumber}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 14px;
            color: #333;
            background: #fff;
            padding: 32px;
        }

        /* ── Top header: logo LEFT, invoice info RIGHT ── */
        .inv-header {
            width: 100%;
            display: table;
            margin-bottom: 40px;
        }
        .inv-header-left,
        .inv-header-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .inv-header-right {
            text-align: right;
        }

        .inv-logo {
            font-size: 26px;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 6px;
        }
        .inv-logo i { margin-right: 6px; }

        .inv-meta-muted { color: #6c757d; font-size: 13px; line-height: 1.8; }

        h2.inv-title {
            font-size: 28px;
            font-weight: 700;
            color: #111;
            margin-bottom: 4px;
        }
        .inv-number { color: #6c757d; font-size: 15px; margin-bottom: 10px; }

        .badge-paid {
            display: inline-block;
            background: #10b981;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 5px 14px;
            border-radius: 4px;
        }

        /* ── Bill-to row ── */
        .inv-billto {
            width: 100%;
            display: table;
            border-top: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            padding: 20px 0;
            margin-bottom: 28px;
        }
        .inv-billto-left,
        .inv-billto-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .inv-billto-right { text-align: right; }

        .label-small {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            color: #6c757d;
            margin-bottom: 6px;
        }
        .client-name { font-size: 17px; font-weight: 700; margin-bottom: 4px; }
        .text-muted   { color: #6c757d; }

        /* ── Table ── */
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
        }
        table.items thead th {
            background: #f8f9fa;
            text-transform: uppercase;
            font-size: 11px;
            color: #6c757d;
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        table.items thead th.text-right { text-align: right; }
        table.items tbody td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
        }
        table.items tbody td.text-right { text-align: right; font-weight: 600; }

        /* ── Bottom row ── */
        .inv-bottom {
            width: 100%;
            display: table;
        }
        .inv-bottom-left,
        .inv-bottom-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .inv-bottom-right { padding-left: 20px; }

        .notes-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 14px 16px;
            font-size: 13px;
            color: #6c757d;
        }
        .notes-box strong { color: #333; display: block; margin-bottom: 4px; }

        .total-box {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-label { font-size: 16px; font-weight: 700; }
        .total-amount { font-size: 22px; font-weight: 700; color: #10b981; }

        /* ── Footer ── */
        .inv-footer {
            text-align: center;
            color: #aaa;
            font-size: 12px;
            margin-top: 40px;
        }

        @media print {
            @page { size: A4; margin: 12mm; }
            body  { padding: 0; }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="inv-header">
        <div class="inv-header-left">
            <div class="inv-logo">
                <i class="fa-solid fa-wallet"></i> AccoSys
            </div>
            <div class="inv-meta-muted">
                AccoSys Finance Management<br>
                Sri Lanka<br>
                support@accosys.com
            </div>
        </div>
        <div class="inv-header-right">
            <h2 class="inv-title">INVOICE</h2>
            <div class="inv-number">#${data.invoiceNumber}</div>
            <span class="badge-paid">PAID IN FULL</span>
        </div>
    </div>

    <!-- BILL TO -->
    <div class="inv-billto">
        <div class="inv-billto-left">
            <div class="label-small">Bill To</div>
            <div class="client-name">${data.clientName}</div>
            <div class="text-muted">${data.clientAddress}</div>
            <div class="text-muted">${data.clientEmail}</div>
        </div>
        <div class="inv-billto-right">
            <span class="text-muted">Invoice Date :</span>
            <strong> ${data.invoiceDate}</strong>
        </div>
    </div>

    <!-- TABLE -->
    <table class="items">
        <thead>
            <tr>
                <th style="width:40px">#</th>
                <th>Description</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><strong>${data.description}</strong></td>
                <td class="text-right">$${data.amount}</td>
            </tr>
        </tbody>
    </table>

    <!-- BOTTOM -->
    <div class="inv-bottom">
        <div class="inv-bottom-left">
            <div class="notes-box">
                <strong><i class="fa-solid fa-circle-info"></i> Notes</strong>
                Thank you for your contribution.
            </div>
        </div>
        <div class="inv-bottom-right">
            <div class="total-box">
                <span class="total-label">Grand Total</span>
                <span class="total-amount">$${data.amount}</span>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="inv-footer">
        If you have any questions, please contact us.
    </div>

</body>
</html>`;

    // ── Open popup, write, then print ──────────────────────────────────────
    const win = window.open('', '_blank', 'width=1000,height=800');
    win.document.open();
    win.document.write(html);
    win.document.close();

    // Wait for Font Awesome to load before printing
    win.onload = function() {
        setTimeout(function() {
            win.focus();
            win.print();
            win.close();
        }, 500);
    };
}
</script>
@endpush