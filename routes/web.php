<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\TruckSubunitController;

Route::get('/', function () {
    return redirect('/trucks');
});


Route::resource('trucks', TruckController::class);
Route::resource('truck_subunits', TruckSubunitController::class);

