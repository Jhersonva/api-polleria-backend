<?php

namespace App\Http\Requests\DishCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDishCategoryRequest extends FormRequest
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
            'name'   => 'sometimes|string|max:255',
            'status' => 'sometimes|in:active, inactive',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
