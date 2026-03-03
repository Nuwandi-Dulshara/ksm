@extends('layouts.app')

@section('styles')
<style>
    body { background-color: #f3f4f6; }

    .invoice-card {
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border-top: 5px solid #10b981;
    }

    .invoice-logo {
        font-size: 2rem;
        color: #1e3a8a;
        font-weight: bold;
    }

    .table-invoice thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        color: #6c757d;
        font-size: 0.85rem;
        text-transform: uppercase;
    }

    .total-section {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
    }

    @media print {
        .sidebar, .no-print {
            display: none !important;
        }

        .main-content {
            margin-left: 0;
            padding: 0;
        }

        body {
            background-color: white;
        }

        .invoice-card {
            box-shadow: none;
            border: none;
        }

        .total-section, thead th {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>
@endsection

@section('content')

<div class="container-fluid px-4 py-4">

    {{-- Top Buttons --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <a href="{{ route('income.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fa-solid fa-arrow-left me-2"></i> Back to Income List
        </a>

        <div class="d-flex gap-2">
            <button class="btn btn-primary fw-bold px-4" onclick="window.print()">
                <i class="fa-solid fa-print me-2"></i> Print / Save PDF
            </button>

            @if($income->invoice_file)
                <a href="{{ asset('storage/'.$income->invoice_file) }}"
                   target="_blank"
                   class="btn btn-success fw-bold px-4">
                    <i class="fa-solid fa-file-pdf me-2"></i> View Attachment
                </a>
            @endif
        </div>
    </div>

    {{-- Invoice Card --}}
    <div class="card invoice-card bg-white">
        <div class="card-body p-5">

            {{-- Header --}}
            <div class="row justify-content-between align-items-start mb-5">
                <div class="col-md-6">
                    <div class="invoice-logo mb-2">
                        <i class="fa-solid fa-wallet"></i> AccoSys
                    </div>
                    <p class="text-muted mb-0">AccoSys Finance Management</p>
                    <p class="text-muted mb-0">Sri Lanka</p>
                    <p class="text-muted">support@accosys.com</p>
                </div>

                <div class="col-md-4 text-end">
                    <h2 class="fw-bold text-dark mb-1">INVOICE</h2>
                    <h5 class="text-muted mb-3">#{{ $income->invoice_number }}</h5>

                    <div class="badge bg-success bg-opacity-10 text-success fs-6 px-3 py-2 border border-success">
                        PAID IN FULL
                    </div>
                </div>
            </div>

            {{-- Bill To Section --}}
            <div class="row mb-5 border-top border-bottom py-4">
                <div class="col-md-6">
                    <small class="text-muted fw-bold text-uppercase d-block mb-1">
                        Bill To:
                    </small>
                    <h5 class="fw-bold mb-1">
                        {{ $income->donator->full_name }}
                    </h5>
                    <p class="text-muted mb-0">
                        {{ $income->donator->address ?? 'No address provided' }}
                    </p>
                    <p class="text-muted">
                        {{ $income->donator->email ?? 'No email provided' }}
                    </p>
                </div>

                <div class="col-md-6 text-end">
                    <div class="mb-2">
                        <span class="text-muted me-2">Invoice Date:</span>
                        <span class="fw-bold">
                            {{ \Carbon\Carbon::parse($income->received_date)->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Invoice Table --}}
            <div class="table-responsive mb-4">
                <table class="table table-invoice align-middle">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Description</th>
                            <th class="text-end" style="width: 150px;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <div class="fw-bold">
                                    {{ $income->description ?? 'Income Payment' }}
                                </div>
                            </td>
                            <td class="text-end fw-bold">
                                ${{ number_format($income->amount,2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Total Section --}}
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="alert alert-light border">
                        <h6 class="fw-bold">
                            <i class="fa-solid fa-circle-info me-2 text-info"></i>
                            Notes:
                        </h6>
                        <p class="mb-0 small text-muted">
                            Thank you for your contribution.
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="total-section ms-auto" style="max-width: 350px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold fs-5">Grand Total:</span>
                            <span class="fw-bold fs-4 text-success">
                                ${{ number_format($income->amount,2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-5 text-center text-muted small">
                <p>
                    If you have any questions, please contact us.
                </p>
            </div>

        </div>
    </div>

</div>

@endsection