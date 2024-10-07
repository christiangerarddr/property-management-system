<?php

namespace App\Services;

use App\Models\PropertyFeature;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class PropertyFeatureService
{
    public function createPropertyFeature(array $data): PropertyFeature
    {
        return PropertyFeature::create($data);
    }

    public function createMultiplePropertyFeature(array $data, int $propertyID): array
    {
        $features = [];

        foreach ($data as $feature) {
            $features[] = $this->createPropertyFeature(array_merge($feature, ['property_id' => $propertyID]));
        }

        return $features;
    }

    public function getPropertyFeature(int $id): PropertyFeature
    {
        return PropertyFeature::find($id);
    }

    public function updatePropertyFeature(int $id, array $data): PropertyFeature
    {
        $location = $this->getPropertyFeature($id);
        $location->update($data);

        return $location;
    }

    public function deletePropertyFeature(int $id): bool
    {
        $location = $this->getPropertyFeature($id);

        return $location->delete();
    }

    public function listPropertyFeature(array $filters = [], bool $paginate = false, int $perPage = 10): Collection|Paginator
    {
        $query = PropertyFeature::query();

        if (! empty($filters['feature'])) {
            $query->where('feature', $filters['feature']);
        }

        if ($paginate) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }
}
