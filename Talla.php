<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talla extends Model
{
    protected $table = 'talla';

    protected $primaryKey = 'id_talla';

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'id_talla',
        'nombre'
    ];

    public function productos()
    {
        return $this->belongsToMany(
            Producto::class,
            'producto_talla',
            'id_talla',
            'id_producto'
        );
    }
}