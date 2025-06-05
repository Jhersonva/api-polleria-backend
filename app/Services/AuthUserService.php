<?php

namespace App\Services;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;

class AuthUserService
{   
    /*
    Mejoras que se podria realizar: 
    -Limitar la cantidad de intentos de inicio de sesión para evitar ataques de fuerza bruta.
    -Implementar un sistema de autenticación de dos factores (2FA) para agregar una capa extra de protección 
    */
    public function registerAdmin(array $data)
    {
        // Verifica si ya hay 3 admins
        $adminCount = User::where('role', User::ROLE_ADMIN)->count();
        if ($adminCount >= 3) {
            throw new \Exception('Límite de administradores alcanzado.');
        }

        // Crear nuevo admin
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => User::ROLE_ADMIN,
            'password' => $data['password'],
        ]);

        return $user;
    }

     public function login(array $credentials)
    {
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                throw new \Exception('Credenciales inválidas.'); // Lanza una excepción genérica
            }
            return $token;
        } catch (JWTException $e) {
            throw new \Exception('No se pudo crear el token: ' . $e->getMessage()); // Excepción para problemas con JWT
        }
    }

    public function refreshToken()
    {
        return JWTAuth::parseToken()->refresh();
    }

    public function getUser()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                throw new \Exception('Usuario no autenticado.');
            }
            return $user;
        } catch (JWTException $e) {
            throw new \Exception('Error de token: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());  
            return 'Cierre de Sesión Exitosa';  
        } catch (JWTException $e) {
            throw new JWTException('No se pudo invalidar el token: ' . $e->getMessage());
        }
    }
}
