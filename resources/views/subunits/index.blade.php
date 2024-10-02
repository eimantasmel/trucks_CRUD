@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Subunits</h1>
    <a href="{{ route('subunits.create') }}" class="btn btn-primary mb-3">Create New Subunit</a>
    @include('partials._notifications')
    
    <table class="table">
        <thead>
            <tr>
                <th>Main Truck</th>
                <th>Subunit Truck</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subunits as $subunit)
                <tr>
                    <td>{{ $subunit->mainTruck->unit_number }}</td>
                    <td>{{ $subunit->subunitTruck->unit_number }}</td>
                    <td>{{ $subunit->start_date }}</td>
                    <td>{{ $subunit->end_date }}</td>
                    <td>
                        <a href="{{ route('subunits.edit', $subunit) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('subunits.destroy', $subunit) }}" method="POST" class="d-inline" onsubmit="return confirmDelete();">
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