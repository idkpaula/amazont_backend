<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\CarritoController; 

// USUARIO O ADMIN
Route::post('/register', [AuthController::class, 'register']); // Ruta para registro
Route::post('/login', [AuthController::class, 'login']); // Ruta para login
Route::post('/update-password', [AuthController::class, 'updatePassword']); // Ruta para actualizar contraseña

Route::get('/usuario/{id}', [AuthController::class, 'getUserById']); // Ruta para obtener la información
Route::post('/usuario/{id}', [AuthController::class, 'updateUser']); // Ruta para actualizar la contraseña y/o la dirección de envío 

// CATEGORIAS Y PRODUCTOS
Route::apiResource('categorias', CategoriaController::class); // Ruta para crear, modificar, mostrar y eliminar
Route::apiResource('productos', ProductoController::class); // Ruta para crear, modificar, mostrar y eliminar

// OPINIONES Y VALORACIONES
Route::get('/productos/{id}/opiniones', [OpinionController::class, 'index']); // Ruta para obtener 
Route::post('/opiniones', [OpinionController::class, 'store']); // Ruta para crear
Route::delete('/opiniones/{id}', [OpinionController::class, 'destroy']); // Ruta para eliminar 

Route::get('/productos/{id}/valoraciones', [ValoracionController::class, 'index']); // Ruta para obtener 
Route::post('/valoraciones', [ValoracionController::class, 'store']); // Ruta para crear 
Route::delete('/valoraciones/{id}', [ValoracionController::class, 'destroy']); // Ruta para eliminar 

// CARRITO
Route::post('/carritos', [CarritoController::class, 'crearCarrito']); // Ruta para crear  
Route::put('/carritos/{id}', [CarritoController::class, 'modificarCarrito']); // Ruta para modificar
Route::get('/carritos/{id}', [CarritoController::class, 'mostrarCarrito']); // Ruta para mostrar

// PROCESO DE PAGO
Route::post('/pago', [PaymentController::class, 'store']);

// ADMINISTRACIÓN DE PRODUCTOS
Route::get('/products/{vendedor_id}', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);