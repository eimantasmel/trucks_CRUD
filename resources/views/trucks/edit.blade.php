<!-- resources/views/trucks/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Truck</h1>
    <form action="{{ route('trucks.update', $truck->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="unit_number" class="form-label">Unit Number</label>
            <input type="text" class="form-control" id="unit_number" name="unit_number" value="{{ old('unit_number', $truck->unit_number) }}" required>
            @error('unit_number')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number" class="form-control" id="year" name="year" value="{{ old('year', $truck->year) }}" required>
            @error('year')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes">{{ old('notes', $truck->notes) }}</textarea>
            @error('notes')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Truck</button>
    </form>
</div>
@endsection
