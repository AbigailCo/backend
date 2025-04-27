<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EstadoGeneral;
use App\Models\Producto;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class SolicitudesController extends Controller
{
    public function filtroSoli(Request $request)
    {
        $query = Solicitud::query();
        $filtros = $request->all();
        if ($request->filled('proveedor_id')) {
            $query->where('proveedor_id', $request->input('proveedor_id'));
        } elseif ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->input('cliente_id'));
        }

        foreach ($filtros as $campo => $valor) {
            if (in_array($campo, ['proveedor_id', 'cliente_id'])) {
                continue;
            }
            switch ($campo) {
                case 'nombre':

                    $query->whereHas('producto', fn($q) => $q->where('nombre', 'like', "%$valor%"))
                        ->orWhereHas('servicio', fn($q) => $q->where('nombre', 'like', "%$valor%"));
                    break;
                case 'codigo':
                    $query->where(function ($q) use ($valor) {
                        $q->whereHas('producto', fn($sub) => $sub->where('codigo', 'like', "%$valor%"))
                            ->orWhereHas('servicio', fn($sub) => $sub->where('codigo', 'like', "%$valor%"));
                    });
                    break;

                case 'stock_minimo':
                    $query->where(function ($q) use ($valor) {
                        $q->whereHas('producto', fn($sub) => $sub->where('stock_minimo', $valor))
                            ->orWhereHas('servicio', fn($sub) => $sub->where('stock_minimo', $valor));
                    });
                    break;

                case 'cliente':
                    $query->whereHas('cliente', fn($q) => $q->where('nombre', 'like', "%$valor%"));
                    break;

                case 'estado_general':
                    $query->where('estado_general', 'like', "%$valor%");
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
            }
        }

        $resultados = $query->with(['cliente', 'producto', 'servicio', 'proveedor', 'estadoGeneral'])->get();

        $datosFiltrados = $resultados->map(function ($solicitud) {
            return [
                'id' => $solicitud->id,
                'cliente' => $solicitud->cliente ? [
                    'nombre' => $solicitud->cliente->name,
                    'contacto' => $solicitud->cliente->email,
                ] : null,
                'proveedor' => $solicitud->proveedor ? [
                    'nombre' => $solicitud->proveedor->name,
                    'contacto' => $solicitud->proveedor->email,
                ] : null,
                'producto' => $solicitud->producto ? [
                    'nombre' => $solicitud->producto->nombre,
                    'codigo' => $solicitud->producto->codigo,
                    'stock' => $solicitud->producto->stock,
                    'precio' => $solicitud->producto->precio,
                ] : null,
                'servicio' => $solicitud->servicio ? [
                    'nombre' => $solicitud->servicio->nombre,
                    'codigo' => $solicitud->servicio->codigo,
                    'stock' => $solicitud->servicio->stock,
                    'precio' => $solicitud->servicio->precio,
                ] : null,
                'estado' => $solicitud->estadoGeneral ? [
                    'id' => $solicitud->estadoGeneral->id,
                    'nombre' => $solicitud->estadoGeneral->nombre,
                ] : null,
            ];
        });

        return response()->json($datosFiltrados);
    }
    public function storeSolicitud(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id' => 'nullable|exists:users,id',
            'proveedor_id' => 'nullable|exists:users,id',
            'producto_id' => 'nullable|exists:productos,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'categoria_id' => 'nullable|exists:categoria,id',
            'fecha_reserva' => 'nullable|regex:/^\d{4}-\d{2}-\d{2}$/',
            'hora_reserva'  => 'nullable|regex:/^\d{2}:\d{2}$/',
            'notas'          => 'nullable|string|max:1000',
        ]);
        $estadoActivo = EstadoGeneral::where('value', 'pend')->first();
        $data = $validatedData;
        $data['fecha_solicitud'] = now()->format('Y-m-d');
        $data['estado_id'] = $estadoActivo->id;
        $solicitud = Solicitud::create($data);

        return response()->json([
            'message' => 'Solicitud creada exitosamente',
            'solicitud' => $solicitud,
        ]);
    }
    public function horariosReservados(Request $request, $id)
    {
        $fecha = $request->query('fecha'); 
        $horasOcupadas = Solicitud::where('servicio_id', $id)
            ->where('fecha_reserva', $fecha)
            ->pluck('hora_reserva');
    
        return response()->json($horasOcupadas);
    }
    public function aprobarSoli($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->estado_general_id = 5;
        $solicitud->save();

        return response()->json(['message' => 'Solicitud aprobada.']);
    }
    public function rechazarSoli($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->estado_general_id = 6;
        $solicitud->save();

        return response()->json(['message' => 'Solicitud rechazada.']);
    }
    public function getSolicitud($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        return [
            'id' => $solicitud->id,
            'fecha_reserva' => $solicitud->fecha_reserva,
            'hora_reserva' => $solicitud->hora_reserva,
            'cliente' => $solicitud->cliente ? [
                'nombre' =>  $solicitud->cliente->name,
                'contacto' => $solicitud->cliente->email
            ] : null,

            'proveedor' => $solicitud->proveedor ? [
                'nombre' =>  $solicitud->proveedor->name,
                'contacto' => $solicitud->proveedor->email
            ] : null,

            'producto' => $solicitud->producto ? [
                'nombre' =>  $solicitud->producto->nombre,
                'codigo' => $solicitud->producto->codigo,
                'stock' => $solicitud->producto->stock,
                'precio' => $solicitud->Producto->precio,
            ] : null,
            'servicio' => $solicitud->servicio ? [
                'nombre' =>  $solicitud->servicio->nombre,
                'codigo' => $solicitud->servicio->codigo,
                'stock' => $solicitud->servicio->stock,
                'precio' => $solicitud->servicio->precio,
            ] : null,
            'estado' => $solicitud->estadoGeneral ? [
                'id' =>  $solicitud->estadoGeneral->id,
                'nombre' => $solicitud->estadoGeneral->nombre
            ] : null,
       

        ];
    }
}
