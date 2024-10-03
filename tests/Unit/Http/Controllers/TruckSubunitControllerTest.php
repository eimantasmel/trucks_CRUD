<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Truck;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Models\TruckSubunit;

class TruckSubunitControllerTest extends TestCase
{
    public function test_it_can_store_a_subunit()
    {
        // Create two trucks
        $mainTruck = Truck::create([
            'unit_number' => 'MAIN001',
            'year' => 2020,
            'notes' => 'Main Truck'
        ]);
    
        $subunitTruck = Truck::create([
            'unit_number' => 'SUB001',
            'year' => 2021,
            'notes' => 'TruckSubunit Truck'
        ]);
    
        $subunitData = [
            'main_truck_id' => $mainTruck->id,
            'subunit_truck_id' => $subunitTruck->id,
            'start_date' => '2020-05-05',
            'end_date' => '2020-06-05',
        ];
    
        $response = $this->post('/truck_subunits', $subunitData);
    
        // Check that the response redirects to the subunits index.
        $response->assertRedirect(route('truck_subunits.index'));
    
        // Check that the TruckSubunit data is in the database.
        $this->assertDatabaseHas('truck_subunits', [
            'main_truck_id' => $mainTruck->id,
            'subunit_truck_id' => $subunitTruck->id,
            'start_date' => '2020-05-05',
            'end_date' => '2020-06-05',
        ]);
    
        // Cleanup: Delete the created trucks
        $mainTruck->delete();
        $subunitTruck->delete();
    }

    public function test_it_cannot_store_invalid_subunit()
    {    
        // Create two trucks
        $mainTruck = Truck::create([
            'unit_number' => 'MAIN001',
            'year' => 2020,
            'notes' => 'Main Truck'
        ]);
    
        $subunitTruck = Truck::create([
            'unit_number' => 'SUB001',
            'year' => 2021,
            'notes' => 'TruckSubunit Truck'
        ]);
    
        $subunitData = [
            'main_truck_id' => $mainTruck->id,
            'subunit_truck_id' => $subunitTruck->id,
            'start_date' => '2020-05-05',
            'end_date' => '1977-04-05', // invalid end date
        ];
    
        $response = $this->post('/truck_subunits', $subunitData);
    
        // Check that the validation errors are in the session
        $response->assertSessionHasErrors();

        $this->assertDatabaseMissing('truck_subunits', $subunitData);


        $subunitData = [
            'main_truck_id' => $mainTruck->id,
            'subunit_truck_id' => $mainTruck->id,
            'start_date' => '2020-05-05',
            'end_date' => '1977-04-05', // invalid end date
        ];

        $response = $this->post('/truck_subunits', $subunitData);
    
        // Check that the validation errors are in the session
        $response->assertSessionHasErrors();

        $this->assertDatabaseMissing('truck_subunits', $subunitData);
    
        // Cleanup: Delete the created trucks
        $mainTruck->delete();
        $subunitTruck->delete();
    }

    public function test_it_can_update_a_subunit()
    {
        // Create two trucks
        $mainTruck = Truck::create([
            'unit_number' => 'MAIN001',
            'year' => 2020,
            'notes' => 'Main Truck'
        ]);
    
        $subunitTruck = Truck::create([
            'unit_number' => 'SUB001',
            'year' => 2021,
            'notes' => 'TruckSubunit Truck'
        ]);
    
        // Create a subunit
        $TruckSubunit = TruckSubunit::create([
            'main_truck_id' => $mainTruck->id,
            'subunit_truck_id' => $subunitTruck->id,
            'start_date' => '2020-05-05',
            'end_date' => '2020-06-05',
        ]);
    
        // Data for the update
        $updatedSubunitData = [
            'main_truck_id' => $mainTruck->id,
            'subunit_truck_id' => $subunitTruck->id,
            'start_date' => '2020-07-01',
            'end_date' => '2020-08-01',
        ];
    
        // Send a PUT request to update the subunit
        $response = $this->put("/truck_subunits/{$TruckSubunit->id}", $updatedSubunitData);
    
        // Check that the response redirects to the subunits index
        $response->assertRedirect(route('truck_subunits.index'));
    
        // Check that the TruckSubunit data is updated in the database
        $this->assertDatabaseHas('truck_subunits', [
            'id' => $TruckSubunit->id, // Check the specific TruckSubunit by its ID
            'main_truck_id' => $mainTruck->id,
            'subunit_truck_id' => $subunitTruck->id,
            'start_date' => '2020-07-01',
            'end_date' => '2020-08-01',
        ]);
    
        // Cleanup: Delete the created TruckSubunit and trucks
        $mainTruck->delete();
        $subunitTruck->delete();
    }    

