<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

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
   public static function rules($id = null)
   {
       $currentYear = date('Y'); // Get the current year
       return [
           'unit_number' => 'required|string|max:255|unique:trucks,unit_number,' . $id,
           'year'        => "required|integer|between:1900," . ($currentYear + 5), // Year between 1900 and 5 years from now
           'notes'       => 'nullable|string',
       ];

    //    if ($id) {
    //     $rules['unit_number'][] = Rule::unique('trucks')->ignore($id); // Exclude the current truck's unit_number from the uniqueness check
    //     }
   }
}
