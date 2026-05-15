@extends('layouts.app')

@section('title', 'Freelance Categories')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Freelance Categories</h2>
            <p class="text-muted mb-0">Create and manage freelancer groups used during registration.</p>
        </div>

        <a href="{{ route('freelance-categories.create') }}" class="btn btn-primary fw-bold px-4">
            <i class="fa-solid fa-plus me-2"></i> Add Category
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Freelancers</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $key => $category)
                    <tr>
                        <td class="ps-4">{{ $key + 1 }}</td>
                        <td class="fw-bold">{{ $category->name }}</td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td>{{ $category->description ?: 'No description' }}</td>
                        <td>
                            @if($category->status === 'active')
                            <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                            @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $category->freelancers_count }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('freelance-categories.edit', $category) }}"
                                class="btn btn-sm btn-outline-primary me-2">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form action="{{ route('freelance-categories.destroy', $category) }}" method="POST"
                                class="d-inline js-delete-form"
                                data-confirm-title="Delete category?"
                                data-confirm-text="This category can only be deleted if no freelancers use it."
                                data-confirm-button="Yes, delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            No freelance categories found. Add a category to get started.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