    public function test_it_can_delete_a_subunit()
    {
        // Create two trucks
        $mainTruck = Truck::create([
            'unit_number' => 'MAIN001',
            'year' => 2020,
            'notes' => 'Main Truck'
        ]);

        $subunitTruck = Truck::create([
            'unit_number' => 'SUB001',
            'year' => 2021,
            'notes' => 'TruckSubunit Truck'
        ]);

        // Create a subunit
        $TruckSubunit = TruckSubunit::create([
            'main_truck_id' => $mainTruck->id,
            'subunit_truck_id' => $subunitTruck->id,
            'start_date' => '2020-05-05',
            'end_date' => '2020-06-05',
        ]);

        // Send a DELETE request to delete the subunit
        $response = $this->delete("/truck_subunits/{$TruckSubunit->id}");

        // Check that the response redirects to the subunits index
        $response->assertRedirect(route('truck_subunits.index'));

        // Check that the TruckSubunit data is no longer in the database
        $this->assertDatabaseMissing('truck_subunits', [
            'id' => $TruckSubunit->id,
            'main_truck_id' => $mainTruck->id,
            'subunit_truck_id' => $subunitTruck->id,
            'start_date' => '2020-05-05',
            'end_date' => '2020-06-05',
        ]);

        // Cleanup: Delete the created trucks
        $mainTruck->delete();
        $subunitTruck->delete();
    }


    public static function invalidSubunitDataProvider(): array
    {
        return [
            [
                [
                    'start_date' => '2024-05-15',         // Second TruckSubunit date is overlaping.
                    'end_date' => '2024-05-25',
                ],
            ],
            [
                [
                    'start_date' => '2023-05-08',
                    'end_date' => '2023-06-08',
                ],
            ],
            [
                [
                    'start_date' => '2024-05-10',
                    'end_date' => '2024-05-20',
                ],
            ],
        ];
    }

    /**
     * @dataProvider invalidTruckDataProvider
     */
    #[DataProvider('invalidSubunitDataProvider')]
    public function test_it_validates_overlaps_of_subunit_dates($subunitData)
    {
        // Create two trucks
        $truck1 = Truck::create([
            'unit_number' => 'TRUCK1',
            'year' => 2020,
            'notes' => 'Main Truck'
        ]);
    
        $truck2 = Truck::create([
            'unit_number' => 'TRUCK2',
            'year' => 2021,
            'notes' => 'TruckSubunit Truck'
        ]);

        TruckSubunit::create([
            'main_truck_id' => $truck1->id,
            'subunit_truck_id' => $truck2->id,
            'start_date' => '2024-05-08',
            'end_date' => '2024-06-08',
        ]);

        TruckSubunit::create([
            'main_truck_id' => $truck2->id,
            'subunit_truck_id' => $truck1->id,
            'start_date' => '2023-05-08',
            'end_date' => '2023-06-08',
        ]);


        $response = $this->post('/truck_subunits', 
                                array_merge($subunitData,  ['main_truck_id' => $truck1->id, 'subunit_truck_id' => $truck2->id]));

    
        // Check that the validation errors are in the session
        $response->assertSessionHasErrors();

        $truck1->delete();
        $truck2->delete();
    }
}
