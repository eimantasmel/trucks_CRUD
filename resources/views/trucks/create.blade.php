<!-- resources/views/trucks/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Truck</h1>

    <form action="{{ route('trucks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="unit_number" class="form-label">Unit Number</label>
            <input type="text" class="form-control" id="unit_number" name="unit_number" required value="{{ old('unit_number')}}"">
            @error('unit_number')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number" class="form-control" id="year" name="year" required value="{{ old('year') }}">
            @error('year')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes">{{ old('notes') }}</textarea>
            @error('notes')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Add Truck</button>
    </form>
</div>
@endsection
