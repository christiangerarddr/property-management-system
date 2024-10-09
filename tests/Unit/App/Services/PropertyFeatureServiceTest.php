<?php

namespace Tests\Unit\App\Services;

use App\Models\Property;
use App\Models\PropertyFeature;
use App\Services\PropertyFeatureService;
use Tests\TestCase;

class PropertyFeatureServiceTest extends TestCase
{
    protected PropertyFeatureService $propertyFeatureService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->propertyFeatureService = new PropertyFeatureService;
    }

    public function test_create_property_feature()
    {
        $property = Property::factory()->create();

        $data = [
            'feature' => 'Swimming Pool',
            'description' => 'A large swimming pool',
            'property_id' => $property->id,
        ];

        $feature = $this->propertyFeatureService->createPropertyFeature($data);

        $this->assertDatabaseHas('property_features', [
            'id' => $feature->id,
            'feature' => 'Swimming Pool',
            'description' => 'A large swimming pool',
            'property_id' => $property->id,
        ]);
    }

    public function test_get_property_feature()
    {
        $feature = PropertyFeature::factory()->create();

        $foundFeature = $this->propertyFeatureService->getPropertyFeature($feature->id);

        $this->assertEquals($feature->id, $foundFeature->id);
    }

    public function test_update_property_feature()
    {
        $feature = PropertyFeature::factory()->create();

        $data = [
            'feature' => 'Updated Feature',
            'description' => 'Updated description',
        ];

        $updatedFeature = $this->propertyFeatureService->updatePropertyFeature($feature->id, $data);

        $this->assertEquals('Updated Feature', $updatedFeature->feature);
        $this->assertEquals('Updated description', $updatedFeature->description);
    }

    public function test_delete_property_feature()
    {
        $feature = PropertyFeature::factory()->create();

        $result = $this->propertyFeatureService->deletePropertyFeature($feature->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('property_features', [
            'id' => $feature->id,
        ]);
    }

    public function test_list_property_features()
    {
        PropertyFeature::factory()->count(5)->create();

        $features = $this->propertyFeatureService->listPropertyFeature();

        $this->assertCount(5, $features);
    }

    public function test_list_property_features_with_pagination()
    {
        PropertyFeature::factory()->create(['feature' => 'Garage']);
        PropertyFeature::factory()->create(['feature' => 'Swimming Pool']);

        $features = $this->propertyFeatureService->listPropertyFeature(['feature' => 'Garage']);

        $this->assertCount(1, $features);
        $this->assertEquals('Garage', $features->first()->feature);
    }
}
