<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'inertia' => 'boolean',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'size' => 'required|numeric',
            'bedrooms' => 'nullable|numeric',
            'bathrooms' => 'nullable|numeric',
            'parking_spaces' => 'nullable|numeric',
            'lease_terms' => 'nullable|numeric',
            'date_built' => 'nullable|date',
            'property_type' => 'nullable|numeric',
            'status' => 'nullable|numeric',
            'condition' => 'nullable|numeric',
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
        ];
    }
}
