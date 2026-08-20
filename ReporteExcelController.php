<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Producto;

class ReporteExcelController extends Controller
{
    /**
     * Descarga un Excel (.xls) con el listado de usuarios.
     * Ruta sugerida: GET /admin/reportes/usuarios/excel
     * Nombre de ruta: reportes.usuarios.excel
     */
    public function usuariosExcel()
    {
        $usuarios = Usuario::with('rol')->get();

        // Cabeceras para forzar la descarga del archivo Excel
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=reporte_usuarios.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Encabezados de columnas
        echo "Id Usuario\tNombre\tApellido\tCorreo\tRol\tEstado\n";

        // Datos
        foreach ($usuarios as $u) {
            $nombre   = $u->primer_nom . ' ' . $u->segundo_nom;
            $apellido = $u->primer_apelli . ' ' . $u->segundo_apelli;
            $rol      = $u->rol->nombre_rol ?? '';
            $estado   = $u->estado == 'A' ? 'Activo' : 'Inactivo';

            echo "{$u->id_usuario}\t{$nombre}\t{$apellido}\t{$u->correo}\t{$rol}\t{$estado}\n";
        }

        exit;
    }

    /**
     * Descarga un Excel (.xls) con el listado de productos,
     * incluyendo categoría, tallas y colores asociados.
     * Ruta sugerida: GET /admin/reportes/productos/excel
     * Nombre de ruta: reportes.productos.excel
     */
    public function productosExcel()
    {
        $productos = Producto::with(['categoria', 'tallas', 'colores'])->get();

        // Cabeceras para forzar la descarga del archivo Excel
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=reporte_productos.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Encabezados de columnas
        echo "Id Producto\tNombre\tCategoria\tDescripcion\tPrecio\tEstado\tTallas\tColores\n";

        // Datos
        foreach ($productos as $p) {
            $categoria = $p->categoria->nombre ?? '';
            $estado    = $p->estado == 'A' ? 'Activo' : 'Inactivo';
            $tallas    = $p->tallas->pluck('nombre')->implode(', ');
            $colores   = $p->colores->pluck('nombre')->implode(', ');

            echo "{$p->id_producto}\t{$p->nombre}\t{$categoria}\t{$p->descripcion}\t{$p->precio}\t{$estado}\t{$tallas}\t{$colores}\n";
        }

        exit;
    }
}