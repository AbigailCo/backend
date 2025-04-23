<?php

namespace Database\Seeders;

use App\Models\Disponibilidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisponibilidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 5) as $dia) {
            Disponibilidad::create([
                'proveedor_id' => '3',
                'servicio_id' => '1',
                'dia_semana' => $dia,
                'hora_inicio' => '10:00',
                'hora_fin' => '18:00',
            ]);
        }
    }
}
