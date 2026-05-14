<div class="card shadow-sm border-0">
    <div class="card-body p-4">

        <div class="form-section-title">Freelancer Information</div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Full Name</label>
                <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                    placeholder="e.g. Ali Ahmed" value="{{ old('full_name', $freelancer?->full_name) }}" required>
                @error('full_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Group / Category</label>
                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                    <option disabled value="" {{ old('category', $freelancer?->category) ? '' : 'selected' }}>
                        Select Category...
                    </option>
                    <option value="xakveen" {{ old('category', $freelancer?->category) === 'xakveen' ? 'selected' : '' }}>
                        Xakveen
                    </option>
                    <option value="pages" {{ old('category', $freelancer?->category) === 'pages' ? 'selected' : '' }}>
                        Pages
                    </option>
                </select>
                @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Service / Skill</label>
                <input type="text" name="service_skill"
                    class="form-control @error('service_skill') is-invalid @enderror"
                    placeholder="e.g. Graphic Designer, Content Writer"
                    value="{{ old('service_skill', $freelancer?->service_skill) }}">
                @error('service_skill')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label text-muted small">Phone Number</label>
                <input type="tel" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                    placeholder="+964 ..." value="{{ old('phone_number', $freelancer?->phone_number) }}">
                @error('phone_number')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12">
                <label class="form-label text-muted small">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="email@example.com" value="{{ old('email', $freelancer?->email) }}">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-section-title">Rate & Agreement</div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold text-success">Billing Rate</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" name="billing_rate"
                        class="form-control fw-bold @error('billing_rate') is-invalid @enderror" placeholder="0.00"
                        step="0.01" min="0" value="{{ old('billing_rate', $freelancer?->billing_rate) }}" required>
                    <select name="rate_type" class="form-select bg-light @error('rate_type') is-invalid @enderror"
                        style="max-width: 160px;">
                        <option value="hourly" {{ old('rate_type', $freelancer?->rate_type) === 'hourly' ? 'selected' : '' }}>
                            Per Hour
                        </option>
                        <option value="project" {{ old('rate_type', $freelancer?->rate_type ?? 'project') === 'project' ? 'selected' : '' }}>
                            Per Project
                        </option>
                        <option value="monthly" {{ old('rate_type', $freelancer?->rate_type) === 'monthly' ? 'selected' : '' }}>
                            Monthly
                        </option>
                        <option value="article" {{ old('rate_type', $freelancer?->rate_type) === 'article' ? 'selected' : '' }}>
                            Per Article
                        </option>
                        <option value="post" {{ old('rate_type', $freelancer?->rate_type) === 'post' ? 'selected' : '' }}>
                            Per Post
                        </option>
                    </select>
                </div>
                @error('billing_rate')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
                @error('rate_type')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label text-muted small">Current Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="active" {{ old('status', $freelancer?->status ?? 'active') === 'active' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="busy" {{ old('status', $freelancer?->status) === 'busy' ? 'selected' : '' }}>
                        Busy
                    </option>
                    <option value="inactive" {{ old('status', $freelancer?->status) === 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
                @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-section-title">Payment Details</div>
        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label text-muted small">Preferred Payment Method & Details</label>
                <textarea name="payment_details" class="form-control @error('payment_details') is-invalid @enderror"
                    rows="2" placeholder="e.g. FastPay: 0750..., or ZainCash">{{ old('payment_details', $freelancer?->payment_details) }}</textarea>
                @error('payment_details')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-section-title">Documents</div>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label text-muted small">Portfolio Link</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-link"></i></span>
                    <input type="url" name="portfolio_url"
                        class="form-control @error('portfolio_url') is-invalid @enderror" placeholder="https://..."
                        value="{{ old('portfolio_url', $freelancer?->portfolio_url) }}">
                    @error('portfolio_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted small">Upload Contract</label>
                <input type="file" name="contract" class="form-control @error('contract') is-invalid @enderror">
                @error('contract')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        @if($freelancer?->contract_path)
        <div class="mb-4">
            <a href="{{ asset('storage/' . $freelancer->contract_path) }}" target="_blank"
                class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-file-lines me-2"></i> View Current Contract
            </a>
        </div>
        @endif

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('freelancers.index') }}" class="btn btn-light border">Cancel</a>
            <button type="submit" class="btn btn-primary fw-bold px-4">
                <i class="fa-solid fa-save me-2"></i> {{ $buttonText }}
            </button>
        </div>

    </div>
</div>
