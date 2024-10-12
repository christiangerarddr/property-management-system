<?php

namespace Tests\Unit\App\Services;

use App\Models\Property;
use App\Services\AmenityService;
use App\Services\LocationService;
use App\Services\OwnerService;
use App\Services\PropertyFeatureService;
use App\Services\PropertyImageService;
use App\Services\PropertyService;
use Illuminate\Contracts\Pagination\Paginator;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class PropertyServiceTest extends TestCase
{
    protected PropertyService $propertyService;

    private LocationService|MockObject $locationService;

    private PropertyFeatureService|MockObject $propertyFeatureService;

    private PropertyImageService|MockObject $propertyImageService;

    private AmenityService|MockObject $amenityService;

    private OwnerService|MockObject $ownerService;

    private array $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'name' => 'Beautiful House',
            'description' => 'A lovely place to live.',
            'price' => 2300000.00,
            'size' => 80.00,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'parking_spaces' => 2,
            'lease_terms' => 24,
            'date_built' => now(),
            'property_type' => Property::HOUSE,
            'status' => Property::AVAILABLE,
            'condition' => Property::NEW_CONDITION,
            'location' => [
                'block_number' => '12',
                'lot_number' => '5',
                'street' => 'Main St',
                'village' => 'Green Village',
                'city' => 'Sample City',
                'region' => 'Sample Region',
            ],
            'features' => [
                [
                    'feature' => 'Swimming Pool',
                    'description' => 'A large swimming pool',
                ],
                [
                    'feature' => 'Bar',
                    'description' => 'Community Bar Area',
                ],
            ],
            'owner' => [
                'name' => 'John Doe',
                'contact_info' => 'johndoe@example.com',
            ],
            'property_images' => [
                [
                    'image_name' => 'Swimming Pool',
                    'image_path' => 'swimming-pool.jpg',
                ],
                [
                    'image_name' => 'Bar',
                    'image_path' => 'bar.jpg',
                ],
            ],
            'amenities' => [
                [
                    'name' => 'Sample Amenity',
                    'description' => 'Sample Amenity',
                ],
                [
                    'name' => 'Another Amenity',
                    'description' => 'Another Amenity',
                ],
            ],
        ];

        $this->locationService = new LocationService;
        $this->propertyFeatureService = new PropertyFeatureService;
        $this->propertyImageService = new PropertyImageService;
        $this->amenityService = new AmenityService;
        $this->ownerService = new OwnerService;

        $this->propertyService = new PropertyService(
            $this->locationService,
            $this->propertyFeatureService,
            $this->propertyImageService,
            $this->amenityService,
            $this->ownerService
        );
    }

    /**
     * @throws \Exception
     */
    public function test_create_property()
    {
        $property = $this->propertyService->createProperty($this->data);

        $this->assertInstanceOf(Property::class, $property);
        $this->assertEquals('Beautiful House', $property->name);

        $this->assertDatabaseHas('locations', [
            'block_number' => '12',
            'lot_number' => '5',
            'street' => 'Main St',
            'village' => 'Green Village',
            'city' => 'Sample City',
            'region' => 'Sample Region',
        ]);

        $this->assertDatabaseHas('properties', [
            'name' => 'Beautiful House',
            'price' => 2300000.00,
        ]);

        $this->assertDatabaseHas('property_features', [
            'feature' => 'Swimming Pool',
            'description' => 'A large swimming pool',
        ]);

        $this->assertDatabaseHas('property_images', [
            'image_name' => 'Swimming Pool',
            'image_path' => 'swimming-pool.jpg',
        ]);

        $this->assertDatabaseHas('amenities', [
            'name' => 'Sample Amenity',
            'description' => 'Sample Amenity',
        ]);

        $this->assertDatabaseHas('owners', [
            'name' => 'John Doe',
            'contact_info' => 'johndoe@example.com',
        ]);
    }

    public function test_update_property()
    {
        $property = Property::factory()->create();

        $data = [
            'name' => 'Updated House',
            'price' => 350000.00,
        ];

        $updatedProperty = $this->propertyService->updateProperty($property->id, $data);

        $this->assertEquals('Updated House', $updatedProperty->name);
        $this->assertEquals(350000.00, $updatedProperty->price);
    }

    public function test_get_property()
    {
        $property = Property::factory()->create();

        $fetchedProperty = $this->propertyService->getProperty($property->id);

        $this->assertEquals($property->id, $fetchedProperty->id);
    }

    public function test_delete_property()
    {
        $property = Property::factory()->create();

        $result = $this->propertyService->deleteProperty($property->id);

        $this->assertTrue($result);
        $this->assertNull(Property::find($property->id));
    }

    public function test_list_properties_with_filters()
    {
        Property::factory()->count(3)->create(['status' => Property::AVAILABLE]);
        Property::factory()->count(2)->create(['status' => Property::RENTED]);

        $properties = $this->propertyService->listProperties(['status' => Property::AVAILABLE]);

        $this->assertCount(3, $properties);
    }

    public function test_list_properties_with_paginator()
    {
        Property::factory()->count(5)->create();

        $properties = $this->propertyService->listProperties([], true, 2);

        $this->assertInstanceOf(Paginator::class, $properties);
        $this->assertCount(2, $properties->items());
        $this->assertEquals(5, $properties->total());
        $this->assertEquals(3, $properties->lastPage());
    }
}
