<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\DiaSemana;
use App\Models\EstadoGeneral;
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
        $estadoActivo = EstadoGeneral::where('value', 'act')->first();
        $categoriaTurno = Categoria::where('value', 'tur')->first(); 
        $categoriaReserva = Categoria::where('value', 'reser')->first(); 


        $servicio = Servicio::firstOrCreate(
            ['id' => 1],
            [
                'nombre' => 'Reserva',
                'descripcion' => 'Descripción del Reserva 1',
                'precio' => 100,
                'estado_general_id' => $estadoActivo->id,
                'categoria_id' => $categoriaReserva?->id,
                'codigo' => '123Servicios456',
                'proveedor_id' => 3,
                'fecha_inicio' => now(),
                'fecha_fin' => now()->addDays(30),
            ]
        );

        $servicio2 = Servicio::create([
            'nombre' => 'Consulta clínica',
            'descripcion' => 'Turno de 30 minutos con la Dra. Perez',
            'precio' => 5000,
            'duracion' => '30 minutos',
            'ubicacion' => 'Consultorio 1',
            'horarios' => ['09:00', '10:00', '11:00'],
            'estado_general_id' => $estadoActivo->id,
            'categoria_id' => $categoriaTurno?->id,
            'codigo' => '123Servicios123',
            'proveedor_id' => 3,
        ]);

        // Asignar días disponibles (lunes y miércoles)
        $dias2 = DiaSemana::whereIn('value', ['lun', 'mier'])->pluck('id');
        $servicio2->diasDisponibles()->sync($dias2);

        $dias = DiaSemana::whereIn('value', ['mier', 'juev'])->pluck('id');
        $servicio->diasDisponibles()->sync($dias);
    }
}
