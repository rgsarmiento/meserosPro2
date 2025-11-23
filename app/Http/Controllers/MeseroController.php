<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Mesa;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MeseroController extends Controller
{
    // Mostrar pantalla de login
    public function login()
    {
        if (Session::has('mesero_id')) {
            return redirect()->route('mesas');
        }
        
        $usuarios = Usuario::activos()->get();
        return view('login', compact('usuarios'));
    }

    // Autenticar mesero
    public function authenticate(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:Usuarios,Id',
        ]);

        $usuario = Usuario::find($request->usuario_id);
        
        if ($usuario && $usuario->Estado == 1) {
            Session::put('mesero_id', $usuario->Id);
            Session::put('mesero_nombre', $usuario->Nombre);
            
            return redirect()->route('mesas');
        }

        return back()->withErrors(['error' => 'Usuario no válido o inactivo']);
    }

    // Mostrar mesas disponibles
    public function mesas()
    {
        // Ordenar naturalmente (Mesa 1, Mesa 2, Mesa 3... en lugar de Mesa 1, Mesa 10, Mesa 11...)
        $mesas = Mesa::all()->sortBy('Nombre', SORT_NATURAL)->values();
        return view('mesas', compact('mesas'));
    }

    // Mostrar menú de productos para una mesa
    public function menu($mesaId)
    {
        $mesa = Mesa::findOrFail($mesaId);
        
        // Obtener todas las mesas para el selector de "Mover a otra mesa"
        $todasLasMesas = Mesa::all()->sortBy('Nombre', SORT_NATURAL)->values();
        
        // Obtener categorías activas con sus productos (filtrados por precio > 0 y SeVende = true)
        $categorias = Categoria::activas()
            ->with(['productos' => function($query) {
                $query->activos()
                      ->vendibles()
                      ->where('PrecioVenta', '>', 0);
            }])
            ->whereHas('productos', function($query) {
                $query->activos()
                      ->vendibles()
                      ->where('PrecioVenta', '>', 0);
            })
            ->orderBy('Nombre')
            ->get();

        return view('menu', compact('mesa', 'categorias', 'todasLasMesas'));
    }

    // Crear orden
    public function crearOrden(Request $request, $mesaId)
    {
        $request->validate([
            'productos' => 'required|array|min:1',
            'productos.*.codigo' => 'required|exists:Productos,Codigo',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
            'productos.*.observacion' => 'nullable|string',
        ]);

        $mesa = Mesa::findOrFail($mesaId);
        $meseroId = Session::get('mesero_id');

        // Calcular total usando el precio del carrito (puede ser personalizado)
        $total = 0;
        $productosData = [];

        foreach ($request->productos as $item) {
            $producto = Producto::where('Codigo', $item['codigo'])->first();
            
            // Usar el precio del carrito (puede ser personalizado para productos de $1)
            $precioUnitario = $item['precio'];
            $subtotal = $precioUnitario * $item['cantidad'];
            $total += $subtotal;

            $productosData[] = [
                'producto' => $producto,
                'cantidad' => $item['cantidad'],
                'observacion' => $item['observacion'] ?? null,
                'subtotal' => $subtotal,
            ];
        }

        // Crear la orden
        $orden = Orden::create([
            'FechaHora' => now(),
            'UsuarioId' => $meseroId,
            'MesaId' => $mesaId,
            'Total' => $total,
            'Estado' => 'Pendiente',
        ]);

        // Crear los detalles de la orden (guardando precio total, no unitario)
        foreach ($productosData as $item) {
            OrdenDetalle::create([
                'OrdenId' => $orden->Id,
                'LlaveOrden' => $orden->Llave,
                'CodigoProducto' => $item['producto']->Codigo,
                'NombreProducto' => $item['producto']->Nombre,
                'CategoriaId' => $item['producto']->Id_Categoria,
                'Cantidad' => $item['cantidad'],
                'Precio' => $item['subtotal'], // Precio total (cantidad * precio unitario)
                'Observacion' => $item['observacion'],
                'MesaId' => $mesaId,
            ]);
        }

        // Actualizar estado de la mesa y registrar hora de ocupación
        $mesa->update([
            'Estado' => 'Ocupada',
            'FechaHora' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Orden creada exitosamente',
            'orden_id' => $orden->Id,
        ]);
    }

    // Mostrar historial de pedidos
    public function historial(Request $request)
    {
        // Query base - SIN filtrar por usuario (todos pueden ver todo)
        $query = Orden::with(['mesa', 'usuario'])
            ->with(['detalles' => function($query) {
                $query->orderBy('NombreProducto', 'asc'); // Ordenar productos alfabéticamente
            }])
            ->orderBy('FechaHora', 'desc')
            ->take(100); // Aumentado a 100 órdenes
        
        // Aplicar filtro por mesa si existe
        if ($request->has('mesa_id') && $request->mesa_id != '') {
            $query->where('MesaId', $request->mesa_id);
        }
        
        // Obtener órdenes agrupadas por mesa
        $ordenes = $query->get()->groupBy('MesaId');
        
        // Obtener lista de mesas con órdenes para el filtro (de todos los usuarios)
        $mesasConOrdenes = Orden::with('mesa')
            ->select('MesaId')
            ->distinct()
            ->get()
            ->pluck('mesa')
            ->sortBy('Nombre');
        
        $mesaSeleccionada = $request->mesa_id;
        
        return view('historial', compact('ordenes', 'mesasConOrdenes', 'mesaSeleccionada'));
    }

    // Cerrar sesión
    public function logout()
    {
        Session::forget('mesero_id');
        Session::forget('mesero_nombre');
        return redirect()->route('login');
    }
}
