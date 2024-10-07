<?php

namespace App\Services\Contracts;

use App\Models\Property;
use Illuminate\Contracts\Pagination\Paginator;

interface PropertyServiceInterface
{
    public function createProperty(array $data): Property;
    public function updateProperty(int $id, array $data): Property;
    public function getProperty(int $id): Property;
    public function deleteProperty(int $id): bool;
    public function listProperties(array $filters = []);
}
