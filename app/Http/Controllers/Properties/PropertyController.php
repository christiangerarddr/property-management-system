<?php

namespace App\Http\Controllers\Properties;

use App\Http\Controllers\Controller;
use App\Http\Responses\ResponseInterface;
use App\Services\Contracts\PropertyServiceInterface;
use Exception;
use Illuminate\Http\Request;
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

    private function validator(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'size' => 'required|numeric',
            'bedrooms' => 'numeric|nullable',
            'bathrooms' => 'numeric|nullable',
            'parking_spaces' => 'numeric|nullable',
            'lease_terms' => 'numeric|nullable',
            'date_built' => 'date|nullable',
            'property_type' => 'numeric|nullable',
            'status' => 'numeric|nullable',
            'condition' => 'numeric|nullable',
            'location.block_number' => 'required|numeric',
            'location.lot_number' => 'required|numeric',
            'location.street' => 'required|string|max:255',
            'location.village' => 'required|string|max:255',
            'location.city' => 'required|string|max:255',
            'location.region' => 'required|string|max:255',
            'features' => 'nullable|array',
            'features.*.feature' => 'required|string|max:255',
            'features.*.description' => 'nullable|string',
            'owner.name' => 'nullable|string|max:255',
            'owner.contact_info' => 'nullable|string|max:255',
            'property_images' => 'nullable|array',
            'property_images.*.image_name' => 'required|string|max:255',
            'property_images.*.image_path' => 'required|string|max:255',
            'amenities' => 'nullable|array',
            'amenities.*.name' => 'required|string|max:255',
            'amenities.*.description' => 'required|string|max:255',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validator($request);
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
