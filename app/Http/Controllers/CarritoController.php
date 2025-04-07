<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\CarritoProducto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    // Crear carrito
    public function crearCarrito(Request $request)
    {
        $request->validate(['usuario' => 'required|string']);
        $carrito = Carrito::create(['usuario' => $request->usuario]);
        return response()->json($carrito, 201);
    }

    // Modificar carrito: añadir o quitar productos, cambiar estado
    public function modificarCarrito(Request $request, $id)
    {
        $carrito = Carrito::findOrFail($id);

        if ($request->has('estado')) {
            $carrito->estado = $request->estado;
            $carrito->save();
        }

        if ($request->has('productos')) {
            foreach ($request->productos as $producto) {
                if (isset($producto['accion']) && $producto['accion'] == 'eliminar') {
                    CarritoProducto::where('carrito_id', $id)
                        ->where('producto', $producto['producto'])
                        ->delete();
                } else {
                    CarritoProducto::updateOrCreate(
                        ['carrito_id' => $id, 'producto' => $producto['producto']],
                        ['cantidad' => $producto['cantidad'] ?? 1]
                    );
                }
            }
        }

        return response()->json(['mensaje' => 'Carrito actualizado correctamente']);
    }

    // Mostrar carrito
    public function mostrarCarrito($id)
    {
        $carrito = Carrito::with('productos')->findOrFail($id);
        return response()->json($carrito);
    }
}
