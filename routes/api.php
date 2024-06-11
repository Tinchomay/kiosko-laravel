<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;

//El middleware auth:sanctum se utiliza para acceder a datos solo si estamos autenticados
//Creamos un grupo de rutas con el middleware para que solo los que esten autenticados pueden acceder a ellos
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/pedidos', PedidoController::class);
    //Con api resource se van a ir mapeando automaticamente los metodos de los controladores
    Route::apiResource('/categorias', CategoriaController::class);
    Route::apiResource('/productos', ProductoController::class);
    Route::get('/productos/all', [ProductoController::class, 'show']);
});


//Registro
Route::post('/registro', [AuthController::class, 'register']);

//Login
Route::post('/login', [AuthController::class, 'login']);
