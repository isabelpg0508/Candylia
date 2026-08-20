<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\ImagenProducto;
use App\Models\Categoria;
use App\Models\Talla;
use App\Models\Color;
use App\Models\Inventario;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['categoria', 'imagenes', 'tallas', 'colores', 'inventario'])->get();
        $categorias = Categoria::all();
        $tallas = Talla::all();
        $colores = Color::all();

        $usuarios = Usuario::with('rol')->get();
        $roles = Rol::all();

        $ventas = Venta::with([
            'cliente.usuario',
            'empleado.usuario',
            'detalles.producto',
            'detalles.talla',
            'detalles.color'
        ])->orderByDesc('fecha')->get();

        return view('admin.dashboard', compact(
            'productos',
            'categorias',
            'tallas',
            'colores',
            'usuarios',
            'roles',
            'ventas'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_producto'  => 'required|unique:productos,id_producto',
            'id_categoria' => 'required|exists:categoria,id_categoria',
            'nombre'       => 'required|max:50',
            'descripcion'  => 'nullable|max:55',
            'precio'       => 'required|numeric|min:20000|max:600000',
            'tallas'       => 'required|array',
            'colores'      => 'required|array',
            'imagen'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $producto = Producto::create([
                'id_producto'  => $request->id_producto,
                'id_categoria' => $request->id_categoria,
                'nombre'       => $request->nombre,
                'descripcion'  => $request->descripcion,
                'precio'       => $request->precio,
                'estado'       => 'A',
            ]);

            $producto->tallas()->attach($request->tallas);
            $producto->colores()->attach($request->colores);

            // Crear inventario inicial del producto
            Inventario::create([
                'id_inventario' => (Inventario::max('id_inventario') ?? 0) + 1,
                'id_producto'   => $producto->id_producto,
                'stock_actual'  => $request->stock_actual,
                'stock_minimo'  => $request->stock_minimo,
            ]);

            if ($request->hasFile('imagen')) {
                $archivo = $request->file('imagen');
                $nombre  = time() . '_' . $archivo->getClientOriginalName();
                $archivo->move(public_path('productos'), $nombre);

                ImagenProducto::create([
                    'id_imagen'   => (ImagenProducto::max('id_imagen') ?? 0) + 1,
                    'id_producto' => $producto->id_producto,
                    'ruta_imagen' => 'productos/' . $nombre,
                ]);
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Producto registrado correctamente.')
                ->with('seccion', 'productos');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre'       => 'required|max:50',
            'id_categoria' => 'required|exists:categoria,id_categoria',
            'descripcion'  => 'nullable|max:55',
            'precio'       => 'required|numeric|min:1',
            'estado'       => 'required|in:A,I',
            'stock_actual' => 'required|integer|min:1',
            'stock_minimo' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $producto->update([
                'id_categoria' => $request->id_categoria,
                'nombre'       => $request->nombre,
                'descripcion'  => $request->descripcion,
                'precio'       => $request->precio,
                'estado'       => $request->estado,
            ]);

            // Sincronizar tallas y colores
            if ($request->has('tallas')) {
                $producto->tallas()->sync($request->tallas);
            } else {
                $producto->tallas()->detach();
            }

            if ($request->has('colores')) {
                $producto->colores()->sync($request->colores);
            } else {
                $producto->colores()->detach();
            }

            // Actualizar o crear inventario
            $inventario = $producto->inventario;
            if ($inventario) {
                $inventario->update([
                    'stock_actual' => $request->stock_actual,
                    'stock_minimo' => $request->stock_minimo,
                ]);
            } else {
                Inventario::create([
                    'id_inventario' => (Inventario::max('id_inventario') ?? 0) + 1,
                    'id_producto'   => $producto->id_producto,
                    'stock_actual'  => $request->stock_actual,
                    'stock_minimo'  => $request->stock_minimo,
                ]);
            }

            // Actualizar imagen si se subió una nueva
            if ($request->hasFile('imagen')) {
                $request->validate([
                    'imagen' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
                ]);
                $archivo = $request->file('imagen');
                $nombre  = time() . '_' . $archivo->getClientOriginalName();
                $archivo->move(public_path('productos'), $nombre);

                // Reemplazar imagen existente
                $imgExistente = $producto->imagenes()->first();
                if ($imgExistente) {
                    $imgExistente->update(['ruta_imagen' => 'productos/' . $nombre]);
                } else {
                    ImagenProducto::create([
                        'id_imagen'   => (ImagenProducto::max('id_imagen') ?? 0) + 1,
                        'id_producto' => $producto->id_producto,
                        'ruta_imagen' => 'productos/' . $nombre,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Producto actualizado correctamente.')
                ->with('seccion', 'productos');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Producto $producto)
    {
        try {
            $producto->tallas()->detach();
            $producto->colores()->detach();
            $producto->imagenes()->delete();
            $producto->inventario()->delete();
            $producto->delete();

            return redirect()
                ->back()
                ->with('success', 'Producto eliminado correctamente.')
                ->with('seccion', 'productos');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'No se pudo eliminar el producto: ' . $e->getMessage())
                ->with('seccion', 'productos');
        }
    }
}