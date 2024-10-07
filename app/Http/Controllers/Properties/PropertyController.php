<?php

namespace App\Http\Controllers\Properties;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Services\AmenityService;
use App\Services\Contracts\PropertyServiceInterface;
use App\Services\LocationService;
use App\Services\OwnerService;
use App\Services\PropertyFeatureService;
use App\Services\PropertyImageService;
use App\Services\PropertyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    protected PropertyServiceInterface $propertyService;
    protected LocationService $locationService;
    protected PropertyFeatureService $propertyFeatureService;
    protected PropertyImageService $propertyImageService;
    protected AmenityService $amenityService;
    protected OwnerService $ownerService;

    public function __construct(
        PropertyServiceInterface $propertyService,
        LocationService $locationService,
        PropertyFeatureService $propertyFeatureService,
        PropertyImageService $propertyImageService,
        AmenityService $amenityService,
        OwnerService $ownerService,
    ) {
        $this->propertyService = $propertyService;
        $this->locationService = $locationService;
        $this->propertyFeatureService = $propertyFeatureService;
        $this->propertyImageService = $propertyImageService;
        $this->amenityService = $amenityService;
        $this->ownerService = $ownerService;
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
            'owner.name' => 'nullable|string|max:255',
            'owner.contact_info' => 'nullable|string|max:255',
            'property_images' => 'nullable|array',
            'property_images.*.image_name' => 'required|string|max:255',
            'property_images.*.image_path' => 'required|string|max:255',
            'amenities' => 'nullable|array',
            'amenities.*.name' => 'required|string|max:255',
            'amenities.*.description' => 'required|string|max:255',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validator($request);

        DB::beginTransaction();

        try {
            $location = $this->locationService->createLocation($data['location']);
            $property = $this->propertyService->createProperty(array_merge($data, ['location_id' => $location->id]));
            $features = $this->propertyFeatureService->createMultiplePropertyFeature($data['features'], $property->id);
            $images = $this->propertyImageService->createMultiplePropertyImage($data['property_images'], $property->id);
            $amenities = $this->amenityService->createMultipleAmenities($data['amenities'], $property->id);
            $owner = $this->ownerService->createOwner($data['owner']);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            logger()->error($exception->getMessage());
            logger()->error(json_encode($data, JSON_PRETTY_PRINT));
        }

        //TODO: Create Standard Response Structure, Property Meta Aggregator
        return [
            $location,
            $property,
            $features,
            $images,
            $amenities,
            $owner
        ];
    }
}
