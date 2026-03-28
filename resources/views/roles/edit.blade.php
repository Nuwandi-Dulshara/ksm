@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary me-3 rounded-circle"
            style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold text-dark mb-0">Edit Role</h2>
            <p class="text-muted mb-0">Update role details.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <div class="form-section-title">Role Information</div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Role Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small">Description</label>
                            <textarea name="description" class="form-control"
                                rows="3">{{ old('description', $role->description) }}</textarea>
                        </div>

                        <!-- ===================== NEW SECTION START ===================== -->

                        <hr>

                        <div class="form-section-title">Assign Permissions</div>

                        <div class="row">
                            <!-- AVAILABLE -->
                            <div class="col-md-6">
                                <h6>Available Sections</h6>
                                <ul id="available" class="list-group">

                                    @foreach($sections as $section)
                                    @if(!isset($permissions[$section]))
                                    <li class="list-group-item d-flex justify-content-between align-items-center"
                                        data-section="{{ $section }}">
                                        <span>{{ $section }}</span>
                                        <button type="button" class="btn btn-sm btn-success add">+</button>
                                    </li>
                                    @endif
                                    @endforeach

                                </ul>
                            </div>

                            <!-- SELECTED -->
                            <div class="col-md-6">
                                <h6>Selected Sections</h6>

                                <div id="selected">

                                    @foreach($sections as $section)
                                    @if(isset($permissions[$section]))
                                    <div class="card mb-2 p-2">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $section }}</strong>
                                            <button type="button" class="btn btn-danger btn-sm remove">-</button>
                                        </div>

                                        <div class="mt-2">
                                            <label>
                                                <input type="checkbox" name="permissions[{{ $section }}][create]"
                                                    {{ $permissions[$section]->can_create ? 'checked' : '' }}>
                                                Create
                                            </label>

                                            <label>
                                                <input type="checkbox" name="permissions[{{ $section }}][read]"
                                                    {{ $permissions[$section]->can_read ? 'checked' : '' }}>
                                                Read
                                            </label>

                                            <label>
                                                <input type="checkbox" name="permissions[{{ $section }}][update]"
                                                    {{ $permissions[$section]->can_update ? 'checked' : '' }}>
                                                Update
                                            </label>

                                            <label>
                                                <input type="checkbox" name="permissions[{{ $section }}][delete]"
                                                    {{ $permissions[$section]->can_delete ? 'checked' : '' }}>
                                                Delete
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <!-- ===================== NEW SECTION END ===================== -->

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('roles.index') }}" class="btn btn-light border">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary fw-bold px-4">
                                <i class="fa-solid fa-save me-2"></i>
                                Update Role
                            </button>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>

</div>

<!-- ===================== SCRIPT ===================== -->

<script>
document.addEventListener('click', function(e) {

    // ADD SECTION
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

    // REMOVE SECTION
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

@endsection
