<?php

namespace Database\Seeders;

use App\Models\EstadoGeneral;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TestUserSeeder extends Seeder
{
    //Usuario de prueba rol ADMIN , los usuarios que se registran mediante front se 
    //les otorga un rol de cliente en el controlador
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'admin']);
        $estadoActivo = EstadoGeneral::where('value', 'act')->first();
        
        $user = User::updateOrCreate(
            ['email' => 'prueba@mail.com'],
            [
                'id' => 1,
                'name' => 'prueba',
                'password' => Hash::make('12345678'),
                'estado_general_id' => $estadoActivo->id,
            ]
        );
        $user->assignRole($role);
    }
}
