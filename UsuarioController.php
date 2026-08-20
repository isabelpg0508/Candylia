<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('rol')->get();
        $roles    = Rol::all();
        return view('admin.dashboard', compact('usuarios', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario'    => 'required|unique:usuario,id_usuario',
            'id_rol'        => 'required|exists:rol,id_rol',
            'primer_nom'    => 'required|max:25',
            'segundo_nom'   => 'nullable|max:25',
            'primer_apelli' => 'required|max:25',
            'segundo_apelli'=> 'nullable|max:25',
            'correo'        => 'required|email|unique:usuario,correo',
            'contrasena'    => 'required|min:6',
        ]);

        Usuario::create([
            'id_usuario'     => $request->id_usuario,
            'id_rol'         => $request->id_rol,
            'primer_nom'     => $request->primer_nom,
            'segundo_nom'    => $request->segundo_nom,
            'primer_apelli'  => $request->primer_apelli,
            'segundo_apelli' => $request->segundo_apelli,
            'correo'         => $request->correo,
            'contrasena'     => $request->contrasena,
            'estado'         => 'A',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Usuario registrado correctamente.')
            ->with('seccion', 'usuarios');
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'id_rol'        => 'required|exists:rol,id_rol',
            'primer_nom'    => 'required|max:25',
            'segundo_nom'   => 'nullable|max:25',
            'primer_apelli' => 'required|max:25',
            'segundo_apelli'=> 'nullable|max:25',
            'correo'        => 'required|email|unique:usuario,correo,' . $id . ',id_usuario',
            'estado'        => 'required|in:A,I',
        ]);

        $usuario->update([
            'id_rol'         => $request->id_rol,
            'primer_nom'     => $request->primer_nom,
            'segundo_nom'    => $request->segundo_nom,
            'primer_apelli'  => $request->primer_apelli,
            'segundo_apelli' => $request->segundo_apelli,
            'correo'         => $request->correo,
            'estado'         => $request->estado,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Usuario actualizado correctamente.')
            ->with('seccion', 'usuarios');
    }

    public function destroy($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->delete();

            return redirect()
                ->back()
                ->with('success', 'Usuario eliminado correctamente.')
                ->with('seccion', 'usuarios');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'No se pudo eliminar el usuario: ' . $e->getMessage())
                ->with('seccion', 'usuarios');
        }
    }
}