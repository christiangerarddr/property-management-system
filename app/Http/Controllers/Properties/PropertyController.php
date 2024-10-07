<?php

namespace App\Http\Controllers\Properties;

use App\Http\Controllers\Controller;
use App\Services\Contracts\PropertyServiceInterface;
use App\Services\LocationService;
use App\Services\PropertyFeatureService;
use App\Services\PropertyService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    protected PropertyServiceInterface $propertyService;
    protected LocationService $locationService;
    protected PropertyFeatureService $propertyFeatureService;

    public function __construct(
        PropertyServiceInterface $propertyService,
        LocationService $locationService,
        PropertyFeatureService $propertyFeatureService
    ) {
        $this->propertyService = $propertyService;
        $this->locationService = $locationService;
        $this->propertyFeatureService = $propertyFeatureService;
    }

    private function validator(Request $request){
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'size' => 'required|numeric',
            'bedrooms' => 'numeric|nullable',
            'bathrooms' => 'numeric|nullable',
            'parking_spaces' => 'numeric|nullable',
            'lease_terms' => 'numeric|nullable',
            'date_built' => 'date|nullable',
            'property_type' => 'numeric|nullable',
            'status' => 'numeric|nullable',
            'condition' => 'numeric|nullable',
            'location.block_number' => 'required|numeric',
            'location.lot_number' => 'required|numeric',
            'location.street' => 'required|string|max:255',
            'location.village' => 'required|string|max:255',
            'location.city' => 'required|string|max:255',
            'location.region' => 'required|string|max:255',
            'features' => 'nullable|array',
            'features.*.feature' => 'required|string|max:255',
            'features.*.description' => 'nullable|string',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validator($request);

        $location = $this->locationService->createLocation($data['location']);
        $property = $this->propertyService->createProperty(array_merge($data, ['location_id' => $location->id]));
        $features = $this->propertyFeatureService->createMultiplePropertyFeature($data['features'], $property->id);

        return $property;
    }
}
