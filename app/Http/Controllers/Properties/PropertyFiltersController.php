<?php

namespace App\Http\Controllers\Properties;

use App\Http\Controllers\Controller;
use App\Http\Responses\ResponseInterface;
use App\Services\Contracts\PropertyServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyFiltersController extends Controller
{
    protected PropertyServiceInterface $propertyService;

    protected ResponseInterface $response;

    public function __construct(
        ResponseInterface $response,
        PropertyServiceInterface $propertyService
    ) {
        $this->response = $response;
        $this->propertyService = $propertyService;
    }

    public function filterProperty(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'filters' => 'array',
            'filters.name' => 'required|string', // Ensure 'name' is required and a string
        ]);

        return $this->response->json($this->propertyService->listProperties($validatedData['filters'], true, 3));
    }
}
