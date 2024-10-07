<?php

namespace Tests\Unit\App\Services;

use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Contracts\Pagination\Paginator;
use Tests\TestCase;

class PropertyServiceTest extends TestCase
{
    protected PropertyService $propertyService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->propertyService = new PropertyService;
    }

    public function test_create_property()
    {
        $data = [
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
        ];

        $property = $this->propertyService->createProperty($data);

        $this->assertInstanceOf(Property::class, $property);
        $this->assertEquals($data['name'], $property->name);
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
