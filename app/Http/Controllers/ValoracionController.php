<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use Illuminate\Http\Request;

class ValoracionController extends Controller
{ 
    public function index($producto_id)
    {
        $valoraciones = Valoracion::where('producto_id', $producto_id)->with('usuario')->get();
        $promedio = Valoracion::where('producto_id', $producto_id)->avg('puntuacion');

        return response()->json([
            'valoraciones' => $valoraciones,
            'promedio' => round($promedio, 1),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id_prod',
            'usuario_id' => 'required|exists:users,id',
            'puntuacion' => 'required|integer|min:1|max:5',
        ]);

        $valoracion = Valoracion::create($request->all());

        return response()->json($valoracion, 201);
    }

    public function destroy($id)
    {
        $valoracion = Valoracion::find($id);
        if (!$valoracion) {
            return response()->json(['message' => 'Valoración no encontrada'], 404);
        }

        $valoracion->delete();
        return response()->json(['message' => 'Valoración eliminada correctamente']);
    }
}
