<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
            'name' => 'required|string',
            'length' => 'required|integer',
            'width' => 'required|integer',
            'description' => 'required|string',
            'location' => 'required|string',
            'phone_num' => 'required|string',
            'whatsapp_num' => 'required|phone:AUTO',
            'email' => 'required|email',
            'type' => 'required|string|in:real_estate_companies,engineering_companies',
            'website' => 'required|string',
            'image' => 'required|file',
        ];
    }
}
