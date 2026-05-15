<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Category Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    placeholder="e.g. Designers" value="{{ old('name', $category?->name) }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Slug</label>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                    placeholder="auto-created from name" value="{{ old('slug', $category?->slug) }}">
                @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Used internally for freelancer filters.</small>
            </div>

            <div class="col-md-12">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                    rows="3" placeholder="Short note about this category">{{ old('description', $category?->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="active" {{ old('status', $category?->status ?? 'active') === 'active' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="inactive" {{ old('status', $category?->status) === 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
                @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('freelance-categories.index') }}" class="btn btn-light border">Cancel</a>
            <button type="submit" class="btn btn-primary fw-bold px-4">
                <i class="fa-solid fa-save me-2"></i> {{ $buttonText }}
            </button>
        </div>
    </div>
</div>
