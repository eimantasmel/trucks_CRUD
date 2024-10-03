<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TruckSubunit;
use App\Models\Truck;
use App\Services\TruckSubunitValidationService;

class TruckSubunitController extends Controller
{

    // I'm assuming that your php version is at least 8.0 or bigger
    public function __construct(protected TruckSubunitValidationService $subunitValidationService)
    {
    }

    // Display a listing of the resource
    public function index()
    {
        $truckSubunits = TruckSubunit::with(['mainTruck', 'subunitTruck'])
                    ->orderBy('id', 'desc') // Order by id in descending order
                    ->get();

        return view('truck_subunits.index', compact('truckSubunits'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        $trucks = Truck::all(); // Get all trucks to populate the dropdown
        return view('truck_subunits.create', compact('trucks'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {       
        $request->validate(TruckSubunit::rules());
        $validation_error = $this->subunitValidationService->validate();

        if($validation_error)
            return $validation_error;

        TruckSubunit::create($request->all());
        return redirect()->route('truck_subunits.index')->with('success', 'Subunit created successfully.');
    }

    // Show the form for editing the specified resource
    public function edit(TruckSubunit $truckSubunit)
    {
        $trucks = Truck::all(); // Get all trucks to populate the dropdown
        return view('truck_subunits.edit', compact('truckSubunit', 'trucks'));
    }

    // Update the specified resource in storage 
    public function update(Request $request, TruckSubunit $truckSubunit)
    {
        $request->validate(TruckSubunit::rules());
        $validation_error = $this->subunitValidationService->validate();

        if($validation_error)
            return $validation_error;

        $truckSubunit->update($request->all());
        return redirect()->route('truck_subunits.index')->with('success', 'Subunit updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy(TruckSubunit $truckSubunit)
    {
        $truckSubunit->delete();
        return redirect()->route('truck_subunits.index')->with('success', 'Subunit deleted successfully.');
    }

}
