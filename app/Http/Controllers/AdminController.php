<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller

{

    public function getUsers()
    {
        $users = User::with('roles')->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'estado_general_id' => $user->estado_general_id,
                'roles' => $user->getRoleNames(),
            ];
        });
        return response()->json($users);
    }


    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'passwoard' => $user->password,
                'email_verified_at' => $user->email_verified_at,
                'remember_token' => $user->remember_token,
                'estado_general_id' => $user->estado_general_id,
                'roles' => $user->getRoleNames(),
        ];
    }

    public function editUser(Request $request, $id)
    {
        if (!$request->user()->hasRole('admin')) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
      

        $user = User::findOrFail($id);
      
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password']
                ? bcrypt($validated['password'])
                : $user->password,
        ]);
       
        return response()->json(['message' => 'Perfil actualizado con exito.']);
    }

    
    public function disableUser($id)
    {
        $user = User::findOrFail($id);
        $user->estado_general_id = 2; 
        $user->save();
    
        return response()->json(['message' => 'Usuario deshabilitado correctamente.']);
        
    }

}
