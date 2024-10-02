<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\SubunitController;

Route::get('/', function () {
    return redirect('/trucks');
});


Route::resource('trucks', TruckController::class);
Route::resource('subunits', SubunitController::class);

