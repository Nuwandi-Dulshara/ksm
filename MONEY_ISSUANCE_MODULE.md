# Money Issuance Module Documentation

## Overview

The Money Issuance module allows you to register, track, approve, and manage issued money/funds within the system. This module includes comprehensive features for managing money distributions with approval workflows, filters, and reporting capabilities.

## Features

### 1. **Money Registration**

- Register new money issuances with detailed information
- Track who receives the money
- Record the reason for issuance
- Add optional notes and descriptions
- Set the issued date
- All issuances start with **Pending** status

### 2. **Admin Approval System**

- Pending issuances require admin approval
- Admins can approve or reject issuances
- Add admin notes during approval/rejection
- Only pending issuances can be edited or deleted

### 3. **Filtering & Search**

- **Search Bar**: Search by recipient name, email, or reason
- **Status Filter**: Filter by Pending, Approved, or Rejected
- **Date Range Filter**: Filter by issued date range
- Combine multiple filters for precise results

### 4. **Dashboard Statistics**

- Quick overview of pending, approved, and rejected issuances
- Display total pending and approved amounts
- Real-time status counts

### 5. **Reports & Printing**

- **Date Range Reports**: Generate reports for specific date ranges
- **Status-based Reports**: Filter reports by status
- **Individual Reports**: View detailed report for each issuance
- **Print Functionality**: Print reports for record-keeping

## File Structure

```
app/
├── Models/
│   └── MoneyIssuance.php              # Model with relationships and scopes
├── Http/Controllers/
│   └── MoneyIssuanceController.php    # All business logic

database/
└── migrations/
    └── 2026_05_21_000000_create_money_issuances_table.php

resources/views/money-issuances/
├── index.blade.php                    # List all issuances
├── create.blade.php                   # Create new issuance
├── edit.blade.php                     # Edit issuance
├── show-report.blade.php              # View detailed report
├── report.blade.php                   # Generate reports
├── print-report.blade.php             # Printable report (date range)
└── print-individual-report.blade.php  # Printable individual report

routes/
└── web.php                            # All routes registered
```

## Database Fields

The `money_issuances` table includes:

| Field          | Type      | Description                     |
| -------------- | --------- | ------------------------------- |
| id             | BIGINT    | Primary key                     |
| issued_to_id   | BIGINT    | User ID receiving the money     |
| recipient_type | VARCHAR   | employee, freelancer, or other  |
| amount         | DECIMAL   | Amount in currency units (IQ)   |
| reason         | VARCHAR   | Reason for issuance             |
| description    | TEXT      | Additional details              |
| notes          | TEXT      | Additional notes                |
| issued_date    | DATE      | When money was issued           |
| status         | VARCHAR   | pending, approved, or rejected  |
| created_by     | BIGINT    | User who created the record     |
| approved_by    | BIGINT    | Admin who approved/rejected     |
| approved_at    | TIMESTAMP | When approval happened          |
| admin_note     | TEXT      | Admin's approval/rejection note |
| timestamps     | -         | created_at, updated_at          |

## Routes

### Navigation Links

- **Index**: `/money-issuances` - View all issuances
- **Create**: `/money-issuances/create` - Issue new money
- **Edit**: `/money-issuances/{id}/edit` - Edit pending issuance
- **Show**: `/money-issuances/{id}` - View details (requires adjustment)
- **Report**: `/money-issuances-report` - Generate reports

### Actions

- **Approve**: `POST /money-issuances/{id}/approve`
- **Reject**: `POST /money-issuances/{id}/reject`
- **Delete**: `DELETE /money-issuances/{id}` (pending only)
- **Individual Report**: `GET /money-issuances/{id}/report`
- **Print Individual**: `GET /money-issuances/{id}/print-report`

## Usage Guide

### Registering Money Issuance

1. Click "Money Issuances" in sidebar
2. Click "Issue Money" button
3. Fill in the form:
    - Select recipient
    - Choose recipient type
    - Enter amount
    - Set issued date
    - Provide reason
    - Add optional description and notes
4. Submit - issuance will be in **Pending** status

### Approving/Rejecting

1. Go to Money Issuances index
2. Click approve or reject icon
3. Enter optional admin note
4. Confirm

### Generating Reports

1. Click "Issuance Reports" in sidebar
2. Set filters (date range, status, recipient)
3. Click "Generate Report" to view
4. Click "Print" to print the report
5. For individual report, click print icon on issuance row

### Viewing Individual Report

1. Click eye icon on issuance row
2. View detailed information
3. Click "Print" for printable version

## Status Workflow

```
Created (Pending)
    ↓
Admin Review
    ├─→ Approved ✓
    └─→ Rejected ✗
```

- **Pending**: Awaiting admin approval (editable and deletable)
- **Approved**: Admin has approved (not editable)
- **Rejected**: Admin has rejected (not editable)

## Key Features in Detail

### 1. Index Page

- Table view of all issuances with pagination
- Statistics cards showing pending, approved, rejected counts
- Filter section for search and date range
- Action buttons for each issuance:
    - View report
    - Edit (if pending)
    - Approve (if pending)
    - Reject (if pending)
    - Delete (if pending)
    - Print report

### 2. Create Page

- Form with all required fields
- Validation for all inputs
- Amount input with IQ currency
- Tips panel with best practices
- Confirmation that issuance will be pending

### 3. Edit Page

- Only editable when status is pending
- All fields same as create
- Status info panel showing current status
- Admin note display if exists

### 4. Report View

- Multiple filter options:
    - Date range (from/to dates)
    - Status filter
    - Individual recipient selection
- Summary statistics
- Detailed table with all issuances
- Print button for printing report

### 5. Individual Report

- Dedicated view for single issuance
- Complete details including all notes
- Action buttons if pending
- Print button for printable version
- Detailed payment information

## Validation Rules

When creating/editing an issuance:

- `issued_to_id`: Required, must exist in users table
- `recipient_type`: Required, must be employee, freelancer, or other
- `amount`: Required, numeric, minimum 0.01
- `reason`: Required, max 255 characters
- `description`: Optional, max 1000 characters
- `notes`: Optional, max 1000 characters
- `issued_date`: Required, cannot be in the future

## Approval Notes

- Admins can add notes when approving or rejecting
- Rejection reason is mandatory
- Approval note is optional
- Notes are visible on detailed report view

## Cards/Financial Cards Feature Note

The requirement mentions "Cards can be created for all of them" - this appears to refer to creating financial cards or records for tracking issued funds. The current implementation stores all issuance data in the database which can be used to generate cards or further integrate with a card management system.

## Future Enhancements

Potential additions based on requirements:

- Card creation/printing for issued funds
- Integration with payment methods
- Budget allocation tracking
- Receipt generation and archiving
- Email notifications for approvals
- Bulk operations for multiple issuances
- Export to Excel/PDF
- Dashboard widget for quick overview

## Troubleshooting

**Can't edit issuance:**

- Check if status is "pending" - only pending issuances are editable

**Can't see in sidebar:**

- Clear browser cache
- Verify routes are registered correctly
- Check user permissions if implemented

**Print not working:**

- Use browser's print function (Ctrl+P)
- Check browser print settings
- PDF viewers should work fine

## Security Considerations

- Only authenticated users can access
- Approval/rejection requires admin role (implement if needed)
- All user inputs are validated and sanitized
- Database relationships prevent orphaned records

---

Created: May 21, 2026
Version: 1.0
