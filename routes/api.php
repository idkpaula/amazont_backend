<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

Route::post('/register', [AuthController::class, 'register']); // Ruta para registro
Route::post('/login', [AuthController::class, 'login']); // Ruta para login
Route::post('/update-password', [AuthController::class, 'updatePassword']); // Ruta para actualizar contraseña

Route::get('/usuario/{id}', [AuthController::class, 'getUserById']); // Ruta para obtener la información del usuario
Route::post('/usuario/{id}', [AuthController::class, 'updateUser']); // Ruta para actualizar la contraseña y/o la dirección de envío 

Route::apiResource('categorias', CategoriaController::class); // Ruta para crear, modificar, mostrar y eliminar categorías
Route::apiResource('productos', ProductoController::class); // Ruta para crear, modificar, mostrar y eliminar productos
