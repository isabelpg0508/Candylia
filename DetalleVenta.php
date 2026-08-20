<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';

    protected $primaryKey = 'id_detalle';

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'id_detalle',
        'id_venta',
        'id_producto',
        'id_talla',
        'id_color',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'total'
    ];

    public function venta()
    {
        return $this->belongsTo(
            Venta::class,
            'id_venta',
            'id_venta'
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