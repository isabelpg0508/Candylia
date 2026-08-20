<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'carrito';

    protected $primaryKey = 'id_carrito';

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'id_carrito',
        'id_cliente',
        'id_producto',
        'id_talla',
        'id_color',
        'cantidad'
    ];

    public function cliente()
    {
        return $this->belongsTo(
            Cliente::class,
            'id_cliente',
            'fkpk_id_cliente'
        );
    }

    public function producto()
    {
        return $this->belongsTo(
            Producto::class,
            'id_producto',
            'id_producto'
        );
    }

    public function talla()
    {
        return $this->belongsTo(
            Talla::class,
            'id_talla',
            'id_talla'
        );
    }

    public function color()
    {
        return $this->belongsTo(
            Color::class,
            'id_color',
            'id_color'
        );
    }
}