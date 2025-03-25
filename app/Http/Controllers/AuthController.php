<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
    public function register(Request $request) {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'role' => 'nullable|string|in:user,admin',
            'address' => 'nullable|string|max:255',  // Agregar validación para la dirección
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        // Crear usuario y encriptar la contraseña
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role ?? 'user',
            'address' => $request->address, // Guardar la dirección si está presente
        ]);
    
        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $user
        ], 201);
    }    

    // Función para el login (comprobación de usuario y contraseña)
    public function login(Request $request) {
        // Validar los datos de la solicitud
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Comprobar si el usuario existe en la base de datos
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Comprobar si la contraseña es correcta
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Contraseña incorrecta'], 401);
        }

        // Aquí puedes generar un token de autenticación o devolver una respuesta exitosa
        // Ejemplo: Devolver datos del usuario o un token JWT
        return response()->json(['message' => 'Login exitoso', 'user' => $user], 200);
    }

    // Función para modificar la contraseña del usuario
    public function updatePassword(Request $request) {
        // Validar los datos de la solicitud
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8|confirmed',  // Confirmar la nueva contraseña
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Buscar el usuario por correo electrónico
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Comprobar si la contraseña antigua es correcta
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Contraseña antigua incorrecta'], 401);
        }

        // Actualizar la contraseña
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada con éxito'], 200);
    }

    public function getUserById($id) {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    
        return response()->json(['user' => $user], 200);
    }
    
    public function updateUser(Request $request, $id) {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    
        $validator = Validator::make($request->all(), [
            'old_password' => 'nullable|min:8',
            'new_password' => 'nullable|min:8|confirmed',
            'address' => 'nullable|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        if ($request->has('new_password')) {
            if (!$request->has('old_password') || !Hash::check($request->old_password, $user->password)) {
                return response()->json(['message' => 'Contraseña antigua incorrecta'], 401);
            }
            $user->password = Hash::make($request->new_password);
        }
    
        if ($request->has('address')) {
            $user->address = $request->address;
        }
    
        $user->save();
    
        return response()->json(['message' => 'Usuario actualizado con éxito', 'user' => $user], 200);
    }    

}