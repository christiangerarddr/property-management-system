<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class LocationService
{
    public function createLocation(array $data): Location
    {
        return Location::create($data);
    }

    public function getLocation(int $id): Location
    {
        return Location::find($id);
    }

    public function updateLocation(int $id, array $data): Location
    {
        $location = $this->getLocation($id);
        $location->update($data);

        return $location;
    }

    public function deleteLocation(int $id): bool
    {
        $location = $this->getLocation($id);

        return $location->delete();
    }

    public function listLocations(array $filters = [], bool $paginate = false, int $perPage = 10): Collection|Paginator
    {
        $query = Location::query();

        if (! empty($filters['city'])) {
            $query->where('city', $filters['city']);
        }

        if (! empty($filters['region'])) {
            $query->where('region', $filters['region']);
        }

        if ($paginate) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }
}
