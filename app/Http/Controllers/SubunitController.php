<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subunit;
use App\Models\Truck;
use App\Services\SubunitValidationService;

class SubunitController extends Controller
{

    // I'm assuming that your php version is at least 8.0 or bigger
    public function __construct(protected SubunitValidationService $subunitValidationService)
    {
    }

    // Display a listing of the resource
    public function index()
    {
        $subunits = Subunit::with(['mainTruck', 'subunitTruck'])
                    ->orderBy('id', 'desc') // Order by id in descending order
                    ->get();

        return view('subunits.index', compact('subunits'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        $trucks = Truck::all(); // Get all trucks to populate the dropdown
        return view('subunits.create', compact('trucks'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {       
        $request->validate(Subunit::rules());
        $validation_error = $this->subunitValidationService->validate();

        if($validation_error)
            return $validation_error;

        Subunit::create($request->all());
        return redirect()->route('subunits.index')->with('success', 'Subunit created successfully.');
    }

    // Display the specified resource
    public function show(Subunit $subunit)
    {
        return view('subunits.show', compact('subunit'));
    }

    // Show the form for editing the specified resource
    public function edit(Subunit $subunit)
    {
        $trucks = Truck::all(); // Get all trucks to populate the dropdown
        return view('subunits.edit', compact('subunit', 'trucks'));
    }

    // Update the specified resource in storage
    public function update(Request $request, Subunit $subunit)
    {
        $request->validate(Subunit::rules());
        $validation_error = $this->subunitValidationService->validate();

        if($validation_error)
            return $validation_error;

        $subunit->update($request->all());
        return redirect()->route('subunits.index')->with('success', 'Subunit updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy(Subunit $subunit)
    {
        $subunit->delete();
        return redirect()->route('subunits.index')->with('success', 'Subunit deleted successfully.');
    }

}
