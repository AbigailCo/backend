<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disponibilidad extends Model
{
    protected $table = 'disponibilidades';

    protected $fillable = [
        'proveedor_id',
        'servicio_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
    ];

    public function proveedor() {
        return $this->belongsTo(User::class, 'proveedor_id');
    }

    public function servicio() {
        return $this->belongsTo(Servicio::class);
    }
    public function estadoGeneral()
    {
        return $this->belongsTo(EstadoGeneral::class, 'estado_general_id');
    }
}
