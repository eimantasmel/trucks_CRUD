<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subunit extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_truck_id', // Reference to the main truck
        'subunit_truck_id', // Reference to the subunit truck
        'start_date', 
        'end_date'
    ];

    // Validation rules within the subunit model
    public static function rules()
    {
        return [
            'main_truck_id' => 'required|exists:trucks,id', // Must exist in the trucks table
            'subunit_truck_id' => 'required|exists:trucks,id', // Must exist in the trucks table
            'start_date'  => 'required|date',  // Start date validation
            'end_date'    => 'required|date|after_or_equal:start_date',  // End date validation
        ];
    }

    // Define the relationship to the main truck
    public function mainTruck()
    {
        return $this->belongsTo(Truck::class, 'main_truck_id', 'id'); // Specify foreign and local keys
    }

    // Define the relationship to the subunit truck
    public function subunitTruck()
    {
        return $this->belongsTo(Truck::class, 'subunit_truck_id', 'id'); // Specify foreign and local keys
    }
}