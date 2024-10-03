<?php

namespace App\Services;

use App\Models\Subunit;
use Illuminate\Http\Request;


class SubunitValidationService
{

    public function __construct(protected Request $request)
    {
    }

    public function validate()
    {
        $main_truck_id = $this->request->main_truck_id;
        $subunit_truck_id = $this->request->subunit_truck_id;
        $start_date = $this->request->start_date;
        $end_date = $this->request->end_date;

        if (!$this->validateTruckSelection($main_truck_id, $subunit_truck_id)) {       
            return redirect()->back()
                             ->withInput() 
                             ->withErrors(['subunit_truck_id' => 'Subutnit truck and main truck cannot be the same']);
        }
        else if (!$this->validateSubunitDate($subunit_truck_id, $start_date, $end_date)) {
            return redirect()->back()
                             ->withInput() // This will retain the old input data
                             ->withErrors(['end_date' => sprintf("The subunit truck's date overlaps with the date interval: %s to %s", 
                                                        $this->request->session()->get('overlap_start_date'),
                                                        $this->request->session()->get('overlap_end_date'),)]);
        }
        else if (!$this->validateSubunitDate($main_truck_id, $start_date, $end_date)) {
            return redirect()->back()
                             ->withInput() 
                             ->withErrors(['end_date' => sprintf('The main truck is already acting as a subunit from %s to %s', 
                                                        $this->request->session()->get('overlap_start_date'),
                                                        $this->request->session()->get('overlap_end_date'),)]);
        }

        return null;
    }

    /**
     * This method checks if the main truck and subunit are not the same truck
     */
    private function validateTruckSelection($main_truck_id, $subunit_truck_id) : bool
    {
        if ($main_truck_id == $subunit_truck_id) {
            return false;
        }

        return true;
    }

    /**
     * This method checks if the provided date ranges overlaps with certain subunit truck.
     */
    private function validateSubunitDate($subunit_truck_id, $start_date, $end_date): bool
    {
        $subunits = Subunit::getSubunitsByTruckId($subunit_truck_id);

        foreach ($subunits as $subunit) {
            // If request->id is set, it indicates an edit action, 
            // meaning we must ignore the current editable subunit's date.
            if(isset($this->request->id) && $this->request->id == $subunit->id) 
                continue;

            $subunit_start_date = $subunit->start_date;
            $subunit_end_date = $subunit->end_date;

            // If the start_date or end_date falls within any existing subunit date range
            if (
                ($start_date >= $subunit_start_date && $start_date <= $subunit_end_date) ||
                ($end_date >= $subunit_start_date && $end_date <= $subunit_end_date) ||
                ($start_date <= $subunit_start_date && $end_date >= $subunit_end_date)
            ) {
                $this->request->session()->put('overlap_start_date', $subunit_start_date);
                $this->request->session()->put('overlap_end_date', $subunit_end_date);
                return false; // Dates overlap, return true
            }
        }

        return true; // No overlapping dates, return false
    }
}
