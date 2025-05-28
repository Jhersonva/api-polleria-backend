<?php

namespace App\Http\Requests\DishCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDishCategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'   => 'sometimes|string|max:255',
            'status' => 'sometimes|in:active, inactive',
            'image'  => 'sometimes|string|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
