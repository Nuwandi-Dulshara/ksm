<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval History | AccoSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    body {
        background-color: #f8f9fa;
    }

    .sidebar {
        height: 100vh;
        background-color: #1e3a8a;
        /* Deep Blue */
        color: white;
        position: fixed;
        width: 250px;
    }

    .sidebar a {
        color: #cfd8dc;
        text-decoration: none;
        padding: 15px 20px;
        display: block;
        border-left: 4px solid transparent;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: #102a71;
        border-left-color: #6c757d;
        /* Gray for History */
        color: white;
    }

    .main-content {
        margin-left: 250px;
        padding: 20px;
    }
    </style>
</head>

<body>


    <div class="main-content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-0">Approval Log</h2>
                <p class="text-muted mb-0">Audit trail of all financial decisions.</p>
            </div>
            <button class="btn btn-outline-secondary" onclick="window.print()">
                <i class="fa-solid fa-print me-2"></i> Print Log
            </button>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-3">
                <form class="row g-2 align-items-center">
                    <div class="col-md-3">
                        <label class="small text-muted fw-bold">Status</label>
                        <select class="form-select form-select-sm">
                            <option value="all">All Decisions</option>
                            <option value="approved">Approved Only</option>
                            <option value="rejected">Rejected Only</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small text-muted fw-bold">Month</label>
                        <input type="month" class="form-control form-control-sm" value="2026-01">
                    </div>
                    <div class="col-md-4">
                        <label class="small text-muted fw-bold">Search</label>
                        <input type="text" class="form-control form-control-sm"
                            placeholder="Search by description or user...">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-sm btn-primary w-100">Filter Results</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Request Date</th>
                            <th>Request Details</th>
                            <th>Requested By</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Decision By</th>
                            <th>Admin Note</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td class="ps-4 text-muted small">Jan 22, 2026<br>10:30 AM</td>
                            <td>
                                <div class="fw-bold text-dark">Office Internet Bill</div>
                                <div class="small text-muted">Monthly Fastlink Subscription</div>
                            </td>
                            <td>Ahmed (Acc)</td>
                            <td class="fw-bold">$45.00</td>
                            <td><span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Approved</span>
                            </td>
                            <td>
                                <div class="small fw-bold">Saman Manager</div>
                                <div class="small text-muted">Jan 22, 11:00 AM</div>
                            </td>
                            <td class="text-muted small"><em>-</em></td>
                        </tr>

                        <tr class="table-danger bg-opacity-10">
                            <td class="ps-4 text-muted small">Jan 20, 2026<br>09:15 AM</td>
                            <td>
                                <div class="fw-bold text-dark">New Gaming Chair</div>
                                <div class="small text-muted">Office Furniture Request</div>
                            </td>
                            <td>Ali (Dev)</td>
                            <td class="fw-bold">$250.00</td>
                            <td><span class="badge bg-danger"><i class="fa-solid fa-xmark me-1"></i> Rejected</span>
                            </td>
                            <td>
                                <div class="small fw-bold">Saman Manager</div>
                                <div class="small text-muted">Jan 20, 09:30 AM</div>
                            </td>
                            <td class="text-danger small fw-bold">
                                "Budget exceeded. Use standard chairs."
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4 text-muted small">Jan 18, 2026<br>02:00 PM</td>
                            <td>
                                <div class="fw-bold text-dark">Article Payment: Ali Ahmed</div>
                                <div class="small text-muted">Category: Xakveen</div>
                            </td>
                            <td>Ahmed (Acc)</td>
                            <td class="fw-bold">$50.00</td>
                            <td><span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Approved</span>
                            </td>
                            <td>
                                <div class="small fw-bold">Saman Manager</div>
                                <div class="small text-muted">Jan 18, 04:00 PM</div>
                            </td>
                            <td class="text-muted small">Paid via FastPay</td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white py-3">
                <nav>
                    <ul class="pagination justify-content-center mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>