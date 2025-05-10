<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use App\Models\Carrito;

class PaymentController extends Controller
{
    public function finalizarCompra(Request $request, $carritoId)
    {
        $carrito = Carrito::with('productos')->findOrFail($carritoId);

        foreach ($carrito->productos as $producto) {
            if ($producto->stock < $producto->pivot->cantidad) {
                return response()->json(['error' => 'Stock insuficiente en: ' . $producto->nombre], 400);
            }
        }

        foreach ($carrito->productos as $producto) {
            $producto->stock -= $producto->pivot->cantidad;
            $producto->save();
        }

        $carrito->estado = 'finalizado';
        $carrito->save();

        return response()->json(['mensaje' => 'Compra finalizada con éxito']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tipo' => 'required',
            'nombre' => 'nullable|string',
            'num_tarjeta' => 'nullable|string',
            'fecha_caducidad' => 'nullable|string',
            'codigo_validacion' => 'nullable|string',
            'direccion_envio' => 'required|string',
        ]);

        User::where('id', $request->user_id)->update([
            'direccion_envio' => $request->direccion_envio
        ]);

        $metodo = PaymentMethod::create($request->only([
            'user_id', 'tipo', 'nombre', 'num_tarjeta', 'fecha_caducidad', 'codigo_validacion'
        ]));

        // Aquí deberías finalizar el carrito
        DB::table('carritos')->where('user_id', $request->user_id)->update([
            'estado' => 'finalizado'
        ]);


        return response()->json(['message' => 'Compra realizada con éxito', 'metodo' => $metodo]);
    }
}

 