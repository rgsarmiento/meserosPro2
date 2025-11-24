<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\OrdenDetalle;
use Illuminate\Http\Request;

class CocinaController extends Controller
{
    // Mostrar vista de cocina con órdenes pendientes
    public function index()
    {
        // Obtener órdenes que tienen al menos un producto no servido
        // Priorizar órdenes con productos "En Preparación", luego por ID
        $ordenes = Orden::whereHas('detalles', function($query) {
                $query->whereIn('Estado', ['Pendiente', 'En Preparación']);
            })
            ->with(['mesa', 'usuario'])
            ->with(['detalles' => function($query) {
                $query->whereIn('Estado', ['Pendiente', 'En Preparación'])
                      ->orderBy('NombreProducto', 'asc');
            }])
            ->get()
            ->sortByDesc(function($orden) {
                // Prioridad: órdenes con productos "En Preparación" primero
                return $orden->detalles->contains('Estado', 'En Preparación');
            })
            ->sortBy('Id'); // Luego por ID
        
        return view('cocina.index', compact('ordenes'));
    }

    // Cambiar estado de un producto
    public function cambiarEstado(Request $request, $detalleId)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente,En Preparación,Listo,Servido'
        ]);

        $detalle = OrdenDetalle::findOrFail($detalleId);
        $detalle->update(['Estado' => $request->estado]);

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente',
            'estado' => $request->estado
        ]);
    }

    // Obtener órdenes actualizadas (para auto-refresh)
    public function getOrdenes()
    {
        $ordenes = Orden::whereHas('detalles', function($query) {
                $query->whereIn('Estado', ['Pendiente', 'En Preparación']);
            })
            ->with(['mesa', 'usuario'])
            ->with(['detalles' => function($query) {
                $query->whereIn('Estado', ['Pendiente', 'En Preparación'])
                      ->orderBy('NombreProducto', 'asc');
            }])
            ->orderBy('Id', 'asc')
            ->get();

        return response()->json($ordenes);
    }
}
