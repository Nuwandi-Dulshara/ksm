@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Dashboard Overview</h2>

        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-warning position-relative text-white fw-bold">
                <i class="fa-solid fa-bell"></i> Pending
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $pendingCount }}
                </span>
            </button>
        </div>
    </div>

    <!-- METRICS -->
    <div class="row g-4 mb-5">

        <div class="col-md-3">
            <div class="card card-metric p-3">
                <p class="text-muted mb-1">Total Income</p>
                <h4 class="fw-bold text-success">
                    ${{ number_format($totalIncome,2) }}
                </h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-metric p-3">
                <p class="text-muted mb-1">Total Outcome</p>
                <h4 class="fw-bold text-danger">
                    ${{ number_format($totalOutcome,2) }}
                </h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-metric p-3">
                <p class="text-muted mb-1">Net Balance</p>
                <h4 class="fw-bold text-primary">
                    ${{ number_format($netBalance,2) }}
                </h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-metric p-3 border border-warning">
                <p class="text-muted mb-1">Pending Approval</p>
                <h4 class="fw-bold text-warning">
                    {{ $pendingCount }} Requests
                </h4>
            </div>
        </div>

    </div>

    <!-- PENDING TABLE -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Recent Pending Requests</h5>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Request Date</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($pendingRequests as $request)

                    <tr>
                        <td class="ps-4">
                            {{ \Carbon\Carbon::parse($request->date)->format('M d, Y') }}
                        </td>

                        <td>{{ $request->description }}</td>

                        <td>
                            {{ $request->expenseCategory->category_name ?? '-' }}
                        </td>

                        <td class="fw-bold text-danger">
                            -${{ number_format($request->amount,2) }}
                        </td>

                        <td class="text-end pe-4">

                            <!-- APPROVE -->
                            <form action="{{ route('outcomes.approve',$request->id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                <button class="btn btn-sm btn-success me-1">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>

                            <!-- REJECT -->
                            <button class="btn btn-sm btn-danger"
                                onclick="openDecisionModal('reject', {{ $request->id }})">
                                <i class="fa-solid fa-xmark"></i>
                            </button>

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            No Pending Requests
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- REJECT MODAL -->
<div class="modal fade" id="decisionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold">Reject Request</h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <form id="rejectForm" method="POST">
                @csrf

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Reason for Rejection
                        </label>
                        <textarea name="admin_note"
                                  class="form-control"
                                  required></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit"
                                class="btn btn-danger fw-bold">
                            Confirm Rejection
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
function openDecisionModal(type, id)
{
    let form = document.getElementById('rejectForm');
    form.action = "/outcomes/" + id + "/reject";

    let modal = new bootstrap.Modal(
        document.getElementById('decisionModal')
    );

    modal.show();
}
</script>

@endsection