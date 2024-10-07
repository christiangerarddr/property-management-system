<?php

namespace Tests\Unit\App\Services;

use App\Models\Location;
use App\Services\LocationService;
use Tests\TestCase;

class LocationServiceTest extends TestCase
{
    protected LocationService $locationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->locationService = new LocationService();
    }

    public function test_create_location()
    {
        $data = [
            'block_number' => '12',
            'lot_number' => '5',
            'street' => 'Main St',
            'village' => 'Green Village',
            'city' => 'Sample City',
            'region' => 'Sample Region',
        ];

        $location = $this->locationService->createLocation($data);

        $this->assertInstanceOf(Location::class, $location);
        $this->assertEquals($data['city'], $location->city);
    }

    public function test_get_location()
    {
        $location = Location::factory()->create();

        $retrievedLocation = $this->locationService->getLocation($location->id);

        $this->assertInstanceOf(Location::class, $retrievedLocation);
        $this->assertEquals($location->id, $retrievedLocation->id);
    }

    public function test_update_location()
    {
        $location = Location::factory()->create();

        $updatedData = ['city' => 'Updated City'];

        $updatedLocation = $this->locationService->updateLocation($location->id, $updatedData);

        $this->assertEquals('Updated City', $updatedLocation->city);
        $this->assertEquals($location->id, $updatedLocation->id);
    }

    public function test_delete_location()
    {
        $location = Location::factory()->create();

        $deleted = $this->locationService->deleteLocation($location->id);

        $this->assertTrue($deleted);
        $this->assertNull(Location::find($location->id)); // Assert that the location is deleted
    }

    public function test_list_locations()
    {
        Location::factory()->count(5)->create(['city' => 'Sample City']);
        Location::factory()->count(3)->create(['city' => 'Another City']);

        $locations = $this->locationService->listLocations(['city' => 'Sample City']);

        $this->assertCount(5, $locations);
        foreach ($locations as $location) {
            $this->assertEquals('Sample City', $location->city);
        }
    }

    public function test_list_locations_with_pagination()
    {
        Location::factory()->count(15)->create(['city' => 'Sample City']);

        $locations = $this->locationService->listLocations(['city' => 'Sample City'], true, 5);

        $this->assertInstanceOf(\Illuminate\Contracts\Pagination\Paginator::class, $locations);
        $this->assertCount(5, $locations->items()); // Assert that it returns 5 items per page
        $this->assertEquals(15, $locations->total()); // Assert total count is correct
    }
}
