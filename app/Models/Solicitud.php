<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitudes';

    protected $fillable = [
       'cliente_id',
       'producto_id',
       'proveedor_id',
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
        return $this->belongsTo(Producto::class);
    }
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
