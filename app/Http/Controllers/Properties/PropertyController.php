<?php

namespace App\Http\Controllers\Properties;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Responses\ResponseInterface;
use App\Services\Contracts\PropertyServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class PropertyController extends Controller
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

    public function store(StorePropertyRequest $request): JsonResponse|Response
    {
        $data = $request->validated();
        $property = [];

        try {
            $property = $this->propertyService->createProperty($data);
        } catch (Exception $exception) {
            logger()->error($exception->getMessage());
            logger()->error(json_encode($data, JSON_PRETTY_PRINT));
        }

        if($data['inertia'] === true){
            $properties = $this->propertyService->listProperties([], true, 3);

            return Inertia::render('Property/Index', [
                'properties' => $properties,
                'notification' => (object) [
                    'visible' => true,
                    'message' => 'Property Created!'
                ]
            ]);
        }

        return $this->response->success($property, 'Property created!', 201);
    }

    public function index(): Response
    {
        $properties = $this->propertyService->listProperties([], true, 3);

        return Inertia::render('Property/Index', ['properties' => $properties]);
    }

    public function listProperties(): JsonResponse
    {
        return $this->response->json($this->propertyService->listProperties([], true, 3));
    }

    public function create(): Response
    {
        return Inertia::render('Property/Create');
    }
}
