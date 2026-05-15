@extends('layouts.app')

@section('title', 'Edit Freelance Category')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('freelance-categories.index') }}" class="btn btn-outline-secondary me-3 rounded-circle"
            style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-0">Edit Freelance Category</h2>
            <p class="text-muted mb-0">Update category details used by freelancer profiles.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">Please check the highlighted fields and try again.</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="{{ route('freelance-categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                @include('freelance-categories.form', ['category' => $category, 'buttonText' => 'Update Category'])
            </form>
        </div>
    </div>
</div>
@endsection
