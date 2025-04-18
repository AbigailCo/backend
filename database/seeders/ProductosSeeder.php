<?php

namespace Database\Seeders;

use App\Models\EstadoGeneral;
use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estadoActivo = EstadoGeneral::where('value', 'act')->first();
        Producto::firstOrCreate(
            ['id' => 1],
            [
                'nombre' => 'Producto1',
                'estado_general_id' => $estadoActivo->id,
                'codigo' => '123uncodigo456',
                'descripcion' => 'Descripcion del producto 1',
                'precio' => 100,
                'stock' => 50,
                'stock_minimo' => 10,
                'fecha_vencimiento' => '2024-12-31',
                'categoria_id' => 1
                'proveedor_id' => 2,

            ]
        );
    }
}
