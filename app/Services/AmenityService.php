<?php

namespace App\Services;

use App\Models\Amenity;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class AmenityService
{
    public function createAmenity(array $data): Amenity
    {
        return Amenity::create($data);
    }

    public function getAmenity(int $id): Amenity
    {
        return Amenity::find($id);
    }

    public function updateAmenity(int $id, array $data): Amenity
    {
        $amenity = $this->getAmenity($id);
        $amenity->update($data);

        return $amenity;
    }

    public function deleteAmenity(int $id): bool
    {
        $amenity = $this->getAmenity($id);
        return $amenity->delete();
    }

    public function listAmenities(array $filters = [], bool $paginate = false, int $perPage = 10): Collection|Paginator
    {
        $query = Amenity::query();

        if (!empty($filters['name'])) {
            $query->where('name', $filters['name']);
        }

        if (!empty($filters['description'])) {
            $query->where('description', $filters['description']);
        }

        if (!empty($filters['property_id'])) {
            $query->where('property_id', $filters['property_id']);
        }

        if($paginate){
            return $query->paginate($perPage);
        }

        return $query->get();
    }
}
