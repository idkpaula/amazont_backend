<?php
// Controlador para la tabla de los vendedores
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($vendedor_id)
    {
        return Product::where('vendedor_id', $vendedor_id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendedor_id' => 'required|exists:users,id',
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|url',
            'oferta' => 'boolean'
        ]);

        $producto = Product::create($request->all());

        return response()->json(['message' => 'Producto creado', 'producto' => $producto]);
    }

    public function update(Request $request, $id)
    {
        $producto = Product::findOrFail($id);
        $producto->update($request->all());

        return response()->json(['message' => 'Producto actualizado', 'producto' => $producto]);
    }
}
