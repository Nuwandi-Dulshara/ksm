@extends('layouts.app')

@section('title', 'Edit Freelancer')

@section('styles')
<style>
.form-section-title {
    font-size: 0.85rem;
    font-weight: bold;
    text-transform: uppercase;
    color: #6c757d;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 5px;
    margin-bottom: 15px;
    margin-top: 20px;
}
</style>
@endsection

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('freelancers.index') }}" class="btn btn-outline-secondary me-3 rounded-circle"
        style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h2 class="fw-bold text-dark mb-0">Edit Freelancer</h2>
        <p class="text-muted mb-0">Update contractor details, rate, and payment information.</p>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger">
    Please check the highlighted fields and try again.
</div>
@endif

<div class="row justify-content-center">
    <div class="col-lg-10">
        <form action="{{ route('freelancers.update', $freelancer) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('freelancers.form', ['freelancer' => $freelancer, 'buttonText' => 'Update Freelancer'])
        </form>
    </div>
</div>
@endsection
