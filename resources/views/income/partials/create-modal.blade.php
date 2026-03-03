<div class="modal fade" id="addIncomeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('income.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="fa-solid fa-circle-plus me-2"></i>Record Income
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Amount Received</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="amount" class="form-control form-control-lg" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small text-muted">Client / Source</label>
                            <select name="donator_id" class="form-select" required>
                                <option value="">Select Donator</option>
                                @foreach($donators as $donator)
                                    <option value="{{ $donator->id }}">
                                        {{ $donator->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6">
                            <label class="form-label small text-muted">Invoice Number</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $nextInvoiceNumber }}"
                                   readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Date Received</label>
                        <input type="date" name="received_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small text-muted">Attach Invoice (PDF/Img)</label>
                        <input type="file" name="invoice_file" class="form-control">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg fw-bold">
                            Save Record
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>