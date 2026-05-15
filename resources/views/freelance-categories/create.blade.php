@extends('layouts.app')

@section('title', 'Add Freelance Category')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('freelance-categories.index') }}" class="btn btn-outline-secondary me-3 rounded-circle"
            style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-0">Add Freelance Category</h2>
            <p class="text-muted mb-0">Create a category for freelancer registration.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">Please check the highlighted fields and try again.</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="{{ route('freelance-categories.store') }}" method="POST">
                @csrf
                @include('freelance-categories.form', ['category' => $category, 'buttonText' => 'Save Category'])
            </form>
        </div>
    </div>
</div>
@endsection
