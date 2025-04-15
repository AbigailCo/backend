<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function editUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validar que el usuario autenticado pueda editar ese perfil
        if ($request->user()->id !== $user->id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            //             'password_confirmation' => 'nullable|min:8|confirmed',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
            //          'password_confirmation' => $validated['password_confirmation'] ? bcrypt($validated['password_confirmation']) : $user->password_confirmation,

        ]);

        return response()->json(['message' => 'Perfil actualizado con éxito.']);
    }
}
