@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center mb-4">
<a href="{{ route('users.index') }}"
class="btn btn-outline-secondary me-3 rounded-circle"
style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
<i class="fa-solid fa-arrow-left"></i>
</a>
<div>
<h2 class="fw-bold mb-0">Edit User</h2>
<p class="text-muted mb-0">Update user account.</p>
</div>
</div>

<div class="row justify-content-center">
<div class="col-lg-8">

<form action="{{ route('users.update', $user->id) }}" method="POST">
@csrf
@method('PUT')

<div class="card shadow-sm border-0">
<div class="card-body p-4">

<div class="form-section-title">User Information</div>

<div class="mb-3">
<label class="form-label fw-bold">Full Name</label>
<input type="text" name="name" class="form-control"
value="{{ $user->name }}" required>
</div>

<div class="mb-3">
<label class="form-label fw-bold">Username</label>
<input type="text" name="username" class="form-control"
value="{{ $user->username }}" required>
</div>

<div class="mb-3">
<label class="form-label fw-bold">Email</label>
<input type="email" name="email" class="form-control"
value="{{ $user->email }}" required>
</div>

<div class="mb-3">
<label class="form-label fw-bold">New Password (optional)</label>
<input type="password" name="password" class="form-control">
</div>

<div class="mb-4">
<label class="form-label fw-bold">Assign Role</label>
<select name="role_id" class="form-select">
<option value="">Select Role</option>
@foreach($roles as $role)
<option value="{{ $role->id }}"
{{ $user->role_id == $role->id ? 'selected' : '' }}>
{{ $role->name }}
</option>
@endforeach
</select>
</div>

<div class="d-flex justify-content-end gap-2">
<a href="{{ route('users.index') }}" class="btn btn-light border">Cancel</a>
<button type="submit" class="btn btn-primary fw-bold px-4">
<i class="fa-solid fa-save me-2"></i> Update User
</button>
</div>

</div>
</div>
</form>

</div>
</div>

@endsection