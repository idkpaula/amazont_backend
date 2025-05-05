<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
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
        DB::table('carritos')->where('usuario', $request->user_id)->update([
            'estado' => 'finalizado'
        ]);

        return response()->json(['message' => 'Compra realizada con éxito', 'metodo' => $metodo]);
    }
}

 