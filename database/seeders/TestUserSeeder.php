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
        $cliente = Role::firstOrCreate(['name' => 'cliente']);
        $proveedor = Role::firstOrCreate(['name' => 'proveedor']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $estadoActivo = EstadoGeneral::where('value', 'act')->first();
        
        $user1 = User::updateOrCreate(
            ['email' => 'prueba@mail.com'],
            [
                'id' => 1,
                'name' => 'prueba',
                'password' => Hash::make('12345678'),
                'estado_general_id' => $estadoActivo->id,
            ]
        );
        $user1->assignRole($admin);
        $user2 = User::updateOrCreate(
            ['email' => '2024@mail.com'],
            [
                'id' => 2,
                'name' => 'cliente',
                'password' => Hash::make('12345678'),
                'estado_general_id' => $estadoActivo->id,
            ]
        );
        $user2->assignRole($cliente);
        $user3 = User::updateOrCreate(
            ['email' => 'test@mail.com'],
            [
                'id' => 3,
                'name' => 'proveedor',
                'password' => Hash::make('12345678'),
                'estado_general_id' => $estadoActivo->id,
            ]
        );
        $user3->assignRole($proveedor);
    }
}
