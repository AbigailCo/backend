<?php

namespace Database\Seeders;

use App\Models\EstadoGeneral;
use App\Models\Solicitud;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SolicitudesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estadoActivo = EstadoGeneral::where('value', 'pend')->first();
        Solicitud::firstOrCreate(
            ['id' => 1],
            [
                'cliente_id' => '2',
                'proveedor_id' => '3',
                'producto_id' => '1',
                'mensaje_opcional' => 'creado con el seeder',
                'estado_general_id' => $estadoActivo->id,
                'fecha_solicitud' => '2024-12-31',
                'fecha_respuesta' =>'2024-12-31',
               
            ]
        );
        Solicitud::firstOrCreate(
            ['id' => 2],
            [
                'cliente_id' => '2',
                'proveedor_id' => '3',
                'servicio_id' => '1',
                'mensaje_opcional' => 'creado con el seeder',
                'estado_general_id' => $estadoActivo->id,
                'fecha_solicitud' => '2024-12-31',
                'fecha_respuesta' =>'2024-12-31',  
                'fecha_reserva' => '2025-04-17',
                'hora_reserva' => '11:00'             
            ]
        );
        
    }
}
