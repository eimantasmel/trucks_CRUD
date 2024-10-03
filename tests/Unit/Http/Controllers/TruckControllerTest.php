<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Truck;
use PHPUnit\Framework\Attributes\DataProvider;

class TruckControllerTest extends TestCase
{
    public function test_it_can_store_a_truck()
    {
        $truckData = [
            'unit_number' => 'TRK001',
            'year' => 2020,
            'notes' => 'Test truck'
        ];

        $response = $this->post('/trucks', $truckData);

        // Check that the response redirects to the trucks index.
        $response->assertRedirect(route('trucks.index'));
        
        // Check that the truck data is in the database.
        $this->assertDatabaseHas('trucks', $truckData);

        // Cleanup: Delete the truck after the test
        $truck = Truck::where('unit_number', 'TRK001')->first();
        if ($truck) {
            $truck->delete();
        }
    }

    public static function invalidTruckDataProvider(): array
    {
        return [
            [
                [
                    'unit_number' => 'T123',
                    'year' => 1400, // Invalid year
                    'notes' => 'Invalid Truck'
                ],
            ],
            [
                [
                    'unit_number' => '', // Missing unit number
                    'year' => 2020,
                    'notes' => 'Missing Unit Number'
                ],
            ],
            [
                [
                    'unit_number' => 'T789',
                    'year' => 2050, // Future year (assuming this is invalid)
                    'notes' => 'Future Truck'
                ],
            ],
        ];
    }

    /**
     * @dataProvider invalidTruckDataProvider
     */
    #[DataProvider('invalidTruckDataProvider')]
    public function test_it_cannot_store_invalid_truck($truckData)
    {    
        $response = $this->post('/trucks', $truckData);
        
        // Check that the validation errors are in the session
        $response->assertSessionHasErrors();
    
        // Check that the truck data is NOT in the database
        $this->assertDatabaseMissing('trucks', $truckData);
    }
    
    
    public function test_it_can_update_a_truck()
    {
        // First, create a truck in the database
        $truckData = [
            'unit_number' => 'TRK001',
            'year' => 2020,
            'notes' => 'Old truck'
        ];
    
        // Create the initial truck
        $this->post('/trucks', $truckData);
    
        // Prepare the updated truck data
        $updatedTruckData = [
            'unit_number' => 'TRK001',
            'year' => 2022,
            'notes' => 'Updated truck'
        ];
    
        // Fetch the truck to update (assumes the first truck created has ID 1)
        $truck = Truck::where('unit_number', 'TRK001')->first();
    
        // Send a PUT request to update the truck
        $response = $this->put("/trucks/{$truck->id}", $updatedTruckData);
    
        // Check that the response redirects to the trucks index
        $response->assertRedirect(route('trucks.index'));
    
        // Check that the truck data has been updated in the database
        $this->assertDatabaseHas('trucks', $updatedTruckData);
    
        // Cleanup: Delete the truck after the test
        if ($truck) {
            $truck->delete();
        }
    }


    public function test_it_can_delete_a_truck()
    {
        // First, create a truck in the database
        $truckData = [
            'unit_number' => 'TRK001',
            'year' => 2020,
            'notes' => 'Truck to be deleted'
        ];
    
        // Create the truck
        $this->post('/trucks', $truckData);
    
        // Fetch the truck to delete (assumes the first truck created has ID 1)
        $truck = Truck::where('unit_number', 'TRK001')->first();
    
        // Send a DELETE request to remove the truck
        $response = $this->delete("/trucks/{$truck->id}");
    
        // Check that the response redirects to the trucks index
        $response->assertRedirect(route('trucks.index'));
    
        // Assert that the truck no longer exists in the database
        $this->assertDatabaseMissing('trucks', ['unit_number' => 'TRK001']);
    }
    
}
