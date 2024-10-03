<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truck;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::orderBy('id', 'desc')->get();
        return view('trucks.index', compact('trucks'));
    }
    
    public function create()
    {
        return view('trucks.create');
    }
    
    public function store(Request $request)
    {
        $request->validate(Truck::rules());
        Truck::create($request->all());
        return redirect()->route('trucks.index');
    }
    
    public function edit(Truck $truck)
    {
        return view('trucks.edit', compact('truck'));
    }
    
    public function update(Request $request, Truck $truck)
    {
        $request->validate(Truck::rules($truck->id)); 
        $truck->update($request->all());
        return redirect()->route('trucks.index');
    }
    
    public function destroy(Truck $truck)
    {
        $truck->delete();
        return redirect()->route('trucks.index');
    }
}
