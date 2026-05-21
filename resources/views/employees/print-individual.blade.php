<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile - {{ $employee->full_name }}</title>
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

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #667eea;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .employee-header {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .info-section h3 {
            color: #667eea;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            min-width: 150px;
        }

        .info-value {
            color: #333;
            text-align: right;
        }

        .section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .section h2 {
            color: #333;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .section-content {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .field-group {
            display: flex;
            flex-direction: column;
        }

        .field-label {
            font-weight: 600;
            color: #667eea;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .field-value {
            color: #333;
            font-size: 14px;
            line-height: 1.6;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .status-probation {
            background-color: #f3e5f5;
            color: #6a1b9a;
        }

        .status-part_time {
            background-color: #fff3e0;
            color: #e65100;
        }

        .salary-box {
            grid-column: 1 / -1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .salary-label {
            font-size: 12px;
            text-transform: uppercase;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .salary-value {
            font-size: 28px;
            font-weight: bold;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .footer {
            border-top: 2px solid #eee;
            padding-top: 20px;
            margin-top: 40px;
            text-align: center;
            color: #999;
            font-size: 12px;
        }

        .print-button {
            margin-bottom: 20px;
            text-align: right;
        }

        .print-button button {
            background-color: #1976d2;
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
            background-color: #1565c0;
        }

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
    </style>
</head>
<body>
    <div class="print-button">
        <button onclick="window.print();">
            <i class="fa-solid fa-print"></i> Print / Save as PDF
        </button>
    </div>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Employee Profile</h1>
            <p>ACCOSYS - Financial Management System</p>
        </div>

        <!-- Employee Header -->
        <div class="employee-header">
            <div class="info-section">
                <h3>Personal Information</h3>
                <div class="info-row">
                    <span class="info-label">Full Name:</span>
                    <span class="info-value">{{ $employee->full_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Job Title:</span>
                    <span class="info-value">{{ $employee->job_title ?? 'Not specified' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Gender:</span>
                    <span class="info-value text-capitalize">{{ $employee->gender ?? 'Not specified' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date of Birth:</span>
                    <span class="info-value">
                        {{ $employee->date_of_birth ? \Carbon\Carbon::parse($employee->date_of_birth)->format('F d, Y') : 'Not specified' }}
                    </span>
                </div>
            </div>

            <div class="info-section">
                <h3>Employment Information</h3>
                <div class="info-row">
                    <span class="info-label">Join Date:</span>
                    <span class="info-value">
                        {{ \Carbon\Carbon::parse($employee->join_date)->format('F d, Y') }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Employment Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ str_replace(' ', '_', strtolower($employee->employment_status)) }}">
                            {{ str_replace('_', ' ', $employee->employment_status) }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Method:</span>
                    <span class="info-value text-capitalize">{{ $employee->payment_method }}</span>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="section">
            <h2>Contact Information</h2>
            <div class="section-content">
                <div class="field-group">
                    <span class="field-label">Email Address</span>
                    <span class="field-value">{{ $employee->email ?? 'Not provided' }}</span>
                </div>
                <div class="field-group">
                    <span class="field-label">Phone Number</span>
                    <span class="field-value">{{ $employee->phone_number ?? 'Not provided' }}</span>
                </div>
            </div>
        </div>

        <!-- Salary & Payment Information -->
        <div class="section">
            <h2>Salary & Payment</h2>
            <div class="section-content">
                <div class="salary-box">
                    <div class="salary-label">Monthly Salary</div>
                    <div class="salary-value">IQ {{ number_format($employee->base_monthly_salary, 2) }}</div>
                </div>
                <div class="field-group full-width">
                    <span class="field-label">Bank Details</span>
                    <span class="field-value">{{ $employee->bank_details ?? 'Not provided' }}</span>
                </div>
            </div>
        </div>

        <!-- Timestamps -->
        <div class="section">
            <h2>Record Information</h2>
            <div class="section-content">
                <div class="field-group">
                    <span class="field-label">Record Created</span>
                    <span class="field-value">{{ $employee->created_at->format('F d, Y H:i:s') }}</span>
                </div>
                <div class="field-group">
                    <span class="field-label">Last Updated</span>
                    <span class="field-value">{{ $employee->updated_at->format('F d, Y H:i:s') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is an automatically generated employee profile from ACCOSYS System</p>
            <p>{{ now()->format('F d, Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
