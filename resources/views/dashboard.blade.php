@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">{{ __('messages.dashboard_overview') }}</h2>

        <div class="d-flex align-items-center gap-3">
            @php
                $currentLocale = app()->getLocale();
                $languages = [
                    'en' => 'English',
                    'ar' => 'العربية',
                    'ku' => 'کوردی',
                ];
            @endphp

            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle fw-bold" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-language me-1"></i>
                    {{ $languages[$currentLocale] ?? 'English' }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    @foreach($languages as $locale => $label)
                    <li>
                        <a class="dropdown-item {{ $currentLocale === $locale ? 'active' : '' }}"
                            href="{{ route('language.switch', $locale) }}">
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <button class="btn btn-warning position-relative text-white fw-bold">
                <i class="fa-solid fa-bell"></i> {{ __('messages.pending') }}
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
                <p class="text-muted mb-1">{{ __('messages.total_income') }}</p>
                <h4 class="fw-bold text-success">
                    ${{ number_format($totalIncome,2) }}
                </h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-metric p-3">
                <p class="text-muted mb-1">{{ __('messages.total_outcome') }}</p>
                <h4 class="fw-bold text-danger">
                    ${{ number_format($totalOutcome,2) }}
                </h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-metric p-3">
                <p class="text-muted mb-1">{{ __('messages.net_balance') }}</p>
                <h4 class="fw-bold text-primary">
                    ${{ number_format($netBalance,2) }}
                </h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-metric p-3 border border-warning">
                <p class="text-muted mb-1">{{ __('messages.pending_approval') }}</p>
                <h4 class="fw-bold text-warning">
                    {{ $pendingCount }} Requests
                </h4>
            </div>
        </div>

    </div>

    <!-- PENDING TABLE -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">{{ __('messages.recent_pending_requests') }}</h5>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">{{ __('messages.request_date') }}</th>
                        <th>{{ __('messages.description') }}</th>
                        <th>{{ __('messages.category') }}</th>
                        <th>{{ __('messages.amount') }}</th>
                        <th class="text-end pe-4">{{ __('messages.actions') }}</th>
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
                            <form action="{{ route('outcomes.approve',$request->id) }}" method="POST"
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
                            {{ __('messages.no_pending_requests') }}
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
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="rejectForm" method="POST">
                @csrf

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Reason for Rejection
                        </label>
                        <textarea name="admin_note" class="form-control" required></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger fw-bold">
                            Confirm Rejection
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
function openDecisionModal(type, id) {
    let form = document.getElementById('rejectForm');
    form.action = "/outcomes/" + id + "/reject";

    let modal = new bootstrap.Modal(
        document.getElementById('decisionModal')
    );

    modal.show();
}
</script>

@endsection
