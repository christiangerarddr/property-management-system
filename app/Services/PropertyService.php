<?php

namespace App\Services;

use App\Models\Property;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PropertyService implements Contracts\PropertyServiceInterface
{
    protected LocationService $locationService;

    protected PropertyFeatureService $propertyFeatureService;

    protected PropertyImageService $propertyImageService;

    protected AmenityService $amenityService;

    protected OwnerService $ownerService;

    public function __construct(
        LocationService $locationService,
        PropertyFeatureService $propertyFeatureService,
        PropertyImageService $propertyImageService,
        AmenityService $amenityService,
        OwnerService $ownerService,
    ) {
        $this->locationService = $locationService;
        $this->propertyFeatureService = $propertyFeatureService;
        $this->propertyImageService = $propertyImageService;
        $this->amenityService = $amenityService;
        $this->ownerService = $ownerService;
    }

    public function createProperty(array $data): Property
    {
        DB::beginTransaction();
        try {
            $location = $this->locationService->createLocation($data['location']);
            $property = Property::create(array_merge($data, ['location_id' => $location->id]));

            $this->propertyFeatureService->createMultiplePropertyFeature($data['features'], $property->id);
            $this->propertyImageService->createMultiplePropertyImage($data['property_images'], $property->id);
            $this->amenityService->createMultipleAmenities($data['amenities'], $property->id);
            $this->ownerService->createOwner($data['owner']);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }

        return $property;
    }

    public function updateProperty(int $id, array $data): Property
    {
        $property = $this->getProperty($id);
        $property->update($data);

        return $property;
    }

    public function getProperty(int $id): Property
    {
        return Property::find($id);
    }

    public function deleteProperty(int $id): bool
    {
        $property = $this->getProperty($id);

        return $property->delete();
    }

    public function listProperties(array $filters = [], bool $paginate = false, int $perPage = 10): Collection|Paginator
    {
        $query = Property::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['property_type'])) {
            $query->where('property_type', $filters['property_type']);
        }

        if (isset($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        if (isset($filters['min_size'])) {
            $query->where('size', '>=', $filters['min_size']);
        }

        if (isset($filters['max_size'])) {
            $query->where('size', '<=', $filters['max_size']);
        }

        if (isset($filters['sort_by'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_order'] ?? 'asc');
        }

        if ($paginate) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }
}
