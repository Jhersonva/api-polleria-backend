<?php

namespace App\Http\Requests\DishCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreDishCategoryRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }
   
    public function rules(): array
    {
        return [
            'name'   => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'image'  => 'nullable|string|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
