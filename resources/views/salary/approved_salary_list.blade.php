<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly {{ __('messages.salary') }} Sheet | AccoSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* WEB VIEW STYLES (Screen only) */
    .toolbar {
        background: #333;
        color: white;
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* PRINT VIEW STYLES (Paper only) */
    .sheet-container {
        background: white;
        padding: 20px;
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Table Design */
    .table-salary {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .table-salary th {
        background-color: #343a40 !important;
        /* Dark header for contrast */
        color: white !important;
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
        text-transform: uppercase;
        font-weight: bold;
    }

    .table-salary td {
        border: 1px solid #000;
        padding: 6px 8px;
        vertical-align: middle;
    }

    /* --- NEW CODE: ZEBRA STRIPING (Grey/White Rows) --- */
    /* Target every EVEN row (2, 4, 6...) and make its cells grey */
    .table-salary tbody tr:nth-child(even) td {
        background-color: #f2f2f2 !important;
    }

    /* -------------------------------------------------- */

    .total-row td {
        background-color: #343a40 !important;
        /* Dark footer to match header */
        color: white !important;
        font-weight: bold;
        font-size: 14px;
        border-top: 2px solid #000;
    }

    /* Make the final total cell stand out */
    .total-row .final-total {
        background-color: #ffc107 !important;
        /* Yellow/Amber */
        color: black !important;
    }


    .sign-box {
        height: 25px;
    }

    .admin-signatures {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
        page-break-inside: avoid;
    }

    .sign-line {
        width: 200px;
        border-top: 1px solid #000;
        text-align: center;
        padding-top: 5px;
        font-size: 12px;
        font-weight: bold;
    }

    @media print {
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            background: white;
            margin: 0;
            padding: 0;
        }

        .toolbar,
        .no-print {
            display: none !important;
        }

        .sheet-container {
            width: 100%;
            max-width: 100%;
            padding: 0;
            margin: 0;
            box-shadow: none;
        }

        /* FORCE PRINTER TO PRINT BACKGROUND COLORS */
        .table-salary th,
        .table-salary td,
        .table-salary tbody tr:nth-child(even) td,
        .total-row td {
            border: 1px solid #000 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
    </style>
</head>

<body>

    <div class="toolbar no-print">
        <div class="d-flex align-items-center gap-3">
            <h5 class="mb-0 me-3">{{ __('messages.salary') }} Sheet</h5>

            <form method="GET" action="{{ route('approve.salary') }}" class="d-flex align-items-center gap-2 mb-0">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-secondary text-white border-secondary">Select Month:</span>
                    <input type="month" id="monthSelector" name="month" class="form-control"
                        value="{{ $salaryMonthValue }}">
                </div>
                <button type="submit" class="btn btn-primary btn-sm fw-bold">
                    <i class="fa-solid fa-filter me-1"></i> {{ __('messages.filter') }}
                </button>
            </form>
        </div>

        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm me-2">Back</a>
            <button onclick="window.print()" class="btn btn-warning fw-bold btn-sm">
                <i class="fa-solid fa-print me-2"></i> Print Now
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="container mt-3 no-print">
        <div class="alert alert-success mb-0">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="sheet-container">

        <div class="d-flex justify-content-between align-items-end mb-3 border-bottom border-2 border-dark pb-2">
            <div>
                <h2 class="fw-bold text-uppercase mb-0">My Company Ltd.</h2>
                <div class="small">100m Street, Erbil, Iraq</div>
            </div>
            <div class="text-end">
                <h3 class="fw-bold mb-0">{{ strtoupper(__('messages.salary')) }} SHEET</h3>
                <div class="fw-bold fs-5" id="sheetDateDisplay">Month: {{ $salaryMonthLabel }}</div>
            </div>
        </div>

        <table class="table-salary">
            <thead>
                <tr>
                    <th style="width: 40px;">No.</th>
                    <th style="text-align: left;">Employee Name</th>
                    <th style="text-align: left;">Position</th>
                    <th style="width: 100px;">Basic {{ __('messages.salary') }}</th>
                    <th style="width: 80px;">Bonus (+)</th>
                    <th style="width: 80px;">Deduct (-)</th>
                    <th style="width: 110px;">Net Payable</th>
                    <th style="width: 150px;">Signature</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salaryRows as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $row['employee_name'] }}</td>
                    <td>{{ $row['position'] }}</td>
                    <td class="text-end">IQ {{ number_format($row['basic_salary'], 2) }}</td>
                    <td class="text-end">{{ $row['bonus'] > 0 ? 'IQ ' . number_format($row['bonus'], 2) : '-' }}</td>
                    <td class="text-end">{{ $row['deduction'] > 0 ? 'IQ ' . number_format($row['deduction'], 2) : '-' }}
                    </td>
                    <td class="text-end fw-bold">IQ {{ number_format($row['net_payable'], 2) }}</td>
                    <td>
                        <div class="sign-box"></div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">No approved salary sheet found for the selected month.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="text-end pe-3">{{ __('messages.grand_total') }}</td>
                    <td class="text-end">IQ {{ number_format($totals['basic_salary'], 2) }}</td>
                    <td class="text-end">{{ $totals['bonus'] > 0 ? 'IQ ' . number_format($totals['bonus'], 2) : '-' }}
                    </td>
                    <td class="text-end">
                        {{ $totals['deduction'] > 0 ? 'IQ ' . number_format($totals['deduction'], 2) : '-' }}</td>
                    <td class="text-end final-total">IQ {{ number_format($totals['net_payable'], 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <div class="admin-signatures">
            <div class="sign-line">{{ __('messages.prepared_by') }} (HR)</div>
            <div class="sign-line">Checked By ({{ __('messages.accountant') }})</div>
            <div class="sign-line">
                @if($approvedSheet)
                <div>Approved By (Manager)</div>
                <div class="small mt-1">{{ $approvedSheet->approver?->name ?? 'System User' }}</div>
                <div class="small">{{ optional($approvedSheet->approved_at)->format('M d, Y h:i A') }}</div>
                @else
                Approved By (Manager)
                @endif
            </div>
        </div>

    </div>

    <script>
    function updateSheetDate() {
        const inputVal = document.getElementById('monthSelector').value;
        if (!inputVal) {
            return;
        }
        const dateObj = new Date(inputVal + '-01');
        const options = {
            year: 'numeric',
            month: 'long'
        };
        const formattedDate = dateObj.toLocaleDateString('en-US', options);
        document.getElementById('sheetDateDisplay').innerText = "Month: " + formattedDate;
    }
    </script>

</body>

</html>
