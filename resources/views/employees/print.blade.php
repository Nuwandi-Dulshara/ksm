<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees Report</title>
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
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #667eea;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .report-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            font-size: 13px;
            color: #666;
        }

        .report-info-item {
            display: flex;
            flex-direction: column;
        }

        .report-info-label {
            font-weight: bold;
            color: #333;
            margin-bottom: 3px;
        }

        /* Job Title Section */
        .job-title-section {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }

        .job-title-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .job-title-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .job-title-count {
            font-size: 12px;
            opacity: 0.9;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 5px 12px;
            border-radius: 20px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background-color: #f0f0f0;
        }

        table th {
            padding: 12px;
            text-align: left;
            color: #333;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #667eea;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
            color: #333;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        table tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 11px;
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

        .text-right {
            text-align: right;
        }

        /* Footer */
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

            .job-title-section {
                page-break-inside: avoid;
            }

            table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="print-button">
        <button onclick="window.print();">
            <i class="fa-solid fa-print"></i> Print Report
        </button>
    </div>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Employee Directory</h1>
            <p>Comprehensive Employee Information Report</p>
        </div>

        <!-- Report Info -->
        <div class="report-info">
            <div class="report-info-item">
                <span class="report-info-label">Report Date:</span>
                <span>{{ now()->format('F d, Y') }}</span>
            </div>
            <div class="report-info-item">
                <span class="report-info-label">Total Employees:</span>
                <span>{{ $employees->count() }}</span>
            </div>
            <div class="report-info-item">
                <span class="report-info-label">Filter:</span>
                <span>{{ $jobTitle ? "Job Title: $jobTitle" : 'All Employees' }}</span>
            </div>
        </div>

        <!-- Employee Sections by Job Title -->
        @php
            $groupedByTitle = $employees->groupBy('job_title')->sort();
        @endphp

        @foreach($groupedByTitle as $title => $titleEmployees)
        <div class="job-title-section">
            <div class="job-title-header">
                <h3>{{ $title ?? 'Not Specified' }}</h3>
                <span class="job-title-count">{{ $titleEmployees->count() }} employee(s)</span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Join Date</th>
                        <th class="text-right">Salary</th>
                        <th>Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($titleEmployees as $employee)
                    <tr>
                        <td>{{ $employee->full_name }}</td>
                        <td>{{ $employee->email ?? 'N/A' }}</td>
                        <td>{{ $employee->phone_number ?? 'N/A' }}</td>
                        <td>
                            <span class="status-badge status-{{ str_replace(' ', '_', strtolower($employee->employment_status)) }}">
                                {{ str_replace('_', ' ', $employee->employment_status) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($employee->join_date)->format('M d, Y') }}</td>
                        <td class="text-right">IQ {{ number_format($employee->base_monthly_salary, 2) }}</td>
                        <td>{{ ucfirst($employee->payment_method) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach

        <!-- Footer -->
        <div class="footer">
            <p>This report was generated automatically on {{ now()->format('F d, Y H:i:s') }}</p>
            <p>ACCOSYS - Financial Management System</p>
        </div>
    </div>
</body>
</html>
