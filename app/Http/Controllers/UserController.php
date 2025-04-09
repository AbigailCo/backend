<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function editUser(Request $request)
    {
      
       
            $user = $request->user();
        
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
