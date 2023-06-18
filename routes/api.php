<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroesController;
use App\Http\Controllers\SpoonacularController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/signup', [AuthController::class, 'signup'])->name('signup'); // Ruta para registrar un usuario en la aplicación 
Route::post('/login', [AuthController::class, 'login'])->name('login'); // Ruta para iniciar sesión en la aplicación 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');  // Ruta para cerrar sesión en la aplicación 

// Rutas para la API de heroes

Route::get('/superhero/{id}', [HeroesController::class, 'getHeroById'])->name('getHeroById');;
Route::get('/superheroes/{id}/powerstats', [HeroesController::class, 'getHeroPowerstatsById']);
Route::get('/superheroes/{id}/biography', [HeroesController::class, 'getHeroBiographyById']);
Route::get('/superheroes/{id}/work', [HeroesController::class, 'getHeroWorkById'])->name('superheroes.getWorkById');

// Rutas para la API de spoonacular

Route::get('/recipes/{id}', [SpoonacularController::class, 'getRecipeById'])->name('getRecipeById');

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */