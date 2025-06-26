<?php

namespace App\Http\Requests\AuthUsers;

use Illuminate\Foundation\Http\FormRequest;

class RegisterAuthRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|min:5|max:50|unique:users',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',      
                'regex:/[A-Z]/',     
                'regex:/[0-9]/',      
                'regex:/[@$!%*#?&]/', 
            ],
        ];
    }

    public function messages()
    {
        return [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe incluir una mayúscula, minúscula, número y carácter especial.',
            'username.unique' => 'El nombre de usuario ya está en uso.',
            'email.unique' => 'El correo electrónico ya está registrado.',

        ];
    }
}
