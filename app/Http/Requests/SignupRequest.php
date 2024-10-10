<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            'number' => 'required|phone:AUTO',
            'email' => 'nullable|string|email|unique:users,email',
            'password' => 'required|confirmed|string|min:8',
            'type' => 'required|string|in:client,office,admin',
            'fcm_token' => 'required|string'
        ];
    }
}
