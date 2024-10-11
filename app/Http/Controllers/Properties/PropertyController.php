<?php

namespace App\Http\Controllers\Properties;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Responses\ResponseInterface;
use App\Services\Contracts\PropertyServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

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

    public function store(StorePropertyRequest $request)
    {
        $data = $request->validated();
        $property = [];

        DB::beginTransaction();

        try {
            $property = $this->propertyService->createProperty($data);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            logger()->error($exception->getMessage());
            logger()->error(json_encode($data, JSON_PRETTY_PRINT));
        }

        return $this->response->success($property, 'Property created!', 201);
    }

    public function index()
    {
        $properties = $this->propertyService->listProperties([], true, 3);

        return Inertia::render('Property/Index', ['properties' => $properties]);
    }
}
