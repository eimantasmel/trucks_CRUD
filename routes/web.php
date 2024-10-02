<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TruckController;

Route::get('/', function () {
    return redirect('/trucks');
});


Route::resource('trucks', TruckController::class);

