<?php

namespace App\Services;

use App\Models\Amenity;
use App\Models\Property;
use App\Services\AmenityService;
use Illuminate\Contracts\Pagination\Paginator;
use Tests\TestCase;

class AmenityServiceTest extends TestCase
{
    protected AmenityService $amenityService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->amenityService = new AmenityService();
    }

    public function test_create_amenity()
    {
        $property = Property::factory()->create();

        $data = [
            'name' => 'Sample Amenity',
            'description' => 'Sample Description',
            'property_id' => $property->id
        ];

        $amenity = $this->amenityService->createAmenity($data);

        $this->assertInstanceOf(Amenity::class, $amenity);
        $this->assertEquals($data['name'], $amenity->name);
    }

    public function test_get_amenity()
    {
        $amenity = Amenity::factory()->create();

        $retrievedAmenity = $this->amenityService->getAmenity($amenity->id);

        $this->assertInstanceOf(Amenity::class, $retrievedAmenity);
        $this->assertEquals($amenity->id, $retrievedAmenity->id);
    }

    public function test_update_amenity()
    {
        $amenity = Amenity::factory()->create();

        $updatedData = ['name' => 'Updated Amenity'];

        $updatedAmenity = $this->amenityService->updateAmenity($amenity->id, $updatedData);

        $this->assertEquals('Updated Amenity', $updatedAmenity->name);
        $this->assertEquals($amenity->id, $updatedAmenity->id);
    }

    public function test_delete_amenity()
    {
        $amenity = Amenity::factory()->create();

        $deleted = $this->amenityService->deleteAmenity($amenity->id);

        $this->assertTrue($deleted);
        $this->assertNull(Amenity::find($amenity->id)); // Assert that the Amenity is deleted
    }

    public function test_list_amenities()
    {
        Amenity::factory()->count(5)->create(['name' => 'Sample Amenity']);
        Amenity::factory()->count(3)->create(['name' => 'Another Amenity']);

        $amenities = $this->amenityService->listAmenities(['name' => 'Sample Amenity']);

        $this->assertCount(5, $amenities);
        foreach ($amenities as $amenity) {
            $this->assertEquals('Sample Amenity', $amenity->name);
        }
    }

    public function test_list_amenities_with_pagination()
    {
        Amenity::factory()->count(15)->create(['name' => 'Sample City']);

        $amenities = $this->amenityService->listAmenities(['name' => 'Sample City'], true, 5);

        $this->assertInstanceOf(Paginator::class, $amenities);
        $this->assertCount(5, $amenities->items());
        $this->assertEquals(15, $amenities->total());
    }
}
