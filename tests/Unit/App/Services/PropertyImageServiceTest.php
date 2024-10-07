<?php

namespace App\Services;

use App\Models\PropertyImage;
use App\Models\Property;
use Illuminate\Contracts\Pagination\Paginator;
use Tests\TestCase;

class PropertyImageServiceTest extends TestCase
{
    protected PropertyImageService $propertyImageService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->propertyImageService = new PropertyImageService();
    }

    public function test_create_property_image()
    {
        $data = [
            'image_name' => 'Test Image',
            'image_path' => '/test/image.jpg'
        ];

        $propertyImage = $this->propertyImageService->createPropertyImage($data);

        $this->assertInstanceOf(PropertyImage::class, $propertyImage);
        $this->assertEquals($data['image_name'], $propertyImage->image_name);
        $this->assertEquals($data['image_path'], $propertyImage->image_path);
    }

    public function test_get_property_image()
    {
        $propertyImage = PropertyImage::factory()->create();

        $retrievedPropertyImage = $this->propertyImageService->getPropertyImage($propertyImage->id);

        $this->assertInstanceOf(PropertyImage::class, $retrievedPropertyImage);
        $this->assertEquals($propertyImage->id, $retrievedPropertyImage->id);
    }

    public function test_update_property_image()
    {
        $propertyImage = PropertyImage::factory()->create();

        $updatedData = ['image_name' => 'Updated PropertyImage'];

        $updatedPropertyImage = $this->propertyImageService->updatePropertyImage($propertyImage->id, $updatedData);

        $this->assertEquals('Updated PropertyImage', $updatedPropertyImage->image_name);
        $this->assertEquals($propertyImage->id, $updatedPropertyImage->id);
    }

    public function test_delete_property_image()
    {
        $propertyImage = PropertyImage::factory()->create();

        $deleted = $this->propertyImageService->deletePropertyImage($propertyImage->id);

        $this->assertTrue($deleted);
        $this->assertNull(PropertyImage::find($propertyImage->id)); // Assert that the PropertyImage is deleted
    }

    public function test_list_amenities()
    {
        PropertyImage::factory()->count(5)->create(['image_name' => 'Sample PropertyImage']);
        PropertyImage::factory()->count(3)->create(['image_name' => 'Another PropertyImage']);

        $propertyImages = $this->propertyImageService->listPropertyImages(['image_name' => 'Sample PropertyImage']);

        $this->assertCount(5, $propertyImages);
        foreach ($propertyImages as $propertyImage) {
            $this->assertEquals('Sample PropertyImage', $propertyImage->image_name);
        }
    }

    public function test_list_amenities_with_pagination()
    {
        PropertyImage::factory()->count(15)->create(['image_name' => 'Sample City']);

        $propertyImages = $this->propertyImageService->listPropertyImages(['image_name' => 'Sample City'], true, 5);

        $this->assertInstanceOf(Paginator::class, $propertyImages);
        $this->assertCount(5, $propertyImages->items());
        $this->assertEquals(15, $propertyImages->total());
    }
}
