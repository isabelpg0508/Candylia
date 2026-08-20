<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $primaryKey = 'id_venta';

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'id_venta',
        'id_cliente',
        'id_empleado',
        'fecha',
        'total',
        'estado',
        'estado_pedido'
    ];

    public function cliente()
    {
        return $this->belongsTo(
            Cliente::class,
            'id_cliente',
            'fkpk_id_cliente'
        );
    }

    public function empleado()
    {
        return $this->belongsTo(
            Empleado::class,
            'id_empleado',
            'fkpk_id_empleado'
        );
    }

    public function detalles()
    {
        return $this->hasMany(
            DetalleVenta::class,
            'id_venta',
            'id_venta'
        );
    }
}