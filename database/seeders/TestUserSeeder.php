<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'test@mail.com'],
            [
                'name' => 'User Prueba',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
