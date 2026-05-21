<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Issuance Report - {{ $moneyIssuance->issuedTo?->name }}</title>
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
        .detail-section { margin-bottom: 30px; }
        .detail-row { display: flex; margin-bottom: 15px; }
        .detail-label { font-weight: bold; width: 200px; color: #333; }
        .detail-value { flex: 1; color: #666; }
        .amount-box { background-color: #f5f5f5; padding: 20px; border-radius: 5px; text-align: center; margin-bottom: 30px; }
        .amount-value { font-size: 36px; font-weight: bold; color: #28a745; }
        .footer { margin-top: 40px; border-top: 1px solid #ddd; padding-top: 20px; text-align: center; font-size: 12px; color: #666; }
        .status-badge { display: inline-block; padding: 8px 16px; border-radius: 5px; font-weight: bold; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-approved { background-color: #d4edda; color: #155724; }
        .status-rejected { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="report-header">
            <div class="report-title">Money Issuance Report</div>
            <div class="report-subtitle">Individual Recipient Report</div>
        </div>

        <div class="amount-box">
            <div style="color: #999; font-size: 14px; margin-bottom: 5px;">ISSUED AMOUNT</div>
            <div class="amount-value">{{ number_format($moneyIssuance->amount, 0) }} IQ</div>
        </div>

        <div class="detail-section">
            <div class="detail-row">
                <div class="detail-label">Recipient Name:</div>
                <div class="detail-value">{{ $moneyIssuance->issuedTo?->name ?? 'Unknown' }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Email:</div>
                <div class="detail-value">{{ $moneyIssuance->issuedTo?->email ?? '-' }}</div>
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-row">
                <div class="detail-label">Reason:</div>
                <div class="detail-value">{{ $moneyIssuance->reason }}</div>
            </div>
            @if($moneyIssuance->description)
            <div class="detail-row">
                <div class="detail-label">Description:</div>
                <div class="detail-value">{{ $moneyIssuance->description }}</div>
            </div>
            @endif
            @if($moneyIssuance->notes)
            <div class="detail-row">
                <div class="detail-label">Notes:</div>
                <div class="detail-value">{{ $moneyIssuance->notes }}</div>
            </div>
            @endif
        </div>

        <div class="detail-section">
            <div class="detail-row">
                <div class="detail-label">Issued Date:</div>
                <div class="detail-value">{{ $moneyIssuance->issued_date->format('d M Y') }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Status:</div>
                <div class="detail-value">
                    @if($moneyIssuance->status === 'pending')
                        <span class="status-badge status-pending">Pending Approval</span>
                    @elseif($moneyIssuance->status === 'approved')
                        <span class="status-badge status-approved">Approved</span>
                    @else
                        <span class="status-badge status-rejected">Rejected</span>
                    @endif
                </div>
            </div>
            @if($moneyIssuance->approved_by)
            <div class="detail-row">
                <div class="detail-label">Approved By:</div>
                <div class="detail-value">{{ $moneyIssuance->approvedBy?->name ?? 'System' }} on {{ $moneyIssuance->approved_at?->format('d M Y H:i') }}</div>
            </div>
            @endif
            @if($moneyIssuance->admin_note)
            <div class="detail-row">
                <div class="detail-label">Admin Note:</div>
                <div class="detail-value">{{ $moneyIssuance->admin_note }}</div>
            </div>
            @endif
        </div>

        <div class="footer">
            <p>Generated on {{ now()->format('d M Y H:i') }}</p>
            <p>This is an official record of money issuance</p>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
