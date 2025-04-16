<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function getRoles()
    {
        $roles = Role::all()->map(function ($role) {
            return [
                'id' => $role->id,
                'nombre' => $role->name,

            ];
        });

        return response()->json($roles);
    }
}
