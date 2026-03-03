@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center mb-4">
<a href="{{ route('donators.index') }}"
class="btn btn-outline-secondary me-3 rounded-circle"
style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
<i class="fa-solid fa-arrow-left"></i>
</a>
<div>
<h2 class="fw-bold mb-0">Register Donator</h2>
<p class="text-muted mb-0">Register new donator information.</p>
</div>
</div>

<div class="row justify-content-center">
<div class="col-lg-8">

<form action="{{ route('donators.store') }}" method="POST">
@csrf

@if($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<div class="card shadow-sm border-0">
<div class="card-body p-4">

<div class="form-section-title">Donator Information</div>

<div class="mb-3">
<label class="form-label fw-bold">Full Name</label>
<input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
</div>

<div class="mb-3">
<label class="form-label fw-bold">Contact Number</label>
<input type="text" name="contact_number" class="form-control" value="{{ old('contact_number') }}" required>
</div>

<div class="mb-3">
<label class="form-label fw-bold">Email Address</label>
<input type="email" name="email" class="form-control" value="{{ old('email') }}">
</div>

<div class="mb-4">
<label class="form-label fw-bold">Address</label>
<textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
</div>

<div class="d-flex justify-content-end gap-2">
<a href="{{ route('donators.index') }}" class="btn btn-light border">Cancel</a>
<button type="submit" class="btn btn-primary fw-bold px-4">
<i class="fa-solid fa-save me-2"></i> Save Donator
</button>
</div>

</div>
</div>
</form>

</div>
</div>

@endsection