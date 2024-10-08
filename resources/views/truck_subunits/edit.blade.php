@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Subunit</h1>
    <form action="{{ route('truck_subunits.update', $truckSubunit) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="main_truck_id">Main Truck</label>
            <select name="main_truck_id" id="main_truck_id" class="form-control">
                @foreach($trucks as $truck)
                <option value="{{ $truck->id }}" {{ (old('main_truck_id', $truckSubunit->main_truck_id) == $truck->id) ? 'selected' : '' }}>
                    {{ $truck->unit_number }}
                </option>
                @endforeach
            </select>
            @error('main_truck_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="subunit_truck_id">Subunit Truck</label>
            <select name="subunit_truck_id" id="subunit_truck_id" class="form-control">
                @foreach($trucks as $truck)
                <option value="{{ $truck->id }}" {{ (old('subunit_truck_id', $truckSubunit->subunit_truck_id) == $truck->id) ? 'selected' : '' }}>
                    {{ $truck->unit_number }}
                </option>
                @endforeach
            </select>
            @error('subunit_truck_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $truckSubunit->start_date ) }}">
            @error('start_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $truckSubunit->end_date) }}">
            @error('end_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <input type="hidden" name="id" value="{{ $truckSubunit->id }}">

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/preventSameTruckSelection.js') }}"></script>
@endsection 