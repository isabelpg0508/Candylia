<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'usuario';

    protected $primaryKey = 'id_usuario';

    public $timestamps = false;

    protected $fillable = [
        'id_rol',
        'primer_nom',
        'segundo_nom',
        'primer_apelli',
        'segundo_apelli',
        'correo',
        'contrasena',
        'estado'
    ];

    protected $hidden = [
        'contrasena'
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}