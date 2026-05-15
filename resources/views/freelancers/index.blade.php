@extends('layouts.app')

@section('title', 'Freelancers')

@section('styles')
<style>
.freelancer-table {
    min-width: 1100px;
}

.freelancer-table th,
.freelancer-table td {
    vertical-align: middle;
    white-space: nowrap;
}

.freelancer-table .freelancer-name,
.freelancer-table .freelancer-notes {
    white-space: normal;
}

.category-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.category-card:hover {
    transform: translateY(-4px);
}
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Freelancer Directory</h2>
            <p class="text-muted mb-0">Manage contractors by freelance category.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('freelance-categories.index') }}" class="btn btn-light border fw-bold">
                <i class="fa-solid fa-folder-tree me-2"></i> Categories
            </a>
            <a href="{{ route('freelancers.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i> Add New Freelancer
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm metric-card">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h6 class="text-uppercase text-muted fw-semibold mb-2">Total Freelancers</h6>
                        <h2 class="fw-bold mb-0">{{ $totalFreelancers }}</h2>
                        <small class="text-muted">Registered contractors</small>
                    </div>
                    <div class="metric-icon bg-primary-gradient">
                        <i class="fa-solid fa-laptop-code"></i>
                    </div>
                </div>
            </div>
        </div>

        @foreach($categories->take(2) as $category)
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm category-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1">{{ $category->name }}</h5>
                            <p class="text-muted mb-0">{{ $category->description ?: 'Freelance category' }}</p>
                        </div>
                        <span class="badge bg-primary fs-6">{{ $categoryCounts[$category->slug] ?? 0 }} Active</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('freelancers.index') }}" method="GET" class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search name, skill, or email..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Any Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="busy" {{ request('status') === 'busy' ? 'selected' : '' }}>Busy</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-dark flex-fill fw-bold">Filter</button>
                    <a href="{{ route('freelancers.index') }}" class="btn btn-light border" title="Clear filters">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 fw-bold">
            <i class="fa-solid fa-list me-2 text-muted"></i> All Freelancers
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 freelancer-table">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Name</th>
                        <th>Category</th>
                        <th>Role / Skill</th>
                        <th>Rate</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Documents</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($freelancers as $freelancer)
                    <tr>
                        <td class="ps-4 freelancer-name">
                            <div class="fw-bold">{{ $freelancer->full_name }}</div>
                            <small class="text-muted">{{ $freelancer->email ?: 'No email provided' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-primary">
                                {{ $freelancer->categoryDefinition?->name ?? ucfirst(str_replace('-', ' ', $freelancer->category)) }}
                            </span>
                        </td>
                        <td>{{ $freelancer->service_skill ?: 'Not specified' }}</td>
                        <td>
                            ${{ number_format($freelancer->billing_rate, 2) }}
                            <span class="text-muted">/ {{ str_replace('_', ' ', $freelancer->rate_type) }}</span>
                        </td>
                        <td>{{ $freelancer->phone_number ?: 'Not specified' }}</td>
                        <td>
                            @php
                            $statusClass = [
                                'active' => 'bg-success bg-opacity-10 text-success',
                                'busy' => 'bg-warning bg-opacity-10 text-dark',
                                'inactive' => 'bg-secondary bg-opacity-10 text-secondary',
                            ][$freelancer->status] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ ucfirst($freelancer->status) }}</span>
                        </td>
                        <td>
                            @if($freelancer->contract_path)
                            <a href="{{ asset('storage/' . $freelancer->contract_path) }}" target="_blank"
                                class="btn btn-sm btn-outline-secondary">
                                <i class="fa-solid fa-file-lines"></i>
                            </a>
                            @else
                            <span class="text-muted">No file</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('outcomes.create') }}"
                                class="btn btn-sm btn-outline-success fw-bold me-1">Pay</a>

                            <a href="{{ route('freelancers.edit', $freelancer) }}"
                                class="btn btn-sm btn-outline-primary me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <form action="{{ route('freelancers.destroy', $freelancer) }}" method="POST"
                                class="d-inline js-delete-form" data-confirm-title="Delete freelancer?"
                                data-confirm-text="This freelancer profile will be permanently deleted."
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
                        <td colspan="8" class="text-center text-muted py-5">
                            No freelancers found. Add the first freelancer profile to get started.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
