<?php

namespace App\Http\Requests\AuthUsers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|min:5|max:50|unique:users,username,' . $this->user()->id,
            'email' => 'required|email|unique:users,email,' . $this->user()->id,
            'password' => 'nullable|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'El nombre de usuario es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ];
    }
}
