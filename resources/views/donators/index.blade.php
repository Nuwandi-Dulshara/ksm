@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-5">
<div>
<h2 class="fw-bold">Donator Management</h2>
<p class="text-muted mb-0">Manage registered donators.</p>
</div>

<a href="{{ route('donators.create') }}" class="btn btn-primary fw-bold px-4">
<i class="fa-solid fa-plus me-2"></i> Add New Donator
</a>
</div>

<div class="row mb-4">
<div class="col-lg-3 col-md-6">
<div class="card border-0 shadow-sm metric-card">
<div class="card-body d-flex justify-content-between align-items-center p-4">
<div>
<h6 class="text-uppercase text-muted fw-semibold mb-2">
Total Donators
</h6>
<h2 class="fw-bold mb-0">
{{ $totalDonators }}
</h2>
<small class="text-muted">Registered donors</small>
</div>

<div class="metric-icon bg-primary-gradient">
<i class="fa-solid fa-hand-holding-dollar"></i>
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
<i class="fa-solid fa-hand-holding-dollar me-2 text-muted"></i> All Donators
</div>

<div class="table-responsive">
<table class="table table-hover align-middle mb-0">
<thead class="bg-light">
<tr>
<th class="ps-4">Full Name</th>
<th>Contact</th>
<th>Email</th>
<th>Address</th>
<th class="text-end pe-4">Actions</th>
</tr>
</thead>
<tbody>

@forelse($donators as $donator)
<tr>
<td class="ps-4 fw-bold">{{ $donator->full_name }}</td>
<td>{{ $donator->contact_number }}</td>
<td>{{ $donator->email ?? '-' }}</td>
<td>{{ $donator->address ?? '-' }}</td>

<td class="text-end pe-4">

<a href="{{ route('donators.edit', $donator->id) }}"
class="btn btn-sm btn-outline-primary me-2">
<i class="fa-solid fa-pen"></i>
</a>

<form action="{{ route('donators.destroy', $donator->id) }}"
method="POST" class="d-inline">
@csrf
@method('DELETE')

<button type="submit"
class="btn btn-sm btn-outline-danger"
onclick="return confirm('Delete this donator?')">
<i class="fa-solid fa-trash"></i>
</button>
</form>

</td>
</tr>
@empty
<tr>
<td colspan="5" class="text-center py-4 text-muted">
No donators found.
</td>
</tr>
@endforelse

</tbody>
</table>
</div>
</div>

@endsection