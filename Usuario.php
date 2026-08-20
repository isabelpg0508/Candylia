<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';

    protected $primaryKey = 'id_usuario';

    protected $keyType = 'int';
    
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
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

    public function rol()
    {
        return $this->belongsTo(
            Rol::class,
            'id_rol',
            'id_rol'
        );
    }
}