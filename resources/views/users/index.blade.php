@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">
<div>
<h2 class="fw-bold">User Management</h2>
<p class="text-muted mb-0">Manage system users.</p>
</div>

<a href="{{ route('users.create') }}" class="btn btn-primary fw-bold px-4">
<i class="fa-solid fa-plus me-2"></i> Add New User
</a>
</div>

<div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm metric-card">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-uppercase text-muted fw-semibold mb-2">
                            Total Users
                        </h6>
                        <h2 class="fw-bold mb-0">
                            {{ $totalUsers }}
                        </h2>
                        <small class="text-muted">Registered accounts</small>
                    </div>

                    <div class="metric-icon bg-primary-gradient">
                        <i class="fa-solid fa-users"></i>
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
<i class="fa-solid fa-users me-2 text-muted"></i> All Users
</div>

<div class="table-responsive">
<table class="table table-hover align-middle mb-0">
<thead class="bg-light">
<tr>
<th class="ps-4">Name</th>
<th>Username</th>
<th>Email</th>
<th>Role</th>
<th class="text-end pe-4">Actions</th>
</tr>
</thead>
<tbody>

@forelse($users as $user)
<tr>
<td class="ps-4 fw-bold">{{ $user->name }}</td>
<td>{{ $user->username }}</td>
<td>{{ $user->email }}</td>
<td>{{ $user->role->name ?? '-' }}</td>

<td class="text-end pe-4">

<a href="{{ route('users.edit', $user->id) }}"
class="btn btn-sm btn-outline-primary me-2">
<i class="fa-solid fa-pen"></i>
</a>

<form action="{{ route('users.destroy', $user->id) }}"
method="POST" class="d-inline js-delete-form"
data-confirm-text="This user will be permanently deleted.">
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
<td colspan="5" class="text-center py-4 text-muted">
No users found.
</td>
</tr>
@endforelse

</tbody>
</table>
</div>
</div>

@endsection
