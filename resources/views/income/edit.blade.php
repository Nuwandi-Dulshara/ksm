@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
<div class="col-lg-8">

<form action="{{ route('income.update',$income->id) }}"
method="POST">
@csrf
@method('PUT')

<div class="card shadow-sm border-0">
<div class="card-body p-4">

<h4 class="fw-bold mb-4">Edit Income</h4>

<div class="mb-3">
<label>Amount</label>
<input type="number"
name="amount"
class="form-control"
value="{{ $income->amount }}">
</div>

<div class="mb-3">
<label>Donator</label>
<select name="donator_id" class="form-select">
@foreach($donators as $donator)
<option value="{{ $donator->id }}"
@if($donator->id == $income->donator_id) selected @endif>
{{ $donator->full_name }}
</option>
@endforeach
</select>
</div>

<div class="mb-3">
<label>Invoice Number</label>
<input type="text"
name="invoice_number"
class="form-control"
value="{{ $income->invoice_number }}">
</div>

<div class="mb-3">
<label>Date</label>
<input type="date"
name="received_date"
class="form-control"
value="{{ $income->received_date }}">
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description"
class="form-control">{{ $income->description }}</textarea>
</div>

<button class="btn btn-primary fw-bold">
Update Income
</button>

</div>
</div>

</form>

</div>
</div>

@endsection