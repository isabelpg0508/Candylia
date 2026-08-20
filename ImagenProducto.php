<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{
    protected $table = 'imagenes_producto';

    protected $primaryKey = 'id_imagen';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'id_imagen',
        'id_producto',
        'ruta_imagen'
    ];

    public function producto()
    {
        return $this->belongsTo(
            Producto::class,
            'id_producto',
            'id_producto'
        );
    }
}