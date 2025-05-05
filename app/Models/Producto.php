<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
        'precio',
        'stock',
        'stock_minimo',
        'fecha_vencimiento',
        'categoria_id',
        'proveedor_id',
        'estado_general_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
    public function estado()
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

        case 'producto_id':
          $query->where('id', $valor);
          break;


          case 'categoria_id':
            $query->whereIn('categoria_id', is_array($valor) ? $valor : [$valor]);
            break;

        case 'proveedor_nombre':
         // $query->whereHas('categoria', fn($q) => $q->where('nombre', 'Turno'));
          $query->whereHas('proveedor', function ($q) use ($valor) {
            $q->where('name', 'like', "%$valor%");
          });
          break;
      }
    }

    return $query;
  }
}
