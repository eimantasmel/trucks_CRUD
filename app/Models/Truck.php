<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; // Set the primary key to the new id column

    public $incrementing = true; // The id is auto-incrementing

    protected $fillable = [
        'unit_number', 
        'year',        
        'notes',       
    ];

   // Validation rules within the Truck model
   public static function rules()
   {
       $currentYear = date('Y'); // Get the current year
       return [
           'unit_number' => 'required|string|max:255|unique:trucks,unit_number',
           'year'        => "required|integer|between:1900," . ($currentYear + 5), // Year between 1900 and 5 years from now
           'notes'       => 'nullable|string',
       ];
   }

   public function subUnits()
   {
        return $this->hasMany(Subunit::class);
   }
}
