@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark">Role Management</h2>
            <p class="text-muted mb-0">Manage system access roles.</p>
        </div>


        <a href="{{ route('roles.create') }}" class="btn btn-primary fw-bold px-4">
            <i class="fa-solid fa-plus me-2"></i> Add New Role
        </a>
    </div>

    <div class="row mb-4">

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm metric-card">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-uppercase text-muted fw-semibold mb-2">
                            Total Roles
                        </h6>
                        <h2 class="fw-bold mb-0">{{ $totalRoles }}</h2>
                        <small class="text-muted">System roles</small>
                    </div>

                    <div class="metric-icon bg-primary-gradient">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 fw-bold">
            <i class="fa-solid fa-user-shield me-2 text-muted"></i> All Roles
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Role Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($roles as $role)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $role->name }}</td>
                        <td>{{ $role->description ?? '-' }}</td>
                        <td>{{ $role->created_at->format('Y-m-d') }}</td>

                        <td class="text-end pe-4">

                            <a href="{{ route('roles.edit', $role->id) }}"
                               class="btn btn-sm btn-outline-primary me-2">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form action="{{ route('roles.destroy', $role->id) }}"
                                  method="POST"
                                  class="d-inline js-delete-form"
                                  data-confirm-text="This role will be permanently deleted.">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            No roles created yet.
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
