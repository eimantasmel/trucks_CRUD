<!-- resources/views/trucks/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Trucks</h1>
    <a href="{{ route('trucks.create') }}" class="btn btn-primary mb-3">Add New Truck</a>
    @include('partials._notifications')
    
    <table class="table">
        <thead>
            <tr>
                <th>Unit Number</th>
                <th>Year</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trucks as $truck)
                <td>{{ $truck->unit_number }}</td>
                <td>{{ $truck->year }}</td>
                <td>{{ $truck->notes }}</td>
                <td>
                    <a href="{{ route('trucks.edit', $truck->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('trucks.destroy', $truck->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete();">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
                <td>

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
