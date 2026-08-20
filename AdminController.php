<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Talla;
use App\Models\Color;
use App\Models\Venta;

class AdminController extends Controller
{
   public function index()
    {

        $usuarios = Usuario::with('rol')->get();

        $roles = Rol::all();

        $productos = Producto::with([
            'tallas',
            'colores',
            'inventario'
        ])->get();

        $categorias = Categoria::all();

        $tallas = Talla::all();

        $colores = Color::all();

         $ventas = Venta::with([
            'cliente.usuario',
            'empleado.usuario',
            'detalles'
        ])->orderByDesc('fecha')->get();

        return view('admin.dashboard', compact(

            'usuarios',

            'roles',

            'productos',

            'categorias',

            'tallas',

            'colores',

            'ventas'

        ));

    }
}