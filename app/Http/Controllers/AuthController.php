<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller // Controlador de autenticación de usuario 
{
    public function signup(Request $request){ // Método para registrar un usuario en la base de datos 
        $user = User::create([ // Creación de un nuevo usuario en la base de datos 
        'name' => $request->input('name'), // Nombre del usuario 
        'email' => $request->input('email'), // Correo electrónico del usuario 
        'password' => bcrypt($request->input('password')), // Contraseña del usuario 
        ]);
        return response()->json(['message' => 'User signed up successfully'], 201); // Respuesta de éxito 
        }
        public function login(Request $request){ // Método para iniciar sesión en la aplicación 
            $validator = Validator::make($request->all(), [ // Validación de los datos de la solicitud 
            'email' => 'required | email', // El correo electrónico es obligatorio y debe ser válido 
            'password' => 'required', // La contraseña es obligatoria 
            ]);
            
            if ($validator->fails()) { // Verificar si la validación falla 
            return response()->json(['errors' => $validator->errors()], 400); // Respuesta de error 
            }
            
            $user = User::where('email', $request->input('email'))->first(); // Obtener el usuario de la base de datos 
            
            if (!$user) { // Verificar si el usuario existe 
            return response()->json(['error' => 'Email is not registered'], 404); // Respuesta de error 
            }
    
            if (!password_verify($request->input('password'), $user->password)) { // Verificar si la contraseña es incorrecta 
                return response()->json(['error' => 'Incorrect password'], 400); // Respuesta de error 
            }
            
            $payload = [ // Creación del payload del token
            'iss' => config('app.url'), // Emisor del token 
            'sub' => $user->id, // Asunto del token 
            'iat' => time(), // Tiempo de creación del token 
            'exp' => time() + (60 * 60 * 24),   // Tiempo de expiración del token 
            ];
            $jwt = JWT::encode($payload, config('app.key'), 'HS256'); // Creación del token de autenticación del usuario 
            return response()->json(['token' => $jwt]); // Respuesta de éxito y envío del token al cliente
    }
    public function logout(Request $request) // Método para cerrar sesión en la aplicación 
    {
        
        // Obtención del token de autenticación de la solicitud
        $token = $request->header('Authorization');
    
        
        // Verificar si el token está
        if ($token) {
            
            // Eliminar el token de la lista de tokens revocados
            Cache::put('revoked_tokens:' . $token, true, 60 * 24); // El token se considera revocado por 24 horas    
            return response()->json(['message' => 'User logged out successfully']); // Respuesta de éxito 
        }
    
        return response()->json(['error' => 'Token not provided'], 400);    // Respuesta de error
    }
}
