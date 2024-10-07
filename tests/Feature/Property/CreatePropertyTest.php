<?php

namespace Tests\Feature\Property;

use App\Models\Property;
use Tests\TestCase;

class CreatePropertyTest extends TestCase
{
    public array $data;

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
                    'description' => 'A large swimming pool'
                ],
                [
                    'feature' => 'Bar',
                    'description' => 'Community Bar Area'
                ]
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
                    'image_path' => 'bar.jpg'
                ]
            ],
            'amenities' => [
                [
                    'name' => 'Sample Amenity',
                    'description' => 'Sample Amenity',
                ],
                [
                    'name' => 'Another Amenity',
                    'description' => 'Another Amenity'
                ]
            ]
        ];
    }

    public function test_create_property(): void
    {
        $response = $this->post('/property', $this->data);

        $responseJSON = $response->json();

        $this->assertDatabaseHas('locations', [
            'block_number' => $this->data['location']['block_number'],
            'lot_number' => $this->data['location']['lot_number'],
            'street' => $this->data['location']['street'],
            'village' => $this->data['location']['village'],
            'city' => $this->data['location']['city'],
            'region' => $this->data['location']['region'],
        ]);

        $this->assertDatabaseHas('properties', [
            'id' => $responseJSON['id'],
            'name' => $this->data['name'],
            'description' => $this->data['description'],
            'price' => $this->data['price'],
            'size' => $this->data['size'],
        ]);

        $this->assertDatabaseHas('property_features', [
            'property_id' => $responseJSON['id'],
        ]);

        $this->assertDatabaseHas('owners', [
            'name' => $this->data['owner']['name'],
            'contact_info' => $this->data['owner']['contact_info'],
        ]);

        $this->assertDatabaseHas('property_images', [
            'property_id' => $responseJSON['id'],
        ]);

        $this->assertDatabaseHas('amenities', [
            'property_id' => $responseJSON['id'],
        ]);

        $response->assertStatus(201);
    }
}
