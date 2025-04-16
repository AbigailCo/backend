<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Servicio::firstOrCreate(
            ['id' => 1],
            ['nombre' => 'Servicios1','codigo' => '123Servicios456' , 'descripcion' => 'Descripcion del Servicios 1', 'precio' => 100, 'stock' => 50, 'stock_minimo' => 10, 'fecha_vencimiento' => '2024-12-31', 'categoria_id' => 1]
        );
    }
}
