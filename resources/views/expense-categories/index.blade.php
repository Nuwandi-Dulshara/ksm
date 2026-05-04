@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold">{{ __('messages.expense_categories') }}</h2>
            <p class="text-muted mb-0">{{ __('messages.manage_expense_categories') }}</p>
        </div>

        <a href="{{ route('expense-categories.create') }}" class="btn btn-primary fw-bold px-4">
            <i class="fa-solid fa-plus me-2"></i> {{ __('messages.add_expense_category') }}
        </a>
    </div>

    <div class="card shadow-sm border-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>{{ __('messages.expense_types') }}</th>
                        <th>{{ __('messages.expense_categories') }}</th>
                        <th class="text-end pe-4">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($categories as $key=>$category)
                    <tr>
                        <td class="ps-4">{{ $key+1 }}</td>
                        <td>{{ $category->expenseType->expense_type }}</td>
                        <td class="fw-bold">{{ $category->category_name }}</td>
                        <td class="text-end pe-4">

                            <a href="{{ route('expense-categories.edit',$category->id) }}"
                                class="btn btn-sm btn-outline-primary me-2">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form action="{{ route('expense-categories.destroy',$category->id) }}" method="POST"
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
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection