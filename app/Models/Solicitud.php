<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'proveedor_id',
        'producto_id',
        'servicio_id',
        'mensaje_opcional',
        'fecha_solicitud',
        'fecha_respuesta',
    ];
    public function estadoGeneral()
    {
        return $this->belongsTo(EstadoGeneral::class, 'estado_general_id');
    }
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
    

    public function proveedor()
    {
        return $this->belongsTo(User::class, 'proveedor_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}
