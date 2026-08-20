<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'color';

    protected $primaryKey = 'id_color';

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'id_color',
        'nombre'
    ];

    public function productos()
    {
        return $this->belongsToMany(
            Producto::class,
            'producto_color',
            'id_color',
            'id_producto'
        );
    }
}