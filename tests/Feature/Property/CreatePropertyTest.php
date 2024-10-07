<?php

namespace Tests\Feature\Property;

use App\Models\Property;
use Tests\TestCase;

class CreatePropertyTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_property(): void
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
            ]
        ];

        $response = $this->post('/property', $data);

        $responseJSON = $response->json();

        $this->assertDatabaseHas('locations', [
            'block_number' => $data['location']['block_number'],
            'lot_number' => $data['location']['lot_number'],
            'street' => $data['location']['street'],
            'village' => $data['location']['village'],
            'city' => $data['location']['city'],
            'region' => $data['location']['region'],
        ]);

        $this->assertDatabaseHas('properties', [
            'id' => $responseJSON['id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'size' => $data['size'],
        ]);

        $this->assertDatabaseHas('property_features', [
            'property_id' => $responseJSON['id'],
        ]);

        $response->assertStatus(201);
    }
}
