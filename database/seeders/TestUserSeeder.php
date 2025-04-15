<?php

namespace Database\Seeders;

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
        
        $user = User::updateOrCreate(
            ['email' => 'prueba@mail.com'],
            [
                'name' => 'prueba',
                'password' => Hash::make('12345678'),
            ]
        );
        $user->assignRole($role);
    }
}
