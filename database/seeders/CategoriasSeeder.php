<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::firstOrCreate(
            ['id' => 1],
            [
                'nombre' => 'Categoria1',
                'label' => 'Categoria1',
                'value' => 'cat1',
                'descripcion' => 'Primera categoria'
            ]
        );

        Categoria::firstOrCreate(
            ['id' => 2],
            [
                'nombre' => 'Categoria2',
                'label' => 'Categoria2',
                'value' => 'cat2',
                'descripcion' => 'Segunda categoria'
            ]
        );

        Categoria::firstOrCreate(
            ['id' => 3],
            [
                'nombre' => 'Categoria3',
                'label' => 'Categoria3',
                'value' => 'cat3',
                'descripcion' => 'Tercera categoria'
            ]
        );
        Categoria::firstOrCreate(
            ['id' => 4],
            [
                'nombre' => 'Compra',
                'label' => 'Compra',
                'value' => 'com',
                'descripcion' => 'Compra de producto'
            ]
        );

        Categoria::firstOrCreate(
            ['id' => 5],
            [
                'nombre' => 'Reserva',
                'label' => 'Reserva',
                'value' => 'reser',
                'descripcion' => 'Reservar servicio'
            ]
        );

        Categoria::firstOrCreate(
            ['id' => 6],
            [
                'nombre' => 'Turno',
                'label' => 'Turno',
                'value' => 'tur',
                'descripcion' => 'Turno medico'
            ]
        );
    }
}
