<!-- resources/views/trucks/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Truck</h1>

    @include('partials._errors') <!-- Include the header partial -->
    <form action="{{ route('trucks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="unit_number" class="form-label">Unit Number</label>
            <input type="text" class="form-control" id="unit_number" name="unit_number" required value="{{ old('unit_number')}}"">
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number" class="form-control" id="year" name="year" required value="{{ old('year') }}">
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes">{{ old('notes') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Truck</button>
    </form>
</div>
@endsection
