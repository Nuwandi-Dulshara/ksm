@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary me-3 rounded-circle"
            style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold text-dark mb-0">Create New Role</h2>
            <p class="text-muted mb-0">Define system access level and permissions.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <div class="form-section-title">Role Information</div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Role Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="e.g. Admin, Manager, Accountant" value="{{ old('name') }}" required>

                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                rows="3"
                                placeholder="Optional description of this role">{{ old('description') }}</textarea>
                        </div>

                        <hr>

                        <div class="form-section-title">Assign Permissions</div>

                        <div class="row">
                            <!-- AVAILABLE -->
                            <div class="col-md-6">
                                <h6>Available Sections</h6>
                                <ul id="available" class="list-group">
                                    @foreach($sections as $section)
                                    <li class="list-group-item d-flex justify-content-between align-items-center"
                                        data-section="{{ $section }}">
                                        <span>{{ $section }}</span>
                                        <button type="button" class="btn btn-sm btn-success add">+</button>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- SELECTED -->
                            <div class="col-md-6">
                                <h6>Selected Sections</h6>
                                <div id="selected"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('roles.index') }}" class="btn btn-light border">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary fw-bold px-4">
                                <i class="fa-solid fa-save me-2"></i>
                                Save Role
                            </button>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('click', function(e) {

    // ADD
    if (e.target.classList.contains('add')) {
        let li = e.target.closest('li');
        let section = li.dataset.section;

        let html = `
        <div class="card mb-2 p-2">
            <div class="d-flex justify-content-between">
                <strong>${section}</strong>
                <button type="button" class="btn btn-danger btn-sm remove">-</button>
            </div>

            <div class="mt-2">
                <label><input type="checkbox" name="permissions[${section}][create]"> Create</label>
                <label><input type="checkbox" name="permissions[${section}][read]" checked> Read</label>
                <label><input type="checkbox" name="permissions[${section}][update]"> Update</label>
                <label><input type="checkbox" name="permissions[${section}][delete]"> Delete</label>
            </div>
        </div>`;

        document.getElementById('selected').insertAdjacentHTML('beforeend', html);
        li.remove();
    }

    // REMOVE
    if (e.target.classList.contains('remove')) {
        let card = e.target.closest('.card');
        let section = card.querySelector('strong').innerText;

        let html = `
        <li class="list-group-item d-flex justify-content-between align-items-center" data-section="${section}">
            <span>${section}</span>
            <button type="button" class="btn btn-sm btn-success add">+</button>
        </li>`;

        document.getElementById('available').insertAdjacentHTML('beforeend', html);
        card.remove();
    }

});
</script>
@endpush