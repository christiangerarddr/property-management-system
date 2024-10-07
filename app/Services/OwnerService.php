<?php

namespace App\Services;

use App\Models\Owner;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class OwnerService
{
    public function createOwner(array $data): Owner
    {
        return Owner::create($data);
    }

    public function getOwner(int $id): Owner
    {
        return Owner::find($id);
    }

    public function updateOwner(int $id, array $data): Owner
    {
        $owner = $this->getOwner($id);
        $owner->update($data);

        return $owner;
    }

    public function deleteOwner(int $id): bool
    {
        $owner = $this->getOwner($id);
        return $owner->delete();
    }

    public function listOwners(array $filters = [], bool $paginate = false, int $perPage = 10): Collection|Paginator
    {
        $query = Owner::query();

        if (!empty($filters['name'])) {
            $query->where('name', $filters['name']);
        }

        if (!empty($filters['contact_info'])) {
            $query->where('contact_info', $filters['contact_info']);
        }

        if($paginate){
            return $query->paginate($perPage);
        }

        return $query->get();
    }
}
