<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Issuance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            body { margin: 0; padding: 0; }
            .no-print { display: none; }
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .report-header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .report-title { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
        .report-subtitle { font-size: 14px; color: #666; }
        .summary-box { margin-bottom: 30px; }
        .summary-item { display: inline-block; margin-right: 30px; min-width: 150px; }
        .summary-label { font-size: 12px; color: #666; text-transform: uppercase; }
        .summary-value { font-size: 18px; font-weight: bold; }
        table { margin-top: 20px; }
        th { background-color: #f5f5f5; font-weight: bold; padding: 12px; }
        td { padding: 10px 12px; border-bottom: 1px solid #ddd; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #666; }
        .amount { text-align: right; }
    </style>
</head>
<body>
    <div class="container">
        <div class="report-header">
            <div class="report-title">Money Issuance Report</div>
            <div class="report-subtitle">Period: {{ Carbon\Carbon::parse($startDate)->format('d M Y') }} to {{ Carbon\Carbon::parse($endDate)->format('d M Y') }}</div>
        </div>

        <div class="summary-box">
            <div class="summary-item">
                <div class="summary-label">Total Items</div>
                <div class="summary-value">{{ $issuances->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Total Amount</div>
                <div class="summary-value">{{ number_format($issuances->sum('amount'), 0) }} IQ</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Approved Amount</div>
                <div class="summary-value">{{ number_format($issuances->where('status', 'approved')->sum('amount'), 0) }} IQ</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Pending Amount</div>
                <div class="summary-value">{{ number_format($issuances->where('status', 'pending')->sum('amount'), 0) }} IQ</div>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Recipient</th>
                    <th>Reason</th>
                    <th class="amount">Amount (IQ)</th>
                    <th>Issued Date</th>
                    <th>Status</th>
                    <th>Approved By</th>
                </tr>
            </thead>
            <tbody>
                @forelse($issuances as $key => $issuance)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <strong>{{ $issuance->issuedTo?->name ?? 'Unknown' }}</strong>
                        <br>
                        <small>{{ $issuance->issuedTo?->email }}</small>
                    </td>
                    <td>{{ $issuance->reason }}</td>
                    <td class="amount">{{ number_format($issuance->amount, 0) }}</td>
                    <td>{{ $issuance->issued_date->format('d M Y') }}</td>
                    <td>{{ ucfirst($issuance->status) }}</td>
                    <td>{{ $issuance->approvedBy?->name ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No records found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <p>Generated on {{ now()->format('d M Y H:i') }}</p>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
