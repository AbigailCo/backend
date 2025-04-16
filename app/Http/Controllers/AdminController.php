<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EstadoGeneral;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules;

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
            'role' => 'required|exists:roles,name',
        ]);
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password']
                ? bcrypt($validated['password'])
                : $user->password,
           
        ]);
        $user->syncRoles([$validated['role']]);
       
        return response()->json(['message' => 'Perfil actualizado con exito.']);
    }

    
    public function disableUser($id)
    {
        $user = User::findOrFail($id);
        $user->estado_general_id = 2; 
        $user->save();
    
        return response()->json(['message' => 'Usuario deshabilitado correctamente.']);
        
    }
    public function enableUser($id)
    {
        $user = User::findOrFail($id);
        $user->estado_general_id = 1; 
        $user->save();
    
        return response()->json(['message' => 'Usuario habilitado correctamente.']);
        
    }

    public function storeUser(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
        ]);
       
        $user->assignRole([$request['role']]);
        $estadoActivo = EstadoGeneral::where('value', 'act')->first();
        event(new Registered($user));


        return response()->json([
            'message' => 'Registro exitoso',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'estado_general_id' => $estadoActivo->id,
                'roles' => $user->getRoleNames(),
            ],
           
        ]);
    }

}
