<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
  // use HasFactory;

  protected $table = 'servicios';

  protected $fillable = [
    'nombre',
    'descripcion',
    'codigo',
    'precio',
    'stock',
    'stock_minimo',
    'fecha_vencimiento',
    'categoria_id',
    'tipo',
    'duracion',
    'ubicacion',
    'proveedor_id',
    'estado_general_id',
    'horarios',
  ];

  protected $casts = [
    'horarios' => 'array',
    'dias_disponibles' => 'array',
  ];
  public function categoria()
  {
    return $this->belongsTo(Categoria::class, 'categoria_id');
  }
  public function diasDisponibles()
  {
    return $this->belongsToMany(DiaSemana::class, 'servicio_dia');
  }
  public function estadoGeneral()
  {
    return $this->belongsTo(EstadoGeneral::class, 'estado_general_id');
  }

  public function proveedor()
  {
    return $this->belongsTo(User::class, 'proveedor_id');
  }
  public function scopeFiltrar($query, array $filtros)
  {
    foreach ($filtros as $campo => $valor) {
      switch ($campo) {
        case 'nombre':
          $query->where('nombre', 'like', "%$valor%");
          break;

        case 'codigo':
          $query->where('codigo', 'like', "%$valor%");
          break;

        case 'stock_minimo':
          $query->where('stock_minimo', $valor);
          break;

        case 'estado_general':
          $query->whereHas('estadoGeneral', fn($q) => $q->where('value', $valor));
          break;

        case 'fecha_vencimiento':
          $query->whereDate('fecha_vencimiento', $valor);
          break;

        case 'servicio_id':
          $query->where('id', $valor);
          break;

        case 'dias_disponibles':
          $query->whereHas('diasDisponibles', function ($q) use ($valor) {
            is_array($valor)
              ? $q->whereIn('nombre', $valor)
              : $q->where('nombre', 'like', "%$valor%");
          });
          break;

          case 'categoria_id':
            $query->whereIn('categoria_id', is_array($valor) ? $valor : [$valor]);
            break;

        case 'proveedor_nombre':
          $query->whereHas('categoria', fn($q) => $q->where('nombre', 'Turno'));
          $query->whereHas('proveedor', function ($q) use ($valor) {
            $q->where('name', 'like', "%$valor%");
          });
          break;
      }
    }

    return $query;
  }
}
