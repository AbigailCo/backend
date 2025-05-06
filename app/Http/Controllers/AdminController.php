<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserEditRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Resources\Users\UserResource;
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
        $users = User::with('roles')->get();
        return UserResource::collection($users);
    }


    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }

    public function editUser(UserEditRequest $request, $id)
    {
        if (!$request->user()->hasRole('admin')) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
      

        $user = User::findOrFail($id);
      
        $validated = $request->validated();
        
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

    public function storeUser(UserStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create($validated);
       
        $user->assignRole([$request['role']]);
        $estadoActivo = EstadoGeneral::where('value', 'act')->first();
        event(new Registered($user));


        return response()->json([
            'message' => 'Registro exitoso',
            'user' => new UserResource($user),
           
        ]);
    }

}
