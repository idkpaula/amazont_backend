<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use Illuminate\Http\Request;

class OpinionController extends Controller
{ 
    public function index($producto_id)
    {
        $opiniones = Opinion::where('producto_id', $producto_id)->with('usuario')->get();
        return response()->json($opiniones);
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id_prod',
            'usuario_id' => 'required|exists:users,id',
            'comentario' => 'required|string',
        ]);

        $opinion = Opinion::create($request->all());

        return response()->json($opinion, 201);
    }

    public function destroy($id)
    {
        $opinion = Opinion::find($id);
        if (!$opinion) {
            return response()->json(['message' => 'Opinión no encontrada'], 404);
        }

        $opinion->delete();
        return response()->json(['message' => 'Opinión eliminada correctamente']);
    }
}
