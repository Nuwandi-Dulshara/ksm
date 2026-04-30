@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark">{{ __('messages.expense_types') }}</h2>
            <p class="text-muted mb-0">{{ __('messages.manage_expense_categories') }}</p>
        </div>

        <a href="{{ route('expense-types.create') }}" class="btn btn-primary fw-bold px-4">
            <i class="fa-solid fa-plus me-2"></i> {{ __('messages.add_expense_type') }}
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 fw-bold">
            <i class="fa-solid fa-list me-2 text-muted"></i> {{ __('messages.all_expense_types') }}
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>{{ __('messages.expense_types') }}</th>
                        <th class="text-end pe-4">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenseTypes as $key => $expenseType)
                    <tr>
                        <td class="ps-4">{{ $key + 1 }}</td>
                        <td class="fw-bold">{{ $expenseType->expense_type }}</td>
                        <td class="text-end pe-4">

                            <a href="{{ route('expense-types.edit', $expenseType->id) }}"
                                class="btn btn-sm btn-outline-primary me-2">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form action="{{ route('expense-types.destroy', $expenseType->id) }}" method="POST"
                                style="display:inline;" class="js-delete-form"
                                data-confirm-text="{{ __('messages.permanently_deleted') }}">
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
                        <td colspan="3" class="text-center py-4 text-muted">
                            No expense types found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection