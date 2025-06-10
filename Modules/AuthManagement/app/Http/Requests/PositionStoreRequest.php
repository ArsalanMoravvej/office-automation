<?php

namespace Modules\AuthManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => ['sometimes', 'integer', 'exists:users,id'],
            'title' =>   ['required', 'string', 'min:2', 'max:50'],
            'description' =>  ['sometimes', 'string', 'min:2', 'max:500'],
            'is_active' =>  ['sometimes', 'boolean'],
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
