<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class HeroesController extends Controller
{
    public function getHeroById(Request $request, $id)
    {
        // Verifica si se proporcionó un token válido en la solicitud
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Unauthorized Invalid Token'], 401);
        }

        // Realiza la validación de la API key con la Superhero API
        $client = new Client();
        $response = $client->get("https://superheroapi.com/api/116175248175067/$id");

        if ($response->getStatusCode() !== 200) {
            return response()->json(['error' => 'Invalid API key or superhero ID'], 401);
        }

        $data = json_decode($response->getBody(), true);

        // Procesa y devuelve los datos del superhéroe
        return response()->json($data);
    }
    public function getHeroPowerstatsById(Request $request,$id)
    {
         // Verifica si se proporcionó un token válido en la solicitud
         $token = $request->bearerToken();

         if (!$token) {
             return response()->json(['error' => 'Unauthorized Invalid Token'], 401);
         }
         
        $client = new Client();
        $response = $client->get("https://superheroapi.com/api/116175248175067/$id/powerstats");
        $data = json_decode($response->getBody(), true);
        
        // Procesa y devuelve los powerstats del superhéroe
        return response()->json($data);
    }
    public function getHeroBiographyById(Request $request,$id)
    {
         // Verifica si se proporcionó un token válido en la solicitud
         $token = $request->bearerToken();

         if (!$token) {
             return response()->json(['error' => 'Unauthorized Invalid Token'], 401);
         }
        $client = new Client();
        $response = $client->get("https://superheroapi.com/api/116175248175067/$id/biography");
        $data = json_decode($response->getBody(), true);
        
        // Procesa y devuelve la biografía del superhéroe
        return response()->json($data);
    }

    public function getHeroWorkById(Request $request,$id)
    {
         // Verifica si se proporcionó un token válido en la solicitud
         $token = $request->bearerToken();

         if (!$token) {
             return response()->json(['error' => 'Unauthorized Invalid Token'], 401);
         }
         
        $client = new Client();
        $response = $client->get("https://superheroapi.com/api/116175248175067/$id/work");
        $data = json_decode($response->getBody(), true);
        
        // Procesa y devuelve el trabajo del superhéroe
        return response()->json($data);
    }


   
}