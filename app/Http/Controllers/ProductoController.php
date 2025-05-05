<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return response()->json(Producto::with('categoria')->get());
    }

    public function store(Request $request)
    { 
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'en_oferta' => 'required|boolean',
            'categoria_id' => 'required|exists:categorias,id_cat',
            'imagen' => 'nullable|string',
        ]);

        $producto = Producto::create($request->all());

        return response()->json($producto->load('categoria'), 201);
    }

    public function show($id)
    {
        // Buscar el producto por id_prod
        $producto = Producto::with('categoria')->where('id_prod', $id)->first();

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string',
            'precio' => 'sometimes|required|numeric',
            'en_oferta' => 'sometimes|required|boolean',
            'categoria_id' => 'sometimes|required|exists:categorias,id_cat',
            'imagen' => 'nullable|string',
        ]);

        $producto = Producto::where('id_prod', $id)->first();

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $producto->update($request->all());

        return response()->json($producto->load('categoria'));
    }

    public function destroy($id)
    {
        $producto = Producto::where('id_prod', $id)->first();

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $producto->delete();

        return response()->json(['message' => 'Producto eliminado correctamente']);
    }
}
