<?php

namespace App\Services;

use App\Models\PropertyImage;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class PropertyImageService
{
    public function createPropertyImage(array $data): PropertyImage
    {
        return PropertyImage::create($data);
    }

    public function createMultiplePropertyImage(array $data, int $propertyID): array
    {
        $images = [];

        foreach($data as $image) {
            $images[] = $this->createPropertyImage(array_merge($image, ['property_id' => $propertyID]));
        }

        return $images;
    }

    public function getPropertyImage(int $id): PropertyImage
    {
        return PropertyImage::find($id);
    }

    public function updatePropertyImage(int $id, array $data): PropertyImage
    {
        $propertyImage = $this->getPropertyImage($id);
        $propertyImage->update($data);

        return $propertyImage;
    }

    public function deletePropertyImage(int $id): bool
    {
        $propertyImage = $this->getPropertyImage($id);
        return $propertyImage->delete();
    }

    public function listPropertyImages(array $filters = [], bool $paginate = false, int $perPage = 10): Collection|Paginator
    {
        $query = PropertyImage::query();

        if (!empty($filters['image_name'])) {
            $query->where('image_name', $filters['image_name']);
        }

        if (!empty($filters['image_path'])) {
            $query->where('image_path', $filters['image_path']);
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
