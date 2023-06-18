<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpoonacularController extends Controller // Controlador para la API de Spoonacular    
{
    private $client;// Cliente HTTP para realizar las peticiones a la API de Spoonacular
    private $apiKey;// Clave de la API de Spoonacular

    public function __construct() // Constructor de la clase    
    {
        $this->client = new Client(); // Creación del cliente HTTP
        $this->apiKey = env('API_KEY_SPOON');// Obtención de la clave de la API de Spoonacular  
    }

    public function searchRecipesByIngredients(Request $request) // Método para buscar recetas por ingredientes
    {
        $ingredients = $request->input('ingredients');// Obtención de los ingredientes de la solicitud 
        $token = $request->bearerToken();// Obtención del token de autenticación de la solicitud

        if (!$token) { // Verificar si el token no está presente
            return response()->json(['error' => 'Unauthorized'], 401); // Respuesta de error
        }

        try {
            $response = $this->client->get('https://api.spoonacular.com/recipes/findByIngredients', [ // Realización de la petición a la API de Spoonacular 
                'headers' => [
                    'x-api-key' => $this->apiKey, 
                ],
                'query' => [
                    'ingredients' => $ingredients
                ]
            ]);

            $data = json_decode($response->getBody(), true); // Decodificación de la respuesta de la API de Spoonacular
            return response()->json(['recipes' => $data]); // Respuesta de éxito y envío de las recetas al cliente
        } catch (GuzzleException $e) { // Captura de excepciones
            return response()->json(['error' => $e->getMessage()]); // Respuesta de error
        }
    }

}
    
