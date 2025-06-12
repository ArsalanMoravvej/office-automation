<?php

namespace Modules\AuthManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|exists:users',
            'password' => 'sometimes|string|min:8|confirmed',
        ];
    }

    /**
     * Get the body parameters for API documentation
     */
    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'The name of the user',
                'example' => 'John Doe',
            ],
            'email' => [
                'description' => 'The email address of the user',
                'example' => 'john@example.com',
            ],
            'password' => [
                'description' => 'The password for the user account (min 8 characters)',
                'example' => 'secret-password',
            ],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
