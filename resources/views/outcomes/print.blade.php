<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $outcome->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 3px solid #dc3545;
            padding-bottom: 20px;
        }

        .company-info h1 {
            color: #dc3545;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .company-info p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 40px;
        }

        .detail-group h3 {
            color: #dc3545;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .detail-group p {
            color: #333;
            font-size: 14px;
            line-height: 1.8;
            margin-bottom: 4px;
        }

        .detail-group .label {
            color: #666;
            font-weight: 500;
            display: inline-block;
            width: 140px;
        }

        /* Items Table */
        .items-section {
            margin-bottom: 40px;
        }

        .items-section h3 {
            color: #333;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background-color: #f8f9fa;
        }

        table thead tr {
            border-bottom: 2px solid #dc3545;
        }

        table th {
            padding: 12px;
            text-align: left;
            color: #333;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
            color: #333;
        }

        table td.text-right {
            text-align: right;
        }

        table tbody tr:hover {
            background-color: #f5f5f5;
        }

        /* Summary Section */
        .summary {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }

        .summary-box {
            width: 350px;
            background-color: #f8f9fa;
            border: 2px solid #dc3545;
            border-radius: 8px;
            padding: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
            color: #333;
        }

        .summary-row.total {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
            font-size: 18px;
            font-weight: bold;
            color: #dc3545;
            padding-top: 10px;
            border-top: 2px solid #dc3545;
        }

        .summary-row .label {
            font-weight: 500;
        }

        .summary-row .value {
            text-align: right;
            font-weight: 600;
        }

        /* Notes Section */
        .notes {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 40px;
            border-left: 4px solid #dc3545;
        }

        .notes h4 {
            color: #333;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        .notes p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            border-top: 2px solid #eee;
            padding-top: 20px;
            text-align: center;
            color: #999;
            font-size: 12px;
            line-height: 1.8;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Print Styles */
        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }

            .print-button {
                display: none;
            }
        }

        .print-button {
            margin-bottom: 20px;
            text-align: right;
        }

        .print-button button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .print-button button:hover {
            background-color: #0056b3;
        }

        .print-button button i {
            margin-right: 8px;
        }

        .header-line {
            color: #dc3545;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .created-info {
            font-size: 12px;
            color: #999;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="print-button">
        <button onclick="window.print();">
            <i class="fas fa-print"></i> Print / Save as PDF
        </button>
    </div>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>ACCOSYS</h1>
                <p class="header-line">Financial Management System</p>
                <p>Organization Expense Invoice</p>
            </div>
            <div class="invoice-title">
                <h2>INVOICE</h2>
                <p><strong>Invoice #:</strong> {{ $outcome->invoice_number }}</p>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="detail-group">
                <h3>Expense Details</h3>
                <p><span class="label">Date:</span> {{ \Carbon\Carbon::parse($outcome->date)->format('F d, Y') }}</p>
                <p><span class="label">Created By:</span> {{ $outcome->creator?->name ?? 'N/A' }}</p>
                <p><span class="label">Created On:</span> {{ $outcome->created_at->format('F d, Y H:i') }}</p>
            </div>

            <div class="detail-group">
                <h3>Approval Details</h3>
                <p><span class="label">Status:</span> <span class="status-badge status-{{ strtolower($outcome->status) }}">{{ ucfirst($outcome->status) }}</span></p>
                <p><span class="label">Approved By:</span> {{ $outcome->decisionBy?->name ?? 'N/A' }}</p>
                <p><span class="label">Approved On:</span> {{ $outcome->decided_at ? \Carbon\Carbon::parse($outcome->decided_at)->format('F d, Y H:i') : 'N/A' }}</p>
            </div>
        </div>

        <!-- Items Section -->
        <div class="items-section">
            <h3>Expense Information</h3>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Paid To</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $outcome->description }}</td>
                        <td>{{ $outcome->expenseCategory?->category_name ?? '-' }} ({{ $outcome->expenseType?->type_name ?? '-' }})</td>
                        <td>{{ $outcome->beneficiary }}</td>
                        <td class="text-right"><strong>IQ {{ number_format($outcome->amount, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-box">
                <div class="summary-row">
                    <span class="label">Subtotal:</span>
                    <span class="value">IQ {{ number_format($outcome->amount, 2) }}</span>
                </div>
                <div class="summary-row total">
                    <span class="label">TOTAL AMOUNT:</span>
                    <span class="value">IQ {{ number_format($outcome->amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($outcome->admin_note)
        <div class="notes">
            <h4>Admin Notes</h4>
            <p>{{ $outcome->admin_note }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>This is an automatically generated invoice from ACCOSYS Financial Management System</p>
            <p>{{ \Carbon\Carbon::now()->format('F d, Y H:i:s') }}</p>
            <div class="created-info">
                <p>Invoice Reference: {{ $outcome->invoice_number }}</p>
            </div>
        </div>
    </div>

    <script>
        // Auto-print option - uncomment if you want it to print automatically
        // window.print();
    </script>
</body>
</html>
