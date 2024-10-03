@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Truck Subunits</h1>
    <a href="{{ route('truck_subunits.create') }}" class="btn btn-primary mb-3">Create New Subunit</a>
    @include('partials._notifications')
    
    <table class="table">
        <thead>
            <tr>
                <th>Main Truck</th>
                <th>TruckSubunit Truck</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($truckSubunits as $truckSubunit)
                <tr>
                    <td>{{ $truckSubunit->mainTruck->unit_number }}</td>
                    <td>{{ $truckSubunit->subunitTruck->unit_number }}</td>
                    <td>{{ $truckSubunit->start_date }}</td>
                    <td>{{ $truckSubunit->end_date }}</td>
                    <td>
                        <a href="{{ route('truck_subunits.edit', $truckSubunit) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('truck_subunits.destroy', $truckSubunit) }}" method="POST" class="d-inline" onsubmit="return confirmDelete();">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


@section('scripts')
    <script src="{{ asset('js/confirmDelete.js') }}"></script>
@endsection 