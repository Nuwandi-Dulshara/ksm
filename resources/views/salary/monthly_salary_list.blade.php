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
        position: relative;
        /* For Stamp Positioning */
    }

    /* Table Design */
    .table-salary {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .table-salary th {
        background-color: #343a40 !important;
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

    /* Zebra Striping */
    .table-salary tbody tr:nth-child(even) td {
        background-color: #f2f2f2 !important;
    }

    .total-row td {
        background-color: #343a40 !important;
        color: white !important;
        font-weight: bold;
        font-size: 14px;
        border-top: 2px solid #000;
    }

    .total-row .final-total {
        background-color: #ffc107 !important;
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

    /* DIGITAL APPROVAL STAMP STYLES */
    .approval-stamp {
        display: none;
        /* Hidden by default */
        position: absolute;
        top: 100px;
        right: 50px;
        border: 4px solid;
        padding: 10px 20px;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 2rem;
        transform: rotate(-15deg);
        opacity: 0.9;
        z-index: 10;
        text-align: center;
    }

    .stamp-approved {
        color: #198754;
        /* Green */
        border-color: #198754;
    }

    .stamp-rejected {
        color: #dc3545;
        /* Red */
        border-color: #dc3545;
    }

    .reason-box {
        font-size: 1rem;
        margin-top: 5px;
        color: #dc3545;
        font-weight: normal;
        background: white;
        border: 1px solid #dc3545;
        padding: 2px 5px;
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

        /* FORCE PRINTER TO PRINT COLORS */
        .table-salary th,
        .table-salary td,
        .table-salary tbody tr:nth-child(even) td,
        .total-row td,
        .approval-stamp {
            border: 1px solid #000 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Specific border colors for stamps in print */
        .stamp-approved {
            border-color: #198754 !important;
            color: #198754 !important;
        }

        .stamp-rejected {
            border-color: #dc3545 !important;
            color: #dc3545 !important;
        }
    }
    </style>
</head>

<body>

    <div class="toolbar no-print">
        <div class="d-flex align-items-center gap-3">
            <h5 class="mb-0 me-3">{{ __('messages.salary') }} Sheet</h5>

            <form method="GET" action="{{ route('monthly.salary') }}" class="d-flex align-items-center gap-2 mb-0">
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

        <div id="actionButtons">
            <form id="approveSalaryForm" method="POST" action="{{ route('monthly.salary.approve') }}" class="d-inline">
                @csrf
                <input type="hidden" name="month" value="{{ $salaryMonthValue }}">
            </form>
            <button onclick="approveSheet()" class="btn btn-success fw-bold btn-sm me-2">
                <i class="fa-solid fa-check me-2"></i> Approve
            </button>
            <button data-bs-toggle="modal" data-bs-target="#rejectModal" class="btn btn-danger fw-bold btn-sm me-2">
                <i class="fa-solid fa-xmark me-2"></i> Reject
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm me-2">Back</a>
            <button onclick="window.print()" class="btn btn-warning fw-bold btn-sm">
                <i class="fa-solid fa-print me-2"></i> Print
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

        <div id="stampApproved" class="approval-stamp stamp-approved">
            OFFICIALLY APPROVED
            <div style="font-size: 0.8rem; border-top: 1px solid #198754; margin-top: 5px;">
                Digitally Signed by Admin
            </div>
        </div>
        <div id="stampRejected" class="approval-stamp stamp-rejected">
            REJECTED
            <div id="rejectReasonDisplay" class="reason-box">Reason: Calculation Error</div>
        </div>

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
                    <td class="text-end">${{ number_format($row['basic_salary'], 2) }}</td>
                    <td class="text-end">{{ $row['bonus'] > 0 ? '$' . number_format($row['bonus'], 2) : '-' }}</td>
                    <td class="text-end">{{ $row['deduction'] > 0 ? '$' . number_format($row['deduction'], 2) : '-' }}</td>
                    <td class="text-end fw-bold">${{ number_format($row['net_payable'], 2) }}</td>
                    <td>
                        <div class="sign-box"></div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">No employees found for the selected month.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="text-end pe-3">{{ __('messages.grand_total') }}</td>
                    <td class="text-end">${{ number_format($totals['basic_salary'], 2) }}</td>
                    <td class="text-end">{{ $totals['bonus'] > 0 ? '$' . number_format($totals['bonus'], 2) : '-' }}</td>
                    <td class="text-end">{{ $totals['deduction'] > 0 ? '$' . number_format($totals['deduction'], 2) : '-' }}</td>
                    <td class="text-end final-total">${{ number_format($totals['net_payable'], 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <div class="admin-signatures">
            <div class="sign-line">{{ __('messages.prepared_by') }} (HR)</div>
            <div class="sign-line">Checked By ({{ __('messages.accountant') }})</div>
            <div class="sign-line" id="managerSignLine">
                Approved By (Manager)
            </div>
        </div>

    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Reject {{ __('messages.salary') }} Sheet</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Please provide a reason for rejecting this sheet. This will be printed on the document.</p>
                    <textarea id="rejectReasonInput" class="form-control" rows="3"
                        placeholder="e.g. Bonus calculation for Ahmed is incorrect."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                    <button type="button" class="btn btn-danger fw-bold" onclick="submitRejection()">Confirm
                        Rejection</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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

    function approveSheet() {
        if (confirm("Are you sure you want to Officially Approve this sheet?")) {
            document.getElementById('approveSalaryForm').submit();
        }
    }

    function submitRejection() {
        const reason = document.getElementById('rejectReasonInput').value;
        if (!reason) {
            alert("Please type a reason.");
            return;
        }

        // 1. Close Modal
        const modalEl = document.getElementById('rejectModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();

        // 2. Show Red Stamp & Reason
        document.getElementById('stampApproved').style.display = 'none';
        const rejectStamp = document.getElementById('stampRejected');
        rejectStamp.style.display = 'block';
        document.getElementById('rejectReasonDisplay').innerText = "Reason: " + reason;

        // 3. Hide Buttons
        document.getElementById('actionButtons').innerHTML = `
                <div class="text-danger fw-bold me-3"><i class="fa-solid fa-xmark-circle"></i> Sheet Rejected</div>
                <button onclick="window.print()" class="btn btn-warning fw-bold btn-sm"><i class="fa-solid fa-print me-2"></i> Print Now</button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm ms-2">Back</a>
            `;
    }
    </script>

</body>

</html>
