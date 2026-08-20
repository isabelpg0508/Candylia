<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';

    protected $primaryKey = 'id_inventario';

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType='int';

    protected $fillable = [
        'id_inventario',
        'id_producto',
        'stock_actual',
        'stock_minimo'
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