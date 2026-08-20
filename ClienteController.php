<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Carrito;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Inventario;

class ClienteController extends Controller
{
    /**
     * ID fijo del empleado "Tienda Online", usado en las ventas
     * generadas automáticamente desde el panel del cliente.
     */
    const ID_EMPLEADO_TIENDA_ONLINE = 1414;

    public function index()
    {
        $productos = Producto::with(['categoria', 'imagenes', 'tallas', 'colores', 'inventario'])
            ->where('estado', 'A')
            ->get();

        $categorias = Categoria::all();

        $idCliente = Auth::id();

        $carrito = Carrito::with(['producto.imagenes', 'producto.inventario', 'talla', 'color'])
            ->where('id_cliente', $idCliente)
            ->get();

        $pedidos = Venta::with(['detalles.producto.imagenes', 'detalles.talla', 'detalles.color'])
            ->where('id_cliente', $idCliente)
            ->orderByDesc('fecha')
            ->get();

        return view('cliente.dashboard', compact('productos', 'categorias', 'carrito', 'pedidos'));
    }


    public function agregarAlCarrito(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id_producto',
            'id_talla'    => 'required|exists:talla,id_talla',
            'id_color'    => 'required|exists:color,id_color',
            'cantidad'    => 'required|integer|min:1',
        ]);

        $idCliente = Auth::id();

        $producto = Producto::with('inventario')->findOrFail($request->id_producto);
        $stockDisponible = $producto->inventario->stock_actual ?? 0;

        if ($stockDisponible <= 0) {
            return redirect()
                ->back()
                ->with('error', 'Este producto no tiene stock disponible.');
        }

        $item = Carrito::where('id_cliente', $idCliente)
            ->where('id_producto', $request->id_producto)
            ->where('id_talla', $request->id_talla)
            ->where('id_color', $request->id_color)
            ->first();

        $cantidadActual = $item ? $item->cantidad : 0;
        $cantidadFinal = min($cantidadActual + $request->cantidad, $stockDisponible);

        if ($item) {
            $item->update(['cantidad' => $cantidadFinal]);
        } else {
            Carrito::create([
                'id_carrito'  => (Carrito::max('id_carrito') ?? 0) + 1,
                'id_cliente'  => $idCliente,
                'id_producto' => $request->id_producto,
                'id_talla'    => $request->id_talla,
                'id_color'    => $request->id_color,
                'cantidad'    => $cantidadFinal,
            ]);
        }

        return redirect()->back()->with('success', 'Producto agregado al carrito.');
    }

    public function actualizarCarrito(Request $request, Carrito $carrito)
    {
        $this->autorizarPropietario($carrito);

        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $stockDisponible = $carrito->producto->inventario->stock_actual ?? 0;
        $cantidad = min($request->cantidad, max($stockDisponible, 1));

        $carrito->update(['cantidad' => $cantidad]);

        return redirect()->back()->with('success', 'Carrito actualizado.');
    }

    public function quitarDelCarrito(Carrito $carrito)
    {
        $this->autorizarPropietario($carrito);

        $carrito->delete();

        return redirect()->back()->with('success', 'Producto eliminado del carrito.');
    }


    public function vaciarCarrito()
    {
        Carrito::where('id_cliente', Auth::id())->delete();

        return redirect()->back()->with('success', 'Carrito vaciado.');
    }

    public function finalizarCompra(Request $request)
    {
        $idCliente = Auth::id();

        $items = Carrito::with('producto.inventario')
            ->where('id_cliente', $idCliente)
            ->get();

        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'Tu carrito está vacío.');
        }

        // Validar stock disponible de cada línea antes de confirmar nada
        foreach ($items as $item) {
            $stockDisponible = $item->producto->inventario->stock_actual ?? 0;
            if ($item->cantidad > $stockDisponible) {
                return redirect()->back()->with(
                    'error',
                    'No hay stock suficiente de "' . $item->producto->nombre . '". Disponible: ' . $stockDisponible
                );
            }
        }

        DB::beginTransaction();
        try {
            $total = $items->sum(function ($item) {
                return $item->producto->precio * $item->cantidad;
            });

            $idVenta = (Venta::max('id_venta') ?? 0) + 1;

            $venta = Venta::create([
                'id_venta'      => $idVenta,
                'id_cliente'    => $idCliente,
                'id_empleado'   => self::ID_EMPLEADO_TIENDA_ONLINE,
                'fecha'         => now(),
                'total'         => $total,
                'estado'        => 'A',
                'estado_pedido' => 'Listo para recoger',
            ]);

            foreach ($items as $item) {
                $subtotal = $item->producto->precio * $item->cantidad;

                DetalleVenta::create([
                    'id_detalle'      => (DetalleVenta::max('id_detalle') ?? 0) + 1,
                    'id_venta'        => $venta->id_venta,
                    'id_producto'     => $item->id_producto,
                    'id_talla'        => $item->id_talla,
                    'id_color'        => $item->id_color,
                    'cantidad'        => $item->cantidad,
                    'precio_unitario' => $item->producto->precio,
                    'subtotal'        => $subtotal,
                    'total'           => $subtotal,
                ]);

                
                $inventario = $item->producto->inventario;
                if ($inventario) {
                    $inventario->decrement('stock_actual', $item->cantidad);
                }
            }

            Carrito::where('id_cliente', $idCliente)->delete();

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Pedido confirmado correctamente.')
                ->with('pedido_confirmado', $venta->id_venta);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'No se pudo procesar tu pedido: ' . $e->getMessage());
        }
    }

    private function autorizarPropietario(Carrito $carrito)
    {
        if ($carrito->id_cliente != Auth::id()) {
            abort(403, 'No tienes permiso sobre este recurso.');
        }
    }
}