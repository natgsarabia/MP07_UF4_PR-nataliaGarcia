<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Laravel\Sanctum\Sanctum;
use App\SwaggerConfig;
use App\Http\Middleware\AdminMiddleware;

/**
 * @OA\Info(
 *     title="Mi API",
 *     version="1.0.0",
 *     description="Documentación de mi API",
 *     @OA\Contact(
 *         email="contacto@midominio.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Bearer token"
 * )
 */


//RUTAS API

//Rutas de registro de usuarios y de login (para estas no hará falta ningún token)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Ruta logout (Para estas si necesitaremos que el usuario este autentificado y su token)
Route::middleware('auth:sanctum')->group(function(){
    //ruta para deslogearse
    Route::post('/logout', [AuthController::class, 'logout']);

    //rutas para los productos
    Route::get('/products', [ProductController::class, 'findAll']);
    Route::get('/products/{id}', [ProductController::class, 'showOne']);

    //rutas de productos pero que solo pueden acceder los admins
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    });
});

