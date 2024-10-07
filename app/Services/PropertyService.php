<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class PropertyService implements Contracts\PropertyServiceInterface
{
    public function createProperty(array $data): Property
    {
        return Property::create($data);
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

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['property_type'])) {
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

        if (!empty($filters['sort_by'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_order'] ?? 'asc');
        }

        if($paginate){
            return $query->paginate($perPage);
        }

        return $query->get();
    }
}
