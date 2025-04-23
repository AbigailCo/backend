<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'cliente_id',
        'proveedor_id',
        'servicio_id',
        'fecha_inicio',
        'fecha_fin',
        'notas',
    ];

    // Relaciones
    public function cliente() {
        return $this->belongsTo(User::class, 'cliente_id');
    }

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
