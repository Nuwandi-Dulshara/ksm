@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('roles.index') }}"
           class="btn btn-outline-secondary me-3 rounded-circle"
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
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ old('name', $role->name) }}"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small">Description</label>
                            <textarea name="description"
                                      class="form-control"
                                      rows="3">{{ old('description', $role->description) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
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

@endsection