<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEstateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|string|in:sale,rent,sold,rented',
            'property_category' => 'required|string|in:residential,commercial,agricultural,industrial',
            'indicators' => 'required|string|in:negotiable,agricultural,residential,industrial',
            'name' => 'required|string',
            'location' => 'required|string',
            'description' => 'required|string',
            'code' => 'nullable|string',
            'space' => 'nullable|numeric',
            'number_of_bedrooms' => 'nullable|numeric',
            'number_of_bathrooms' => 'nullable|numeric',
            'number_of_floors' => 'nullable|numeric',
            'number_of_parking_spaces' => 'nullable|numeric',
            'year_of_construction' => 'nullable|date_format:Y-m-d',
            'services' => 'nullable|array',
            'services.*' => 'nullable|string', 
            '3d_photo' => 'nullable|file',
            'blueprint' => 'nullable|file',
            'video_url' => 'nullable|file',
            'price' => 'nullable|numeric',
            'rental_duration' => 'nullable|string|in:يوم,شهر,سنة',
            'filters' => 'nullable|array',
            'filters.*' => 'nullable|string',
            'photos' => 'required|array|min:3', 
            'photos.*' => 'required|file', 
        ];
    }
}
