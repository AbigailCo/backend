<?php

namespace Database\Seeders;

use App\Models\EstadoGeneral;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estadoActivo = EstadoGeneral::where('value', 'apro')->first();
        Reserva::create([
            'cliente_id' => '2',
            'proveedor_id' => '3',
            'servicio_id' => '1',
            'fecha_inicio' => Carbon::parse('2025-04-24 11:00'),
            'fecha_fin' => Carbon::parse('2025-04-24 12:00'),
            'estado_general_id' => $estadoActivo->id,
        ]);
    }
}
