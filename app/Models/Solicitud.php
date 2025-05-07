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
       'servicio_id',
       'proveedor_id',
       'categoria_id',
       'hora_reserva',
       'fecha_reserva',
       'fecha_fin_reserva',
       'fecha_inicio_reserva'
    ];
    public function estadoGeneral()
    {
        return $this->belongsTo(EstadoGeneral::class, 'estado_general_id');
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
    public function diasDisponibles()
{
    return $this->belongsToMany(DiaSemana::class, 'servicio_dia');
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

    public function scopeFiltrar($query, array $filtros)
{
    if (!empty($filtros['proveedor_id'])) {
        $query->where('proveedor_id', $filtros['proveedor_id']);
    } elseif (!empty($filtros['cliente_id'])) {
        $query->where('cliente_id', $filtros['cliente_id']);
    }

    foreach ($filtros as $campo => $valor) {
        switch ($campo) {
            case 'nombre':
                $query->where(function ($q) use ($valor) {
                    $q->whereHas('producto', fn($q) => $q->where('nombre', 'like', "%$valor%"))
                      ->orWhereHas('servicio', fn($q) => $q->where('nombre', 'like', "%$valor%"));
                });
                break;
            case 'codigo':
                $query->where(function ($q) use ($valor) {
                    $q->whereHas('producto', fn($q) => $q->where('codigo', 'like', "%$valor%"))
                      ->orWhereHas('servicio', fn($q) => $q->where('codigo', 'like', "%$valor%"));
                });
                break;
            case 'stock_minimo':
                $query->where(function ($q) use ($valor) {
                    $q->whereHas('producto', fn($q) => $q->where('stock_minimo', $valor))
                      ->orWhereHas('servicio', fn($q) => $q->where('stock_minimo', $valor));
                });
                break;
            case 'cliente':
                $query->whereHas('cliente', fn($q) => $q->where('name', 'like', "%$valor%"));
                break;
            case 'estado_general':
                $query->whereHas('estadoGeneral', fn($q) => $q->where('value', $valor));
                break;
            case 'fecha_vencimiento':
                $query->whereDate('fecha_vencimiento', $valor);
                break;
            case 'producto_id':
                $query->where('producto_id', $valor);
                break;
            case 'servicio_id':
                $query->where('servicio_id', $valor);
                break;
            case 'categoria_id':
                $query->where(function ($q) use ($valor) {
                    $q->whereHas('producto.categoria', fn($q1) => $q1->where('id', $valor))
                      ->orWhereHas('servicio.categoria', fn($q2) => $q2->where('id', $valor));
                });
                break;
        }
    }

    return $query;
}
}
